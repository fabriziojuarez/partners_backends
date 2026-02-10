<?php

namespace Database\Seeders;

use App\Models\CourseTopic;
use Illuminate\Database\Seeder;

class CourseTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseTopic::create([
            'name' => 'tema de eva. 1-1',
            'grade_max' => 20,
            'course_id' => 1
        ]);

        CourseTopic::create([
            'name' => 'tema de eva. 1-2',
            'grade_max' => 20,
            'course_id' => 1,
        ]);

        CourseTopic::create([
            'name' => 'tema de eva. 1-3',
            'grade_max' => 20,
            'course_id' => 1,
        ]);

        CourseTopic::create([
            'name' => 'Cappuccino',
            'grade_max' => 1,
            'course_id' =>2
        ]);
        CourseTopic::create([
            'name' => 'Flat White',
            'grade_max' => 1,
            'course_id' =>2
        ]);
        CourseTopic::create([
            'name' => 'Blue Berry Perls Limonade',
            'grade_max' => 1,
            'course_id' => 2,
            'is_active' => 0
        ]);
        CourseTopic::create([
            'name' => 'Caramel Frappuccino',
            'grade_max' => 1,
            'course_id' =>2
        ]);
    }
}
