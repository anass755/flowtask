<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectTask;
use App\Models\Staff;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = Staff::first();
        
        if ($staff) {
            ProjectTask::create([
                'description' => 'Set up database migrations for the new task management system',
                'staff_id' => $staff->id,
                'hours' => 2,
                'minutes' => 0,
                'status' => 'completed',
            ]);

            ProjectTask::create([
                'description' => 'Implement dual authentication system for admin and staff',
                'staff_id' => $staff->id,
                'hours' => 3,
                'minutes' => 0,
                'status' => 'completed',
            ]);

            ProjectTask::create([
                'description' => 'Create admin and staff dashboards with widgets',
                'staff_id' => $staff->id,
                'hours' => 1,
                'minutes' => 30,
                'status' => 'in_progress',
            ]);

            ProjectTask::create([
                'description' => 'Integrate third-party APIs for task management',
                'staff_id' => $staff->id,
                'hours' => 0,
                'minutes' => 45,
                'status' => 'pending',
            ]);

            ProjectTask::create([
                'description' => 'Perform comprehensive testing of the application',
                'staff_id' => $staff->id,
                'hours' => 1,
                'minutes' => 0,
                'status' => 'pending',
            ]);

            ProjectTask::create([
                'description' => 'Write technical documentation for the project',
                'staff_id' => $staff->id,
                'hours' => 0,
                'minutes' => 30,
                'status' => 'pending',
            ]);
        }
    }
}
