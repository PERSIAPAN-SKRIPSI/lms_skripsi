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
            'role' => ['required', 'in:employee,teacher'], // Gunakan role

            // Validasi Tambahan untuk Employee
            'nik' => ['required', 'string', 'max:20', 'unique:users'], // Contoh: Harus unik
            'gender' => ['required', 'in:male,female'],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'division' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'employment_status' => ['required', 'string', 'max:255'],
            'join_date' => ['required', 'date'],
            'is_active' => ['sometimes', 'boolean'], // 'sometimes' karena mungkin tidak selalu ada di form.
            //'is_approved' => ['sometimes', 'boolean'], // Seharusnya di set di server, bukan dari form.

            // Validasi Tambahan untuk Teacher (Jika diperlukan)
            'certificate' => ['required_if:role,teacher', 'file', 'mimes:pdf,doc,docx,jpeg,png,jpg', 'max:5120'],
            'cv' => ['required_if:role,teacher', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        // Upload avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');

        // Determine is_approved based on role (only employee needs approval)
        $isApproved = $request->role !== 'employee';

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'occupation' => $request->occupation,
            'avatar' => $avatarPath,
            'is_approved' => $isApproved, // Set is_approved
        ];

        // Tambahkan data employee jika role adalah employee
        if ($request->role === 'employee') {
            $userData = array_merge($userData, [
                'nik' => $request->nik,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'division' => $request->division,
                'position' => $request->position,
                'employment_status' => $request->employment_status,
                'join_date' => $request->join_date,
                'is_active' => $request->is_active ?? false, // Default ke false jika tidak ada
            ]);
        }

        $user = User::create($userData);

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
