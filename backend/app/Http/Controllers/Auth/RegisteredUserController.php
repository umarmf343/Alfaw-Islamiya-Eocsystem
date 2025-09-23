<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    protected array $availableRoles = ['Student', 'Teacher'];

    public function create(): View
    {
        return view('auth.register', [
            'roles' => $this->availableRoles,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'string', 'in:' . implode(',', $this->availableRoles)],
            'timezone' => ['nullable', 'string', 'max:64'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'timezone' => $validated['timezone'] ?? config('app.timezone'),
        ]);

        $user->assignRole($validated['role']);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Welcome to AlFawz! Your profile is ready.');
    }
}
