<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use App\Models\Informacion_personal;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Método para la consulta de usuarios
    public function getUsuarios(Request $request)
    {
        $users = DB::connection('mysql')->table('usuarios as u')
                ->select('u.id','u.Name','u.Email','infoP.Direccion','infoP.Telefono','infoP.FechaNacimiento')
                ->leftJoin('informacion_personal as infoP','u.id','=','infoP.usuario_id')->get();
        $users = json_encode($users);
        $users = json_decode($users);
        
        return response()->json([
            'csrf_token' => csrf_token(),
            'data' => $users
        ], 200)->header("Access-Control-Allow-Origin",  "*");
    }
    
    // Método para la eliminación de usuarios
    public function deleteUsuario(Request $request)
    {
        $user = Usuarios::find($request->id);
        
        if ($user) {
            $user->deleteUser(); // Llamamos al método personalizado
            return response()->json(['message' => 'Usuario eliminado correctamente']);
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }

    public function updateUsuario(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
        ]);

        // Buscar al usuario por su id
        $usuario = Usuarios::find($request->id);

        if(!isset($usuario)){
            $usuario = new Usuarios();
        }

        // Actualizar los datos del usuario en la tabla usuarios
        $usuario->Name = $request->input('nombre');
        $usuario->Email = $request->input('email');
        $usuario->Password = Hash::make('password123');
        $usuario->save();

        // Verificar si existe la información personal relacionada
        $informacionP = $users = DB::connection('mysql')->table('usuarios as u')
        ->leftJoin('informacion_personal as infoP','u.id','=','infoP.usuario_id')
        ->where('infoP.usuario_id',$usuario->id)->get();
 
        $informacionPersonal = new Informacion_personal();
        // Actualizar o establecer los datos en la tabla Informacion_personal
        $informacionPersonal->Direccion = $request->input('direccion');
        $informacionPersonal->Telefono = $request->input('telefono');
        $informacionPersonal->FechaNacimiento = $request->input('fecha_nacimiento');

        if (count($informacionP) > 0) {
            $informacionPersonal->usuario_id = $usuario->id; 
            
            $informacionPersonal->update();// Asegúrate de que esta clave foránea esté correcta
        }else{
            $informacionPersonal->usuario_id = $usuario->id; 
            $informacionPersonal->save();
        }

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'Usuario actualizado correctamente.');
    }

}
