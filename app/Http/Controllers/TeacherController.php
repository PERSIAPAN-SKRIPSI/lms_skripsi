<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Only admins can view teachers
          if (!Auth::user()->hasRole('admin')) {
                abort(403, 'Unauthorized action.');
            }

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
          // Only admins can create teachers
          if (!Auth::user()->hasRole('admin')) {
                abort(403, 'Unauthorized action.');
            }
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
        // Hanya admin yang bisa membuat guru
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'email' => 'required|exists:users,email',
            'certificate' => 'nullable|file|mimes:pdf,doc,docx,jpeg,png,jpg|max:5120',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'use_existing' => 'sometimes|boolean'
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        // Validasi tambahan: cek apakah guru dengan user_id ini sudah ada
        $existingTeacher = Teacher::where('user_id', $user->id)->exists();
        if ($existingTeacher) {
            return back()->withErrors(['email' => 'Teacher with this email is already registered.'])->withInput();
        }

        DB::transaction(function () use ($user, $request) {
            $teacherData = [
                'user_id' => $user->id,
                'is_active' => $request->has('activate')
            ];

            $existingTeacherData = Teacher::where('user_id', $user->id)->first(); // Ambil data guru yang mungkin sudah ada (seharusnya tidak ada karena validasi di atas)

            // Handle document uploads
            if ($request->use_existing) {
                if ($existingTeacherData) { // Hanya gunakan dokumen existing jika guru sudah ada (seharusnya tidak ada karena validasi di atas)
                    $teacherData['certificate'] = $existingTeacherData->certificate;
                    $teacherData['cv'] = $existingTeacherData->cv;
                }
            } else {
                if ($request->hasFile('certificate')) {
                    if ($existingTeacherData && $existingTeacherData->certificate) { // Hapus certificate lama jika ada dan guru sudah exist (seharusnya tidak ada karena validasi di atas)
                        Storage::delete($existingTeacherData->certificate);
                    }
                    $teacherData['certificate'] = $request->file('certificate')->store('teachers/documents', 'public');
                }

                if ($request->hasFile('cv')) {
                    if ($existingTeacherData && $existingTeacherData->cv) { // Hapus CV lama jika ada dan guru sudah exist (seharusnya tidak ada karena validasi di atas)
                        Storage::delete($existingTeacherData->cv);
                    }
                    $teacherData['cv'] = $request->file('cv')->store('teachers/cvs', 'public');
                }
            }

            // Karena validasi di atas sudah memastikan guru belum ada, kita bisa langsung membuat guru baru
            $teacher = Teacher::create($teacherData);

            // Update user role
            $user->syncRoles(['teacher']);

            // Deactivate employee role if exists
            if ($user->hasRole('employee')) {
                $user->removeRole('employee');
            }
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
         // Only admins can view teachers
            if (!Auth::user()->hasRole('admin')) {
                abort(403, 'Unauthorized action.');
            }
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
         // Only admins can edit teachers
            if (!Auth::user()->hasRole('admin')) {
               abort(403, 'Unauthorized action.');
            }
        return view('admin.teachers.edit', [
            'teacher' => $teacher->load('user'),
            'users' => User::whereDoesntHave('teacher')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
      /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        // Only admins can update teachers
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'certificate' => 'nullable|file|mimes:pdf,doc,docx,jpeg,png,jpg|max:5120',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($teacher, $request) {
            $updateData = [];
            $isUpdated = false; // Flag untuk menandakan apakah ada update yang dilakukan

            // Handle is_active update
            if ($request->has('is_active')) {
                $updateData['is_active'] = $request->is_active;
                $isUpdated = true; // Tandai bahwa is_active diupdate jika ada di request
            }

            // Handle certificate update
            if ($request->hasFile('certificate')) {
                if ($teacher->certificate) {
                    Storage::delete($teacher->certificate);
                }
                $updateData['certificate'] = $request->file('certificate')->store('teachers/documents', 'public');
                $isUpdated = true; // Tandai bahwa certificate diupdate
            }

            // Handle CV update
            if ($request->hasFile('cv')) {
                if ($teacher->cv) {
                    Storage::delete($teacher->cv);
                }
                $updateData['cv'] = $request->file('cv')->store('teachers/cvs', 'public');
                $isUpdated = true; // Tandai bahwa cv diupdate
            }

            // Jika tidak ada update yang dilakukan, kembalikan dengan notifikasi
            if (!$isUpdated && empty($updateData)) {
                return back()->with('warning', 'Tidak ada dokumen atau status yang diupdate.');
            }

            if (!empty($updateData)) {
                $teacher->update($updateData);
            }
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Data teacher berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
          // Only admins can delete teachers
            if (!Auth::user()->hasRole('admin')) {
                abort(403, 'Unauthorized action.');
            }
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
         // Only admins can check teachers documents
         if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }
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
        // Only admins can activate/deactivate teachers
         if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }
        $teacher->update(['is_active' => !$teacher->is_active]);
        return back()->with('success', 'Status teacher berhasil diupdate');
    }
}
