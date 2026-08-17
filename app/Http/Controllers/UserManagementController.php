<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER MANAGEMENT PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        // Get all users
        $users = User::orderBy('created_at', 'desc')->get();

        // Statistics
        $totalStaff = User::where('access_level', 'staff')->count();

        $activeStaff = User::where('access_level', 'staff')
            ->where('status', 'active')
            ->count();

        $inactiveStaff = User::where('access_level', 'staff')
            ->where('status', 'inactive')
            ->count();

        $totalAdmins = User::where('access_level', 'admin')->count();


        return view('usermanagement', compact(
            'users',
            'totalStaff',
            'activeStaff',
            'inactiveStaff',
            'totalAdmins'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE STAFF
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'firstname' => [
                'required',
                'string',
                'max:255',
            ],

            'lastname' => [
                'required',
                'string',
                'max:255',
            ],

            'employeeid' => [
                'required',
                'string',
                'max:255',
                'unique:users,employeeid',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'access_level' => [
                'required',
                Rule::in([
                    'staff',
                    'admin',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ]);


        User::create([

            'firstname' => $validated['firstname'],

            'lastname' => $validated['lastname'],

            'employeeid' => $validated['employeeid'],

            'email' => $validated['email'],

            'password' => Hash::make(
                $validated['password']
            ),

            'access_level' => $validated['access_level'],

            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('user.management')
            ->with(
                'success',
                'Staff account created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE STAFF
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        User $user
    ) {
        $validated = $request->validate([

            'firstname' => [
                'required',
                'string',
                'max:255',
            ],

            'lastname' => [
                'required',
                'string',
                'max:255',
            ],

            'employeeid' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'users',
                    'employeeid'
                )->ignore($user->id),
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique(
                    'users',
                    'email'
                )->ignore($user->id),
            ],

            'access_level' => [
                'required',
                Rule::in([
                    'staff',
                    'admin',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);


        /*
         * Update user information
         */

        $user->firstname = $validated['firstname'];

        $user->lastname = $validated['lastname'];

        $user->employeeid = $validated['employeeid'];

        $user->email = $validated['email'];

        $user->access_level = $validated['access_level'];

        $user->status = $validated['status'];


        /*
         * Only update password if
         * a new password was entered.
         */

        if (!empty($validated['password'])) {

            $user->password = Hash::make(
                $validated['password']
            );
        }


        $user->save();


        return redirect()
            ->route('user.management')
            ->with(
                'success',
                'Staff account updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE STAFF
    |--------------------------------------------------------------------------
    */

    public function destroy(User $user)
    {
        /*
         * Prevent logged-in user from
         * deleting their own account.
         */

        if (
            auth()->check() &&
            auth()->id() === $user->id
        ) {

            return redirect()
                ->route('user.management')
                ->with(
                    'error',
                    'You cannot delete your own account.'
                );
        }


        $user->delete();


        return redirect()
            ->route('user.management')
            ->with(
                'success',
                'Staff account deleted successfully.'
            );
    }
}