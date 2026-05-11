<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Deduction Bracket Form</h2></x-slot>
    <div class="max-w-2xl mx-auto px-4 py-6">
        @php $isEditing = isset($config) && $config->exists; @endphp
        <form method="POST" action="{{ $isEditing ? route('gov-deductions.update', ['gov_deduction' => $config->id]) : route('gov-deductions.store') }}" class="bg-white border rounded p-4 space-y-3">
            @csrf @if($isEditing) @method('PUT') @endif
            <label class="block text-sm font-medium">Deduction Type</label>
            <select name="deduction_type" class="w-full border rounded p-2">@foreach(['sss','philhealth','pagibig','withholding_tax'] as $type)<option value="{{ $type }}" @selected(old('deduction_type',$config->deduction_type ?? '')===$type)>{{ strtoupper($type) }}</option>@endforeach</select>
            <label class="block text-sm font-medium">Bracket Name</label>
            <input name="name" class="w-full border rounded p-2" value="{{ old('name',$config->name ?? '') }}">
            <label class="block text-sm font-medium">Salary Min</label>
            <input name="config[salary_min]" type="number" step="0.01" class="w-full border rounded p-2" value="{{ old('config.salary_min',$config->config['salary_min'] ?? '') }}">
            <label class="block text-sm font-medium">Salary Max</label>
            <input name="config[salary_max]" type="number" step="0.01" class="w-full border rounded p-2" value="{{ old('config.salary_max',$config->config['salary_max'] ?? '') }}">
            <label class="block text-sm font-medium">Employee Share Amount</label>
            <input name="config[employee_share]" type="number" step="0.01" class="w-full border rounded p-2" value="{{ old('config.employee_share',$config->config['employee_share'] ?? '') }}">
            <label class="flex gap-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$config->is_active ?? true))>Active</label>
            <button class="px-3 py-2 bg-slate-900 text-white rounded">Save</button>
        </form>
    </div>
</x-app-layout>
