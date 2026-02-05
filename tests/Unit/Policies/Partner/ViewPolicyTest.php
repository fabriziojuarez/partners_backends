<?php

namespace Tests\Unit\Policies\Partner;

use App\Policies\PartnerPolicy;
use PHPUnit\Framework\TestCase;
use Tests\Support\CreatePartners;

use function Symfony\Component\String\s;

class ViewPolicyTest extends TestCase
{
    use CreatePartners;

    private function partner_view_any_partner(string $rolePrefix, string $systemroleName, bool $is_active){
        $Partner = $this->makePartner($rolePrefix, $systemroleName, $is_active);
        $User = $Partner->user;

        $policy = new PartnerPolicy();
        return $policy->viewAny($User);
    }

    public function test_bt_user_can_view_any_partner()
    {
        $this->assertTrue($this->partner_view_any_partner('BT', 'Usuario Comun', true));
    }

    public function test_ssv_user_can_view_any_partner()
    {
        $this->assertTrue($this->partner_view_any_partner('SSV', 'Usuario Comun', true));
    }

    public function test_sm_user_can_view_any_partner()
    {
        $this->assertTrue($this->partner_view_any_partner('SM', 'Usuario Comun', true));
    }

    public function test_ft_admin_can_view_any_partner()
    {
        $this->assertTrue($this->partner_view_any_partner('FT', 'Administrador', true));
    }

    public function test_ft_user_cannot_view_any_partner()
    {
        $this->assertFalse($this->partner_view_any_partner('FT', 'Usuario Comun', true));
    }

    public function test_pt_admin_innactive_cannot_view_any_partner()
    {
        $this->assertFalse($this->partner_view_any_partner('PT', 'Administrador', false)); 
    }
}
