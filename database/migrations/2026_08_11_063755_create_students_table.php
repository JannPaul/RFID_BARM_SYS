<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('student_number')->unique();

            $table->string('year_level')->nullable();

            $table->string('course_program')->nullable();

            $table->string('rfid_tag_uid')->nullable()->unique();

            $table->string('contact_information')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};