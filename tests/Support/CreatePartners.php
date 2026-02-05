<?php

namespace Tests\Support;

use App\Models\Partner;
use App\Models\Role;
use App\Models\SystemRole;
use App\Models\User;

trait CreatePartners
{
    protected function makeRole(string $rolePrefix){
        switch($rolePrefix){
            case 'SM':
                $hierarchy = 4;
                break;
            case 'SSV':
                $hierarchy = 3;
                break;
            case 'BT':
                $hierarchy = 2;
                break;
            case 'FT' || 'PT':
                $hierarchy = 1;
                break;
        }

        $role = new Role([
            'hierarchy' => $hierarchy,
            'prefix' => $rolePrefix,
        ]);
        return $role;
    }

    protected function makePartner(string $rolePrefix, string $systemRoleName, bool $is_active): Partner
    {
        $role = $this->makeRole($rolePrefix);

        $partner = new Partner();
        $partner->setRelation('role', $role);

        $systemRole = new SystemRole(['name' => $systemRoleName]);

        $user = new User([
            'is_active' => $is_active,
        ]);
        $user->setRelation('systemRole', $systemRole);
        $partner->setRelation('user', $user);
        $user->setRelation('partner', $partner);

        return $partner;
    }
}