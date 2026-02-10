<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topic::create([
            'name' => 'tema de eva. 1-1',
            'note_max' => 20,
            'course_id' => 1
        ]);

        Topic::create([
            'name' => 'tema de eva. 1-2',
            'note_max' => 20,
            'course_id' => 1,
        ]);

        Topic::create([
            'name' => 'tema de eva. 1-3',
            'note_max' => 20,
            'course_id' => 1,
        ]);

        Topic::create([
            'name' => 'Cappuccino',
            'note_max' => 1,
            'course_id' =>2
        ]);
        Topic::create([
            'name' => 'Flat White',
            'note_max' => 1,
            'course_id' =>2
        ]);
        Topic::create([
            'name' => 'Blue Berry Perls Limonade',
            'note_max' => 1,
            'course_id' => 2,
            'is_active' => 0
        ]);
        Topic::create([
            'name' => 'Caramel Frappuccino',
            'note_max' => 1,
            'course_id' =>2
        ]);
    }
}
