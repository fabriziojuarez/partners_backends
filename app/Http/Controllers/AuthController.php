<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Partner;
use App\Models\Role;

use App\Http\Resources\PartnerResource;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('name', $request->user)
            ->where('is_active', true)
            ->with(['partner.partner_role'])
            ->first();

        if (
            !$user || 
            !$user->partner || 
            !Hash::check($request->code, $user->password)
        ) {
            $data = [
                'message' => 'Credenciales inválidas',
            ];
            return response()->json($data, 401);
        }   

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'message' => 'Login exitoso',
            'partner' => new PartnerResource($user->partner),
            'access_token' => $token,
        ];
        return response()->json($data, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $data = [
            'message' => 'Sesion finalizada',
        ];
        return response()->json($data, 200);
    }   
}
