<?php

namespace Tests\Unit\Policies\Course;

use App\Policies\CoursePolicy;
use PHPUnit\Framework\TestCase;
use Tests\Support\CreatePartners;

class ViewPolicyTest extends TestCase
{
    use CreatePartners;

    private function parnter_view_any_course(){
        
    }
    private function partner_view_courses(string $rolePrefix, string $systemroleName, bool $is_active)
    {
        $Partner = $this->makePartner($rolePrefix, $systemroleName, $is_active);
        $User = $Partner->user;

        $policy = new CoursePolicy();
        return $policy->view($User);
    }

    public function test_bt_user_can_view_courses()
    {
        $this->assertTrue($this->partner_view_courses('BT', 'Usuario Comun', true));
    }

    public function test_ssv_user_can_view_courses()
    {
        $this->assertTrue($this->partner_view_courses('SSV', 'Usuario Comun', true));
    }

    public function test_sm_user_can_view_courses()
    {
        $this->assertTrue($this->partner_view_courses('SM', 'Usuario Comun', true));
    }

    public function test_pt_user_cannot_view_courses()
    {
        $this->assertFalse($this->partner_view_courses('PT', 'Usuario Comun', true));
    }

    public function test_ft_user_cannot_view_courses()
    {
        $this->assertFalse($this->partner_view_courses('FT', 'Usuario Comun', true));
    }

    public function test_pt_admin_can_view_courses()
    {
        $this->assertTrue($this->partner_view_courses('PT', 'Administrador', true));
    }

    public function test_bt_admin_innactive_cannot_view_courses()
    {
        $this->assertFalse($this->partner_view_courses('BT', 'Administrador', false));
    }
}
