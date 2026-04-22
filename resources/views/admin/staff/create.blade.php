<x-admin-layout title="Create Staff">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <!-- Create Staff Card -->
                <div class="card border-0 shadow-lg">
                    <!-- Card Header -->
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #0a1929 0%, #1a2332 100%);">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-user-plus me-2"></i>Create New Staff
                        </h3>
                        <p class="mb-0 text-white-80">Add a new staff member to the system</p>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <form action="{{ route('admin.staff.store') }}" method="POST">
                            @csrf

                            <!-- Name and Email Row -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="fas fa-user me-2" style="color: #0a1929;"></i>Full Name
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input
                                            type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            id="name"
                                            name="name"
                                            placeholder="Enter full name"
                                            required
                                            value="{{ old('name') }}"
                                        >
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold">
                                        <i class="fas fa-envelope me-2" style="color: #0a1929;"></i>Email Address
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input
                                            type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            id="email"
                                            name="email"
                                            placeholder="Enter email address"
                                            required
                                            value="{{ old('email') }}"
                                        >
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Row -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-bold">
                                        <i class="fas fa-lock me-2" style="color: #0a1929;"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="password"
                                            name="password"
                                            placeholder="Enter password"
                                            required
                                        >
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-bold">
                                        <i class="fas fa-lock me-2" style="color: #0a1929;"></i>Confirm Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input
                                            type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            placeholder="Confirm password"
                                            required
                                        >
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a
                                    href="{{ route('admin.staff.index') }}"
                                    class="btn btn-secondary"
                                >
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="fas fa-save me-2"></i>Create Staff
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
