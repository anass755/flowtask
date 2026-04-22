<x-staff-layout title="Dashboard">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 p-4 rounded-4 mb-4 text-white"
     style="background: linear-gradient(135deg, #0f766e 0%, #059669 100%); box-shadow: 0 12px 40px rgba(15,118,110,0.15);">

    <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
             style="width:48px; height:48px; background: rgba(255,255,255,0.18); font-size:1.2rem;">
            <i class="fas fa-tasks text-white"></i>
        </div>
        <div>
            <h2 class="mb-0 fw-bold fs-5 text-white">Dashboard</h2>
            <p class="mb-0 small" style="color: rgba(255,255,255,0.65);">
                View and manage all your assigned tasks
            </p>
        </div>
    </div>

    <div>
        <a href="{{ route('staff.tasks.create') }}" 
           class="btn btn-light fw-semibold d-inline-flex align-items-center gap-2"
           style="color: #0f766e;">
            <i class="fas fa-plus-circle"></i> Add New Task
        </a>
    </div>

</div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-2" style="color: var(--accent);">Total Tasks</h6>
                                <h3 class="fw-bold mb-0">{{ $stats['totalTasks'] ?? 0 }}</h3>
                            </div>
                            <div class="p-3 bg-primary bg-opacity-10 rounded-circle">
                                <i class="fas fa-tasks text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-2" style="color: var(--accent);">Completed</h6>
                                <h3 class="fw-bold mb-0" style="color: var(--accent);">{{ $stats['completedTasks'] ?? 0 }}</h3>
                            </div>
                            <div class="p-3 bg-success bg-opacity-10 rounded-circle">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-2" style="color: var(--accent);">In Progress</h6>
                                <h3 class="fw-bold mb-0" style="color: var(--accent);">{{ $stats['inProgressTasks'] ?? 0 }}</h3>
                            </div>
                            <div class="p-3 bg-success bg-opacity-10 rounded-circle">
                                <i class="fas fa-clock" style="color: var(--accent);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-2" style="color: var(--accent);">Total Hours</h6>
                                <h3 class="fw-bold mb-0" style="color: var(--accent);">{{ $stats['totalHours'] ?? 0 }}</h3>
                            </div>
                            <div class="p-3 bg-success bg-opacity-10 rounded-circle">
                                <i class="fas fa-stopwatch" style="color: var(--accent);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Recent Tasks
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if(isset($recentTasks) && $recentTasks->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Description</th>
                                            <th>Time</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentTasks as $task)
                                            <tr>
                                                <td>{{ Str::limit($task->description, 50) }}</td>
                                                <td>{{ $task->hours }}h {{ $task->minutes }}m</td>
                                                <td>{{ $task->task_date ? $task->task_date->format('M d, Y') : 'N/A' }}</td>
                                                <td>
                                                    @if($task->status == 'completed')
                                                        <span class="badge bg-success">Completed</span>
                                                    @elseif($task->status == 'in_progress')
                                                        <span class="badge bg-warning">In Progress</span>
                                                    @else
                                                        <span class="badge bg-secondary">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('staff.tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x mb-3" style="color: var(--accent);"></i>
                                <p style="color: var(--accent);">No tasks found. Create your first task!</p>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#quickAddTaskModal">
                                    <i class="fas fa-plus-circle me-2"></i>Create Your First Task
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Task Statistics Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Task Statistics
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-light">
                                        <th>Metric</th>
                                        <th>Value</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fas fa-tasks me-2 text-primary"></i>Total Tasks</td>
                                        <td>{{ $stats['totalTasks'] ?? 0 }}</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-check-circle me-2 text-success"></i>Completed Tasks</td>
                                        <td>{{ $stats['completedTasks'] ?? 0 }}</td>
                                        <td>{{ $stats['totalTasks'] > 0 ? round(($stats['completedTasks'] / $stats['totalTasks']) * 100, 1) : 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-clock me-2 text-warning"></i>In Progress Tasks</td>
                                        <td>{{ $stats['inProgressTasks'] ?? 0 }}</td>
                                        <td>{{ $stats['totalTasks'] > 0 ? round(($stats['inProgressTasks'] / $stats['totalTasks']) * 100, 1) : 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-hourglass-half me-2 text-info"></i>Pending Tasks</td>
                                        <td>{{ ($stats['totalTasks'] ?? 0) - ($stats['completedTasks'] ?? 0) - ($stats['inProgressTasks'] ?? 0) }}</td>
                                        <td>{{ $stats['totalTasks'] > 0 ? round((($stats['totalTasks'] - $stats['completedTasks'] - $stats['inProgressTasks']) / $stats['totalTasks']) * 100, 1) : 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-stopwatch me-2 text-secondary"></i>Total Time Tracked</td>
                                        <td>{{ $stats['totalHours'] ?? 0 }} hours</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Add Task Modal -->
    <div class="modal fade" id="quickAddTaskModal" tabindex="-1" aria-labelledby="quickAddTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header text-white border-0" 
                     style="background: linear-gradient(135deg, #0f766e 0%, #059669 100%);">
                    <h5 class="modal-title" id="quickAddTaskModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Quick Add Task
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('staff.tasks.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <p class="mb-4" style="color: var(--accent);">Add a new task to track your time and progress</p>

                        <div class="mb-4">
                            <label for="modal_description" class="form-label fw-bold">
                                <i class="fas fa-align-left me-2"></i>Task Description <span class="text-danger">*</span>
                            </label>
                            <textarea id="modal_description" name="description" rows="4" required
                                      class="form-control"
                                      placeholder="Describe your task in detail..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="modal_hours" class="form-label fw-bold">
                                    <i class="fas fa-clock me-2"></i>Hours <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                                    <select id="modal_hours" name="hours" required class="form-select">
                                        <option value="">Select Hours</option>
                                        @for($i = 0; $i <= 23; $i++)
                                            <option value="{{ $i }}">{{ $i }} hour{{ $i != 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="modal_minutes" class="form-label fw-bold">
                                    <i class="fas fa-clock me-2"></i>Minutes <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-stopwatch"></i></span>
                                    <select id="modal_minutes" name="minutes" required class="form-select">
                                        <option value="">Select Minutes</option>
                                        @for($i = 0; $i <= 59; $i++)
                                            <option value="{{ $i }}">{{ $i }} minute{{ $i != 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="modal_task_date" class="form-label fw-bold">
                                    <i class="fas fa-calendar me-2"></i>Task Date
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" id="modal_task_date" name="task_date" class="form-control">
                                </div>
                                <small style="color: var(--accent);">Optional: Set a specific date for this task</small>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="modal_status" class="form-label fw-bold">
                                    <i class="fas fa-info-circle me-2"></i>Status <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                    <select id="modal_status" name="status" required class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Create Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-staff-layout>
