<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            DepartmentSeeder::class,
            JobPositionSeeder::class,
            SystemSettingSeeder::class,
            GovernmentDeductionConfigSeeder::class,
            LeaveTypeSeeder::class,
            LoanTypeSeeder::class,
            PayrollPeriodSeeder::class,
            AccountSeeder::class,
            EmployeeSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}
