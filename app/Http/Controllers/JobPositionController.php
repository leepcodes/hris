<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobPositionRequest;
use App\Http\Requests\UpdateJobPositionRequest;
use App\Models\Department;
use App\Models\JobPosition;

class JobPositionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', JobPosition::class);

        $jobPositions = JobPosition::query()->with('department')->latest()->paginate(12);

        return view('job-positions.index', compact('jobPositions'));
    }

    public function create()
    {
        $this->authorize('create', JobPosition::class);

        $departments = Department::query()->where('is_active', true)->orderBy('name')->get();

        return view('job-positions.create', compact('departments'));
    }

    public function store(StoreJobPositionRequest $request)
    {
        JobPosition::query()->create($request->validated());

        return redirect()->route('job-positions.index')->with('status', 'Job position created.');
    }

    public function edit(JobPosition $jobPosition)
    {
        $this->authorize('update', $jobPosition);

        $departments = Department::query()->orderBy('name')->get();

        return view('job-positions.edit', compact('jobPosition', 'departments'));
    }

    public function update(UpdateJobPositionRequest $request, JobPosition $jobPosition)
    {
        $jobPosition->update($request->validated());

        return redirect()->route('job-positions.index')->with('status', 'Job position updated.');
    }

    public function destroy(JobPosition $jobPosition)
    {
        $this->authorize('delete', $jobPosition);

        $jobPosition->delete();

        return redirect()->route('job-positions.index')->with('status', 'Job position deleted.');
    }
}
