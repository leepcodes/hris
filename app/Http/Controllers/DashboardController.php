<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SystemSetting;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'employeeCount' => Employee::query()->count(),
            'activeEmployeeCount' => Employee::query()->where('is_active', true)->count(),
            'pendingLeaveCount' => 0,
            'openPayrollCount' => 0,
            'systemSettingCount' => SystemSetting::query()->count(),
        ]);
    }
}
