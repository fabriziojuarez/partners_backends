<?php 

namespace Tests\Support;

use App\Models\Course;
use App\Models\Partner;

trait CreateCourses
{
    protected function makeCourse(Partner $manager){
        $Course = new Course();
        $Course->setRelation('manager', $manager);   
        return $Course;
    }
}