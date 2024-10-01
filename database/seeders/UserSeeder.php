<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de importar tu modelo User
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crea un usuario con una contraseña
        User::create([
            'name' => 'Test User', // Nombre del usuario
            'email' => 'testuser@example.com', // Correo electrónico
            'password' => Hash::make('password123'), // Contraseña
        ]);
    }
}
