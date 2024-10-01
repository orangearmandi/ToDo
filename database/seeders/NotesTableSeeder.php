<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notes')->insert([
            [
                'title' => 'First Note',
                'description' => 'This is the description for the first note.',
                'user' => 'User1',
                'tags' => 'work,important', // Etiquetas separadas por comas
                'due_date' => Carbon::now()->addDays(5)->toDateString(), // Fecha de vencimiento en 5 días
                'image_path' => 'images/note1.jpg', // Ruta de imagen
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Second Note',
                'description' => 'This is the description for the second note.',
                'user' => 'User2',
                'tags' => 'personal,urgent',
                'due_date' => Carbon::now()->addDays(10)->toDateString(),
                'image_path' => 'images/note2.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Third Note',
                'description' => 'This is the description for the third note.',
                'user' => 'User3',
                'tags' => 'meeting,notes',
                'due_date' => Carbon::now()->addDays(3)->toDateString(),
                'image_path' => 'images/note3.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
