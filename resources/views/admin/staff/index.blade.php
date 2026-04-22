<x-admin-layout title="Staff Management">
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
                            <h2 class="mb-0 fw-bold fs-5" style="color: var(--fg); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">Staff Management</h2>
                            <p class="mb-0 small" style="color: var(--muted);">
                                View and manage all staff members
                            </p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.staff.create') }}"
                           class="btn fw-semibold d-inline-flex align-items-center gap-2"
                           style="background: var(--accent); border: none; color: var(--bg);">
                            <i class="fas fa-plus-circle"></i> Add New Staff
                        </a>
                    </div>
                </div>

                <!-- Staff Table -->
                <div class="card" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                    <div class="card-header" style="background: rgba(92, 184, 92, 0.1); border-bottom: 1px solid var(--card-border);">
                        <h3 class="card-title mb-0" style="color: var(--accent); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">
                            <i class="fas fa-users me-2"></i>All Staff Members
                        </h3>
                        <p class="mb-0" style="color: var(--muted);">View and manage all staff members in the system</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover" style="color: #2e5a2e;">
                                <thead>
                                    <tr style="background: rgba(92, 184, 92, 0.1); color: var(--accent);">
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                            <td style="color: #2e5a2e;">{{ $member->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group gap-2">
                                                    <a href="{{ route('admin.staff.edit', $member->id) }}"
                                                       class="btn btn-sm" style="border: 1px solid var(--card-border); color: var(--accent);">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.staff.destroy', $member->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm" style="border: 1px solid var(--card-border); color: var(--accent);">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
