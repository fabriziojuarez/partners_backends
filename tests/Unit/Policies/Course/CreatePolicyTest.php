<?php

namespace Tests\Unit\Policies\Course;

use App\Policies\CoursePolicy;
use PHPUnit\Framework\TestCase;
use Tests\Support\CreatePartners;

class CreatePolicyTest extends TestCase
{
    use CreatePartners;

    private function partner_create_course(string $rolePrefix, string $systemroleName, bool $is_active)
    {
        $Partner = $this->makePartner($rolePrefix, $systemroleName, $is_active);
        $User = $Partner->user;

        $policy = new CoursePolicy();
        return $policy->create($User, $Partner);
    }

    public function test_bt_user_can_create_course()
    {
        $this->assertTrue($this->partner_create_course('BT', 'Usuario Comun', true));
    }

    public function test_ssv_user_can_create_course()
    {
        $this->assertTrue($this->partner_create_course('SSV', 'Usuario Comun', true));
    }

    public function test_sm_user_can_create_course()
    {
        $this->assertTrue($this->partner_create_course('SM', 'Usuario Comun', true));
    }

    public function pt_admin_can_create_course()
    {
        $this->assertTrue($this->partner_create_course('PT', 'Administrador', true));
    }

    public function pt_user_cannot_create_course()
    {
        $this->assertFalse($this->partner_create_course('PT', 'Usuario Comun', true));
    }

    public function ft_user_cannot_create_course()
    {
        $this->assertFalse($this->partner_create_course('FT', 'Usuario Comun', true));
    }

    public function bt_admin_innactive_cannot_create_course()
    {
        $this->assertFalse($this->partner_create_course('BT', 'Administrador', false));
    }
}
