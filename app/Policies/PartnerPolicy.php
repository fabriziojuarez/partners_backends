<?php

namespace App\Policies;

use App\Models\Partner;
use App\Models\Role;
use App\Models\User;

class PartnerPolicy
{
    private function canManage(User $user, Role $role): bool
    {
        // Toda accion de un usuario o administrador inactivo dara error
        if(!$user->is_active){
            return false;
        }
        // Toda accion realizada por el administrador se cumplira
        if($user->isAdmin()){
            return true;
        }
        // Dependera si el usuario que realiza la accion tiene una mayor jerarquia
        return $user->partner->role->hierarchy > $role->hierarchy;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if(!$user->is_active){
            return false;
        }
        return $user->partner->role->isManager() || $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if(!$user->is_active){
            return false;
        }
        return $user->partner->role->isManager() || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Role $role): bool
    {
        // Todo usuario que no sea gestor de partners ni administrador, dara error
        if(!$user->partner->role->isManager() && !$user->isAdmin()){
            return false;
        }
        return $this->canManage($user, $role);
    }

    /**
     * Determine whether the user can update the model.
     */
    // User: Quien realiza la accion | Partner: Usuario seleccionado | Role: a definir
    public function update(User $user, Partner $partner, Role $role): bool
    {
        // Todo usuario que no sea gestor de partners ni administrador, dara error
        if(!$user->partner->role->isManager() && !$user->isAdmin()){
            return false;
        }

        // Si el partner seleccionado es de mayor jerarquia o es administrador, dara error
        if(!$this->canManage($user, $partner->role) || $partner->user->isAdmin()){
            return false;
        }
        // Si ninguno de los casos se cumple, el partner puede modificarlo con un rol inferior a el
        return $this->canManage($user, $role);
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
        return $this->canManage($user, $partner->role);
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
