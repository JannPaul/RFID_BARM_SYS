<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login page.
     */
     public function showLoginForm()
    {
        return view('login');
    }
    /**
     * Process the login request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'employeeid' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'employeeid.required' => 'Please enter your Employee ID.',
            'password.required' => 'Please enter your password.',
        ]);

        /*
         * Only users with active status can log in.
         */
        $credentials['status'] = 'active';

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

                return redirect()
                 ->route('index')
                ->with('success', 'Login successful.');

            /*
             * Logout users with an unknown access level.
             */
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('error', 'Your account does not have a valid access level.');
        }

        return back()
            ->withErrors([
                'employeeid' => 'The Employee ID or password is incorrect, or the account is inactive.',
            ])
            ->onlyInput('employeeid');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out.');
    }
}