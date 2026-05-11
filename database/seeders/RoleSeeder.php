<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin'],
            ['name' => 'HR Admin', 'slug' => 'hr-admin'],
            ['name' => 'Payroll Officer', 'slug' => 'payroll-officer'],
            ['name' => 'Manager', 'slug' => 'manager'],
            ['name' => 'Employee', 'slug' => 'employee'],
            ['name' => 'Auditor', 'slug' => 'auditor'],
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
