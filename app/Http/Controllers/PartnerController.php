<?php

namespace App\Http\Controllers;

use App\Http\Requests\Partner\StorePartnerRequest;
use App\Http\Requests\Partner\UpdatePartnerRequest;
use App\Http\Resources\PartnerResource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\User;
use App\Models\Partner;
use App\Models\PartnerRole;
use App\Models\Role;

class PartnerController extends Controller
{
    use AuthorizesRequests;

    public function profile()
    {
        $id = Auth::user()->partner->id;
        $partner = Partner::with(['partner_role', 'user'])->findOrFail($id);

        if($partner->role->isManager()){
            // Agregar progreso de cumplimiento en los cursos que gestiones
        }
        // Agregar el progreso en cada curso que estes matriculado con algun sp

        $data = [
            'message' => 'Datos del Partner',
            'data' => new PartnerResource($partner),
        ];
        return response()->json($data, 200);
    }

    public function index()
    {
        // agregar filtros:
        // ROL, NOMBRE, ESTADO(ACTIVO E INNACTIVO)
        $this->authorize('view', Partner::class);

        $partners = Partner::with(['partner_role', 'user'])->paginate(5);

        // Agregar el proceso de "cumplimiento" en general por cada partner
        $partners->load('enrollments');
        $partners->load(['managedCourses']);

        $data = [
            'message' => 'Lista de Partners',
            'partners' => PartnerResource::collection($partners),
        ];
        return response()->json($data, 200);
    }
    
    public function show(int $id)
    {
        // ABRIR DISCUSION SI ES NECESARIO EL SHOW, YA QUE EN INDEX SE ESTAN EXTRAYENDO
        // LOS DATOS NECESARIOS
        $partner = Partner::with(['partner_role', 'user'])->findOrFail($id);

        $this->authorize('viewAny', $partner);

        $partner->load('enrollments');
        $partner->load(['managedCourses']);

        $data = [
            'message' => 'Detalle del Partner',
            'partner' => new PartnerResource($partner),
        ];
        return response()->json($data, 200);
    }

    public function store(StorePartnerRequest $request)
    {
        $role = PartnerRole::findOrFail($request->partner_role_id);
        $this->authorize('create', [Partner::class, $role]);

        $partner = DB::transaction(function () use ($request){
            $user = User::create([
                'name' => $request->user,
                'password' => Hash::make($request->code),
            ]);

            return Partner::create([
                'name' => $request->name,
                'partner_role_id' => $request->partner_role_id,
                'user_id' => $user->id,
            ]);
        });

        $partner->load(['partner_role', 'user']);

        $data = [
            'message' => 'Partner creado correctamente',
            'partner' => new PartnerResource($partner),
        ];
        return response()->json($data, 201);
    }

    public function update(int $id, UpdatePartnerRequest $request)
    {
        $partner = Partner::with(['user', 'role'])->findOrFail($id);
        $role = PartnerRole::find($request->partner_role_id) ?? $partner->partner_role;
        $this->authorize('update', [$partner, $role]);

        DB::transaction(function() use ($request, $partner){
            if($request->filled('user')){
                $partner->user->update(['name' => $request->user,]);
            }

            if($request->filled('code')){
                $partner->user->update(['password' => Hash::make($request->code),]);
            }

            if($request->filled('name')){
                $partner->update(['name' => $request->name,]);
            }

            if($request->filled('partner_role_id')){
                $partner->update(['partner_role_id' => $request->partner_role_id,]);
            }

            if($request->filled('is_active')){
                $partner->user->update(['is_active' => $request->is_active,]);
            }
        });

        $partner->load(['partner_role', 'user']);

        $data = [
            'message' => 'Partner actualizado correctamente',
            'partner' => new PartnerResource($partner),
        ];
        return response()->json($data, 200);
    }

    public function destroy(int $id)
    {
        $partner = Partner::findOrFail($id);
        $this->authorize('delete', $partner);

        DB::transaction(function() use ($partner){
            $partner->user->delete();
            $partner->delete();
        });

        $data = [
            'message' => 'Partner eliminado correctamente',
        ];
        return response()->json($data, 200);
    }
}
