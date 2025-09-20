<?php

namespace App\Policies;

use App\Models\MemorizationReview;
use App\Models\User;

class MemorizationReviewPolicy
{
    public function update(User $user, MemorizationReview $review): bool
    {
        return $user->id === $review->user_id || $user->hasRole('Teacher');
    }
}
