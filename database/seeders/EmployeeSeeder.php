<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->first();

        if (! $admin) {
            return;
        }

        Employee::query()->updateOrCreate(
            ['employee_code' => 'EMP-000001'],
            [
                'user_id' => $admin->id,
                'department_id' => 1,
                'job_position_id' => 1,
                'first_name' => 'System',
                'last_name' => 'Admin',
                'email' => $admin->email,
                'employment_status' => 'active',
                'hired_at' => now()->toDateString(),
                'basic_salary' => 35000,
                'daily_rate' => 1590.91,
                'hourly_rate' => 198.86,
            ]
        );
    }
}
