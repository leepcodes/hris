<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip {{ $payslip->reference_no }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        .box { border: 1px solid #ddd; padding: 16px; margin-bottom: 12px; }
        .row { display: flex; justify-content: space-between; margin: 6px 0; }
        .section-title { font-weight: 700; margin-bottom: 8px; }
        @media print { .no-print { display:none; } }
    </style>
</head>
<body>
<button class="no-print" onclick="window.print()">Print Payslip</button>
<h2>Payslip</h2>

<div class="box">
    <div class="row"><strong>Reference</strong><span>{{ $payslip->reference_no }}</span></div>
    <div class="row"><strong>Employee</strong><span>{{ $payslip->employee?->last_name }}, {{ $payslip->employee?->first_name }}</span></div>
    <div class="row"><strong>Released At</strong><span>{{ optional($payslip->released_at)->format('Y-m-d H:i') }}</span></div>
</div>

@php
    $snapshot = $payslip->payrollRunItem?->snapshot ?? [];
@endphp

<div class="box">
    <div class="section-title">Gross Breakdown</div>
    <div class="row"><span>Basic Pay</span><span>{{ number_format((float)($snapshot['basic_pay'] ?? 0), 2) }}</span></div>
    <div class="row"><span>Overtime Pay</span><span>{{ number_format((float)($snapshot['overtime_pay'] ?? 0), 2) }}</span></div>
    <div class="row"><span>Allowances</span><span>{{ number_format((float)($snapshot['allowances'] ?? 0), 2) }}</span></div>
    <div class="row"><span>Holiday Pay</span><span>{{ number_format((float)($snapshot['holiday_pay'] ?? 0), 2) }}</span></div>
    <div class="row"><strong>Gross Pay</strong><strong>{{ number_format((float) $payslip->payrollRunItem?->gross_pay, 2) }}</strong></div>
</div>

<div class="box">
    <div class="section-title">Deduction Breakdown</div>
    <div class="row"><span>Late Deduction ({{ (int)($snapshot['late_minutes'] ?? 0) }} mins)</span><span>{{ number_format((float)($snapshot['late_deduction'] ?? 0), 2) }}</span></div>
    <div class="row"><span>Undertime Deduction ({{ (int)($snapshot['undertime_minutes'] ?? 0) }} mins)</span><span>{{ number_format((float)($snapshot['undertime_deduction'] ?? 0), 2) }}</span></div>
    <div class="row"><span>Absence Deduction ({{ (int)($snapshot['absent_days'] ?? 0) }} day/s)</span><span>{{ number_format((float)($snapshot['absence_deduction'] ?? 0), 2) }}</span></div>
    <div class="row"><span>Leave Without Pay</span><span>{{ number_format((float)($snapshot['leave_without_pay'] ?? 0), 2) }}</span></div>
    <div class="row"><span>Loan Deductions</span><span>{{ number_format((float)($snapshot['loan_deductions'] ?? 0), 2) }}</span></div>
    <div class="row"><span>SSS</span><span>{{ number_format((float)($snapshot['sss_deduction'] ?? 0), 2) }}</span></div>
    <div class="row"><span>PhilHealth</span><span>{{ number_format((float)($snapshot['philhealth_deduction'] ?? 0), 2) }}</span></div>
    <div class="row"><span>Pag-IBIG</span><span>{{ number_format((float)($snapshot['pagibig_deduction'] ?? 0), 2) }}</span></div>
    <div class="row"><span>Withholding Tax</span><span>{{ number_format((float)($snapshot['withholding_tax'] ?? 0), 2) }}</span></div>
    <div class="row"><strong>Total Deductions</strong><strong>{{ number_format((float) $payslip->payrollRunItem?->total_deductions, 2) }}</strong></div>
    <div class="row"><small>Cutoff Type</small><small>{{ (bool)($snapshot['is_second_cutoff'] ?? false) ? '2nd Cutoff (gov deductions applied)' : '1st Cutoff (no gov deductions)' }}</small></div>
</div>

<div class="box">
    <div class="row"><strong>Taxable Income</strong><strong>{{ number_format((float) $payslip->payrollRunItem?->taxable_income, 2) }}</strong></div>
    <div class="row"><strong>Net Pay</strong><strong>{{ number_format((float) $payslip->payrollRunItem?->net_pay, 2) }}</strong></div>
</div>
</body>
</html>
