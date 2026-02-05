<?php

namespace App\Http\Controllers;

use App\Http\Requests\Partner\StorePartnerRequest;
use App\Http\Requests\Partner\UpdatePartnerRequest;
use App\Http\Resources\PartnerResource;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\User;
use App\Models\Partner;
use App\Models\Role;

class PartnerController extends Controller
{
    use AuthorizesRequests;

    public function profile()
    {
        $id = Auth::user()->partner->id;
        $partner = Partner::with(['role', 'user'])->findOrFail($id);

        $data = [
            'message' => 'Bienvenido',
            'mydata' => new PartnerResource($partner),
        ];
        return response()->json($data, 200);
    }

    public function index()
    {
        $this->authorize('view', Partner::class);

        // Extraer con algun sp tambien sus progresos y cursos matriculados
        $partners = Partner::with(['role', 'user'])->paginate(5);

        $data = [
            'message' => 'Lista de Partners',
            'partners' => PartnerResource::collection($partners),
        ];
        return response()->json($data, 200);
    }
    
    public function show(int $id)
    {
        // Extraer con algun sp el progreso de este partner y sus cursos matriculados
        $partner = Partner::with(['role', 'user'])->findOrFail($id);

        $this->authorize('viewAny', $partner);

        $data = [
            'message' => 'Detalle del Partner',
            'partner' => new PartnerResource($partner),
        ];
        return response()->json($data, 200);
    }

    public function store(StorePartnerRequest $request)
    {
        $role = Role::findOrFail($request->role_id);
        $this->authorize('create', [Partner::class, $role]);

        $partner = DB::transaction(function () use ($request){
            $user = User::create([
                'name' => $request->user,
                'password' => Hash::make($request->code),
            ]);

            return Partner::create([
                'name' => $request->name,
                'role_id' => $request->role_id,
                'user_id' => $user->id,
            ]);
        });

        $partner->load(['role', 'user']);

        $data = [
            'message' => 'Partner creado correctamente',
            'partner' => new PartnerResource($partner),
        ];
        return response()->json($data, 201);
    }

    public function update(int $id, UpdatePartnerRequest $request)
    {
        $partner = Partner::with(['user', 'role'])->findOrFail($id);
        $role = Role::find($request->role_id) ?? $partner->role;
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

            if($request->filled('role_id')){
                $partner->update(['role_id' => $request->role_id,]);
            }

            if($request->filled('is_active')){
                $partner->user->update(['is_active' => $request->is_active,]);
            }
        });

        $partner->load(['role', 'user']);

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
