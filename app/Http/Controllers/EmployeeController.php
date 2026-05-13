<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDependent;
use App\Models\EmployeeDocument;
use App\Models\EmployeeEducation;
use App\Models\EmployeeWorkHistory;
use App\Models\JobPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Employee::class);

        $employees = Employee::query()->with(['department', 'jobPosition'])->latest()->paginate(12);

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $this->authorize('create', Employee::class);

        return view('employees.create', [
            'departments' => Department::query()->orderBy('name')->get(),
            'jobPositions' => JobPosition::query()->orderBy('title')->get(),
        ]);
    }

    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        if (blank($data['employee_code'] ?? null)) {
            $data['employee_code'] = 'EMP-'.str_pad((string) (Employee::query()->max('id') + 1), 6, '0', STR_PAD_LEFT);
        }

        $employee = Employee::query()->create($data);

        return redirect()->route('employees.show', $employee)->with('status', 'Employee created.');
    }

    public function show(Employee $employee)
    {
        $this->authorize('view', $employee);

        $employee->load(['department', 'jobPosition', 'dependents', 'educations', 'workHistories', 'documents']);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $this->authorize('update', $employee);

        return view('employees.edit', [
            'employee' => $employee,
            'departments' => Department::query()->orderBy('name')->get(),
            'jobPositions' => JobPosition::query()->orderBy('title')->get(),
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        return redirect()->route('employees.show', $employee)->with('status', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);
        $employee->delete();

        return redirect()->route('employees.index')->with('status', 'Employee archived.');
    }

    public function addDependent(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'relationship' => ['required', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
        ]);

        $employee->dependents()->create($validated);

        return back()->with('status', 'Dependent added.');
    }

    public function deleteDependent(Employee $employee, EmployeeDependent $dependent)
    {
        $this->authorize('update', $employee);
        abort_unless($dependent->employee_id === $employee->id, 404);

        $dependent->delete();

        return back()->with('status', 'Dependent removed.');
    }

    public function addEducation(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $validated = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'degree' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:100'],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date'],
        ]);

        $employee->educations()->create($validated);

        return back()->with('status', 'Education record added.');
    }

    public function deleteEducation(Employee $employee, EmployeeEducation $education)
    {
        $this->authorize('update', $employee);
        abort_unless($education->employee_id === $employee->id, 404);

        $education->delete();

        return back()->with('status', 'Education record removed.');
    }

    public function addWorkHistory(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'position_title' => ['nullable', 'string', 'max:255'],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date'],
            'last_salary' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $employee->workHistories()->create($validated);

        return back()->with('status', 'Work history added.');
    }

    public function deleteWorkHistory(Employee $employee, EmployeeWorkHistory $workHistory)
    {
        $this->authorize('update', $employee);
        abort_unless($workHistory->employee_id === $employee->id, 404);

        $workHistory->delete();

        return back()->with('status', 'Work history removed.');
    }

    public function uploadDocument(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $validated = $request->validate([
            'document_type' => ['required', 'string', 'max:100'],
            'document_file' => ['required', 'file', 'max:10240'],
        ]);

        $path = $request->file('document_file')->store('employee-documents');

        $employee->documents()->create([
            'document_type' => $validated['document_type'],
            'file_path' => $path,
            'original_name' => $request->file('document_file')->getClientOriginalName(),
        ]);

        return back()->with('status', 'Document uploaded.');
    }

    public function deleteDocument(Employee $employee, EmployeeDocument $document)
    {
        $this->authorize('update', $employee);
        abort_unless($document->employee_id === $employee->id, 404);

        Storage::delete($document->file_path);
        $document->delete();

        return back()->with('status', 'Document deleted.');
    }
}
