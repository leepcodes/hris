<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLoan;
use App\Models\LoanType;
use Illuminate\Http\Request;

class LoanManagementController extends Controller
{
    public function index()
    {
        return view('loans.index', [
            'loans' => EmployeeLoan::query()->latest()->paginate(15),
            'employees' => Employee::query()->orderBy('last_name')->get(),
            'loanTypes' => LoanType::query()->where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'loan_type_id' => ['required', 'exists:loan_types,id'],
            'principal_amount' => ['required', 'numeric', 'min:1'],
            'amortization_amount' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        EmployeeLoan::query()->create($validated + ['balance_amount' => $validated['principal_amount'], 'status' => 'active']);

        return back()->with('status', 'Loan created.');
    }

    public function update(Request $request, EmployeeLoan $employeeLoan)
    {
        $validated = $request->validate([
            'principal_amount' => ['required', 'numeric', 'min:1'],
            'amortization_amount' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $employeeLoan->update($validated);

        return back()->with('status', 'Loan updated.');
    }

    public function destroy(EmployeeLoan $employeeLoan)
    {
        $employeeLoan->delete();

        return back()->with('status', 'Loan deleted.');
    }

    public function updateStatus(EmployeeLoan $employeeLoan, Request $request)
    {
        $validated = $request->validate(['status' => ['required', 'in:active,paused,closed']]);

        $employeeLoan->update(['status' => $validated['status']]);

        return back()->with('status', 'Loan status updated.');
    }
}
