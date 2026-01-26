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
        if(!$user->is_active){
            return false;
        }
        if($user->isAdmin()){
            return true;
        }
        return $user->partner->role->isManager();
    }

    public function viewAny(User $user): bool
    {
        return $this->canManage($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Course $course): bool
    {
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
    public function update(User $user, Partner $partner): bool
    {
        if(!$partner->role->isManager() || 
            $user->partner->role->hierarchy <= $partner->role->hierarchy
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
        if($user->partner->id !== $course->manager_id){
            return false;
        }
        return $this->canManage($user);
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
