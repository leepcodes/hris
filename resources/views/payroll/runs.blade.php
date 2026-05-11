<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Payroll Runs</h2></x-slot>
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-4">
        <form method="POST" action="{{ route('payroll-runs.generate') }}" class="bg-white border rounded p-4 flex gap-3 items-end">@csrf
            <div>
                <label class="block text-sm font-medium">Payroll Period</label>
                <select name="payroll_period_id" class="border rounded p-2">@foreach($periods as $period)<option value="{{ $period->id }}">{{ $period->name }} ({{ $period->start_date }} - {{ $period->end_date }})</option>@endforeach</select>
            </div>
            <button class="px-3 py-2 bg-slate-900 text-white rounded">Generate Draft</button>
        </form>
        <a href="{{ route('payslips.index') }}" class="text-blue-700">View Payslips</a>
        <div class="bg-white border rounded overflow-x-auto"><table class="min-w-full text-sm"><thead><tr class="border-b"><th class="p-2">Run #</th><th>Period</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Actions</th></tr></thead><tbody>@foreach($runs as $run)<tr class="border-b"><td class="p-2">{{ $run->id }}</td><td>{{ $run->payrollPeriod?->name }}</td><td>{{ $run->payrollPeriod?->start_date }}</td><td>{{ $run->payrollPeriod?->end_date }}</td><td>{{ $run->status }}</td><td><form method="POST" action="{{ route('payroll-runs.transition',$run) }}" class="flex gap-2">@csrf @method('PATCH')<select name="status" class="border rounded p-1"><option>reviewed</option><option>approved</option><option>released</option><option>cancelled</option></select><button class="text-blue-700">Apply</button></form></td></tr>@endforeach</tbody></table></div>
        {{ $runs->links() }}
    </div>
</x-app-layout>
