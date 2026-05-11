<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">HRIS Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-lg border border-slate-200 p-4"><p class="text-sm text-slate-500">Employees</p><p class="text-2xl font-bold">{{ $employeeCount }}</p></div>
            <div class="bg-white rounded-lg border border-slate-200 p-4"><p class="text-sm text-slate-500">Active Employees</p><p class="text-2xl font-bold">{{ $activeEmployeeCount }}</p></div>
            <div class="bg-white rounded-lg border border-slate-200 p-4"><p class="text-sm text-slate-500">Pending Leaves</p><p class="text-2xl font-bold">{{ $pendingLeaveCount }}</p></div>
            <div class="bg-white rounded-lg border border-slate-200 p-4"><p class="text-sm text-slate-500">Open Payroll</p><p class="text-2xl font-bold">{{ $openPayrollCount }}</p></div>
            <div class="bg-white rounded-lg border border-slate-200 p-4"><p class="text-sm text-slate-500">System Settings</p><p class="text-2xl font-bold">{{ $systemSettingCount }}</p></div>
        </div>
    </div>
</x-app-layout>
