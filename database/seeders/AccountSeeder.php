<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['name' => 'Super Admin', 'email' => 'admin@hris.local', 'role' => 'super-admin'],
            ['name' => 'HR Admin', 'email' => 'hr@hris.local', 'role' => 'hr-admin'],
            ['name' => 'Payroll Officer', 'email' => 'payroll@hris.local', 'role' => 'payroll-officer'],
            ['name' => 'Manager', 'email' => 'manager@hris.local', 'role' => 'manager'],
            ['name' => 'Employee User', 'email' => 'employee@hris.local', 'role' => 'employee'],
            ['name' => 'Auditor', 'email' => 'auditor@hris.local', 'role' => 'auditor'],
        ];

        $allPermissionIds = Permission::query()->pluck('id')->all();

        foreach ($accounts as $account) {
            $user = User::query()->updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => 'password',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            $role = Role::query()->where('slug', $account['role'])->first();

            if (! $role) {
                continue;
            }

            $user->roles()->sync([$role->id]);

            if ($role->slug === 'super-admin') {
                $role->permissions()->sync($allPermissionIds);
            }
        }
    }
}
