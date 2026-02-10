<?php

namespace Tests\Unit\Policies\Partner;

use App\Policies\PartnerPolicy;
use PHPUnit\Framework\TestCase;
use Tests\Support\CreatePartners;

class UpdatePolicyTest extends TestCase
{
    use CreatePartners;

    public function test_bt_user_can_update_ft_user_to_pt()
    {
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User = $BT_Partner->user;

        $FT_Partner = $this->makePartner('FT', 'Usuario Comun', true);

        $PT_Rol = $this->makePartnerRole('PT');

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->update($BT_User, $FT_Partner, $PT_Rol));
    }

    public function test_bt_user_cannot_update_bt_user_to_ft()
    {
        $BT_Partner_1 = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User_1 = $BT_Partner_1->user;

        $BT_Partner_2 = $this->makePartner('BT', 'Usuario Comun', true);

        $FT_Rol = $this->makePartnerRole('FT');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->update($BT_User_1, $BT_Partner_2, $FT_Rol));
    }

    public function test_bt_user_cannot_update_ssv_user_to_sm()
    {
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User = $BT_Partner->user;

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);

        $SM_Rol = $this->makePartnerRole('SM');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->update($BT_User, $SSV_Partner, $SM_Rol));
    }

    public function test_ssv_user_can_update_bt_user_to_ft()
    {
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User = $SSV_Partner->user;

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);

        $FT_Rol = $this->makePartnerRole('FT');

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->update($SSV_User, $BT_Partner, $FT_Rol));
    }

    public function test_ssv_user_cannot_update_pt_admin_to_ft()
    {
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User = $SSV_Partner->user;

        $PT_Partner = $this->makePartner('PT', 'Administrador', true);

        $FT_Rol = $this->makePartnerRole('FT');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->update($SSV_User, $PT_Partner, $FT_Rol));
    }

    public function test_sm_user_can_update_svv_user_to_bt()
    {
        $SM_Partner = $this->makePartner('SM', 'Usuario Comun', true);
        $SM_User = $SM_Partner->user;

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);

        $BT_Rol = $this->makePartnerRole('BT');

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->update($SM_User, $SSV_Partner, $BT_Rol));
    }

    public function test_sm_user_cannot_update_sm_user_to_ssv()
    {
        $SM_Partner_1 = $this->makePartner('SM', 'Usuario Comun', true);
        $SM_User_1 = $SM_Partner_1->user;

        $SM_Partner_2 = $this->makePartner('SM', 'Usuario Comun', true);

        $SSV_Rol = $this->makePartnerRole('SSV');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->update($SM_User_1, $SM_Partner_2, $SSV_Rol));
    }

    public function test_pt_admin_can_update_ssv_user_to_bt()
    {
        $PT_Partner = $this->makePartner('PT', 'Administrador', true);
        $PT_User = $PT_Partner->user;

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);

        $BT_Rol = $this->makePartnerRole('BT');

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->update($PT_User, $SSV_Partner, $BT_Rol));
    }

    public function test_ft_user_cannot_update_bt_user_to_ft()
    {
        $FT_Partner = $this->makePartner('FT', 'Usuario Comun', true);
        $FT_User = $FT_Partner->user;

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);

        $FT_Rol = $this->makePartnerRole('FT');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->update($FT_User, $BT_Partner, $FT_Rol));
    }

    public function test_bt_admin_innactive_cannot_update_ft_user_to_pt()
    {
        $BT_Partner = $this->makePartner('BT', 'Administrador', false);
        $BT_User = $BT_Partner->user;

        $FT_Partner = $this->makePartner('FT', 'Usuario Comun', true);

        $PT_Rol = $this->makePartnerRole('PT');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->update($BT_User, $FT_Partner, $PT_Rol));
    }
}
