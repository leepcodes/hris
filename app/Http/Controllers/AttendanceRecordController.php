<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRecordRequest;
use App\Http\Requests\UpdateAttendanceRecordRequest;
use App\Models\AttendanceImportBatch;
use App\Models\AttendanceRecord;
use App\Models\Employee;

class AttendanceRecordController extends Controller
{
    public function index()
    {
        abort_unless(request()->user()->hasPermission('attendance.view'), 403);

        return view('attendance-imports.records', [
            'records' => AttendanceRecord::query()->with('employee')->latest('attendance_date')->paginate(30),
            'employees' => Employee::query()->orderBy('last_name')->get(),
        ]);
    }

    public function store(StoreAttendanceRecordRequest $request)
    {
        $batch = AttendanceImportBatch::query()->create([
            'filename' => 'manual-entry',
            'uploaded_by' => auth()->id(),
            'status' => 'manual',
            'total_rows' => 1,
            'valid_rows' => 1,
            'invalid_rows' => 0,
            'row_errors' => [],
            'imported_at' => now(),
        ]);

        AttendanceRecord::query()->create($request->validated() + [
            'attendance_import_batch_id' => $batch->id,
            'time_in' => $request->filled('time_in') ? $request->input('time_in').':00' : null,
            'time_out' => $request->filled('time_out') ? $request->input('time_out').':00' : null,
            'is_absent' => (bool) $request->boolean('is_absent'),
        ]);

        return back()->with('status', 'Manual attendance saved.');
    }

    public function edit(AttendanceRecord $attendanceRecord)
    {
        abort_unless(request()->user()->hasPermission('attendance.upload'), 403);

        return view('attendance-imports.edit-record', compact('attendanceRecord'));
    }

    public function update(UpdateAttendanceRecordRequest $request, AttendanceRecord $attendanceRecord)
    {
        $data = $request->validated();
        $attendanceRecord->update([
            ...$data,
            'time_in' => array_key_exists('time_in', $data) && filled($data['time_in']) ? $data['time_in'].':00' : null,
            'time_out' => array_key_exists('time_out', $data) && filled($data['time_out']) ? $data['time_out'].':00' : null,
            'is_absent' => (bool) ($data['is_absent'] ?? false),
        ]);

        return redirect()->route('attendance-records.index')->with('status', 'Attendance record updated.');
    }

    public function destroy(AttendanceRecord $attendanceRecord)
    {
        abort_unless(request()->user()->hasPermission('attendance.upload'), 403);

        $attendanceRecord->delete();

        return back()->with('status', 'Attendance record deleted.');
    }
}
