<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PaystackWebhookTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_successful_charge_marks_payment_and_enrols_student(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Student');

        $classroom = Classroom::create([
            'name' => 'Evening Hifdh Circle',
            'description' => 'Intensive memorisation programme',
            'start_date' => Carbon::now()->startOfMonth(),
            'end_date' => Carbon::now()->addMonths(3),
        ]);

        $payment = Payment::create([
            'user_id' => $user->id,
            'reference' => 'PSK-12345',
            'amount' => 15000,
            'currency' => 'NGN',
            'status' => 'initialized',
            'metadata' => [],
        ]);

        config(['services.paystack.webhook_secret' => 'test-secret']);

        $payload = [
            'event' => 'charge.success',
            'data' => [
                'reference' => 'PSK-12345',
                'metadata' => [
                    'classroom_id' => $classroom->id,
                ],
                'amount' => 1500000,
            ],
        ];

        $signature = hash_hmac('sha512', json_encode($payload), 'test-secret');

        $this->postJson('/api/payments/webhook', $payload, ['x-paystack-signature' => $signature])
            ->assertStatus(202);

        $payment->refresh();

        $this->assertEquals('successful', $payment->status);
        $this->assertDatabaseHas('enrollments', [
            'classroom_id' => $classroom->id,
            'student_id' => $user->id,
            'status' => 'active',
        ]);
    }
}
