<?php

namespace Database\Seeders;

use App\Models\PayrollPeriod;
use Illuminate\Database\Seeder;

class PayrollPeriodSeeder extends Seeder
{
    public function run(): void
    {
        PayrollPeriod::query()->updateOrCreate(
            ['name' => 'Current Semi-Monthly'],
            [
                'frequency' => 'semi-monthly',
                'start_date' => now()->startOfMonth()->toDateString(),
                'end_date' => now()->startOfMonth()->addDays(14)->toDateString(),
                'status' => 'open',
            ]
        );
    }
}
