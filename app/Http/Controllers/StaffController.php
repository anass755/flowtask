<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function dashboard()
    {
        $staff = Auth::guard('staff')->user();
        $tasks = $staff->tasks()->orderBy('created_at', 'desc')->get();
        
        $totalHours = $tasks->sum('hours');
        $totalMinutes = $tasks->sum('minutes');
        $additionalHours = intval($totalMinutes / 60);
        $remainingMinutes = $totalMinutes % 60;
        $totalTime = $totalHours + ($additionalHours + $remainingMinutes / 60);
        
        $stats = [
            'totalTasks' => $tasks->count(),
            'pendingTasks' => $tasks->where('status', 'pending')->count(),
            'inProgressTasks' => $tasks->where('status', 'in_progress')->count(),
            'completedTasks' => $tasks->where('status', 'completed')->count(),
            'totalHours' => number_format($totalTime, 1),
        ];

        $recentTasks = $tasks->take(5);

        return view('staff.dashboard', compact('staff', 'tasks', 'stats', 'recentTasks'));
    }
}
