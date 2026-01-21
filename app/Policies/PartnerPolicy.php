<?php

namespace App\Policies;

use App\Models\Partner;
use App\Models\User;

class PartnerPolicy
{
    private function canManage(User $user, Partner $partner): bool
    {
        // Toda accion realizada por el administrador se cumplira
        if($user->isAdmin()){
            return true;
        }
        // Dependera si el usuario que realiza la accion tiene una mayor jerarquia
        return $user->partner->role->hierarchy > $partner->role->hierarchy;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->partner->role->isManager();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Partner $partner): bool
    {
        if ($user->partner->role->isManager() || $user->isAdmin()) {
            return true;
        }
        return $user->partner->id === $partner->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Partner $partner): bool
    {
        // Todo usuario que no sea gestor de partners, dara error
        if(!$user->partner->role->isManager()){
            return false;
        }
        return $this->canManage($user, $partner);

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Partner $partner): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Partner $partner): bool
    {
        // Si se intenta eliminar a un usuario administrador, dara error
        if($partner->user->isAdmin()){
            return false;
        }
        return $this->canManage($user, $partner);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Partner $partner): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Partner $partner): bool
    {
        return false;
    }
}
