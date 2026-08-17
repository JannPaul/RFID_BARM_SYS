<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentPersonnelManagementController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MANAGEMENT PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $students = Student::orderBy('lastname')
            ->orderBy('firstname')
            ->get();

        $personnel = Personnel::orderBy('lastname')
            ->orderBy('firstname')
            ->get();

        return view(
            'studentpersonnelmanagement',
            compact(
                'students',
                'personnel'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD STUDENT
    |--------------------------------------------------------------------------
    */

    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'firstname' => [
                'required',
                'string',
                'max:255'
            ],

            'lastname' => [
                'required',
                'string',
                'max:255'
            ],

            'student_number' => [
                'required',
                'string',
                'max:255',
                'unique:students,student_number'
            ],

            'year_level' => [
                'nullable',
                'string',
                'max:255'
            ],

            'course_program' => [
                'nullable',
                'string',
                'max:255'
            ],

            'rfid_tag_uid' => [
                'nullable',
                'string',
                'max:255',
                'unique:students,rfid_tag_uid',
                'unique:personnel,rfid_tag_uid'
            ],

            'contact_information' => [
                'nullable',
                'string',
                'max:255'
            ],
        ]);

        Student::create($validated);

        return redirect()
            ->route('studentpersonnel.management')
            ->with(
                'success',
                'Student added successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE STUDENT
    |--------------------------------------------------------------------------
    */

    public function updateStudent(
        Request $request,
        Student $student
    ) {
        $validated = $request->validate([
            'firstname' => [
                'required',
                'string',
                'max:255'
            ],

            'lastname' => [
                'required',
                'string',
                'max:255'
            ],

            'student_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique(
                    'students',
                    'student_number'
                )->ignore($student->id)
            ],

            'year_level' => [
                'nullable',
                'string',
                'max:255'
            ],

            'course_program' => [
                'nullable',
                'string',
                'max:255'
            ],

            'rfid_tag_uid' => [
                'nullable',
                'string',
                'max:255',

                Rule::unique(
                    'students',
                    'rfid_tag_uid'
                )->ignore($student->id),

                Rule::unique(
                    'personnel',
                    'rfid_tag_uid'
                ),
            ],

            'contact_information' => [
                'nullable',
                'string',
                'max:255'
            ],
        ]);

        $student->update($validated);

        return redirect()
            ->route('studentpersonnel.management')
            ->with(
                'success',
                'Student updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE STUDENT
    |--------------------------------------------------------------------------
    */

    public function destroyStudent(
        Student $student
    ) {
        $student->delete();

        return redirect()
            ->route('studentpersonnel.management')
            ->with(
                'success',
                'Student deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD PERSONNEL
    |--------------------------------------------------------------------------
    */

    public function storePersonnel(Request $request)
    {
        $validated = $request->validate([
            'firstname' => [
                'required',
                'string',
                'max:255'
            ],

            'lastname' => [
                'required',
                'string',
                'max:255'
            ],

            'employee_number' => [
                'required',
                'string',
                'max:255',
                'unique:personnel,employee_number'
            ],

            'department' => [
                'nullable',
                'string',
                'max:255'
            ],

            'rfid_tag_uid' => [
                'nullable',
                'string',
                'max:255',
                'unique:personnel,rfid_tag_uid',
                'unique:students,rfid_tag_uid'
            ],

            'contact_information' => [
                'nullable',
                'string',
                'max:255'
            ],
        ]);

        Personnel::create($validated);

        return redirect()
            ->route('studentpersonnel.management')
            ->with(
                'success',
                'Personnel added successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PERSONNEL
    |--------------------------------------------------------------------------
    */

    public function updatePersonnel(
        Request $request,
        Personnel $personnel
    ) {
        $validated = $request->validate([
            'firstname' => [
                'required',
                'string',
                'max:255'
            ],

            'lastname' => [
                'required',
                'string',
                'max:255'
            ],

            'employee_number' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'personnel',
                    'employee_number'
                )->ignore($personnel->id)
            ],

            'department' => [
                'nullable',
                'string',
                'max:255'
            ],

            'rfid_tag_uid' => [
                'nullable',
                'string',
                'max:255',

                Rule::unique(
                    'personnel',
                    'rfid_tag_uid'
                )->ignore($personnel->id),

                Rule::unique(
                    'students',
                    'rfid_tag_uid'
                ),
            ],

            'contact_information' => [
                'nullable',
                'string',
                'max:255'
            ],
        ]);

        $personnel->update($validated);

        return redirect()
            ->route('studentpersonnel.management')
            ->with(
                'success',
                'Personnel updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE PERSONNEL
    |--------------------------------------------------------------------------
    */

    public function destroyPersonnel(
        Personnel $personnel
    ) {
        $personnel->delete();

        return redirect()
            ->route('studentpersonnel.management')
            ->with(
                'success',
                'Personnel deleted successfully.'
            );
    }
}