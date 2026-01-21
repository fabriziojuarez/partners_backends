<?php

namespace App\Http\Controllers;

use App\Http\Requests\Partner\StorePartnerRequest;
use App\Http\Requests\Partner\UpdatePartnerRequest;
use App\Http\Resources\PartnerResource;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\User;
use App\Models\Partner;
use App\Models\Role;

class PartnerController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Partner::class);

        // Agregar arreglo de partners (modificar)
        return "Listar partners";
    }
    
    public function show(int $id)
    {
        $partner = Partner::findOrFail($id);

        $this->authorize('view', $partner);

        // Mostrar partner (modificar)
        return $partner;
    }

    public function store(StorePartnerRequest $request)
    {
        $role = Role::findOrFail($request->role_id);
        $this->authorize('create', [Partner::class, $role]);

        // Agregar partner (modificar)
        return $request;
    }

    public function update(int $id, UpdatePartnerRequest $request)
    {
        $partner = Partner::findOrFail($id);
        
        $role = Role::find($request->role_id) ?? $partner->role;
        $this->authorize('update', [$partner, $role]);

        // Actualizar partner (modificar)
        return response()->json($request);
    }

    public function destroy(int $id)
    {
        $partner = Partner::findOrFail($id);
        $this->authorize('delete', $partner);

        // Eliminar Partner (modificar)
        return new PartnerResource($partner);
    }
}
