<x-admin-layout title="Tasks Management">
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
                            <h2 class="mb-0 fw-bold fs-5" style="color: var(--fg); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">Tasks Management</h2>
                            <p class="mb-0 small" style="color: var(--muted);">
                                Click on staff to view their tasks
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Staff Accordion -->
                <div class="accordion" id="staffAccordion">
                    @foreach($staff as $staffMember)
                        <div class="accordion-item mb-3" style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--border-radius-md); overflow: hidden;">
                            <h2 class="accordion-header" id="heading{{ $staffMember->id }}">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $staffMember->id }}"
                                        aria-expanded="false"
                                        aria-controls="collapse{{ $staffMember->id }}"
                                        style="background: var(--card-bg); border: 1px solid var(--card-border);">
                                    <div class="d-flex align-items-center gap-3 w-100">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                             style="width:40px; height:40px; background: rgba(92, 184, 92, 0.3); color: var(--accent);">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-0 fw-bold" style="color: #7dd87d;">{{ $staffMember->name }}</h5>
                                            <small class="mb-0" style="color: #7dd87d;">
                                                {{ $staffMember->tasks->count() }} task(s) • {{ $staffMember->email }}
                                            </small>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{ $staffMember->id }}"
                                 class="accordion-collapse collapse"
                                 aria-labelledby="heading{{ $staffMember->id }}"
                                 data-bs-parent="#staffAccordion">
                                <div class="accordion-body p-0" style="background: rgba(92, 184, 92, 0.05);">
                                    @if($staffMember->tasks->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" style="color: #2e5a2e;">
                                                <thead>
                                                    <tr style="background: rgba(92, 184, 92, 0.1); color: var(--accent);">
                                                        <th>Task</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Status</th>
                                                        <th>Lock</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($staffMember->tasks as $task)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <span class="fw-semibold" style="color: #2e5a2e;">{{ $task->description }}</span>
                                                                    @if($task->locked)
                                                                        <span class="badge" style="background: rgba(92, 184, 92, 0.2); color: var(--accent);">
                                                                            <i class="fas fa-lock me-1"></i>Locked
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td style="color: #2e5a2e;">{{ $task->task_date ? $task->task_date->format('M d, Y') : 'N/A' }}</td>
                                                            <td style="color: #2e5a2e;">{{ $task->hours }}h {{ $task->minutes }}m</td>
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
                                                            <td>
                                                                <form action="{{ route('admin.tasks.toggle-lock', $task->id) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                            class="btn btn-sm"
                                                                            style="@if($task->locked) background: #f59e0b; border: none; color: white; @else background: var(--accent); border: none; color: var(--bg); @endif">
                                                                        <i class="fas {{ $task->locked ? 'fa-unlock' : 'fa-lock' }}"></i>
                                                                        {{ $task->locked ? 'Unlock' : 'Lock' }}
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="p-4 text-center" style="color: var(--muted);">
                                            <i class="fas fa-inbox fa-2x mb-2" style="color: var(--accent);"></i>
                                            <p>No tasks assigned to this staff member.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
