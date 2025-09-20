<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;

class AssignmentPolicy
{
    public function view(User $user, Assignment $assignment): bool
    {
        return $user->hasRole('Admin')
            || $user->id === $assignment->teacher_id
            || $assignment->classroom->students()->whereKey($user->id)->exists();
    }

    public function update(User $user, Assignment $assignment): bool
    {
        return $user->hasRole('Admin') || $user->id === $assignment->teacher_id;
    }

    public function delete(User $user, Assignment $assignment): bool
    {
        return $user->hasRole('Admin');
    }

    public function grade(User $user, Assignment $assignment): bool
    {
        return $user->hasRole('Admin') || $user->id === $assignment->teacher_id;
    }
}
