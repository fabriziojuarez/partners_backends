<?php

namespace Tests\Unit\Policies\Partner;

use PHPUnit\Framework\TestCase;

use App\Policies\PartnerPolicy;
use Tests\Support\CreatePartners;

class CreatePolicyTest extends TestCase
{
    use CreatePartners;

    public function test_bt_user_can_create_ft_user()
    {
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User = $BT_Partner->user;

        $FT_Rol = $this->makeRole('FT');

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->create($BT_User, $FT_Rol));
    }

    public function test_bt_user_cannot_create_bt_user()
    {
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User = $BT_Partner->user;

        $BT_Rol = $this->makeRole('BT');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->create($BT_User, $BT_Rol));
    }

    public function test_bt_user_cannot_create_ssv_user()
    {
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User = $BT_Partner->user;

        $SSV_Rol = $this->makeRole('SSV');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->create($BT_User, $SSV_Rol));
    }

    public function test_ssv_user_can_create_bt_user()
    {
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User = $SSV_Partner->user;

        $BT_Rol = $this->makeRole('BT');

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->create($SSV_User, $BT_Rol));
    }

    public function test_svv_user_cannot_create_ssv_user()
    {
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User = $SSV_Partner->user;

        $SSV_Rol = $this->makeRole('SSV');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->create($SSV_User, $SSV_Rol));
    }

    public function test_sm_user_can_create_ssv_user()
    {
        $SM_Partner = $this->makePartner('SM', 'Usuario Comun', true);
        $SM_User = $SM_Partner->user;

        $SSV_Rol = $this->makeRole('SSV');

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->create($SM_User, $SSV_Rol));
    }

    public function test_pt_admin_can_create_ssv_user()
    {
        $PT_Partner = $this->makePartner('PT', 'Administrador', true);
        $PT_User = $PT_Partner->user;

        $SSV_Rol = $this->makeRole('SSV');

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->create($PT_User, $SSV_Rol));
    }

    public function test_pt_user_cannot_create_bt_user()
    {
        $PT_Partner = $this->makePartner('PT', 'Usuario Comun', true);
        $PT_User = $PT_Partner->user;

        $BT_Rol = $this->makeRole('BT');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->create($PT_User, $BT_Rol));
    }

    public function test_bt_admin_innactive_cannot_create_pt_user()
    {
        $BT_Partner = $this->makePartner('BT', 'Administrador', false);
        $BT_User = $BT_Partner->user;

        $PT_Rol = $this->makeRole('PT');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->create($BT_User, $PT_Rol));
    }
}
