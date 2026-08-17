<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * RFID Scanner
     *
     * First scan  = Clock In
     * Second scan = Clock Out
     * Third scan  = New Clock In
     */
    public function scanRfid(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate RFID
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'rfid_tag_uid' => 'required|string',
        ]);

        $rfid = trim((string) $request->input('rfid_tag_uid'));


        /*
        |--------------------------------------------------------------------------
        | Search Student
        |--------------------------------------------------------------------------
        */

        $person = Student::where(
            'rfid_tag_uid',
            $rfid
        )->first();


        /*
        |--------------------------------------------------------------------------
        | If not Student, search Personnel
        |--------------------------------------------------------------------------
        */

        if (!$person) {

            $person = Personnel::where(
                'rfid_tag_uid',
                $rfid
            )->first();

        }


        /*
        |--------------------------------------------------------------------------
        | RFID Not Registered
        |--------------------------------------------------------------------------
        */

        if (!$person) {

            return response()->json([
                'success' => false,
                'message' => 'RFID card is not registered.',
                'rfid_tag_uid' => $rfid,
            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Determine Person Type
        |--------------------------------------------------------------------------
        */

        $personType = $person instanceof Student
            ? 'Student'
            : 'Personnel';


        /*
        |--------------------------------------------------------------------------
        | Find Open Attendance
        |--------------------------------------------------------------------------
        |
        | We use the polymorphic relationship here.
        |
        | Because of the morph map:
        |
        | Student   = student
        | Personnel = personnel
        |
        */

        $openAttendance = $person
            ->attendances()
            ->whereNull('time_out')
            ->latest('time_in')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | CLOCK OUT
        |--------------------------------------------------------------------------
        */

        if ($openAttendance) {

            $openAttendance->update([
                'time_out' => Carbon::now(),
            ]);


            return response()->json([
                'success' => true,

                'action' => 'clock_out',

                'message' =>
                    $person->firstname . ' ' .
                    $person->lastname .
                    ' clocked out successfully.',

                'person_type' => $personType,

                'person_id' => $person->id,

                'name' =>
                    $person->firstname . ' ' .
                    $person->lastname,

                'rfid_tag_uid' =>
                    $person->rfid_tag_uid,

                /*
                |--------------------------------------------------------------------------
                | Student Information
                |--------------------------------------------------------------------------
                */

                'student_number' =>
                    $person instanceof Student
                        ? $person->student_number
                        : null,

                'year_level' =>
                    $person instanceof Student
                        ? $person->year_level
                        : null,

                'course_program' =>
                    $person instanceof Student
                        ? $person->course_program
                        : null,

                /*
                |--------------------------------------------------------------------------
                | Personnel Information
                |--------------------------------------------------------------------------
                */

                'employee_number' =>
                    $person instanceof Personnel
                        ? $person->employee_number
                        : null,

                'department' =>
                    $person instanceof Personnel
                        ? $person->department
                        : null,

                /*
                |--------------------------------------------------------------------------
                | Attendance Information
                |--------------------------------------------------------------------------
                */

                'attendance_id' =>
                    $openAttendance->id,

                'date' =>
                    $openAttendance->date,

                'time_in' =>
                    $openAttendance->time_in,

                'time_out' =>
                    $openAttendance->time_out,
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | CLOCK IN
        |--------------------------------------------------------------------------
        |
        | DO NOT manually set attendable_id or attendable_type.
        |
        | Laravel automatically fills those fields when we use:
        |
        | $person->attendances()->create(...)
        |
        */

        $attendance = $person
            ->attendances()
            ->create([

                'date' =>
                    Carbon::today()->toDateString(),

                'time_in' =>
                    Carbon::now(),

                'time_out' =>
                    null,

            ]);


        /*
        |--------------------------------------------------------------------------
        | Return Clock In Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'action' => 'clock_in',

            'message' =>
                $person->firstname . ' ' .
                $person->lastname .
                ' clocked in successfully.',

            'person_type' => $personType,

            'person_id' => $person->id,

            'name' =>
                $person->firstname . ' ' .
                $person->lastname,

            'rfid_tag_uid' =>
                $person->rfid_tag_uid,


            /*
            |--------------------------------------------------------------------------
            | Student Information
            |--------------------------------------------------------------------------
            */

            'student_number' =>
                $person instanceof Student
                    ? $person->student_number
                    : null,

            'year_level' =>
                $person instanceof Student
                    ? $person->year_level
                    : null,

            'course_program' =>
                $person instanceof Student
                    ? $person->course_program
                    : null,


            /*
            |--------------------------------------------------------------------------
            | Personnel Information
            |--------------------------------------------------------------------------
            */

            'employee_number' =>
                $person instanceof Personnel
                    ? $person->employee_number
                    : null,

            'department' =>
                $person instanceof Personnel
                    ? $person->department
                    : null,


            /*
            |--------------------------------------------------------------------------
            | Attendance Information
            |--------------------------------------------------------------------------
            */

            'attendance_id' =>
                $attendance->id,

            'date' =>
                $attendance->date,

            'time_in' =>
                $attendance->time_in,

            'time_out' =>
                null,
        ]);
    }
}