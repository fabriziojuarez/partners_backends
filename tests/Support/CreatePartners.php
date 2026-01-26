<?php

namespace Tests\Support;

use App\Models\Partner;
use App\Models\Role;
use App\Models\SystemRole;
use App\Models\User;

trait CreatePartners
{
    protected function makePartner(string $rolePrefix, string $systemRoleName): Partner
    {
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

        $partner = new Partner();
        $partner->setRelation('role', $role);

        $systemRole = new SystemRole(['name' => $systemRoleName]);

        $user = new User();
        $user->setRelation('systemRole', $systemRole);
        $partner->setRelation('user', $user);
        $user->setRelation('partner', $partner);

        return $partner;
    }
}