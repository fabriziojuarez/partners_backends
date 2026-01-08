<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Partner;

use function PHPUnit\Framework\isFalse;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        // Extraer por usuario
        $user = User::where('name', $request->user)->first();

        // Comparar con password
        if(!$user || !Hash::check($request->code, $user->password)) {
            $data = [
                'code_status' => 401,
                'message' => 'Credenciales Invalidas',
            ];
            return response()->json($data, $data['code_status']);

        }
        
        // Verificacion si usuario esta Innactivo
        if(!$user->is_active){
            $data = [
                'code_status' => 401,
                'msg' => 'Usuario Innactivo'
            ];
            return response()->json($data, $data['code_status']);
        }

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'code_status' => 200,
            'rol_system' => $user->systemRole->name,
            'partner' => $user->partner,
            'access_token' => $token,
        ];

        return response()->json($data, $data['code_status']);
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
