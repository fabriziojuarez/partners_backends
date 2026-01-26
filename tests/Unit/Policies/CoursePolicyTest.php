<?php

namespace Tests\Unit\Policies;

use PHPUnit\Framework\TestCase;

use App\Models\Course;
use App\Models\User;
use App\Models\Partner;
use App\Models\Role;
use App\Models\SystemRole;

use App\Policies\CoursePolicy;
use Tests\Support\CreatePartners;

class CoursePolicyTest extends TestCase
{
    use CreatePartners;

    public function test_bt_user_can_create_course_with_bt_user(){
        $BT_Partner_1 = $this->makePartner('BT', 'Usuario Comun');
        $BT_User_1 = $BT_Partner_1->user;
        
        $BT_Partner_2 = $this->makePartner('BT', 'Usuario Comun');

        $policy = new CoursePolicy();
        $this->assertTrue($policy->create($BT_User_1, $BT_Partner_2));
    }

    public function test_bt_user_cannot_create_course_with_ssv_user(){
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun');
        $BT_User = $BT_Partner->user;

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun');

        $policy = new CoursePolicy();
        $this->assertFalse($policy->create($BT_User, $SSV_Partner));
    }

    public function test_bt_user_cannot_create_course_with_pt_admin(){
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun');
        $BT_User = $BT_Partner->user;

        $PT_Partner = $this->makePartner('PT', 'Administrador');

        $policy = new CoursePolicy();
        $this->assertFalse($policy->create($BT_User, $PT_Partner));
    }

    public function test_ssv_user_can_update_course_with_bt_user()
    {
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun');
        $SSV_User = $SSV_Partner->user;

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun');

        $policy = new CoursePolicy();
        $this->assertTrue($policy->update($SSV_User, $BT_Partner));
    }

    public function test_bt_user_cannot_update_course_with_bt_user()
    {
        $BT_Partner_1 = $this->makePartner('BT', 'Usuario Comun');
        $BT_User_1 = $BT_Partner_1->user;

        $BT_Partner_2 = $this->makePartner('BT', 'Usuario Comun');

        $policy = new CoursePolicy();
        $this->assertFalse($policy->update($BT_User_1, $BT_Partner_2));
    }

    public function test_bt_user_cannot_update_course_with_ssv_user()
    {
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun');
        $BT_User = $BT_Partner->user;

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun');

        $policy = new CoursePolicy();
        $this->assertFalse($policy->update($BT_User, $SSV_Partner));
    }
}
