<?php

namespace Tests\Unit\Policies;

use PHPUnit\Framework\TestCase;

use App\Models\User;
use App\Models\Partner;
use App\Models\Role;
use App\Models\SystemRole;

use App\Policies\PartnerPolicy;
use Tests\Support\CreatePartners;

class PartnerPolicyTest extends TestCase
{
    use CreatePartners;

    public function test_bt_user_cannot_delete_pt_admin()
    {
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun');
        $BT_User = $BT_Partner->user;

        $PT_Partner = $this->makePartner('PT', 'Administrador');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->delete($BT_User, $PT_Partner));
    }

    public function test_bt_user_cannot_update_bt_user()
    {
        $BT_Partner_1 = $this->makePartner('BT', 'Usuario Comun');
        $BT_User_1 = $BT_Partner_1->user;
        
        $BT_Partner_2 = $this->makePartner('BT', 'Usuario Comun');
        
        $newRole = new Role(['hierarchy' => 2]);

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->update($BT_User_1, $BT_Partner_2, $newRole));
    }

    public function test_bt_user_innactive_cannot_see_partners()
    {
        $BT_Partner = $this->makePartner('BT', 'Usuario Comun');
        $BT_User = $BT_Partner->user;
        $BT_User->is_active = false;

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->viewAny($BT_User));
    }


}
