<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseTopic;

class TopicPolicy
{
    private function canManage(User $user){
        return $user->isAdmin() || $user->partner->partner_role->isManager();
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->canManage($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CourseTopic $topic): bool
    {
        return $this->canManage($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Course $course): bool
    {
        return $this->canManage($user) && $course->manager === $user->partner;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CourseTopic $topic, Course $course): bool
    {
        if($topic->course !== $course) return false;
        return $this->canManage($user) && $course->manager === $user->partner;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CourseTopic $topic): bool
    {
        return $user->isAdmin() || 
        ($user->partner->partner_role->isManager() && $topic->course->manager === $user->partner);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CourseTopic $topic): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CourseTopic $topic): bool
    {
        return false;
    }
}
