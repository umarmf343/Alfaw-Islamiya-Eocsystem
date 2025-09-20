<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    public function refund(User $user, Payment $payment): bool
    {
        return $user->hasRole('Admin');
    }
}
