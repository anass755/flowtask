<x-staff-layout title="My Tasks">
    <div class="container-fluid">
        <!-- Header Section -->
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 p-4 rounded-4 mb-4"
     style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-lg);">

    <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
             style="width:48px; height:48px; background: rgba(92, 184, 92, 0.1); font-size:1.2rem; color: var(--accent);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
        </div>
        <div>
            <h2 class="mb-0 fw-bold fs-5" style="color: var(--fg); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">Manage Tasks</h2>
            <p class="mb-0 small" style="color: var(--accent);">
                View and manage all your assigned tasks
            </p>
        </div>
    </div>

    <div>
        <a href="{{ route('staff.tasks.create') }}"
           class="btn fw-semibold d-inline-flex align-items-center gap-2"
           style="background: var(--accent); border: none; color: var(--bg);">
            <i class="fas fa-plus-circle"></i> Add New Task
        </a>
    </div>

</div>

        <!-- Locked Tasks Toaster Notice -->
        @if(($lockedTasksCount ?? 0) > 0)
            <div class="toaster-notification toaster-warning" id="lockedTasksToaster">
                <div class="toaster-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="toaster-content">
                    <h6 class="toaster-title mb-1">Locked Tasks</h6>
                    <p class="toaster-message mb-0">You have {{ $lockedTasksCount }} task(s) locked by the administrator. These tasks cannot be edited or deleted until unlocked.</p>
                </div>
                <button type="button" class="toaster-close" onclick="closeToaster('lockedTasksToaster')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <script>
                setTimeout(function() {
                    closeToaster('lockedTasksToaster');
                }, 15000);
            </script>
        @endif

        <!-- Tasks List -->
        <div class="row">
            <div class="col-12">
                @if($tasks->count() > 0)
                    <div class="card" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" style="color: #2e5a2e;">
                                    <thead>
                                        <tr style="background: rgba(92, 184, 92, 0.1); color: var(--accent);">
                                            <th scope="col" class="border-0">
                                                <i class="fas fa-info-circle me-2"></i>Task Details
                                            </th>
                                            <th scope="col" class="border-0 text-center">
                                                <i class="fas fa-flag me-2"></i>Status
                                            </th>
                                            <th scope="col" class="border-0 text-center">
                                                <i class="fas fa-clock me-2"></i>Time
                                            </th>
                                            <th scope="col" class="border-0 text-center">
                                                <i class="fas fa-calendar me-2"></i>Date
                                            </th>
                                            <th scope="col" class="border-0 text-center">
                                                <i class="fas fa-cogs me-2"></i>Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tasks as $task)
                                            <tr class="align-middle">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($task->locked)
                                                            <span class="badge bg-danger me-2">
                                                                <i class="fas fa-lock me-1"></i>LOCKED
                                                            </span>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-1 fw-bold" style="color: #2e5a2e;">{{ Str::limit($task->description, 80) }}</h6>
                                                            <small style="color: #2e5a2e;">
                                                                <i class="fas fa-history me-1"></i>
                                                                Created {{ $task->created_at->diffForHumans() }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="position-relative">
                                                        <select name="status" class="form-select form-select-sm status-select"
                                                                data-task-id="{{ $task->id }}"
                                                                style="min-width: 130px; @if($task->status === 'completed') background-color: #d4edda; border-color: #c3e6cb; @elseif($task->status === 'in_progress') background-color: #e2e3e5; border-color: #d6d8db; @elseif($task->status === 'pending') background-color: rgba(92, 184, 92, 0.2); border-color: rgba(92, 184, 92, 0.4); @endif">
                                                            <option value="pending"     {{ $task->status === 'pending'     ? 'selected' : '' }}>
                                                                Pending
                                                            </option>
                                                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>
                                                                In Progress
                                                            </option>
                                                            <option value="completed"   {{ $task->status === 'completed'   ? 'selected' : '' }}>
                                                                Completed
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="fw-bold" style="color: #2e5a2e;">
                                                        {{ $task->time_display }}
                                                    </div>
                                                    <small style="color: #2e5a2e;">{{ $task->total_minutes }} min</small>
                                                </td>
                                                <td class="text-center">
                                                    @if($task->task_date)
                                                        <span class="badge" style="background: rgba(92, 184, 92, 0.2); color: var(--accent);">
                                                            <i class="fas fa-calendar-day me-1"></i>
                                                            {{ $task->task_date->format('M d') }}
                                                        </span>
                                                    @else
                                                        <span style="color: #2e5a2e;">
                                                            <i class="fas fa-calendar-times me-1"></i>No date
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        @if($task->locked)
                                                            <button type="button" class="btn btn-sm" style="border: 1px solid var(--card-border); color: var(--accent);" disabled>
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm" style="border: 1px solid var(--card-border); color: var(--accent);" disabled>
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @else
                                                            <a href="{{ route('staff.tasks.edit', $task->id) }}"
                                                               class="btn btn-sm" style="border: 1px solid var(--card-border); color: var(--accent);">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button"
                                                                    class="btn btn-sm" style="border: 1px solid var(--card-border); color: var(--accent);"
                                                                    onclick="if(confirm('Are you sure you want to delete this task?')) {
                                                                        document.getElementById('delete-form-{{ $task->id }}').submit();
                                                                    }">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="card-footer" style="background: rgba(92, 184, 92, 0.05); border-top: 1px solid var(--card-border);">
                                {{ $tasks->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-clipboard-list fa-4x" style="color: var(--accent);"></i>
                            </div>
                            <h4 class="mb-3" style="color: var(--fg);">No tasks yet</h4>
                            <p class="mb-4" style="color: var(--accent);">Start by creating your first task to track your time</p>
                            <a href="{{ route('staff.tasks.create') }}"
                               class="btn btn-lg" style="background: var(--accent); border: none; color: var(--bg);">
                                <i class="fas fa-plus-circle me-2"></i>Create Your First Task
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-staff-layout>

<style>
.status-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%235cb85c' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
}

.toaster-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    width: 450px;
    z-index: 9999;
    animation: slideIn 0.3s ease-out;
    border-left: 4px solid #5cb85c;
}

.toaster-success {
    border-left-color: #28a745;
}

.toaster-warning {
    border-left-color: #5cb85c;
}

.toaster-icon {
    width: 40px;
    height: 40px;
    background: rgba(92, 184, 92, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #5cb85c;
    font-size: 20px;
    flex-shrink: 0;
}

.toaster-content {
    flex: 1;
}

.toaster-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--fg);
    margin-bottom: 4px;
}

.toaster-message {
    font-size: 13px;
    color: var(--fg);
    line-height: 1.4;
}

.toaster-close {
    background: none;
    border: none;
    color: var(--accent);
    font-size: 16px;
    cursor: pointer;
    padding: 4px;
    transition: color 0.2s;
}

.toaster-close:hover {
    color: var(--accent);
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

.toaster-notification.hiding {
    animation: slideOut 0.3s ease-in;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle status change
    document.querySelectorAll('.status-select').forEach(function(select) {
        select.addEventListener('change', function(e) {
            var taskId = this.getAttribute('data-task-id');
            var newStatus = this.value;
            var statusText = this.options[this.selectedIndex].text;
            
            if (confirm('Are you sure you want to change this task status to "' + statusText + '"?')) {
                // Show loading state
                var originalValue = this.value;
                this.disabled = true;
                
                // Send AJAX request
                fetch('/staff/tasks/' + taskId + '/update-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to show updated status
                        window.location.reload();
                    } else {
                        // Show error message
                        alert('Error updating task status: ' + (data.message || 'Unknown error'));
                        
                        // Restore select state
                        this.value = originalValue;
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating task status. Please try again.');
                    
                    // Restore select state
                    this.value = originalValue;
                    this.disabled = false;
                });
            } else {
                // Restore original value if cancelled
                this.value = originalValue;
            }
        });
    });
});

function closeToaster(toasterId) {
    var toaster = document.getElementById(toasterId);
    if (toaster) {
        toaster.classList.add('hiding');
        setTimeout(function() {
            toaster.remove();
        }, 300);
    }
}
</script>
