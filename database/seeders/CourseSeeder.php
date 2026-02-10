<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'title' => 'Curso de prueba 1',
            'manager_id' => 2,
        ]);

        Course::create([
            'title' => 'Tracker de bebidas',
            'manager_id' => 5,
        ]);
    }
}
