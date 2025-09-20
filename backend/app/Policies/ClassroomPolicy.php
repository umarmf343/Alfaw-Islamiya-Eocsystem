<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;

class ClassroomPolicy
{
    public function view(User $user, Classroom $classroom): bool
    {
        return $user->hasRole('Admin')
            || $classroom->teachers()->whereKey($user->id)->exists()
            || $classroom->students()->whereKey($user->id)->exists();
    }

    public function update(User $user, Classroom $classroom): bool
    {
        return $user->hasRole('Admin');
    }
}
