<?php

namespace App\Http\Controllers;

use App\Models\CourseEmployee;
use Illuminate\Http\Request;

class CourseEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the currently authenticated user's courses.

        // Return the view, passing the courses to it.
        return view('admin.employees.courses.index');
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
}
