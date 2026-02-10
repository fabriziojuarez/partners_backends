<?php

namespace Tests\Support;

use App\Models\Partner;
use App\Models\PartnerRole;
use App\Models\Role;
use App\Models\SystemRole;
use App\Models\User;
use App\Models\UserRole;

trait CreatePartners
{
    protected function makePartnerRole(string $partnerRolePrefix){
        switch($partnerRolePrefix){
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

        $partner_role = new PartnerRole([
            'hierarchy' => $hierarchy,
            'prefix' => $partnerRolePrefix,
        ]);
        return $partner_role;
    }

    protected function makePartner(
        string $partnerRolePrefix, 
        string $userRoleName, 
        bool $is_active): Partner
    {
        $partner_role = $this->makePartnerRole($partnerRolePrefix);

        $partner = new Partner();
        $partner->setRelation('partner_role', $partner_role);

        $user_role = new UserRole(['name' => $userRoleName]);

        $user = new User([
            'is_active' => $is_active,
        ]);
        $user->setRelation('user_role', $user_role);
        $partner->setRelation('user', $user);
        $user->setRelation('partner', $partner);

        return $partner;
    }
}