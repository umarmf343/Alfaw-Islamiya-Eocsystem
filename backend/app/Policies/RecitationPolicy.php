<?php

namespace App\Policies;

use App\Models\Recitation;
use App\Models\User;

class RecitationPolicy
{
    public function update(User $user, Recitation $recitation): bool
    {
        return $user->hasRole('Admin') || $user->hasRole('Teacher');
    }
}
