<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Registro de usuario
    public function register(Request $request)
    {
        // Validar los datos del formulario de registro
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Retorna errores si la validación falla
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Crear el usuario con los datos del request
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Retornar la información del usuario registrado
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ], 201);
    }

    // Login de usuario
    public function login(Request $request)
    {
        // Validar los datos del formulario de inicio de sesión
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Credenciales de inicio de sesión
        $credentials = request(['email', 'password']);

        // Comprobar las credenciales del usuario
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Obtener el usuario autenticado
        $user = $request->user();

        // Crear el token de acceso con Passport
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        // Opcional: Establecer la expiración del token si 'remember_me' está activado
        if ($request->remember_me) {
            $token->expires_at = now()->addWeeks(1);
        }

        // Guardar el token y retornar la respuesta
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $token->expires_at->toDateTimeString(),
        ]);
    }

    // Obtener el usuario autenticado
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // Cerrar sesión y revocar el token de acceso
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
