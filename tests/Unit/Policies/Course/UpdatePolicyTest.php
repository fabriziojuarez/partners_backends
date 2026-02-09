<?php

namespace Tests\Unit\Policies\Course;

use App\Models\Course;
use App\Policies\CoursePolicy;
use PHPUnit\Framework\TestCase;
use Tests\Support\CreateCourses;
use Tests\Support\CreatePartners;

class UpdatePolicyTest extends TestCase
{
    use CreatePartners;
    use CreateCourses;

    public function test_bt_user_manager_can_update_course()
    {
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User = $BT_Partner->user;

        $BT_Course = $this->makeCourse($BT_Partner);

        $policy = new CoursePolicy();
        $this->assertTrue($policy->update($BT_User, $BT_Course, $BT_Partner));
    }

    public function test_bt_user_manager_cannot_update_course_to_ssv()
    {
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User = $BT_Partner->user;

        $BT_Course = $this->makeCourse($BT_Partner);

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);

        $policy = new CoursePolicy();
        $this->assertFalse($policy->update($BT_User, $BT_Course, $SSV_Partner));
    }

    public function test_ssv_user_manager_can_update_course_to_bt()
    {
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User = $SSV_Partner->user;

        $SSV_Course = $this->makeCourse($SSV_Partner);

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);

        $policy = new CoursePolicy();
        $this->assertTrue($policy->update($SSV_User, $SSV_Course, $BT_Partner));
    }

    public function test_sm_user_no_manager_can_update_ssv_course_to_bt()
    {
        $SM_Partner = $this->makePartner('SM', 'Usuario Comun', true);
        $SM_User = $SM_Partner->user;

        $SSV_Partner = $this->makePartner('SSV', 'Usuarion Comun', true);
        $SSV_Course = $this->makeCourse($SSV_Partner);

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);

        $policy = new CoursePolicy();
        $this->assertTrue($policy->update($SM_User, $SSV_Course, $BT_Partner));
    }

    public function test_sm_user_manager_cannot_update_course_to_pt()
    {
        $SM_Partner = $this->makePartner('SM', 'Usuario Comun', true);
        $SM_User = $SM_Partner->user;

        $SM_Course = $this->makeCourse($SM_Partner);

        $PT_Partner = $this->makePartner('PT', 'Usuario Comun', true);

        $policy = new CoursePolicy();
        $this->assertFalse($policy->update($SM_User, $SM_Course, $PT_Partner));
    }

    public function test_bt_user_manager_cannot_update_course_to_bt()
    {
        $BT_Partner_1 = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User_1 = $BT_Partner_1->user;

        $BT_Course_1 = $this->makeCourse($BT_Partner_1);

        $BT_Partner_2 = $this->makePartner('BT', 'Usuario Comun', true);

        $policy = new CoursePolicy();
        $this->assertFalse($policy->update($BT_User_1, $BT_Course_1, $BT_Partner_2));
    }

    public function test_ssv_user_no_manager_can_update_bt_course_to_me()
    {
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User = $SSV_Partner->user;

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_Course = $this->makeCourse($BT_Partner);

        $policy = new CoursePolicy();
        $this->assertTrue($policy->update($SSV_User, $BT_Course, $SSV_Partner));
    }

    public function test_ssv_user_no_manager_cannot_update_bt_course_to_ssv()
    {
        $SSV_Partner_1 = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User_1 = $SSV_Partner_1->user;

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_Course = $this->makeCourse($BT_Partner);

        $SSV_Partner_2 = $this->makePartner('SSV', 'Usuario Comun', true);

        $policy = new CoursePolicy();
        $this->assertFalse($policy->update($SSV_User_1, $BT_Course, $SSV_Partner_2));
    }

    public function test_bt_admin_no_manager_can_update_bt_course()
    {
        $BT_Partner_1 = $this->makePartner('BT', 'Administrador', true);
        $BT_User_1 = $BT_Partner_1->user;

        $BT_Partner_2 = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_Course_2 = $this->makeCourse($BT_Partner_2);

        $policy = new CoursePolicy();
        $this->assertTrue($policy->update($BT_User_1, $BT_Course_2, $BT_Partner_2));
    }

    public function test_sm_user_manager_cannot_update_course_to_pt_admin()
    {
        $SM_Partner = $this->makePartner('SM', 'Usuario Comun', true);
        $SM_User = $SM_Partner->user;

        $SM_Course = $this->makeCourse($SM_Partner);

        $PT_Partner = $this->makePartner('PT', 'Administrador', true);

        $policy = new CoursePolicy();
        $this->assertFalse($policy->update($SM_User, $SM_Course, $PT_Partner));
    }

    public function test_sm_manager_can_update_course_to_bt_admin()
    {
        $SM_Partner = $this->makePartner('SM', 'Usuario Comun', true);
        $SM_User = $SM_Partner->user;

        $SM_Course = $this->makeCourse($SM_Partner);

        $BT_Partner = $this->makePartner('BT', 'Administrador', true);

        $policy = new CoursePolicy();
        $this->assertTrue($policy->update($SM_User, $SM_Course, $BT_Partner));
    }

    public function test_pt_admin_can_update_ssv_course()
    {
        $PT_Partner = $this->makePartner('PT', 'Administrador', true);
        $PT_User = $PT_Partner->user;

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_Course = $this->makeCourse($SSV_Partner);

        $policy = new CoursePolicy();
        $this->assertTrue($policy->update($PT_User, $SSV_Course, $SSV_Partner));
    }

    public function test_pt_admin_can_update_bt_course_to_ssv(){
        $PT_Partner = $this->makePartner('PT', 'Administrador', true);
        $PT_User = $PT_Partner->user;

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_Course = $this->makeCourse($BT_Partner);

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);

        $policy = new CoursePolicy();
        $this->assertTrue($policy->update($PT_User, $BT_Course, $SSV_Partner));
    }

    public function test_ssv_admin_innactive_cannot_update_course_to_bt()
    {
        $SSV_Partner = $this->makePartner('SSV', 'Administrador', false);
        $SSV_User = $SSV_Partner->user;

        $SSV_Course = $this->makeCourse($SSV_Partner);

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);

        $policy = new CoursePolicy();
        $this->assertFalse($policy->update($SSV_User, $SSV_Course, $BT_Partner));
    }

    public function test_ssv_admin_cannot_update_course_to_bt_innactive()
    {
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User = $SSV_Partner->user;

        $SSV_Course = $this->makeCourse($SSV_Partner);

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', false);

        $policy = new CoursePolicy();
        $this->assertFalse($policy->update($SSV_User, $SSV_Course, $BT_Partner));
    }
}
