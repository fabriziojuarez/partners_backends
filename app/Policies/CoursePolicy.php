<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    private function canManage(User $user): bool
    {
        return $user->partner->role->isManager() || $user->isAdmin();
    }

    public function viewAny(User $user): bool
    {
        return $this->canManage($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $this->canManage($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Partner $partner): bool
    {
        if(
            !$partner->role->isManager() || 
            $partner->role->hierarchy > $user->partner->role->hierarchy
        ){
            return false;
        }
        return $this->canManage($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Partner $partner): bool
    {
        if(
            !$partner->role->isManager() || 
            $partner->role->hierarchy >= $user->partner->role->hierarchy
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
        if($course->manager->id === $user->partner->id){
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
