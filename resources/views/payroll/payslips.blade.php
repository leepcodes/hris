<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Payslips</h2></x-slot>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="bg-white border rounded overflow-x-auto">
            <table class="min-w-full text-sm"><thead><tr class="border-b"><th class="p-2">Ref No</th><th>Employee</th><th>Run Item</th><th>Released</th><th></th></tr></thead><tbody>
                @foreach($payslips as $payslip)
                    <tr class="border-b"><td class="p-2">{{ $payslip->reference_no }}</td><td>{{ $payslip->employee?->last_name }}, {{ $payslip->employee?->first_name }}</td><td>{{ $payslip->payroll_run_item_id }}</td><td>{{ optional($payslip->released_at)->format('Y-m-d H:i') }}</td><td><a class="text-blue-700" target="_blank" href="{{ route('payslips.show',$payslip) }}">Print</a></td></tr>
                @endforeach
            </tbody></table>
        </div>
        {{ $payslips->links() }}
    </div>
</x-app-layout>
