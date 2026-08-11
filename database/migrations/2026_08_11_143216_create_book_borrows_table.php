<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_borrows', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('book_id');

            // Borrower/user ID
            $table->unsignedBigInteger('borrower_id');

            $table->date('borrowed_at');
            $table->date('due_date');
            $table->date('returned_at')->nullable();

            $table->enum('status', [
                'borrowed',
                'returned',
                'overdue'
            ])->default('borrowed');

            $table->text('remarks')->nullable();

            $table->timestamps();

            // Link borrowing record to books table
            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_borrows');
    }
};