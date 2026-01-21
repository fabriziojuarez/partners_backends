<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerRequest;
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
    
    public function show(int $id){
        $partner = Partner::findOrFail($id);

        $this->authorize('view', $partner);

        // Mostrar partner (modificar)
        return $partner;
    }

    public function store(StorePartnerRequest $request)
    {
        // SE CREA UN USER
        $user = new User();
        $user->name = $request->user;
        $user->save();

        // SE CREA UN PARTNER PARA EL USER
        $partner = new Partner();
        $partner->name = $request->name;
        $partner->code = $request->code; 
        $partner->role_id = $request->role_id;
        $partner->user_id = $user->id;
        $partner->save();

        $data = [
            'code' => 201,
            'message' => 'Partner created successfully',
            'user' => $user,
            'partner' => $partner,
        ];

        return response()->json($data, $data['code']);
    }

    public function register_courses(){
        
    }

    public function destroy(int $id)
    {
        $partner = Partner::findOrFail($id);
        $this->authorize('delete', $partner);

        // Eliminar Partner (modificar)
        return new PartnerResource($partner);
    }
}
