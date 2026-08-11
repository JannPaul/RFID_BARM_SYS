<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookBorrow;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('created_at', 'desc')->get();

        return view('book', compact('books'));
    }

     public function borrow()
    {
        $borrows = BookBorrow::with([
            'book',
            'borrower'
        ])
        ->orderBy('due_date', 'asc')
        ->get();

        return view('bookborrow', compact('borrows'));
    }

    public function returnBook($id)
    {
        $borrow = BookBorrow::findOrFail($id);

        $borrow->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        return redirect()
            ->route('bookborrow')
            ->with('success', 'Book returned successfully.');
    }
}