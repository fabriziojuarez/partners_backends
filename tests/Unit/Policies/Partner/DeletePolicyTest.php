<?php

namespace Tests\Unit\Policies\Partner;

use App\Policies\PartnerPolicy;
use PHPUnit\Framework\TestCase;
use Tests\Support\CreatePartners;

class DeletePolicyTest extends TestCase
{
    use CreatePartners;

    public function test_bt_user_can_delete_ft_user(){
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User = $BT_Partner->user;

        $FT_Partner = $this->makePartner('FT', 'Usuario Comun', true);

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->delete($BT_User, $FT_Partner));
    }

    public function test_bt_user_cannot_delete_bt_user(){
        $BT_Partner_1 = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User_1 = $BT_Partner_1->user;

        $BT_Partner_2 = $this->makePartner('BT', 'Usuario Comun', true);

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->delete($BT_User_1, $BT_Partner_2));
    }

    public function test_bt_user_cannot_delete_ssv_user(){
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);
        $BT_User = $BT_Partner->user;

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->delete($BT_User, $SSV_Partner));
    }

    public function test_ssv_user_can_delete_bt_user(){
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User = $SSV_Partner->user;

        $BT_Partner = $this->makePartner('BT', 'Usuario Comun', true);

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->delete($SSV_User, $BT_Partner));
    }

    public function test_ssv_user_cannot_delete_ssv_user(){
        $SSV_Partner_1 = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User_1 = $SSV_Partner_1->user;

        $SSV_Partner_2 = $this->makePartner('SSV', 'Usuario Comun', true);

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->delete($SSV_User_1, $SSV_Partner_2));
    }

    public function test_ssv_user_cannot_delete_sm_user(){
        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        $SSV_User = $SSV_Partner->user;

        $SM_Partner = $this->makePartner('SM', 'Usuario Comun', true);

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->delete($SSV_User, $SM_Partner));
    }

    public function test_sm_user_can_delete_ssv_user(){
        $SM_Partner = $this->makePartner('SM', 'Usuario Comun', true);
        $SM_User = $SM_Partner->user;

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);

        $policy = new PartnerPolicy();
        $this->assertTrue($policy->delete($SM_User, $SSV_Partner));
    }

    public function test_sm_user_cannot_delete_pt_admin(){
        $SM_Partner = $this->makePartner('SM', 'Usuario Comun', true);
        $SM_User = $SM_Partner->user;

        $PT_Partner = $this->makePartner('PT', 'Administrador', true);

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->delete($SM_User, $PT_Partner));
    }

    public function test_ft_admin_can_delete_ssv_user(){
        $FT_Partner = $this->makePartner('FT', 'Administrador', true);
        $FT_User = $FT_Partner->user;

        $SSV_Partner = $this->makePartner('SSV', 'Usuario Comun', true);
        
        $policy = new PartnerPolicy();
        $this->assertTrue($policy->delete($FT_User, $SSV_Partner));
    }
}
