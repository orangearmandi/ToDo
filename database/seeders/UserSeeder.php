<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de importar tu modelo User
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'id' => 2,
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'id' => 3,
            'name' => 'Mike Johnson',
            'email' => 'mikejohnson@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'id' => 4,
            'name' => 'Emily Davis',
            'email' => 'emilydavis@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'id' => 5,
            'name' => 'David Brown',
            'email' => 'davidbrown@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}

