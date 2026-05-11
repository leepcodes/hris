<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Government Deduction Brackets (PH)</h2></x-slot>
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-4">
        <a href="{{ route('gov-deductions.create') }}" class="px-3 py-2 bg-slate-900 text-white rounded">New Bracket</a>
        <div class="bg-white border rounded overflow-x-auto">
            <table class="min-w-full text-sm"><thead><tr class="border-b"><th class="p-2">Type</th><th>Name</th><th>Salary Min</th><th>Salary Max</th><th>Employee Share</th><th>Status</th><th></th></tr></thead><tbody>
                @foreach($configs as $c)
                    <tr class="border-b"><td class="p-2">{{ strtoupper($c->deduction_type) }}</td><td>{{ $c->name }}</td><td>{{ number_format((float)($c->config['salary_min'] ?? 0),2) }}</td><td>{{ number_format((float)($c->config['salary_max'] ?? 0),2) }}</td><td>{{ number_format((float)($c->config['employee_share'] ?? 0),2) }}</td><td>{{ $c->is_active ? 'Active' : 'Inactive' }}</td><td class="flex gap-2"><a class="text-blue-700" href="{{ route('gov-deductions.edit',$c) }}">Edit</a><form method="POST" action="{{ route('gov-deductions.destroy',$c) }}">@csrf @method('DELETE')<button class="text-red-700">Delete</button></form></td></tr>
                @endforeach
            </tbody></table>
        </div>
        {{ $configs->links() }}
    </div>
</x-app-layout>
