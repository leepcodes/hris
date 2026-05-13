<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Employee;
use App\Models\EmployeeLoan;
use App\Models\LeaveCredit;
use App\Models\LeaveRequest;
use App\Models\OvertimeRequest;
use App\Models\Payslip;

class EssController extends Controller
{
    public function index()
    {
        $employee = auth()->user()?->email ? Employee::query()->where('email', auth()->user()->email)->first() : null;

        return view('ess.index', [
            'employee' => $employee,
            'leaveRequests' => $employee ? LeaveRequest::query()->where('employee_id', $employee->id)->latest()->limit(10)->get() : collect(),
            'leaveCredits' => $employee ? LeaveCredit::query()->where('employee_id', $employee->id)->get() : collect(),
            'overtimeRequests' => $employee ? OvertimeRequest::query()->where('employee_id', $employee->id)->latest()->limit(10)->get() : collect(),
            'attendanceRecords' => $employee ? AttendanceRecord::query()->where('employee_id', $employee->id)->latest('attendance_date')->limit(15)->get() : collect(),
            'loans' => $employee ? EmployeeLoan::query()->where('employee_id', $employee->id)->get() : collect(),
            'payslips' => $employee ? Payslip::query()->where('employee_id', $employee->id)->latest()->limit(10)->get() : collect(),
        ]);
    }
}
