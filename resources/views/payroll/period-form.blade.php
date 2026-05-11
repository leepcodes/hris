<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Payroll Period Form</h2></x-slot>
    <div class="max-w-2xl mx-auto px-4 py-6">
        <form method="POST" action="{{ isset($payrollPeriod)?route('payroll-periods.update',$payrollPeriod):route('payroll-periods.store') }}" class="bg-white border rounded p-4 space-y-3">
            @csrf
            @isset($payrollPeriod) @method('PUT') @endisset
            <input name="name" class="w-full border rounded p-2" value="{{ old('name',$payrollPeriod->name ?? '') }}">
            <input type="hidden" name="frequency" value="semi-monthly">
            <div class="text-sm text-slate-600">Frequency: Semi-monthly (fixed)</div>
            <input name="start_date" type="date" class="w-full border rounded p-2" value="{{ old('start_date',isset($payrollPeriod)?$payrollPeriod->start_date?->format('Y-m-d'):'') }}">
            <input name="end_date" type="date" class="w-full border rounded p-2" value="{{ old('end_date',isset($payrollPeriod)?$payrollPeriod->end_date?->format('Y-m-d'):'') }}">
            <select name="status" class="w-full border rounded p-2">@foreach(['open','locked','closed'] as $s)<option value="{{ $s }}" @selected(old('status',$payrollPeriod->status ?? 'open')===$s)>{{ $s }}</option>@endforeach</select>
            <button class="px-3 py-2 bg-slate-900 text-white rounded">Save</button>
        </form>
    </div>
</x-app-layout>
