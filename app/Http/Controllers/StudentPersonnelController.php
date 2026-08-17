<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Personnel;
use Illuminate\Http\Request;

class StudentPersonnelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STUDENT MONITORING
    |--------------------------------------------------------------------------
    */

    public function students(Request $request)
    {
        $search = $request->get('search');

        $students = Student::with('latestAttendance')
            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('student_number', 'like', "%{$search}%")
                        ->orWhere('year_level', 'like', "%{$search}%")
                        ->orWhere('course_program', 'like', "%{$search}%")
                        ->orWhere('rfid_tag_uid', 'like', "%{$search}%");
                });
            })
            ->orderBy('lastname')
            ->orderBy('firstname')
            ->paginate(15)
            ->withQueryString();

        $totalStudents = Student::count();

        $insideToday = Student::whereHas('attendances', function ($query) {

            $query->whereDate('date', today())
                ->whereNotNull('time_in')
                ->whereNull('time_out');

        })->count();

        $visitedToday = Student::whereHas('attendances', function ($query) {

            $query->whereDate('date', today());

        })->count();

        return view('student', compact(
            'students',
            'totalStudents',
            'insideToday',
            'visitedToday'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | PERSONNEL MONITORING
    |--------------------------------------------------------------------------
    */

    public function personnel(Request $request)
    {
        $search = $request->get('search');

        $personnel = Personnel::with('latestAttendance')
            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('employee_number', 'like', "%{$search}%")
                        ->orWhere('department', 'like', "%{$search}%")
                        ->orWhere('rfid_tag_uid', 'like', "%{$search}%");
                });
            })
            ->orderBy('lastname')
            ->orderBy('firstname')
            ->paginate(15)
            ->withQueryString();

        $totalPersonnel = Personnel::count();

        $insideToday = Personnel::whereHas('attendances', function ($query) {

            $query->whereDate('date', today())
                ->whereNotNull('time_in')
                ->whereNull('time_out');

        })->count();

        $visitedToday = Personnel::whereHas('attendances', function ($query) {

            $query->whereDate('date', today());

        })->count();

        return view('personnel', compact(
            'personnel',
            'totalPersonnel',
            'insideToday',
            'visitedToday'
        ));
    }
}