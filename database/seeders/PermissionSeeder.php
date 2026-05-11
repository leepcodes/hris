<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'View Users', 'slug' => 'users.view', 'module' => 'users'],
            ['name' => 'Create Users', 'slug' => 'users.create', 'module' => 'users'],
            ['name' => 'Update Users', 'slug' => 'users.update', 'module' => 'users'],
            ['name' => 'Delete Users', 'slug' => 'users.delete', 'module' => 'users'],

            ['name' => 'View Employees', 'slug' => 'employees.view', 'module' => 'employees'],
            ['name' => 'Create Employees', 'slug' => 'employees.create', 'module' => 'employees'],
            ['name' => 'Update Employees', 'slug' => 'employees.update', 'module' => 'employees'],
            ['name' => 'Delete Employees', 'slug' => 'employees.delete', 'module' => 'employees'],

            ['name' => 'View Departments', 'slug' => 'departments.view', 'module' => 'departments'],
            ['name' => 'Create Departments', 'slug' => 'departments.create', 'module' => 'departments'],
            ['name' => 'Update Departments', 'slug' => 'departments.update', 'module' => 'departments'],
            ['name' => 'Delete Departments', 'slug' => 'departments.delete', 'module' => 'departments'],

            ['name' => 'View Job Positions', 'slug' => 'job_positions.view', 'module' => 'job_positions'],
            ['name' => 'Create Job Positions', 'slug' => 'job_positions.create', 'module' => 'job_positions'],
            ['name' => 'Update Job Positions', 'slug' => 'job_positions.update', 'module' => 'job_positions'],
            ['name' => 'Delete Job Positions', 'slug' => 'job_positions.delete', 'module' => 'job_positions'],

            ['name' => 'View Attendance', 'slug' => 'attendance.view', 'module' => 'attendance'],
            ['name' => 'Upload Attendance', 'slug' => 'attendance.upload', 'module' => 'attendance'],

            ['name' => 'View Leave', 'slug' => 'leave.view', 'module' => 'leave'],
            ['name' => 'Manage Leave', 'slug' => 'leave.manage', 'module' => 'leave'],

            ['name' => 'View Overtime', 'slug' => 'overtime.view', 'module' => 'overtime'],
            ['name' => 'Manage Overtime', 'slug' => 'overtime.manage', 'module' => 'overtime'],

            ['name' => 'View Loans', 'slug' => 'loans.view', 'module' => 'loans'],
            ['name' => 'Manage Loans', 'slug' => 'loans.manage', 'module' => 'loans'],

            ['name' => 'View Deductions', 'slug' => 'deductions.view', 'module' => 'deductions'],
            ['name' => 'Manage Deductions', 'slug' => 'deductions.manage', 'module' => 'deductions'],

            ['name' => 'View Payroll', 'slug' => 'payroll.view', 'module' => 'payroll'],
            ['name' => 'Prepare Payroll', 'slug' => 'payroll.prepare', 'module' => 'payroll'],
            ['name' => 'Approve Payroll', 'slug' => 'payroll.approve', 'module' => 'payroll'],

            ['name' => 'View Reports', 'slug' => 'reports.view', 'module' => 'reports'],
            ['name' => 'Export Reports', 'slug' => 'reports.export', 'module' => 'reports'],

            ['name' => 'View Audit', 'slug' => 'audit.view', 'module' => 'audit'],
            ['name' => 'View ESS', 'slug' => 'ess.view', 'module' => 'ess'],

            ['name' => 'View Settings', 'slug' => 'settings.view', 'module' => 'settings'],
            ['name' => 'Update Settings', 'slug' => 'settings.update', 'module' => 'settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(['slug' => $permission['slug']], $permission);
        }
    }
}
