<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['group' => 'company', 'key' => 'name', 'value' => ['value' => 'Demo HRIS Company']],
            ['group' => 'payroll', 'key' => 'frequency', 'value' => ['value' => 'semi-monthly']],
            ['group' => 'work_schedule', 'key' => 'hours_per_day', 'value' => ['value' => 8]],
            ['group' => 'currency', 'key' => 'code', 'value' => ['value' => 'PHP']],
        ];

        foreach ($settings as $setting) {
            SystemSetting::query()->updateOrCreate(
                ['group' => $setting['group'], 'key' => $setting['key']],
                ['value' => $setting['value'], 'is_public' => false]
            );
        }
    }
}
