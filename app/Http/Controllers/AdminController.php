<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\ProjectTask;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get all staff with their tasks
        $staff = Staff::with('tasks')
            ->withCount('tasks')
            ->get()
            ->map(function ($staffMember) {
                // Calculate completed, in progress, and pending tasks
                $staffMember->completed_tasks = $staffMember->tasks->where('status', 'completed')->count();
                $staffMember->in_progress_tasks = $staffMember->tasks->where('status', 'in_progress')->count();
                $staffMember->pending_tasks = $staffMember->tasks->where('status', 'pending')->count();

                return $staffMember;
            });

        // Calculate overall stats
        $totalStaff = $staff->count();
        $totalTasks = ProjectTask::count();
        $totalCompletedTasks = ProjectTask::where('status', 'completed')->count();
        $totalInProgressTasks = ProjectTask::where('status', 'in_progress')->count();
        $totalPendingTasks = ProjectTask::where('status', 'pending')->count();

        // Calculate total locked tasks
        $totalLocked = ProjectTask::where('locked', true)->count();

        // Calculate total hours
        $totalHours = ProjectTask::sum('hours') + (ProjectTask::sum('minutes') / 60);

        // Create stats array for summary table
        $stats = [
            'totalTasks' => $totalTasks,
            'completedTasks' => $totalCompletedTasks,
            'inProgressTasks' => $totalInProgressTasks,
            'pendingTasks' => $totalPendingTasks,
            'totalHours' => round($totalHours, 2),
        ];

        return view('admin.dashboard', compact(
            'staff',
            'totalStaff',
            'totalTasks',
            'totalCompletedTasks',
            'totalInProgressTasks',
            'totalPendingTasks',
            'totalLocked',
            'stats'
        ));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            if (!\Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
