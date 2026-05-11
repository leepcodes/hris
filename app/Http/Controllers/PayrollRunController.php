<?php

namespace App\Http\Controllers;

use App\Models\PayrollPeriod;
use App\Models\PayrollRun;
use App\Models\PayrollRunItem;
use App\Models\Payslip;
use App\Services\PayrollService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollRunController extends Controller
{
    public function __construct(private PayrollService $payrollService)
    {
    }

    public function index()
    {
        return view('payroll.runs', [
            'periods' => PayrollPeriod::query()->orderByDesc('start_date')->get(),
            'runs' => PayrollRun::query()->with('payrollPeriod')->latest()->paginate(15),
        ]);
    }

    public function generate(Request $request)
    {
        $validated = $request->validate(['payroll_period_id' => ['required', 'exists:payroll_periods,id']]);
        $period = PayrollPeriod::query()->findOrFail($validated['payroll_period_id']);
        $this->payrollService->generateDraft($period, (int) auth()->id());

        return back()->with('status', 'Payroll draft generated.');
    }

    public function transition(PayrollRun $payrollRun, Request $request)
    {
        $validated = $request->validate(['status' => ['required', 'in:reviewed,approved,released,cancelled']]);
        $status = $validated['status'];

        DB::transaction(function () use ($payrollRun, $status): void {
            $payrollRun->status = $status;
            if ($status === 'reviewed') { $payrollRun->reviewed_by = auth()->id(); $payrollRun->reviewed_at = now(); }
            if ($status === 'approved') { $payrollRun->approved_by = auth()->id(); $payrollRun->approved_at = now(); }
            if ($status === 'released') { $payrollRun->released_at = now(); }
            $payrollRun->save();

            if (in_array($status, ['approved', 'released'], true)) {
                $items = PayrollRunItem::query()->where('payroll_run_id', $payrollRun->id)->get();
                foreach ($items as $item) {
                    Payslip::query()->firstOrCreate(['payroll_run_item_id' => $item->id], [
                        'employee_id' => $item->employee_id,
                        'reference_no' => 'PS-'.now()->format('Ymd').'-'.$payrollRun->id.'-'.$item->employee_id,
                        'released_at' => $status === 'released' ? now() : null,
                    ]);
                }
            }
        });

        return back()->with('status', 'Payroll status updated.');
    }
}
