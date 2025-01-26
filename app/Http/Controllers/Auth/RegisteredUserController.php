<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'occupation' => ['required', 'string', 'max:255'],
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'role' => ['required', 'in:employee,teacher'],
            'certificate' => ['required_if:role,teacher', 'file', 'mimes:pdf,doc,docx,jpeg,png,jpg', 'max:5120'],
            'cv' => ['required_if:role,teacher', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        // Upload avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'occupation' => $request->occupation,
            'avatar' => $avatarPath,
        ]);

        // Handle teacher registration
        if ($request->role === 'teacher') {
            $certificatePath = $request->file('certificate')->store('teachers/documents', 'public');
            $cvPath = $request->file('cv')->store('teachers/cvs', 'public');

            Teacher::create([
                'user_id' => $user->id,
                'certificate' => $certificatePath,
                'cv' => $cvPath,
                'is_active' => false // Need admin approval
            ]);
        }

        // Assign role
        $user->assignRole($request->role);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
