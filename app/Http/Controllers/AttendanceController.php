<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Get today's attendance status.
     */
    public function status()
{
    $user = auth()->user();

    $attendance = Attendance::where('user_id', $user->id)
        ->whereDate('attendance_date', Carbon::today())
        ->first();

    /*
     * No attendance record TODAY.
     *
     * Even if the user clocked in/out yesterday,
     * today's button starts again as Clock In.
     */
    if (!$attendance) {
        return response()->json([
            'status' => 'clocked_out',
            'time_in' => null,
            'time_out' => null,
        ]);
    }

    /*
     * Clocked in but not clocked out.
     */
    if ($attendance->time_in && !$attendance->time_out) {
        return response()->json([
            'status' => 'clocked_in',
            'time_in' => $attendance->time_in,
            'time_out' => null,
        ]);
    }

    /*
     * Finished attendance TODAY.
     */
    if ($attendance->time_in && $attendance->time_out) {
        return response()->json([
            'status' => 'complete',
            'time_in' => $attendance->time_in,
            'time_out' => $attendance->time_out,
        ]);
    }

    return response()->json([
        'status' => 'clocked_out',
        'time_in' => null,
        'time_out' => null,
    ]);
}


    /**
     * Clock In.
     */
    public function clockIn()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $today = Carbon::today()->toDateString();

        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an attendance record today.'
            ], 422);
        }

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'time_in' => Carbon::now(),
            'time_out' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Clocked in successfully.',
            'status' => 'clocked_in',
            'time_in' => $attendance->time_in,
        ]);
    }


    /**
     * Clock Out.
     */
    public function clockOut()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'You need to clock in first.'
            ], 422);
        }

        if ($attendance->time_out) {
            return response()->json([
                'success' => false,
                'message' => 'You have already clocked out today.'
            ], 422);
        }

        $attendance->update([
            'time_out' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Clocked out successfully.',
            'status' => 'complete',
            'time_in' => $attendance->time_in,
            'time_out' => $attendance->time_out,
        ]);
    }
}