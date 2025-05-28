<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Set locale Carbon ke Indonesia agar format tanggal (nama bulan) juga Indonesia
        Carbon::setLocale('id');

        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        $startDate = $startDateInput ? Carbon::parse($startDateInput)->startOfDay() : null;
        $endDate = $endDateInput ? Carbon::parse($endDateInput)->endOfDay() : null;

        // --- Rentang Tanggal untuk Tampilan ---
        $dateRangeDisplay = "Semua Waktu";
        if ($startDate && $endDate) {
            if ($startDate->isSameDay($endDate)) {
                $dateRangeDisplay = $startDate->isoFormat('D MMMM YYYY');
            } else {
                $dateRangeDisplay = $startDate->isoFormat('D MMMM YYYY') . ' - ' . $endDate->isoFormat('D MMMM YYYY');
            }
        } elseif ($startDate) {
            $dateRangeDisplay = "Mulai " . $startDate->isoFormat('D MMMM YYYY');
        } elseif ($endDate) {
            $dateRangeDisplay = "Hingga " . $endDate->isoFormat('D MMMM YYYY');
        }


        // --- Statistik Karyawan, Terfilter Tanggal ---
        $employeeQuizAttemptsQuery = QuizAttempt::whereHas('user', function ($query) {
            $query->role('employee'); // Pastikan 'employee' adalah nama role yang benar
        })->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('quiz_attempts.created_at', [$startDate, $endDate]);
        })->when($startDate && !$endDate, function ($query) use ($startDate) {
            return $query->where('quiz_attempts.created_at', '>=', $startDate);
        })->when(!$startDate && $endDate, function ($query) use ($endDate) {
            return $query->where('quiz_attempts.created_at', '<=', $endDate);
        });

        $totalQuizAttemptsEmployeeFiltered = (clone $employeeQuizAttemptsQuery)->count();
        $averageQuizScoreEmployeeFiltered = (clone $employeeQuizAttemptsQuery)->avg('score') ?? 0;

        $quizPassingRateEmployeeFiltered = 0;
        if ($totalQuizAttemptsEmployeeFiltered > 0) {
            $passedEmployeeQuizAttemptsCount = (clone $employeeQuizAttemptsQuery)
                ->where('status', 'passed')
                ->count();
            $quizPassingRateEmployeeFiltered = ($passedEmployeeQuizAttemptsCount / $totalQuizAttemptsEmployeeFiltered) * 100;
        }

        $totalUniqueEmployeeAttemptersFiltered = (clone $employeeQuizAttemptsQuery)
                                                ->distinct('user_id')
                                                ->count('user_id');

        $employeeAttemptersDetails = [];
        if ($totalQuizAttemptsEmployeeFiltered > 0) {
             $employeeAttemptersDetails = (clone $employeeQuizAttemptsQuery)
                ->join('users', 'quiz_attempts.user_id', '=', 'users.id')
                ->select('users.id as user_id', 'users.name as user_name')
                ->distinct('users.id')
                ->orderBy('users.name')
                ->get()
                ->map(fn ($item) => ['id' => $item->user_id, 'name' => $item->user_name])
                ->all();
        }

        // --- Statistik Sistem Keseluruhan ---
        $totalQuizzesSystem = Quiz::count();
        $totalActiveQuizzesSystem = Quiz::where('is_active', true)->count();

        return view('admin.dashboard', [
            'totalQuizzesSystem' => $totalQuizzesSystem,
            'totalActiveQuizzesSystem' => $totalActiveQuizzesSystem,

            'totalQuizAttemptsEmployeeFiltered' => $totalQuizAttemptsEmployeeFiltered,
            'averageQuizScoreEmployeeFiltered' => $averageQuizScoreEmployeeFiltered,
            'quizPassingRateEmployeeFiltered' => $quizPassingRateEmployeeFiltered,
            'totalUniqueEmployeeAttemptersFiltered' => $totalUniqueEmployeeAttemptersFiltered,

            'employeeAttemptersDetails' => $employeeAttemptersDetails,

            'startDate' => $startDateInput,
            'endDate' => $endDateInput,
            'dateRangeDisplay' => $dateRangeDisplay,

            // Variabel untuk Radar Chart (sudah disesuaikan dengan data karyawan terfilter)
            'totalQuizzes' => $totalQuizzesSystem, // Ini adalah total kuis di sistem
            'totalQuizAttempts' => $totalQuizAttemptsEmployeeFiltered,
            'averageQuizScore' => $averageQuizScoreEmployeeFiltered,
            'quizPassingRate' => $quizPassingRateEmployeeFiltered,
        ]);
    }
}
