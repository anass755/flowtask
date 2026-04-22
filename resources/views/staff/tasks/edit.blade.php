<x-staff-layout title="Edit Task">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <!-- Edit Task Card -->
                <div class="card border-0 shadow-lg">
                    <!-- Card Header -->
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #03166c 0%, #764ba2 100%);">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-edit me-2"></i>Edit Task
                        </h3>
                        <p class="mb-0 text-white-80">Update your task details and time tracking</p>
                    </div>

                    <!-- Card Body -->
                    @if($task->locked)
                        <div class="p-4 text-center">
                            <div class="alert alert-warning">
                                <i class="fas fa-lock me-2"></i>
                                <strong>This task is locked by the administrator.</strong>
                                <p class="mb-0">You cannot edit this task until it is unlocked.</p>
                            </div>
                            <a href="{{ route('staff.tasks.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                            </a>
                        </div>
                    @else
                        <form action="{{ route('staff.tasks.update', $task->id) }}" method="POST" class="p-4">
                            @csrf
                            @method('PUT')

                        <!-- Task Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="fas fa-align-left me-2" style="color: #03166c;"></i>
                                Task Description <span class="text-danger">*</span>
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="4" 
                                required
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Describe your task in detail..."
                            >{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Hours and Minutes -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="hours" class="form-label fw-bold">
                                    <i class="fas fa-clock me-2" style="color: #03166c;"></i>Hours <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-hourglass-half"></i>
                                    </span>
                                    <input 
                                        type="number" 
                                        id="hours" 
                                        name="hours" 
                                        min="0" 
                                        max="23"
                                        required
                                        class="form-control @error('hours') is-invalid @enderror"
                                        placeholder="0-23"
                                        value="{{ old('hours', $task->hours) }}"
                                    >
                                </div>
                                <small style="color: var(--accent);">Enter hours (0-23)</small>
                                @error('hours')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="minutes" class="form-label fw-bold">
                                    <i class="fas fa-clock me-2" style="color: #03166c;"></i>Minutes <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-stopwatch"></i>
                                    </span>
                                    <input 
                                        type="number" 
                                        id="minutes" 
                                        name="minutes" 
                                        min="0" 
                                        max="59"
                                        required
                                        class="form-control @error('minutes') is-invalid @enderror"
                                        placeholder="0-59"
                                        value="{{ old('minutes', $task->minutes) }}"
                                    >
                                </div>
                                <small style="color: var(--accent);">Enter minutes (0-59)</small>
                                @error('minutes')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Task Date and Status -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="task_date" class="form-label fw-bold">
                                    <i class="fas fa-calendar me-2" style="color: #03166c;"></i>Task Date
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <input 
                                        type="date" 
                                        id="task_date" 
                                        name="task_date"
                                        value="{{ old('task_date', $task->task_date ? $task->task_date->format('Y-m-d') : '') }}"
                                        class="form-control @error('task_date') is-invalid @enderror"
                                    >
                                </div>
                                @error('task_date')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">
                                    <i class="fas fa-flag me-2" style="color: #03166c;"></i>Status <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                    <select 
                                        id="status" 
                                        name="status" 
                                        required
                                        class="form-select @error('status') is-invalid @enderror"
                                    >
                                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a 
                                href="{{ route('staff.tasks.index') }}" 
                                class="btn btn-secondary"
                            >
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button 
                                type="submit" 
                                class="btn btn-success"
                            >
                                <i class="fas fa-save me-2"></i>Update Task
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>
