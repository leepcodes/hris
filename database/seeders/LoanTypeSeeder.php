<?php

namespace Database\Seeders;

use App\Models\LoanType;
use Illuminate\Database\Seeder;

class LoanTypeSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Salary Loan', 'default_interest_rate' => 0.02, 'is_active' => true],
            ['name' => 'Calamity Loan', 'default_interest_rate' => 0.01, 'is_active' => true],
        ] as $type) {
            LoanType::query()->updateOrCreate(['name' => $type['name']], $type);
        }
    }
}
