<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Auth::guard('staff')->user();
        $tasks = $staff->tasks()->orderBy('created_at', 'desc')->paginate(10);
        $lockedTasksCount = $staff->tasks()->where('locked', true)->count();

        return view('staff.tasks.index', compact('tasks', 'staff', 'lockedTasksCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'hours' => 'required|integer|min:0',
            'minutes' => 'required|integer|min:0|max:59',
            'status' => 'required|in:pending,in_progress,completed',
            'task_date' => 'nullable|date',
        ]);

        $staff = Auth::guard('staff')->user();
        
        ProjectTask::create([
            'description' => $request->description,
            'hours' => $request->hours,
            'minutes' => $request->minutes,
            'status' => $request->status,
            'task_date' => $request->task_date ? \Carbon\Carbon::parse($request->task_date) : null,
            'staff_id' => $staff->id,
        ]);

        return redirect()->route('staff.tasks.index')
            ->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectTask $task)
    {
        $this->authorizeTask($task);
        return view('staff.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectTask $task)
    {
        $this->authorizeTask($task);
        return view('staff.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectTask $task)
    {
        $this->authorizeTask($task);
        
        $request->validate([
            'description' => 'required|string',
            'hours' => 'required|integer|min:0',
            'minutes' => 'required|integer|min:0|max:59',
            'status' => 'required|in:pending,in_progress,completed',
            'task_date' => 'nullable|date',
        ]);

        $task->update([
            'description' => $request->description,
            'hours' => $request->hours,
            'minutes' => $request->minutes,
            'status' => $request->status,
            'task_date' => $request->task_date ? \Carbon\Carbon::parse($request->task_date) : null,
        ]);

        return redirect()->route('staff.tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectTask $task)
    {
        $this->authorizeTask($task);
        $task->delete();

        return redirect()->route('staff.tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    private function authorizeTask(ProjectTask $task)
    {
        $staff = Auth::guard('staff')->user();
        if ($task->staff_id !== $staff->id) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($task->locked) {
            abort(403, 'This task is locked and cannot be modified.');
        }
    }

    /**
     * Update task status via AJAX.
     */
    public function updateStatus(Request $request, ProjectTask $task)
    {
        $this->authorizeTask($task);
        
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully!',
            'new_status' => $request->status
        ]);
    }
}
