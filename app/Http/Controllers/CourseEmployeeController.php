<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employeeId = Auth::id();

        $enrolledCourses = CourseEmployee::with('course')
            ->where('user_id', $employeeId)
            ->where('is_approved', true) // Opsional: Hanya kursus yang disetujui
            ->get();

        return view('employees-dashboard.courses.index', compact('enrolledCourses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseEmployee $CourseEmployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseEmployee $CourseEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseEmployee $CourseEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseEmployee $CourseEmployee)
    {
        //
    }
    public function enroll(Request $request, Course $course)
    {
        $employee = Auth::user();

        // Periksa apakah karyawan sudah terdaftar di kursus ini
        $isEnrolled = CourseEmployee::where('user_id', $employee->id)
            ->where('course_id', $course->id)
            ->exists();

        if ($isEnrolled) {
            // Jika sudah terdaftar, redirect dengan pesan error atau kembali ke halaman kursus dengan pesan
            return Redirect::back()->with('error', 'Anda sudah terdaftar dalam kursus ini.');
        }

        // Mulai transaksi database untuk memastikan atomicity
        DB::beginTransaction();
        try {
            // Buat record pendaftaran di tabel course_employees
            CourseEmployee::create([
                'user_id' => $employee->id,
                'course_id' => $course->id,
                'enrolled_at' => now(), // Tambahkan waktu pendaftaran
                'is_approved' => true, // Atur default is_approved menjadi true atau sesuai kebutuhan Anda
            ]);

            DB::commit(); // Commit transaksi jika berhasil
            // Redirect ke halaman dashboard karyawan atau halaman kursus dengan pesan sukses
            return redirect()->route('employee.dashboard')->with('success', 'Anda berhasil mendaftar di kursus ' . $course->name . '.');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan
            // Log error atau tampilkan pesan error yang lebih informatif
            return Redirect::back()->with('error', 'Terjadi kesalahan saat mendaftar kursus. Silakan coba lagi.');
        }
    }
}
