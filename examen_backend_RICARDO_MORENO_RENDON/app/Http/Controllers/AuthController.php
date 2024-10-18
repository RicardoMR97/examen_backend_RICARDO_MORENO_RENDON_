<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Método para el login
    public function login(Request $request)
    {
        dd($request);
        // Valida los datos que vienen en la petición
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Busca al usuario por su email
        $user = User::where('email', $request->email)->first();

        // Verifica si el usuario existe y si la contraseña es correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Si las credenciales no son correctas, devuelve un error 401
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        // Genera un token de autenticación usando Sanctum o Passport
        $token = $user->createToken('authToken')->plainTextToken;

        // Devuelve la respuesta con el token y un mensaje de éxito
        return response()->json([
            'token' => $token,
            'message' => 'Inicio de sesión exitoso'
        ]);
    }

}
