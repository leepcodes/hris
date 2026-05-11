<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveCredit;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Services\AuditTrailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveManagementController extends Controller
{
    public function __construct(private AuditTrailService $auditTrailService)
    {
    }

    public function index()
    {
        return view('leave.index', [
            'leaveRequests' => LeaveRequest::query()->latest()->paginate(15),
            'employees' => Employee::query()->orderBy('last_name')->get(),
            'leaveTypes' => LeaveType::query()->where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'leave_type_id' => ['required', 'exists:leave_types,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'day_part' => ['required', 'string'],
            'days' => ['required', 'numeric', 'min:0.5'],
            'reason' => ['nullable', 'string'],
        ]);

        $leaveRequest = LeaveRequest::query()->create($validated + ['status' => 'pending']);
        $this->auditTrailService->log((int) auth()->id(), 'create', 'leave', LeaveRequest::class, $leaveRequest->id, null, $leaveRequest->toArray(), request()->ip(), request()->userAgent());

        return back()->with('status', 'Leave request filed.');
    }

    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'day_part' => ['required', 'string'],
            'days' => ['required', 'numeric', 'min:0.5'],
            'reason' => ['nullable', 'string'],
        ]);

        $leaveRequest->update($validated);

        return back()->with('status', 'Leave request updated.');
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();

        return back()->with('status', 'Leave request deleted.');
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        DB::transaction(function () use ($leaveRequest): void {
            $leaveRequest->update(['status' => 'approved', 'approved_by' => auth()->id(), 'approved_at' => now()]);

            $credit = LeaveCredit::query()->firstOrCreate(
                ['employee_id' => $leaveRequest->employee_id, 'leave_type_id' => $leaveRequest->leave_type_id],
                ['balance' => 0, 'used' => 0]
            );

            $credit->balance = max((float) $credit->balance - (float) $leaveRequest->days, 0);
            $credit->used = (float) $credit->used + (float) $leaveRequest->days;
            $credit->save();
        });

        return back()->with('status', 'Leave approved.');
    }

    public function reject(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update(['status' => 'rejected', 'approved_by' => auth()->id(), 'approved_at' => now()]);

        return back()->with('status', 'Leave rejected.');
    }
}
