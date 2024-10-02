<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NotesTableSeeder extends Seeder
{
    public function run()
    {
        $notes = [
            // Notas para el usuario con ID 1
            [
                'title' => 'First Note',
                'description' => 'This is the description for the first note. The note covers multiple aspects of the ongoing project and includes detailed tasks that need to be completed within the next week. It is essential that each task is handled with priority, ensuring no step is missed during execution. The deadline is strict, and the team needs to collaborate effectively to meet the required standards.',
                'user' => 1,
                'tags' => 'work,important',
                'due_date' => Carbon::now()->addDays(5)->toDateString(),
                'image_path' => 'images/note1.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Second Note',
                'description' => 'This is the description for the second note. This note details personal tasks that need attention, including errands and appointments. Some of these tasks are time-sensitive, especially an urgent visit to the doctor. Prioritizing health over other activities is crucial, as ignoring these issues might lead to more significant problems later on.',
                'user' => 1,
                'tags' => 'personal,urgent',
                'due_date' => Carbon::now()->addDays(10)->toDateString(),
                'image_path' => 'images/note2.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Third Note',
                'description' => 'This is the description for the third note. This note outlines the agenda for the upcoming team meeting. It includes key discussion points, such as project milestones, potential challenges, and budget allocations. The meeting aims to align the team\'s objectives and set clear, actionable steps to ensure smooth progress.',
                'user' => 1,
                'tags' => 'meeting,notes',
                'due_date' => Carbon::now()->addDays(3)->toDateString(),
                'image_path' => 'images/note3.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Notas para el usuario con ID 2
            [
                'title' => 'First Note',
                'description' => 'This is the description for the first note. It includes a detailed plan to improve personal well-being through a healthier lifestyle. It involves scheduling daily activities, such as exercise, meditation, and proper meal planning. The note also emphasizes the importance of regular check-ups to ensure a balanced and healthy lifestyle.',
                'user' => 2,
                'tags' => 'personal,health',
                'due_date' => Carbon::now()->addDays(7)->toDateString(),
                'image_path' => 'images/note4.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Second Note',
                'description' => 'This is the description for the second note. An urgent reminder to finalize all pending work projects before the deadline. The note provides a breakdown of the remaining tasks, each with its own set of instructions and required resources. Missing the deadline is not an option, and this note serves as a guide to ensure everything is completed in time.',
                'user' => 2,
                'tags' => 'urgent',
                'due_date' => Carbon::now()->addDays(12)->toDateString(),
                'image_path' => 'images/note5.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Notas para el usuario con ID 3
            [
                'title' => 'First Note',
                'description' => 'This is the description for the first note. It details the tasks related to a work project that needs to be delivered soon. The project includes both individual contributions and collaborative work with different teams. Each step requires thorough review and quality control to ensure the final product meets the client\'s expectations.',
                'user' => 3,
                'tags' => 'work',
                'due_date' => Carbon::now()->addDays(9)->toDateString(),
                'image_path' => 'images/note6.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Second Note',
                'description' => 'This is the description for the second note. It highlights personal goals and aspirations, focusing on long-term development. Whether it\'s learning new skills, picking up a new hobby, or simply making time for family, this note outlines a structured plan for personal growth over the next few months.',
                'user' => 3,
                'tags' => 'personal',
                'due_date' => Carbon::now()->addDays(14)->toDateString(),
                'image_path' => 'images/note7.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Third Note',
                'description' => 'This is the description for the third note. The note provides an outline for the next business meeting. It includes key points to discuss, including budget reallocation, new marketing strategies, and updates on the current project. Each topic is expected to receive feedback from different departments during the meeting.',
                'user' => 3,
                'tags' => 'meeting',
                'due_date' => Carbon::now()->addDays(2)->toDateString(),
                'image_path' => 'images/note8.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Notas para el usuario con ID 4
            [
                'title' => 'First Note',
                'description' => 'This is the description for the first note. It contains an urgent action plan to resolve a critical issue at work. The issue needs immediate attention and requires collaboration with several team members to fix. The note includes detailed steps on how to resolve the problem and a checklist to ensure nothing is overlooked.',
                'user' => 4,
                'tags' => 'urgent',
                'due_date' => Carbon::now()->addDays(5)->toDateString(),
                'image_path' => 'images/note9.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Second Note',
                'description' => 'This is the description for the second note. It focuses on the details of a new work project. This project has a long-term scope and involves multiple phases, each requiring specific resources and timelines. The note provides a comprehensive plan to ensure that all phases are completed on time and within budget.',
                'user' => 4,
                'tags' => 'work',
                'due_date' => Carbon::now()->addDays(15)->toDateString(),
                'image_path' => 'images/note10.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Notas para el usuario con ID 5
            [
                'title' => 'First Note',
                'description' => 'This is the description for the first note. It is a reminder to focus on personal activities, such as spending time with family and taking care of one\'s mental health. The note highlights the importance of balance between work and personal life, and suggests ways to unwind and recharge.',
                'user' => 5,
                'tags' => 'personal',
                'due_date' => Carbon::now()->addDays(6)->toDateString(),
                'image_path' => 'images/note11.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Second Note',
                'description' => 'This is the description for the second note. It is a summary of key discussion points for an upcoming meeting. The meeting will cover various important topics, including team performance, ongoing projects, and potential areas for improvement. The note is meant to serve as a guide for all participants.',
                'user' => 5,
                'tags' => 'meeting',
                'due_date' => Carbon::now()->addDays(11)->toDateString(),
                'image_path' => 'images/note12.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('notes')->insert($notes);
    }
}
