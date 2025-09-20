<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\MemorizationReview;
use App\Models\Payment;
use App\Models\Recitation;
use App\Policies\AssignmentPolicy;
use App\Policies\ClassroomPolicy;
use App\Policies\MemorizationReviewPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\RecitationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Assignment::class => AssignmentPolicy::class,
        Classroom::class => ClassroomPolicy::class,
        MemorizationReview::class => MemorizationReviewPolicy::class,
        Payment::class => PaymentPolicy::class,
        Recitation::class => RecitationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
