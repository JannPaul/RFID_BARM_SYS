<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'name',
        'student_number',
        'year_level',
        'course_program',
        'rfid_tag_uid',
        'contact_information',
    ];
}