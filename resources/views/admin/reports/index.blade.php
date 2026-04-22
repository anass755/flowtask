<x-admin-layout title="Staff Reports">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Header Section -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 p-4 rounded-4 mb-4"
                     style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-lg);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:48px; height:48px; background: rgba(92, 184, 92, 0.1); color: var(--accent);">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="mb-0 fw-bold fs-5" style="color: var(--fg); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">Staff Reports</h2>
                            <p class="mb-0 small" style="color: var(--muted);">
                                Generate detailed reports for staff performance
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card mb-4" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                    <div class="card-body">
                        <form action="{{ route('admin.reports.index') }}" method="GET">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-2">
                                    <label class="form-label" style="color: var(--muted);">
                                        <i class="fas fa-user me-2"></i>Staff Member
                                    </label>
                                    <select name="staff_id" class="form-select form-select-sm" style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--accent);" required>
                                        <option value="">Select Staff</option>
                                        @foreach($staff as $staffMember)
                                            <option value="{{ $staffMember->id }}"
                                                {{ $staffId == $staffMember->id ? 'selected' : '' }}>
                                                {{ Str::limit($staffMember->name, 15) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label" style="color: var(--muted);">
                                        <i class="fas fa-filter me-2"></i>Filter Type
                                    </label>
                                    <select name="filter_type" id="filterType" class="form-select form-select-sm" style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--accent);">
                                        <option value="all" {{ $filterType == 'all' ? 'selected' : '' }}>All Time</option>
                                        <option value="day" {{ $filterType == 'day' ? 'selected' : '' }}>Specific Day</option>
                                        <option value="month" {{ $filterType == 'month' ? 'selected' : '' }}>Specific Month</option>
                                        <option value="range" {{ $filterType == 'range' ? 'selected' : '' }}>Custom Range</option>
                                    </select>
                                </div>
                                <div class="col-md-2" id="dayFilter" style="display: {{ $filterType == 'day' ? 'block' : 'none' }};">
                                    <label class="form-label" style="color: var(--muted);">
                                        <i class="fas fa-calendar me-2"></i>Select Date
                                    </label>
                                    <input type="date" name="date" class="form-control form-control-sm" style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--accent);" value="{{ $date }}">
                                </div>
                                <div class="col-md-2" id="monthFilter" style="display: {{ $filterType == 'month' ? 'block' : 'none' }};">
                                    <label class="form-label" style="color: var(--muted);">
                                        <i class="fas fa-calendar-alt me-2"></i>Select Month
                                    </label>
                                    <div class="d-flex gap-2">
                                        <select name="month" class="form-select form-select-sm flex-fill" style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--accent);">
                                            @for($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                                    {{ date('M', mktime(0, 0, 0, $m, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="year" class="form-select form-select-sm flex-fill" style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--accent);">
                                            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="rangeFilter" style="display: {{ $filterType == 'range' ? 'block' : 'none' }};">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label" style="color: var(--muted);">
                                                <i class="fas fa-calendar-day me-2"></i>From Date
                                            </label>
                                            <input type="date" name="from_date" class="form-control form-control-sm" style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--accent);" value="{{ $fromDate }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" style="color: var(--muted);">
                                                <i class="fas fa-calendar-check me-2"></i>To Date
                                            </label>
                                            <input type="date" name="to_date" class="form-control form-control-sm" style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--accent);" value="{{ $toDate }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn w-100" style="background: var(--accent); border: none; color: var(--bg);">
                                        <i class="fas fa-search me-2"></i>Generate Report
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if(!$selectedStaff)
                    <!-- Staff Overview Table -->
                    <div class="card" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                        <div class="card-header" style="background: rgba(92, 184, 92, 0.1); border-bottom: 1px solid var(--card-border);">
                            <h5 class="mb-0" style="color: var(--accent); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">
                                <i class="fas fa-calendar-day me-2"></i>Today's Staff Report
                            </h5>
                            <p class="mb-0" style="color: var(--muted);">View today's task details for all staff members</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover" style="color: #2e5a2e;">
                                    <thead>
                                        <tr style="background: rgba(92, 184, 92, 0.1); color: var(--accent);">
                                            <th>Staff Name</th>
                                            <th>Email</th>
                                            <th>Today's Tasks</th>
                                            <th>Completed</th>
                                            <th>In Progress</th>
                                            <th>Pending</th>
                                            <th>Today's Hours</th>
                                            <th>Task Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($staff as $staffMember)
                                            @php
                                                $todayTasks = $staffMember->tasks->where('task_date', \Carbon\Carbon::today()->toDateString());
                                                $todayTasksCount = $todayTasks->count();
                                                $todayCompleted = $todayTasks->where('status', 'completed')->count();
                                                $todayInProgress = $todayTasks->where('status', 'in_progress')->count();
                                                $todayPending = $todayTasks->where('status', 'pending')->count();
                                                $todayHours = round($todayTasks->sum('hours') + ($todayTasks->sum('minutes') / 60), 2);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                             style="width:32px; height:32px; background: rgba(92, 184, 92, 0.15); font-size:0.8rem; color: var(--accent);">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #2e5a2e;">{{ $staffMember->name }}</span>
                                                    </div>
                                                </td>
                                                <td style="color: #2e5a2e;">{{ $staffMember->email }}</td>
                                                <td>
                                                    <span class="badge" style="background: rgba(92, 184, 92, 0.1); color: #2e5a2e;">{{ $todayTasksCount }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background: rgba(92, 184, 92, 0.2); color: #2e5a2e;">{{ $todayCompleted }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background: rgba(92, 184, 92, 0.15); color: #2e5a2e;">{{ $todayInProgress }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background: rgba(92, 184, 92, 0.1); color: #2e5a2e;">{{ $todayPending }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background: rgba(92, 184, 92, 0.15); color: #2e5a2e;">{{ $todayHours }}h</span>
                                                </td>
                                                <td>
                                                    @if($todayTasksCount > 0)
                                                        <button type="button" class="btn btn-sm" style="background: rgba(92, 184, 92, 0.2); border: none; color: var(--accent);"
                                                                data-bs-toggle="collapse" data-bs-target="#todayTasks{{ $staffMember->id }}">
                                                            <i class="fas fa-list me-1"></i>View Tasks
                                                        </button>
                                                        <div class="collapse mt-2" id="todayTasks{{ $staffMember->id }}">
                                                            <div class="card" style="background: rgba(92, 184, 92, 0.05); border: 1px solid var(--card-border); font-size: 0.85rem;">
                                                                <div class="card-body p-2">
                                                                    <ul class="list-unstyled mb-0" style="color: #2e5a2e;">
                                                                        @foreach($todayTasks as $task)
                                                                            <li class="mb-1">
                                                                                <strong style="color: var(--accent);">{{ $task->hours }}h {{ $task->minutes }}m</strong> - {{ Str::limit($task->description, 40) }}
                                                                                <span class="badge ms-1" style="background: rgba(92, 184, 92, 0.15); color: #2e5a2e; font-size: 0.7rem;">{{ $task->status }}</span>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span style="color: var(--muted); font-size: 0.85rem;">No tasks today</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                @if($selectedStaff && $reportData)
                    <!-- Report Summary Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <div class="card h-100" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                                <div class="card-body text-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                         style="width:60px; height:60px; background: rgba(92, 184, 92, 0.15);">
                                        <i class="fas fa-tasks fa-2x" style="color: var(--accent);"></i>
                                    </div>
                                    <h3 class="fw-bold mb-1" style="color: var(--fg);">{{ $reportData['totalTasks'] }}</h3>
                                    <p class="mb-0" style="color: var(--muted);">Total Tasks</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                                <div class="card-body text-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                         style="width:60px; height:60px; background: rgba(92, 184, 92, 0.2);">
                                        <i class="fas fa-check-circle fa-2x" style="color: var(--accent);"></i>
                                    </div>
                                    <h3 class="fw-bold mb-1" style="color: var(--fg);">{{ $reportData['completedTasks'] }}</h3>
                                    <p class="mb-0" style="color: var(--muted);">Completed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                                <div class="card-body text-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                         style="width:60px; height:60px; background: rgba(92, 184, 92, 0.15);">
                                        <i class="fas fa-clock fa-2x" style="color: var(--accent);"></i>
                                    </div>
                                    <h3 class="fw-bold mb-1" style="color: var(--fg);">{{ $reportData['totalTimeDisplay'] }}</h3>
                                    <p class="mb-0" style="color: var(--muted);">Total Time</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card h-100" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                                <div class="card-body text-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                         style="width:60px; height:60px; background: rgba(92, 184, 92, 0.2);">
                                        <i class="fas fa-fire fa-2x" style="color: var(--accent);"></i>
                                    </div>
                                    <h3 class="fw-bold mb-1" style="color: var(--fg);">{{ $reportData['taskWithMostTimeDisplay'] }}</h3>
                                    <p class="mb-0" style="color: var(--muted);">Most Time on Task</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Summary Table -->
                    <div class="card" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                        <div class="card-header" style="background: rgba(92, 184, 92, 0.1); border-bottom: 1px solid var(--card-border);">
                            <h5 class="mb-0" style="color: var(--accent); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">
                                <i class="fas fa-chart-bar me-2"></i>Report Summary for {{ $selectedStaff->name }}
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="background: rgba(92, 184, 92, 0.1); color: var(--accent);">
                                            <th>Metric</th>
                                            <th>Value</th>
                                            <th>Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="color: #2e5a2e;"><i class="fas fa-tasks me-2" style="color: var(--accent);"></i>Total Tasks</td>
                                            <td style="color: #2e5a2e;">{{ $reportData['totalTasks'] }}</td>
                                            <td style="color: #2e5a2e;">100%</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #2e5a2e;"><i class="fas fa-check-circle me-2" style="color: var(--accent);"></i>Completed Tasks</td>
                                            <td style="color: #2e5a2e;">{{ $reportData['completedTasks'] }}</td>
                                            <td style="color: #2e5a2e;">{{ $reportData['totalTasks'] > 0 ? round(($reportData['completedTasks'] / $reportData['totalTasks']) * 100, 1) : 0 }}%</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #2e5a2e;"><i class="fas fa-clock me-2" style="color: var(--accent);"></i>In Progress Tasks</td>
                                            <td style="color: #2e5a2e;">{{ $reportData['inProgressTasks'] ?? 0 }}</td>
                                            <td style="color: #2e5a2e;">{{ $reportData['totalTasks'] > 0 ? round(($reportData['inProgressTasks'] / $reportData['totalTasks']) * 100, 1) : 0 }}%</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #2e5a2e;"><i class="fas fa-hourglass-half me-2" style="color: var(--accent);"></i>Pending Tasks</td>
                                            <td style="color: #2e5a2e;">{{ ($reportData['totalTasks'] ?? 0) - ($reportData['completedTasks'] ?? 0) - ($reportData['inProgressTasks'] ?? 0) }}</td>
                                            <td style="color: #2e5a2e;">{{ $reportData['totalTasks'] > 0 ? round((($reportData['totalTasks'] - $reportData['completedTasks'] - $reportData['inProgressTasks']) / $reportData['totalTasks']) * 100, 1) : 0 }}%</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #2e5a2e;"><i class="fas fa-stopwatch me-2" style="color: var(--accent);"></i>Total Time Tracked</td>
                                            <td style="color: #2e5a2e;">{{ $reportData['totalTimeDisplay'] }}</td>
                                            <td style="color: #2e5a2e;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #2e5a2e;"><i class="fas fa-fire me-2" style="color: var(--accent);"></i>Most Time on Task</td>
                                            <td style="color: #2e5a2e;">{{ $reportData['taskWithMostTimeDisplay'] }}</td>
                                            <td style="color: #2e5a2e;">-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Task Details Table -->
                    <div class="card mt-4" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                        <div class="card-header" style="background: rgba(92, 184, 92, 0.1); border-bottom: 1px solid var(--card-border);">
                            <h5 class="mb-0" style="color: var(--accent); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">
                                <i class="fas fa-list me-2"></i>Task Details for {{ $selectedStaff->name }}
                                @if($filterType == 'day' && $date)
                                    <span class="badge ms-2" style="background: rgba(92, 184, 92, 0.2); color: var(--accent);">{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</span>
                                @elseif($filterType == 'month' && $month && $year)
                                    <span class="badge ms-2" style="background: rgba(92, 184, 92, 0.2); color: var(--accent);">{{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</span>
                                @elseif($filterType == 'range' && $fromDate && $toDate)
                                    <span class="badge ms-2" style="background: rgba(92, 184, 92, 0.2); color: var(--accent);">{{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}</span>
                                @endif
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if($tasks->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" style="color: #2e5a2e;">
                                        <thead>
                                            <tr style="background: rgba(92, 184, 92, 0.1); color: var(--accent);">
                                                <th>Task Description</th>
                                                <th>Date</th>
                                                <th>Time Spent</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tasks as $task)
                                                <tr style="{{ $reportData['taskWithMostTime'] && $task->id == $reportData['taskWithMostTime']->id ? 'background: rgba(92, 184, 92, 0.1);' : '' }}">
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if($reportData['taskWithMostTime'] && $task->id == $reportData['taskWithMostTime']->id)
                                                                <span class="badge" style="background: rgba(92, 184, 92, 0.3); color: var(--accent);">
                                                                    <i class="fas fa-fire me-1"></i>Most Time
                                                                </span>
                                                            @endif
                                                            <span style="color: #2e5a2e;">{{ Str::limit($task->description, 80) }}</span>
                                                        </div>
                                                    </td>
                                                    <td style="color: #2e5a2e;">{{ $task->task_date ? $task->task_date->format('M d, Y') : 'N/A' }}</td>
                                                    <td>
                                                        <strong style="color: #2e5a2e;">{{ $task->hours }}h {{ $task->minutes }}m</strong>
                                                        <small style="color: #2e5a2e;">({{ $task->total_minutes }} min)</small>
                                                    </td>
                                                    <td>
                                                        @switch($task->status)
                                                            @case('completed')
                                                                <span class="badge" style="background: rgba(92, 184, 92, 0.2); color: #2e5a2e;">Completed</span>
                                                                @break
                                                            @case('in_progress')
                                                                <span class="badge" style="background: rgba(92, 184, 92, 0.15); color: #2e5a2e;">In Progress</span>
                                                                @break
                                                            @default
                                                                <span class="badge" style="background: rgba(92, 184, 92, 0.1); color: #2e5a2e;">Pending</span>
                                                        @endswitch
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-5 text-center" style="color: var(--muted);">
                                    <i class="fas fa-inbox fa-3x mb-3" style="color: var(--accent);"></i>
                                    <p>No tasks found for the selected criteria.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif($selectedStaff && !$reportData)
                    <div class="card" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                        <div class="card-body p-5 text-center" style="color: var(--muted);">
                            <i class="fas fa-inbox fa-3x mb-3" style="color: var(--accent);"></i>
                            <h5 style="color: var(--fg);">No tasks found</h5>
                            <p>{{ $selectedStaff->name }} has no tasks for the selected criteria.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Fix select dropdown arrow visibility */
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='%230a1929' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            background-size: 16px 12px !important;
        }

        .form-select:focus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='%23c9a227' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterType = document.getElementById('filterType');
            const dayFilter = document.getElementById('dayFilter');
            const monthFilter = document.getElementById('monthFilter');
            const rangeFilter = document.getElementById('rangeFilter');

            filterType.addEventListener('change', function() {
                if (this.value === 'day') {
                    dayFilter.style.display = 'block';
                    monthFilter.style.display = 'none';
                    rangeFilter.style.display = 'none';
                } else if (this.value === 'month') {
                    dayFilter.style.display = 'none';
                    monthFilter.style.display = 'block';
                    rangeFilter.style.display = 'none';
                } else if (this.value === 'range') {
                    dayFilter.style.display = 'none';
                    monthFilter.style.display = 'none';
                    rangeFilter.style.display = 'block';
                } else {
                    dayFilter.style.display = 'none';
                    monthFilter.style.display = 'none';
                    rangeFilter.style.display = 'none';
                }
            });
        });
    </script>
</x-admin-layout>
