<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectTask;
use App\Models\Staff;

class TaskController extends Controller
{
    public function index()
    {
        $staff = Staff::with('tasks')->orderBy('name')->get();
        return view('admin.tasks.index', compact('staff'));
    }

    public function toggleLock(ProjectTask $task)
    {
        $task->update([
            'locked' => !$task->locked
        ]);

        return redirect()->back()->with('success', $task->locked ? 'Task locked successfully!' : 'Task unlocked successfully!');
    }
}
