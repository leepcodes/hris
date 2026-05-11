<?php

namespace App\Services;

use App\Models\AttendanceRecord;
use App\Models\Employee;
use App\Models\EmployeeLoan;
use App\Models\GovernmentDeductionConfig;
use App\Models\LeaveRequest;
use App\Models\OvertimeRequest;
use App\Models\PayrollItemBreakdown;
use App\Models\PayrollPeriod;
use App\Models\PayrollRun;
use App\Models\PayrollRunItem;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    public function generateDraft(PayrollPeriod $period, int $preparedBy): PayrollRun
    {
        return DB::transaction(function () use ($period, $preparedBy): PayrollRun {
            $payrollRun = PayrollRun::query()->create([
                'payroll_period_id' => $period->id,
                'status' => 'prepared',
                'prepared_by' => $preparedBy,
                'prepared_at' => now(),
            ]);

            $employees = Employee::query()->where('is_active', true)->get();
            $isSecondCutoff = (int) $period->start_date->format('d') >= 16 || (int) $period->end_date->format('d') >= 30;

            foreach ($employees as $employee) {
                $attendance = AttendanceRecord::query()->where('employee_id', $employee->id)->whereBetween('attendance_date', [$period->start_date, $period->end_date])->get();
                $otHours = OvertimeRequest::query()->where('employee_id', $employee->id)->where('status', 'approved')->whereBetween('ot_date', [$period->start_date, $period->end_date])->sum('hours');
                $unpaidLeaves = LeaveRequest::query()->where('employee_id', $employee->id)->where('status', 'approved')->whereBetween('start_date', [$period->start_date, $period->end_date])->sum('days');

                $basicPay = (float) $employee->basic_salary;
                $overtimePay = (float) $otHours * (float) $employee->hourly_rate * 1.25;
                $allowances = 0.0;
                $holidayPay = 0.0;
                $grossPay = $basicPay + $overtimePay + $allowances + $holidayPay;

                $lateMinutes = (int) $attendance->sum('late_minutes');
                $undertimeMinutes = (int) $attendance->sum('undertime_minutes');
                $absentDays = (int) $attendance->where('is_absent', true)->count();

                $lateDeduction = ($lateMinutes / 60) * (float) $employee->hourly_rate;
                $undertimeDeduction = ($undertimeMinutes / 60) * (float) $employee->hourly_rate;
                $absenceDeduction = (float) $absentDays * (float) $employee->daily_rate;
                $leaveWithoutPay = (float) $unpaidLeaves * (float) $employee->daily_rate;
                $loanDeductions = (float) EmployeeLoan::query()->where('employee_id', $employee->id)->where('status', 'active')->sum('amortization_amount');

                $taxableIncome = max($grossPay - $leaveWithoutPay, 0);

                $sssDeduction = 0.0;
                $philhealthDeduction = 0.0;
                $pagibigDeduction = 0.0;
                $withholdingTax = 0.0;

                if ($isSecondCutoff) {
                    $brackets = GovernmentDeductionConfig::query()->where('is_active', true)->get()->groupBy('deduction_type');
                    $resolve = function (string $type) use ($brackets, $basicPay): float {
                        $match = ($brackets[$type] ?? collect())->first(function ($row) use ($basicPay) {
                            $min = (float) ($row->config['salary_min'] ?? 0);
                            $max = (float) ($row->config['salary_max'] ?? INF);

                            return $basicPay >= $min && $basicPay <= $max;
                        });

                        return (float) ($match->config['employee_share'] ?? 0);
                    };

                    $sssDeduction = $resolve('sss');
                    $philhealthDeduction = $resolve('philhealth');
                    $pagibigDeduction = $resolve('pagibig');
                    $withholdingTax = $resolve('withholding_tax');
                }

                $governmentDeductionTotal = $sssDeduction + $philhealthDeduction + $pagibigDeduction + $withholdingTax;
                $totalDeductions = $lateDeduction + $undertimeDeduction + $absenceDeduction + $leaveWithoutPay + $loanDeductions + $governmentDeductionTotal;
                $netPay = max($grossPay - $totalDeductions, 0);

                $item = PayrollRunItem::query()->create([
                    'payroll_run_id' => $payrollRun->id,
                    'employee_id' => $employee->id,
                    'gross_pay' => $grossPay,
                    'taxable_income' => $taxableIncome,
                    'total_deductions' => $totalDeductions,
                    'net_pay' => $netPay,
                    'snapshot' => [
                        'basic_pay' => $basicPay,
                        'overtime_pay' => $overtimePay,
                        'allowances' => $allowances,
                        'holiday_pay' => $holidayPay,
                        'late_minutes' => $lateMinutes,
                        'late_deduction' => $lateDeduction,
                        'undertime_minutes' => $undertimeMinutes,
                        'undertime_deduction' => $undertimeDeduction,
                        'absent_days' => $absentDays,
                        'absence_deduction' => $absenceDeduction,
                        'leave_without_pay' => $leaveWithoutPay,
                        'loan_deductions' => $loanDeductions,
                        'sss_deduction' => $sssDeduction,
                        'philhealth_deduction' => $philhealthDeduction,
                        'pagibig_deduction' => $pagibigDeduction,
                        'withholding_tax' => $withholdingTax,
                        'government_deduction_total' => $governmentDeductionTotal,
                        'is_second_cutoff' => $isSecondCutoff,
                    ],
                ]);

                foreach ([['earning', 'basic_pay', $basicPay], ['earning', 'overtime_pay', $overtimePay], ['earning', 'allowances', $allowances], ['earning', 'holiday_pay', $holidayPay], ['deduction', 'late_deduction', $lateDeduction], ['deduction', 'undertime_deduction', $undertimeDeduction], ['deduction', 'absence_deduction', $absenceDeduction], ['deduction', 'leave_without_pay', $leaveWithoutPay], ['deduction', 'loan', $loanDeductions], ['deduction', 'sss', $sssDeduction], ['deduction', 'philhealth', $philhealthDeduction], ['deduction', 'pagibig', $pagibigDeduction], ['deduction', 'withholding_tax', $withholdingTax]] as [$category, $code, $amount]) {
                    PayrollItemBreakdown::query()->create(['payroll_run_item_id' => $item->id, 'category' => $category, 'code' => $code, 'amount' => $amount]);
                }
            }

            return $payrollRun;
        });
    }
}
