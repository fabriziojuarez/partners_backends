<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
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
            ->first();

        if (!$user || !Hash::check($request->code, $user->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }   

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        $user->load('partner.role');
        return response()->json([
            'message' => 'Login exitoso',
            'partner' => new PartnerResource($user->partner),
            'access_token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $data = [
            'code_status' => 200,
            'message' => 'Logged out',
        ];

        return response()->json($data, $data['code_status']);
    }   
}
