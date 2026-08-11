<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_reservations', function (Blueprint $table) {
            $table->id();

            // Selected book
            $table->unsignedBigInteger('book_id');

            // Student information
            $table->string('student_id');
            $table->string('student_name');

            // Reservation schedule
            $table->date('borrow_date');
            $table->string('pickup_time');

            // Reservation status
            $table->enum('status', [
                'pending',
                'ready',
                'picked_up',
                'cancelled',
                'expired'
            ])->default('pending');

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_reservations');
    }
};