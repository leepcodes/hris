<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadAttendanceCsvRequest;
use App\Models\AttendanceImportBatch;
use App\Services\AttendanceCsvImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AttendanceImportController extends Controller
{
    public function __construct(private AttendanceCsvImportService $attendanceCsvImportService) {}

    public function index(): View
    {
        abort_unless(request()->user()->hasPermission('attendance.view'), 403);

        $batches = AttendanceImportBatch::query()->with('uploader')->latest()->paginate(15);

        return view('attendance-imports.index', compact('batches'));
    }

    public function preview(UploadAttendanceCsvRequest $request): View
    {
        $result = $this->attendanceCsvImportService->preview($request->file('attendance_csv'));

        $token = (string) Str::uuid();

        $request->session()->put('attendance_preview.'.$token, [
            'filename' => $request->file('attendance_csv')->getClientOriginalName(),
            'valid_rows' => $result['valid_rows'],
            'errors' => $result['errors'],
            'total_rows' => $result['total_rows'],
        ]);

        return view('attendance-imports.preview', [
            'token' => $token,
            'filename' => $request->file('attendance_csv')->getClientOriginalName(),
            'validRows' => $result['valid_rows'],
            'errors' => $result['errors'],
            'totalRows' => $result['total_rows'],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->hasPermission('attendance.upload'), 403);

        $validated = $request->validate([
            'preview_token' => ['required', 'string'],
        ]);

        $preview = $request->session()->get('attendance_preview.'.$validated['preview_token']);

        if (! $preview) {
            return redirect()->route('attendance-imports.index')->with('status', 'Preview expired. Please upload again.');
        }

        $batch = $this->attendanceCsvImportService->import(
            $preview['filename'],
            (int) $request->user()->id,
            $preview['valid_rows'],
            $preview['errors']
        );

        $request->session()->forget('attendance_preview.'.$validated['preview_token']);

        return redirect()->route('attendance-imports.index')->with('status', 'Attendance imported. Batch #'.$batch->id);
    }
}
