<?php

namespace Tests\Unit\Policies;

use PHPUnit\Framework\TestCase;

use App\Models\User;
use App\Models\Partner;
use App\Models\Role;
use App\Models\SystemRole;

use App\Policies\PartnerPolicy;

class PartnerPolicyTest extends TestCase
{

    private function makePartnerWhithRoles(int $role_hierarchy, string $role_prefix, string $system_role_name): Partner
    {
        $role = new Role([
            'hierarchy' => $role_hierarchy,
            'prefix' => $role_prefix,
        ]);

        $partner = new Partner();
        $partner->setRelation('role', $role);

        $systemRole = new SystemRole(['name' => $system_role_name]);

        $user = new User();
        $user->setRelation('systemRole', $systemRole);
        $partner->setRelation('user', $user);
        $user->setRelation('partner', $partner);
        
        return $partner;
    }

    public function test_bt_user_cannot_delete_pt_admin()
    {
        $BT_Partner = $this->makePartnerWhithRoles(2, 'BT', 'Usuario Comun');
        $BT_User = $BT_Partner->user;

        $PT_Partner = $this->makePartnerWhithRoles(1, 'PT', 'Administrador');

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->delete($BT_User, $PT_Partner));
    }

    public function test_bt_user_cannot_update_bt_user()
    {
        $BT_Partner_1 = $this->makePartnerWhithRoles(2, 'BT', 'Usuario Comun');
        $BT_User_1 = $BT_Partner_1->user;
        
        $BT_Partner_2 = $this->makePartnerWhithRoles(2, 'BT', 'Usuario Comun');
        
        $newRole = new Role(['hierarchy' => 2]);

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->update($BT_User_1, $BT_Partner_2, $newRole));
    }

    public function test_bt_user_innactive_cannot_see_partners()
    {
        $BT_Partner = $this->makePartnerWhithRoles(3, 'BT', 'Usuario Comun');
        $BT_User = $BT_Partner->user;
        $BT_User->is_active = false;

        $policy = new PartnerPolicy();
        $this->assertFalse($policy->viewAny($BT_User));
    }


}
