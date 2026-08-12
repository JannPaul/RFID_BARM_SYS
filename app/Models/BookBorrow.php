<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookBorrow extends Model
{
    protected $fillable = [
        'book_id',
        'borrower_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'remarks',
    ];


    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | BOOK
    |--------------------------------------------------------------------------
    */

    public function book()
    {
        return $this->belongsTo(
            Book::class,
            'book_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BORROWER / STUDENT
    |--------------------------------------------------------------------------
    */

    public function borrower()
    {
        return $this->belongsTo(
            Student::class,
            'borrower_id'
        );
    }
}