<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookReservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookReservationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STUDENT RESERVATION PAGE
    |--------------------------------------------------------------------------
    | Shows all books from the books table.
    */
    public function create()
    {
        $books = Book::orderBy('title', 'asc')->get();

        return view('reserve', compact('books'));
    }


    /*
    |--------------------------------------------------------------------------
    | SAVE RESERVATION
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'  => 'required|string',
            'student_name' => 'required|string',
            'book_id'     => 'required|exists:books,id',
            'borrow_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|string',
        ]);

        /*
         * Prevent duplicate active reservation
         * for the same student and book.
         */
        $existingReservation = BookReservation::where(
                'student_id',
                $request->student_id
            )
            ->where('book_id', $request->book_id)
            ->whereIn('status', [
                'pending',
                'ready'
            ])
            ->first();

        if ($existingReservation) {
            return back()->with(
                'error',
                'You already have an active reservation for this book.'
            );
        }


        BookReservation::create([
            'student_id'   => $request->student_id,
            'student_name' => $request->student_name,
            'book_id'      => $request->book_id,
            'borrow_date'  => $request->borrow_date,
            'pickup_time'  => $request->pickup_time,
            'status'       => 'pending',
        ]);


        return redirect()
            ->route('reserve')
            ->with(
                'success',
                'Book reserved successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN RESERVATION MONITORING
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        /*
         * Automatically mark old pending reservations
         * as expired.
         */
        BookReservation::whereIn('status', ['pending', 'ready'])
            ->whereDate('borrow_date', '<', Carbon::today())
            ->update([
                'status' => 'expired'
            ]);


        $reservations = BookReservation::with('book')
            ->orderBy('borrow_date', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();


        return view(
            'reserve_monitoring',
            compact('reservations')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MARK READY
    |--------------------------------------------------------------------------
    */
    public function ready($id)
    {
        $reservation = BookReservation::findOrFail($id);

        $reservation->update([
            'status' => 'ready'
        ]);


        return redirect()
            ->route('reserve.monitoring')
            ->with(
                'success',
                'Reservation marked as ready for pickup.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PICKUP
    |--------------------------------------------------------------------------
    */
    public function pickup($id)
    {
        $reservation = BookReservation::findOrFail($id);

        $reservation->update([
            'status' => 'picked_up'
        ]);


        return redirect()
            ->route('reserve.monitoring')
            ->with(
                'success',
                'Reservation marked as picked up.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CANCEL
    |--------------------------------------------------------------------------
    */
    public function cancel(Request $request, $id)
    {
        $reservation = BookReservation::findOrFail($id);

        $reservation->update([
            'status' => 'cancelled',
            'remarks' => $request->remarks
        ]);


        return redirect()
            ->route('reserve.monitoring')
            ->with(
                'success',
                'Reservation cancelled successfully.'
            );
    }
}