<?php

namespace App\Http\Controllers;

use App\Models\PayrollRun;
use App\Models\PayrollRunItem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $payrollRunId = $request->integer('payroll_run_id');
        $items = PayrollRunItem::query()->with('employee')->when($payrollRunId, fn ($q) => $q->where('payroll_run_id', $payrollRunId))->paginate(20);

        return view('reports.index', [
            'items' => $items,
            'runs' => PayrollRun::query()->latest()->get(),
            'selectedRunId' => $payrollRunId,
        ]);
    }

    public function printPayrollRegister(Request $request)
    {
        $runId = $request->integer('payroll_run_id');
        $items = PayrollRunItem::query()->with('employee')->where('payroll_run_id', $runId)->get();

        return view('reports.payroll-register-print', ['items' => $items, 'runId' => $runId]);
    }

    public function exportPayrollRegister(Request $request): StreamedResponse
    {
        $runId = $request->integer('payroll_run_id');
        $items = PayrollRunItem::query()->where('payroll_run_id', $runId)->get();

        return response()->streamDownload(function () use ($items): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Employee ID', 'Gross Pay', 'Total Deductions', 'Net Pay']);
            foreach ($items as $item) {
                fputcsv($handle, [$item->employee_id, $item->gross_pay, $item->total_deductions, $item->net_pay]);
            }
            fclose($handle);
        }, 'payroll-register.csv');
    }
}
