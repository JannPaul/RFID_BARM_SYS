<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\User;
use App\Models\Student;
class BookController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BOOK LIST
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
    | BORROW KIOSK PAGE
    |--------------------------------------------------------------------------
    |
    | This is for:
    |
    | /borrow
    |
    | It loads the available books from the books table.
    |
    */

    public function borrowForm()
    {
        /*
         * Get book IDs that are currently borrowed.
         */
        $borrowedBookIds = BookBorrow::where('status', 'borrowed')
            ->pluck('book_id');


        /*
         * Only show books that are not currently borrowed.
         */
        $books = Book::whereNotIn('id', $borrowedBookIds)
            ->orderBy('title', 'asc')
            ->get();


  
        return view('borrow', compact('books'));
    }


    /*
    |--------------------------------------------------------------------------
    | STORE BORROW
    |--------------------------------------------------------------------------
    |
    | Called when the user presses Confirm Borrow
    | from borrow.blade.php.
    |
    */

   public function storeBorrow(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | VALIDATE
    |--------------------------------------------------------------------------
    */

    $request->validate([
        'student_id' => 'required|string',

        'book_ids' => 'required|array|min:1',

        'book_ids.*' => 'required|exists:books,id',
    ]);


    /*
    |--------------------------------------------------------------------------
    | FIND STUDENT
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    | C21-0001
    |
    | is searched in:
    |
    | students.student_number
    |
    */

    $borrower = Student::where(
        'student_number',
        $request->student_id
    )->first();


    /*
     * Student not found.
     */
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
    | BORROW SELECTED BOOKS
    |--------------------------------------------------------------------------
    */

    $borrowedCount = 0;


    foreach ($request->book_ids as $bookId) {

        /*
         * Check if book is currently borrowed.
         */
        $alreadyBorrowed = BookBorrow::where(
            'book_id',
            $bookId
        )
            ->where('status', 'borrowed')
            ->exists();


        if ($alreadyBorrowed) {
            continue;
        }


        /*
         * Create borrowing transaction.
         */
        BookBorrow::create([

            'book_id' => $bookId,

            /*
             * This is students.id.
             *
             * Example:
             *
             * students:
             * id = 5
             * student_number = C21-0001
             *
             * book_borrows:
             * borrower_id = 5
             */
            'borrower_id' => $borrower->id,

            'borrowed_at' => now(),

            'due_date' => now()->addDays(7),

            'returned_at' => null,

            'status' => 'borrowed',

            'remarks' => null,

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
            ->route('borrow')
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
        ->route('borrow')
        ->with(
            'success',
            $borrowedCount . ' book(s) borrowed successfully.'
        );
}


    /*
    |--------------------------------------------------------------------------
    | BOOK BORROW MONITORING
    |--------------------------------------------------------------------------
    |
    | This is for:
    |
    | /bookborrow
    |
    | It loads borrowing records, NOT the available books.
    |
    */

    public function borrowMonitoring()
    {
        $borrows = BookBorrow::with([
            'book',
            'borrower'
        ])
            ->orderBy('due_date', 'asc')
            ->orderBy('created_at', 'desc')
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
        $borrow = BookBorrow::findOrFail($id);


        /*
         * Prevent returning the same transaction twice.
         */
        if ($borrow->status === 'returned') {

            return redirect()
                ->route('bookborrow')
                ->with(
                    'error',
                    'This book has already been returned.'
                );
        }


        $borrow->update([
            'status' => 'returned',

            'returned_at' => now(),
        ]);


        return redirect()
            ->route('bookborrow')
            ->with(
                'success',
                'Book returned successfully.'
            );
    }
}