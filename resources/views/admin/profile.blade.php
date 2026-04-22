<x-admin-layout title="Profile">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
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
                            <h2 class="mb-0 fw-bold fs-5" style="color: var(--fg); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">Profile Settings</h2>
                            <p class="mb-0 small" style="color: var(--muted);">
                                Manage your account settings and preferences
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Profile Card -->
                <div class="card" style="background: var(--card-bg); border: 1px solid var(--card-border); box-shadow: var(--shadow-md);">
                    <div class="card-header" style="background: rgba(92, 184, 92, 0.1); border-bottom: 1px solid var(--card-border);">
                        <h5 class="mb-0" style="color: var(--accent); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">
                            <i class="fas fa-user-circle me-2"></i>Account Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: var(--fg);">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-2"></i>Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--fg);"
                                           value="{{ $user->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" class="form-control"
                                           style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--fg);"
                                           value="{{ $user->email }}" required>
                                </div>
                            </div>

                            <hr style="border-color: var(--card-border); margin: 2rem 0;">

                            <h5 class="mb-3" style="color: var(--accent); font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.05em;">
                                <i class="fas fa-lock me-2"></i>Change Password
                            </h5>
                            <p class="mb-4 small" style="color: var(--muted);">
                                Leave blank if you don't want to change your password
                            </p>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="current_password" class="form-label">
                                        <i class="fas fa-key me-2"></i>Current Password
                                    </label>
                                    <input type="password" id="current_password" name="current_password" class="form-control"
                                           style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--fg);">
                                </div>
                                <div class="col-md-6"></div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="new_password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>New Password
                                    </label>
                                    <input type="password" id="new_password" name="new_password" class="form-control"
                                           style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--fg);">
                                </div>
                                <div class="col-md-6">
                                    <label for="new_password_confirmation" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Confirm New Password
                                    </label>
                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control"
                                           style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--fg);">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('admin.dashboard') }}" class="btn"
                                   style="background: transparent; border: 1px solid var(--card-border); color: var(--fg);">
                                    Cancel
                                </a>
                                <button type="submit" class="btn"
                                        style="background: var(--accent); border: none; color: var(--bg);">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
