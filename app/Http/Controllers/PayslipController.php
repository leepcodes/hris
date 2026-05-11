<?php

namespace App\Http\Controllers;

use App\Models\Payslip;

class PayslipController extends Controller
{
    public function index()
    {
        $payslips = Payslip::query()->with(['employee', 'payrollRunItem'])->latest()->paginate(20);

        return view('payroll.payslips', compact('payslips'));
    }

    public function show(Payslip $payslip)
    {
        $payslip->load(['employee', 'payrollRunItem']);

        return view('payroll.payslip-print', compact('payslip'));
    }
}
