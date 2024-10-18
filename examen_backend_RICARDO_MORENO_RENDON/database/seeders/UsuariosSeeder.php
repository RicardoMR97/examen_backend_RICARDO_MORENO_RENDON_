<?php

namespace Database\Seeders;

use App\Models\Usuarios;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Crear 100 usuarios con contraseñas hashadas
        for ($i = 0; $i < 100; $i++) {
            Usuarios::create([
                'Name' => $faker->name,
                'Email' => $faker->unique()->safeEmail,
                'Password' => Hash::make('password123'), // Contraseña hasheada
            ]);
        }
    }
}
