<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Vacation Leave', 'code' => 'VL', 'is_paid' => true, 'accrual_rate' => 1.25, 'is_active' => true],
            ['name' => 'Sick Leave', 'code' => 'SL', 'is_paid' => true, 'accrual_rate' => 1.25, 'is_active' => true],
            ['name' => 'Emergency Leave', 'code' => 'EL', 'is_paid' => true, 'accrual_rate' => 0.25, 'is_active' => true],
            ['name' => 'Service Incentive Leave', 'code' => 'SIL', 'is_paid' => true, 'accrual_rate' => 0.42, 'is_active' => true],
            ['name' => 'Unpaid Leave', 'code' => 'UL', 'is_paid' => false, 'accrual_rate' => 0, 'is_active' => true],
        ];

        foreach ($types as $type) {
            LeaveType::query()->updateOrCreate(['code' => $type['code']], $type);
        }
    }
}
