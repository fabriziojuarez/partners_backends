<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    private function canManage(User $user): bool
    {
        return $user->partner->role->isManager() || $user->isAdmin();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if(!$user->is_active)return false;
        // Si es FT o PT solo lo pueden ver los cursos en que uno esta escrito
        return $this->canManage($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if(!$user->is_active)return false;
        return $this->canManage($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->canManage($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Course $course, Partner $partner): bool
    {
        if(!$user->is_active || !$partner->user->is_active || !$partner->role->isManager()){
            return false;
        }
        if(
            (($course->manager->role->hierarchy > $user->partner->role->hierarchy &&
            $course->manager !== $user->partner) || ($user->partner !== $partner &&
            $user->partner->role->hierarchy <= $partner->role->hierarchy)) && 
            !$user->isAdmin()
        ){
            return false;
        }
        return $this->canManage($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Course $course): bool
    {
        if($course->manager === $user->partner){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Course $course): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Course $course): bool
    {
        return false;
    }
}
