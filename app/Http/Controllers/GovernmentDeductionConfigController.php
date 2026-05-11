<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGovernmentDeductionConfigRequest;
use App\Http\Requests\UpdateGovernmentDeductionConfigRequest;
use App\Models\GovernmentDeductionConfig;

class GovernmentDeductionConfigController extends Controller
{
    public function index()
    {
        return view('gov-deductions.index', ['configs' => GovernmentDeductionConfig::query()->latest()->paginate(15)]);
    }

    public function create()
    {
        return view('gov-deductions.form');
    }

    public function store(StoreGovernmentDeductionConfigRequest $request)
    {
        GovernmentDeductionConfig::query()->create($request->validated() + ['effective_date' => now()->toDateString()]);

        return redirect()->route('gov-deductions.index')->with('status', 'Deduction bracket created.');
    }

    public function edit(GovernmentDeductionConfig $governmentDeductionConfig)
    {
        return view('gov-deductions.form', ['config' => $governmentDeductionConfig]);
    }

    public function update(UpdateGovernmentDeductionConfigRequest $request, GovernmentDeductionConfig $governmentDeductionConfig)
    {
        $governmentDeductionConfig->update($request->validated());

        return redirect()->route('gov-deductions.index')->with('status', 'Deduction bracket updated.');
    }

    public function destroy(GovernmentDeductionConfig $governmentDeductionConfig)
    {
        $governmentDeductionConfig->delete();

        return back()->with('status', 'Deduction bracket deleted.');
    }
}
