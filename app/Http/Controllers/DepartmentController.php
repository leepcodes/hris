<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Department::class);

        $departments = Department::query()->latest()->paginate(12);

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $this->authorize('create', Department::class);

        return view('departments.create');
    }

    public function store(StoreDepartmentRequest $request)
    {
        Department::query()->create($request->validated());

        return redirect()->route('departments.index')->with('status', 'Department created.');
    }

    public function edit(Department $department)
    {
        $this->authorize('update', $department);

        return view('departments.edit', compact('department'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());

        return redirect()->route('departments.index')->with('status', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);

        $department->delete();

        return redirect()->route('departments.index')->with('status', 'Department deleted.');
    }
}
