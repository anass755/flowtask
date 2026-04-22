<x-admin-layout title="Dashboard">
    <div class="container-fluid">
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
                    <h2 class="mb-0 fw-bold fs-5" style="color: var(--fg); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">Admin Dashboard</h2>
                    <p class="mb-0 small" style="color: var(--muted);">
                        Overview of staff performance and tasks
                    </p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-2" style="color: var(--muted);">Total Staff</h6>
                                <h3 class="fw-bold mb-0" style="color: var(--fg);">{{ $totalStaff ?? 0 }}</h3>
                            </div>
                            <div class="p-3 rounded-circle" style="background: rgba(92, 184, 92, 0.15); color: var(--accent);">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-2" style="color: var(--muted);">Total Tasks</h6>
                                <h3 class="fw-bold mb-0" style="color: var(--fg);">{{ $totalTasks ?? 0 }}</h3>
                            </div>
                            <div class="p-3 rounded-circle" style="background: rgba(92, 184, 92, 0.15); color: var(--accent);">
                                <i class="fas fa-tasks"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-2" style="color: var(--muted);">Total Locked</h6>
                                <h3 class="fw-bold mb-0" style="color: var(--fg);">{{ $totalLocked ?? 0 }}</h3>
                            </div>
                            <div class="p-3 rounded-circle" style="background: rgba(92, 184, 92, 0.15); color: var(--accent);">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-2" style="color: var(--muted);">Completed</h6>
                                <h3 class="fw-bold mb-0" style="color: var(--fg);">{{ $totalCompletedTasks ?? 0 }}</h3>
                            </div>
                            <div class="p-3 rounded-circle" style="background: rgba(92, 184, 92, 0.15); color: var(--accent);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff Performance Table -->
        <div class="card border-0 shadow-lg">
            <div class="card-header" style="background: rgba(92, 184, 92, 0.1); border-bottom: 1px solid var(--card-border);">
                <h3 class="card-title mb-0" style="color: var(--accent); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">
                    <i class="fas fa-users me-2"></i>Staff Performance Overview
                </h3>
                <p class="mb-0" style="color: var(--muted);">View all staff members, their tasks, and performance metrics</p>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover" style="color: #2e5a2e;">
                        <thead>
                            <tr>
                                <th>Staff Name</th>
                                <th>Email</th>
                                <th>Total Tasks</th>
                                <th>Completed</th>
                                <th>In Progress</th>
                                <th>Pending</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($staff->count() > 0)
                                @foreach($staff as $member)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width:32px; height:32px; background: rgba(92, 184, 92, 0.15); font-size:0.8rem; color: var(--accent);">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <span class="fw-semibold" style="color: #2e5a2e;">{{ $member->name }}</span>
                                            </div>
                                        </td>
                                        <td style="color: #2e5a2e;">{{ $member->email }}</td>
                                        <td>
                                            <span class="badge" style="background: rgba(92, 184, 92, 0.1); color: #2e5a2e;">{{ $member->tasks_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: rgba(92, 184, 92, 0.2); color: #2e5a2e;">{{ $member->completed_tasks ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: rgba(92, 184, 92, 0.15); color: #2e5a2e;">{{ $member->in_progress_tasks ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: rgba(92, 184, 92, 0.1); color: #2e5a2e;">{{ $member->pending_tasks ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group gap-2">
                                                <a href="{{ route('admin.staff.edit', $member->id) }}"
                                                   class="btn btn-sm" style="border: 1px solid var(--card-border); color: var(--accent);">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-sm" style="border: 1px solid var(--card-border); color: var(--accent);"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#staffTasksModal{{ $member->id }}">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-users-slash fa-2x mb-2"></i>
                                            <p>No staff members found. Add staff to get started.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Staff Tasks Modals -->
        @foreach($staff as $member)
            @if($member->tasks->count() > 0)
                <div class="modal fade" id="staffTasksModal{{ $member->id }}" tabindex="-1" aria-labelledby="staffTasksModalLabel{{ $member->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #ffffff; border-bottom: 1px solid #e0e0e0;">
                                <h5 class="modal-title" id="staffTasksModalLabel{{ $member->id }}" style="color: #0a1929; font-weight: 700;">
                                    <i class="fas fa-list me-2"></i>{{ $member->name }}'s Tasks
                                </h5>
                                <button type="button" class="btn-close" onclick="closeModal('staffTasksModal{{ $member->id }}')" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Task</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($member->tasks as $task)
                                                <tr>
                                                    <td>{{ $task->description }}</td>
                                                    <td>{{ $task->task_date ? $task->task_date->format('M d, Y') : 'N/A' }}</td>
                                                    <td>{{ $task->hours }}h {{ $task->minutes }}m</td>
                                                    <td>
                                                        @switch($task->status)
                                                            @case('completed')
                                                                <span class="badge bg-success">Completed</span>
                                                                @break
                                                            @case('in_progress')
                                                                <span class="badge bg-warning">In Progress</span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-secondary">Pending</span>
                                                        @endswitch
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="closeModal('staffTasksModal{{ $member->id }}')">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <script>
    // Function to close modal by ID
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const bootstrapModal = bootstrap.Modal.getInstance(modal);
            if (bootstrapModal) {
                bootstrapModal.hide();
            } else {
                modal.classList.remove('show');
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            }
        }
    }

    // Close modal when clicking outside (on backdrop)
    document.addEventListener('click', function(event) {
        // Check if click is on backdrop
        if (event.target.classList.contains('modal')) {
            closeModal(event.target.id);
        }
        // Also check if click is on modal-backdrop
        if (event.target.classList.contains('modal-backdrop')) {
            // Find the associated modal
            const modals = document.querySelectorAll('.modal.show');
            modals.forEach(function(modal) {
                closeModal(modal.id);
            });
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('.modal.show');
            modals.forEach(function(modal) {
                closeModal(modal.id);
            });
        }
    });
    </script>
    <style>
    .modal {
        z-index: 99999 !important;
    }
    .modal-backdrop {
        z-index: 99998 !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
    }
    .modal-content {
        pointer-events: auto !important;
        background: #ffffff !important;
        box-shadow: none !important;
        border: 1px solid #e0e0e0 !important;
    }
    .modal-body {
        background: #ffffff !important;
    }
    .modal-header button,
    .modal-footer button {
        pointer-events: auto !important;
        cursor: pointer !important;
    }
    .table {
        background: #ffffff !important;
        border: 1px solid #e0e0e0 !important;
    }
    .table thead {
        background: #f8f9fa !important;
    }
    .table thead th {
        color: #0a1929 !important;
        border-bottom: 1px solid #e0e0e0 !important;
    }
    </style>
</x-admin-layout>
