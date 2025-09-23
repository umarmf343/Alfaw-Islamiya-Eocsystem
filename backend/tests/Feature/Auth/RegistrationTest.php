<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
    }

    public function test_user_can_register_and_receive_role_assignment(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Hafsat Student',
            'email' => 'hafsat@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'Student',
            'timezone' => 'Africa/Lagos',
        ]);

        $response->assertRedirect(route('dashboard'));

        $user = User::where('email', 'hafsat@example.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('Student'));
        $this->assertEquals('Africa/Lagos', $user->timezone);
    }
}
