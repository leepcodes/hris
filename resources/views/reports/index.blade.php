<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Reports</h2></x-slot>
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-4">
        <form method="GET" class="bg-white border rounded p-4 flex gap-2">
            <select name="payroll_run_id" class="border rounded p-2"><option value="">All Runs</option>@foreach($runs as $run)<option value="{{ $run->id }}" @selected(request('payroll_run_id')==$run->id)>Run #{{ $run->id }}</option>@endforeach</select>
            <button class="px-3 py-2 bg-slate-900 text-white rounded">Filter</button>
        </form>
        @if($selectedRunId)
            <div class="flex gap-4">
                <a href="{{ route('reports.print.payroll-register',['payroll_run_id'=>$selectedRunId]) }}" target="_blank" class="text-blue-700">Print Payroll Register</a>
                <a href="{{ route('reports.export.payroll-register',['payroll_run_id'=>$selectedRunId]) }}" class="text-blue-700">Export Payroll Register CSV</a>
            </div>
        @endif
        <div class="bg-white border rounded overflow-x-auto"><table class="min-w-full text-sm"><thead><tr class="border-b"><th class="p-2">Run</th><th>Employee</th><th>Gross</th><th>Deductions</th><th>Net</th></tr></thead><tbody>@foreach($items as $item)<tr class="border-b"><td class="p-2">{{ $item->payroll_run_id }}</td><td>{{ $item->employee?->last_name }}, {{ $item->employee?->first_name }}</td><td>{{ $item->gross_pay }}</td><td>{{ $item->total_deductions }}</td><td>{{ $item->net_pay }}</td></tr>@endforeach</tbody></table></div>{{ $items->links() }}
    </div>
</x-app-layout>
