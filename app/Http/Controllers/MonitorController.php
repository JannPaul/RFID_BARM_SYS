<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitorController extends Controller
{
    public function monitor()
    {
        return view('kiosk');
    }

    /*
    |--------------------------------------------------------------------------
    | Borrow
    |--------------------------------------------------------------------------
    */

    public function enterBorrow()
    {
        // Give one-time permission to open the borrow page
        session()->flash('allow_borrow_page', true);

        return redirect()->route('borrow');
    }

    public function borrow()
    {
        // Prevent manually typing /borrow
        if (!session('allow_borrow_page')) {
            return redirect()->route('monitor');
        }

        return view('borrow');
    }

    /*
    |--------------------------------------------------------------------------
    | Return
    |--------------------------------------------------------------------------
    */

    public function enterReturn()
    {
        // Give one-time permission to open the return page
        session()->flash('allow_return_page', true);

        return redirect()->route('return');
    }

    public function return()
    {
        // Prevent manually typing /return
        if (!session('allow_return_page')) {
            return redirect()->route('monitor');
        }

        return view('return');
    }

    /*
    |--------------------------------------------------------------------------
    | Reserve
    |--------------------------------------------------------------------------
    */

    public function reserve()
    {
        return view('reserve');
    }
}