<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayrollPeriodRequest;
use App\Http\Requests\UpdatePayrollPeriodRequest;
use App\Models\PayrollPeriod;

class PayrollPeriodController extends Controller
{
    public function index()
    {
        return view('payroll.periods', ['periods' => PayrollPeriod::query()->latest('start_date')->paginate(15)]);
    }

    public function create()
    {
        return view('payroll.period-form');
    }

    public function store(StorePayrollPeriodRequest $request)
    {
        PayrollPeriod::query()->create($request->validated());

        return redirect()->route('payroll-periods.index')->with('status', 'Payroll period created.');
    }

    public function edit(PayrollPeriod $payrollPeriod)
    {
        return view('payroll.period-form', compact('payrollPeriod'));
    }

    public function update(UpdatePayrollPeriodRequest $request, PayrollPeriod $payrollPeriod)
    {
        $payrollPeriod->update($request->validated());

        return redirect()->route('payroll-periods.index')->with('status', 'Payroll period updated.');
    }

    public function destroy(PayrollPeriod $payrollPeriod)
    {
        $payrollPeriod->delete();

        return back()->with('status', 'Payroll period deleted.');
    }
}
