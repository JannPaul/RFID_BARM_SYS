<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            // Can belong to Student or2088350422
            //  Personnel
            $table->unsignedBigInteger('attendable_id');
            $table->string('attendable_type');

            // Date of library visit
            $table->date('date');

            // Library clock in/out
            $table->dateTime('time_in')->nullable();
            $table->dateTime('time_out')->nullable();

            $table->timestamps();

            $table->index([
                'attendable_id',
                'attendable_type'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};