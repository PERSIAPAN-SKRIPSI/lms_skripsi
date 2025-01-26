<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('user')
            ->orderBy('is_active', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereDoesntHave('teacher')
            ->whereHas('roles', fn($q) => $q->where('name', 'employee'))
            ->get();

        return view('admin.teachers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'certificate' => 'nullable|file|mimes:pdf,doc,docx,jpeg,png,jpg|max:5120',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
             'use_existing' => 'sometimes|boolean'
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        DB::transaction(function () use ($user, $request) {
             $teacherData = [
                'user_id' => $user->id,
                'is_active' => $request->has('activate')
            ];

            // Handle document uploads
            if ($request->use_existing) {
                $existing = Teacher::where('user_id', $user->id)->firstOrFail();
                $teacherData['certificate'] = $existing->certificate;
                $teacherData['cv'] = $existing->cv;
            } else {
                if ($request->hasFile('certificate')) {
                    $teacherData['certificate'] = $request->file('certificate')->store('teachers/documents', 'public');
                }

                if ($request->hasFile('cv')) {
                    $teacherData['cv'] = $request->file('cv')->store('teachers/cvs', 'public');
                }
            }

            $teacher = Teacher::updateOrCreate(
                ['user_id' => $user->id],
                $teacherData
            );

            // Update user role
            $user->syncRoles(['teacher']);

            // Deactivate employee role if exists
            if ($user->hasRole('employee')) {
                $user->removeRole('employee');
            }
         });


        return redirect()->route('admin.teachers.index')->with('success', 'Teacher berhasil ditambahkan/diupdate');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', [
            'teacher' => $teacher->load('user'),
            'certificateUrl' => $teacher->certificate ? Storage::url($teacher->certificate) : null,
            'cvUrl' => $teacher->cv ? Storage::url($teacher->cv) : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', [
            'teacher' => $teacher->load('user'),
            'users' => User::whereDoesntHave('teacher')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'certificate' => 'nullable|file|mimes:pdf,doc,docx,jpeg,png,jpg|max:5120',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($teacher, $request) {
            $updateData = ['is_active' => $request->is_active ?? false];

            // Handle certificate update
            if ($request->hasFile('certificate')) {
                Storage::delete($teacher->certificate);
                $updateData['certificate'] = $request->file('certificate')->store('teachers/documents', 'public');
            }

            // Handle CV update
            if ($request->hasFile('cv')) {
                Storage::delete($teacher->cv);
                $updateData['cv'] = $request->file('cv')->store('teachers/cvs', 'public');
            }

            $teacher->update($updateData);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Data teacher berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        DB::transaction(function () use ($teacher) {
           $user = $teacher->user;

            // Delete documents
            Storage::delete([$teacher->certificate, $teacher->cv]);

            $teacher->delete();

            // Reset user role
            if ($user && !$user->hasRole('admin')) {
                $user->syncRoles(['employee']);
            }
        });


        return redirect()->route('admin.teachers.index')->with('success', 'Teacher berhasil dihapus');
    }

    /**
     * Check existing documents for a user
     */
    public function checkDocuments(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->teacher) {
            return response()->json(['exists' => false]);
        }

        return response()->json([
            'exists' => true,
            'certificate' => Storage::url($user->teacher->certificate),
            'cv' => Storage::url($user->teacher->cv)
        ]);
    }

    /**
     * Toggle teacher activation status
     */
     public function activate(Teacher $teacher)
     {
         $teacher->update(['is_active' => !$teacher->is_active]);
         return back()->with('success', 'Status teacher berhasil diupdate');
    }
}
