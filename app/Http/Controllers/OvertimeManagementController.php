<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OvertimeRequest;
use Illuminate\Http\Request;

class OvertimeManagementController extends Controller
{
    public function index()
    {
        return view('overtime.index', [
            'overtimeRequests' => OvertimeRequest::query()->latest()->paginate(15),
            'employees' => Employee::query()->orderBy('last_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'ot_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'reason' => ['nullable', 'string'],
        ]);

        $hours = max((strtotime($validated['ot_date'].' '.$validated['end_time']) - strtotime($validated['ot_date'].' '.$validated['start_time'])) / 3600, 0);
        OvertimeRequest::query()->create($validated + ['hours' => $hours, 'status' => 'pending']);

        return back()->with('status', 'Overtime request filed.');
    }

    public function update(Request $request, OvertimeRequest $overtimeRequest)
    {
        $validated = $request->validate([
            'ot_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'reason' => ['nullable', 'string'],
        ]);

        $hours = max((strtotime($validated['ot_date'].' '.$validated['end_time']) - strtotime($validated['ot_date'].' '.$validated['start_time'])) / 3600, 0);
        $overtimeRequest->update($validated + ['hours' => $hours]);

        return back()->with('status', 'Overtime request updated.');
    }

    public function destroy(OvertimeRequest $overtimeRequest)
    {
        $overtimeRequest->delete();

        return back()->with('status', 'Overtime request deleted.');
    }

    public function approve(OvertimeRequest $overtimeRequest)
    {
        $overtimeRequest->update(['status' => 'approved', 'approved_by' => auth()->id(), 'approved_at' => now()]);

        return back()->with('status', 'Overtime approved.');
    }

    public function reject(OvertimeRequest $overtimeRequest)
    {
        $overtimeRequest->update(['status' => 'rejected', 'approved_by' => auth()->id(), 'approved_at' => now()]);

        return back()->with('status', 'Overtime rejected.');
    }
}
