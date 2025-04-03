<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Método para iniciar sesión
    public function login(Request $request)
    {
        // Validar que los campos email y password estén presentes
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user(); // Obtener al usuario autenticado

            // Crear un token si la autenticación fue exitosa
            $token = $user->createToken('YourAppName')->plainTextToken;

            // Retornar el usuario y el token
            return response()->json([
                'success' => true,
                'user' => $user,
                'token' => $token,
            ]);
        }

        // Si las credenciales no son correctas
        return response()->json([
            'success' => false,
            'message' => 'Credenciales incorrectas.',
        ], 401);
    }

    // Método para cerrar sesión
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json([
            'message' => 'Usuario deslogueado con éxito',
        ]);
    }
}
