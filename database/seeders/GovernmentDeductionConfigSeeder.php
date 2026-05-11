<?php

namespace Database\Seeders;

use App\Models\GovernmentDeductionConfig;
use Illuminate\Database\Seeder;

class GovernmentDeductionConfigSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['deduction_type' => 'sss', 'name' => 'SSS Bracket A', 'config' => ['salary_min' => 0, 'salary_max' => 14999.99, 'employee_share' => 675.00], 'is_active' => true],
            ['deduction_type' => 'sss', 'name' => 'SSS Bracket B', 'config' => ['salary_min' => 15000, 'salary_max' => 24999.99, 'employee_share' => 900.00], 'is_active' => true],
            ['deduction_type' => 'sss', 'name' => 'SSS Bracket C', 'config' => ['salary_min' => 25000, 'salary_max' => 999999.99, 'employee_share' => 1125.00], 'is_active' => true],

            ['deduction_type' => 'philhealth', 'name' => 'PhilHealth Bracket A', 'config' => ['salary_min' => 0, 'salary_max' => 14999.99, 'employee_share' => 375.00], 'is_active' => true],
            ['deduction_type' => 'philhealth', 'name' => 'PhilHealth Bracket B', 'config' => ['salary_min' => 15000, 'salary_max' => 24999.99, 'employee_share' => 500.00], 'is_active' => true],
            ['deduction_type' => 'philhealth', 'name' => 'PhilHealth Bracket C', 'config' => ['salary_min' => 25000, 'salary_max' => 999999.99, 'employee_share' => 625.00], 'is_active' => true],

            ['deduction_type' => 'pagibig', 'name' => 'Pag-IBIG Bracket A', 'config' => ['salary_min' => 0, 'salary_max' => 14999.99, 'employee_share' => 100.00], 'is_active' => true],
            ['deduction_type' => 'pagibig', 'name' => 'Pag-IBIG Bracket B', 'config' => ['salary_min' => 15000, 'salary_max' => 999999.99, 'employee_share' => 200.00], 'is_active' => true],

            ['deduction_type' => 'withholding_tax', 'name' => 'WHT Bracket A', 'config' => ['salary_min' => 0, 'salary_max' => 20832.99, 'employee_share' => 0.00], 'is_active' => true],
            ['deduction_type' => 'withholding_tax', 'name' => 'WHT Bracket B', 'config' => ['salary_min' => 20833, 'salary_max' => 33332.99, 'employee_share' => 1250.00], 'is_active' => true],
            ['deduction_type' => 'withholding_tax', 'name' => 'WHT Bracket C', 'config' => ['salary_min' => 33333, 'salary_max' => 999999.99, 'employee_share' => 2500.00], 'is_active' => true],
        ];

        foreach ($rows as $row) {
            GovernmentDeductionConfig::query()->updateOrCreate(
                ['deduction_type' => $row['deduction_type'], 'name' => $row['name']],
                $row + ['effective_date' => now()->toDateString()]
            );
        }
    }
}
