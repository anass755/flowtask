<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::updateOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'staff',
                'password' => bcrypt('staff@1234'),
                'email_verified_at' => now(),
            ]
        );
    }
}
