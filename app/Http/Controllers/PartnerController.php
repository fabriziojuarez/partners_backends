<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Partner;
use App\Models\Role;

class PartnerController extends Controller
{
    public function index()
    {
        $partner = Auth::user()->partner;

        $data = [
            'status_code' => 200,
            'partner' => $partner->Role,
        ];
        return response()->json($partner);
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
}
