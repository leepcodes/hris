<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JobPosition;

class EmployeeController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Employee::class);

        $employees = Employee::query()
            ->with(['department', 'jobPosition'])
            ->latest()
            ->paginate(12);

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

        Employee::query()->create($data);

        return redirect()->route('employees.index')->with('status', 'Employee created.');
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

        return redirect()->route('employees.index')->with('status', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $employee->delete();

        return redirect()->route('employees.index')->with('status', 'Employee archived.');
    }
}
