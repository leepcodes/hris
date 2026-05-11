<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\JobPosition;
use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    public function run(): void
    {
        $hr = Department::query()->where('code', 'HR')->first();
        $fin = Department::query()->where('code', 'FIN')->first();

        if (! $hr || ! $fin) {
            return;
        }

        JobPosition::query()->updateOrCreate(
            ['title' => 'HR Officer'],
            ['department_id' => $hr->id, 'salary_grade' => 'SG-11', 'basic_salary' => 28000, 'daily_rate' => 1272.73, 'hourly_rate' => 159.09]
        );

        JobPosition::query()->updateOrCreate(
            ['title' => 'Payroll Specialist'],
            ['department_id' => $fin->id, 'salary_grade' => 'SG-12', 'basic_salary' => 32000, 'daily_rate' => 1454.55, 'hourly_rate' => 181.82]
        );
    }
}
