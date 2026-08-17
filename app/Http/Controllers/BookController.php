<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\Student;


class BookController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | BOOK LIST / READ
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $books = Book::orderBy('created_at', 'desc')
            ->get();

        return view('book', compact('books'));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE / STORE BOOK
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATE
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'title' => [
                'required',
                'string'
            ],

            'author' => [
                'nullable',
                'string'
            ],

            'call_number' => [
                'nullable',
                'string',
                'max:255'
            ],

            'sublocation' => [
                'nullable',
                'string',
                'max:255'
            ],

            'publisher' => [
                'nullable',
                'string'
            ],

            'year' => [
                'nullable',
                'string',
                'max:20'
            ],

            'edition' => [
                'nullable',
                'string',
                'max:255'
            ],

            'format' => [
                'nullable',
                'string'
            ],

            'content_type' => [
                'nullable',
                'string',
                'max:255'
            ],

            'media_type' => [
                'nullable',
                'string',
                'max:255'
            ],

            'carrier_type' => [
                'nullable',
                'string',
                'max:255'
            ],

            'isbn' => [
                'nullable',
                'string'
            ],

            'issn' => [
                'nullable',
                'string'
            ],

            'lccn' => [
                'nullable',
                'string',
                'max:255'
            ],

            'subjects' => [
                'nullable',
                'string'
            ],

            'additional_details' => [
                'nullable',
                'string'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | GENERATE UNIQUE BOOK KEY
        |--------------------------------------------------------------------------
        |
        | Your books table requires unique_key.
        |
        | Example:
        |
        | BOOK-000001
        | BOOK-000002
        |
        */

        do {

            $uniqueKey =
                'BOOK-' .
                strtoupper(
                    substr(
                        md5(uniqid(mt_rand(), true)),
                        0,
                        8
                    )
                );

        } while (
            Book::where('unique_key', $uniqueKey)
                ->exists()
        );


        $validated['unique_key'] = $uniqueKey;


        /*
        |--------------------------------------------------------------------------
        | CREATE BOOK
        |--------------------------------------------------------------------------
        */

        Book::create($validated);


        return redirect()
            ->route('book')
            ->with(
                'success',
                'Book added successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE BOOK
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Book $book
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDATE
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'title' => [
                'required',
                'string'
            ],

            'author' => [
                'nullable',
                'string'
            ],

            'call_number' => [
                'nullable',
                'string',
                'max:255'
            ],

            'sublocation' => [
                'nullable',
                'string',
                'max:255'
            ],

            'publisher' => [
                'nullable',
                'string'
            ],

            'year' => [
                'nullable',
                'string',
                'max:20'
            ],

            'edition' => [
                'nullable',
                'string',
                'max:255'
            ],

            'format' => [
                'nullable',
                'string'
            ],

            'content_type' => [
                'nullable',
                'string',
                'max:255'
            ],

            'media_type' => [
                'nullable',
                'string',
                'max:255'
            ],

            'carrier_type' => [
                'nullable',
                'string',
                'max:255'
            ],

            'isbn' => [
                'nullable',
                'string'
            ],

            'issn' => [
                'nullable',
                'string'
            ],

            'lccn' => [
                'nullable',
                'string',
                'max:255'
            ],

            'subjects' => [
                'nullable',
                'string'
            ],

            'additional_details' => [
                'nullable',
                'string'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $book->update($validated);


        return redirect()
            ->route('book')
            ->with(
                'success',
                'Book updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE BOOK
    |--------------------------------------------------------------------------
    */

    public function destroy(Book $book)
    {
        /*
         * Check if this book is currently borrowed.
         *
         * Prevent deleting it while someone
         * still has the book.
         */

        $currentlyBorrowed = BookBorrow::where(
            'book_id',
            $book->id
        )
            ->where(
                'status',
                'borrowed'
            )
            ->exists();


        if ($currentlyBorrowed) {

            return redirect()
                ->route('book')
                ->with(
                    'fail',
                    'This book cannot be deleted because it is currently borrowed.'
                );
        }


        /*
         * If the book has old borrowing records,
         * deleting it may fail if your database
         * foreign key does not use cascade.
         *
         * We do NOT delete borrowing history here.
         */

        $hasBorrowHistory = BookBorrow::where(
            'book_id',
            $book->id
        )->exists();


        if ($hasBorrowHistory) {

            return redirect()
                ->route('book')
                ->with(
                    'fail',
                    'This book cannot be deleted because it has borrowing history.'
                );
        }


        /*
         * Delete book.
         */

        $book->delete();


        return redirect()
            ->route('book')
            ->with(
                'success',
                'Book deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | BORROW KIOSK PAGE
    |--------------------------------------------------------------------------
    */

    public function borrowForm()
    {
        /*
         * Get currently borrowed Book IDs.
         */

        $borrowedBookIds = BookBorrow::where(
            'status',
            'borrowed'
        )
            ->pluck('book_id');


        /*
         * Only display available books.
         */

        $books = Book::whereNotIn(
            'id',
            $borrowedBookIds
        )
            ->orderBy(
                'title',
                'asc'
            )
            ->get();


        return view(
            'borrowkiosk',
            compact('books')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE BORROW
    |--------------------------------------------------------------------------
    */

    public function storeBorrow(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | VALIDATE
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'student_id' => [
                'required',
                'string'
            ],

            'book_ids' => [
                'required',
                'array',
                'min:1'
            ],

            'book_ids.*' => [
                'required',
                'exists:books,id'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | FIND STUDENT
        |--------------------------------------------------------------------------
        */

        $borrower = Student::where(
            'student_number',
            $request->student_id
        )->first();


        if (!$borrower) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Student number not found.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | BORROW BOOKS
        |--------------------------------------------------------------------------
        */

        $borrowedCount = 0;


        foreach (
            $request->book_ids as $bookId
        ) {

            /*
             * Check if already borrowed.
             */

            $alreadyBorrowed =
                BookBorrow::where(
                    'book_id',
                    $bookId
                )
                    ->where(
                        'status',
                        'borrowed'
                    )
                    ->exists();


            if ($alreadyBorrowed) {

                continue;
            }


            /*
             * Create borrowing transaction.
             */

            BookBorrow::create([

                'book_id' =>
                    $bookId,

                'borrower_id' =>
                    $borrower->id,

                'borrowed_at' =>
                    now(),

                'due_date' =>
                    now()->addDays(7),

                'returned_at' =>
                    null,

                'status' =>
                    'borrowed',

                'remarks' =>
                    null,

            ]);


            $borrowedCount++;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTHING BORROWED
        |--------------------------------------------------------------------------
        */

        if ($borrowedCount === 0) {

            return redirect()
                ->route('borrow.kiosk')
                ->with(
                    'error',
                    'The selected book or books are already borrowed.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('borrow.kiosk')
            ->with(
                'success',
                $borrowedCount .
                ' book(s) borrowed successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | BOOK BORROW MONITORING
    |--------------------------------------------------------------------------
    */

    public function borrowMonitoring()
    {
        $borrows = BookBorrow::with([
            'book',
            'borrower'
        ])
            ->orderBy(
                'due_date',
                'asc'
            )
            ->orderBy(
                'created_at',
                'desc'
            )
            ->get();


        return view(
            'bookborrow',
            compact('borrows')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RETURN BOOK
    |--------------------------------------------------------------------------
    */

    public function returnBook($id)
    {
        $borrow =
            BookBorrow::findOrFail($id);


        /*
         * Prevent duplicate returns.
         */

        if (
            $borrow->status ===
            'returned'
        ) {

            return redirect()
                ->route('bookborrow')
                ->with(
                    'error',
                    'This book has already been returned.'
                );
        }


        /*
         * Mark returned.
         */

        $borrow->update([

            'status' =>
                'returned',

            'returned_at' =>
                now(),

        ]);


        return redirect()
            ->route('bookborrow')
            ->with(
                'success',
                'Book returned successfully.'
            );
    }
}