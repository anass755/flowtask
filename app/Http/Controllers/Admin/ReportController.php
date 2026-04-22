<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectTask;
use App\Models\Staff;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $staff = Staff::with('tasks')->orderBy('name')->get()
            ->map(function ($staffMember) {
                // Calculate task statistics
                $staffMember->tasks_count = $staffMember->tasks->count();
                $staffMember->completed_tasks = $staffMember->tasks->where('status', 'completed')->count();
                $staffMember->in_progress_tasks = $staffMember->tasks->where('status', 'in_progress')->count();
                $staffMember->pending_tasks = $staffMember->tasks->where('status', 'pending')->count();
                $staffMember->total_hours = round($staffMember->tasks->sum('hours') + ($staffMember->tasks->sum('minutes') / 60), 2);
                return $staffMember;
            });
        $selectedStaff = null;
        $tasks = collect();
        $reportData = null;

        $filterType = $request->input('filter_type', 'all'); // all, day, month, range
        $staffId = $request->input('staff_id');
        $date = $request->input('date', now()->format('Y-m-d'));
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $fromDate = $request->input('from_date', now()->subDays(30)->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        if ($staffId) {
            $selectedStaff = Staff::find($staffId);
            
            if ($selectedStaff) {
                $query = $selectedStaff->tasks();

                // Apply date filters
                if ($filterType === 'day' && $date) {
                    $query->whereDate('task_date', $date);
                } elseif ($filterType === 'month' && $month && $year) {
                    $query->whereYear('task_date', $year)
                          ->whereMonth('task_date', $month);
                } elseif ($filterType === 'range' && $fromDate && $toDate) {
                    $query->whereBetween('task_date', [$fromDate, $toDate]);
                }

                $tasks = $query->orderBy('task_date', 'desc')->get();

                // Calculate report data
                $reportData = $this->calculateReportData($tasks);
            }
        }

        return view('admin.reports.index', compact(
            'staff',
            'selectedStaff',
            'tasks',
            'reportData',
            'filterType',
            'staffId',
            'date',
            'month',
            'year',
            'fromDate',
            'toDate'
        ));
    }

    public function downloadPdf(Request $request)
    {
        $staffId = $request->input('staff_id');
        $filterType = $request->input('filter_type', 'all');
        $date = $request->input('date', now()->format('Y-m-d'));
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $fromDate = $request->input('from_date', now()->subDays(30)->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        $selectedStaff = Staff::find($staffId);
        
        if (!$selectedStaff) {
            return redirect()->back()->with('error', 'Staff member not found');
        }

        $query = $selectedStaff->tasks();

        // Apply date filters
        if ($filterType === 'day' && $date) {
            $query->whereDate('task_date', $date);
        } elseif ($filterType === 'month' && $month && $year) {
            $query->whereYear('task_date', $year)
                  ->whereMonth('task_date', $month);
        } elseif ($filterType === 'range' && $fromDate && $toDate) {
            $query->whereBetween('task_date', [$fromDate, $toDate]);
        }

        $tasks = $query->orderBy('task_date', 'desc')->get();
        $reportData = $this->calculateReportData($tasks);

        // Generate filter description for PDF
        $filterDescription = 'All Time';
        if ($filterType === 'day' && $date) {
            $filterDescription = \Carbon\Carbon::parse($date)->format('F d, Y');
        } elseif ($filterType === 'month' && $month && $year) {
            $filterDescription = date('F', mktime(0, 0, 0, $month, 1)) . ' ' . $year;
        } elseif ($filterType === 'range' && $fromDate && $toDate) {
            $filterDescription = \Carbon\Carbon::parse($fromDate)->format('F d, Y') . ' - ' . \Carbon\Carbon::parse($toDate)->format('F d, Y');
        }

        return view('admin.reports.pdf', compact(
            'selectedStaff',
            'tasks',
            'reportData',
            'filterDescription',
            'filterType'
        ));
    }

    private function calculateReportData($tasks)
    {
        if ($tasks->isEmpty()) {
            return null;
        }

        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count();
        
        $totalHours = $tasks->sum('hours');
        $totalMinutes = $tasks->sum('minutes');
        $totalTimeInMinutes = ($totalHours * 60) + $totalMinutes;
        
        $finalHours = floor($totalTimeInMinutes / 60);
        $finalMinutes = $totalTimeInMinutes % 60;

        // Find task with most time
        $taskWithMostTime = $tasks->sortByDesc(function($task) {
            return ($task->hours * 60) + $task->minutes;
        })->first();

        return [
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $tasks->where('status', 'pending')->count(),
            'inProgressTasks' => $tasks->where('status', 'in_progress')->count(),
            'totalHours' => $finalHours,
            'totalMinutes' => $finalMinutes,
            'totalTimeDisplay' => sprintf('%dh %dm', $finalHours, $finalMinutes),
            'taskWithMostTime' => $taskWithMostTime,
            'taskWithMostTimeDisplay' => $taskWithMostTime ? 
                sprintf('%dh %dm', $taskWithMostTime->hours, $taskWithMostTime->minutes) : 'N/A',
        ];
    }
}
