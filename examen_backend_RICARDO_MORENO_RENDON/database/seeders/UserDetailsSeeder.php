<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Usuarios; // Si utilizas Eloquent para acceder a los usuarios

class UserDetailsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create(); // Instancia de Faker

        // Seleccionamos solo un usuario único
        $users = Usuarios::all(); // Obtenemos todos los usuarios

        foreach ($users as $user) {
            DB::table('informacion_personal')->insert([
                'usuario_id' => $user->id, // Usamos el id del usuario
                'Direccion' => $faker->address, // Dirección aleatoria
                'Telefono' => $faker->phoneNumber, // Teléfono aleatorio
                'FechaNacimiento' => $faker->date($format = 'Y-m-d', $max = '2000-01-01'), // Fecha de nacimiento aleatoria
            ]);
        }
    }
}
