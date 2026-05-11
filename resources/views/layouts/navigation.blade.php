<nav x-data="{ open: false }" class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-4 text-sm flex-wrap">
                <a href="{{ route('dashboard') }}" class="font-semibold text-slate-800 mr-2">HRIS Payroll</a>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                @if(auth()->user()->hasPermission('users.view'))<x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">Users</x-nav-link>@endif
                @if(auth()->user()->hasPermission('employees.view'))<x-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.*')">Employees</x-nav-link>@endif
                @if(auth()->user()->hasPermission('attendance.view'))<x-nav-link :href="route('attendance-imports.index')" :active="request()->routeIs('attendance-imports.*')">Attendance</x-nav-link>@endif
                @if(auth()->user()->hasPermission('leave.view'))<x-nav-link :href="route('leave.index')" :active="request()->routeIs('leave.*')">Leave</x-nav-link>@endif
                @if(auth()->user()->hasPermission('overtime.view'))<x-nav-link :href="route('overtime.index')" :active="request()->routeIs('overtime.*')">Overtime</x-nav-link>@endif
                @if(auth()->user()->hasPermission('loans.view'))<x-nav-link :href="route('loans.index')" :active="request()->routeIs('loans.*')">Loans</x-nav-link>@endif
                @if(auth()->user()->hasPermission('deductions.view'))<x-nav-link :href="route('gov-deductions.index')" :active="request()->routeIs('gov-deductions.*')">Deductions</x-nav-link>@endif
                @if(auth()->user()->hasPermission('payroll.view'))<x-nav-link :href="route('payroll-periods.index')" :active="request()->routeIs('payroll-periods.*')">Payroll Periods</x-nav-link>@endif
                @if(auth()->user()->hasPermission('payroll.view'))<x-nav-link :href="route('payroll-runs.index')" :active="request()->routeIs('payroll-runs.*')">Payroll Runs</x-nav-link>@endif
                @if(auth()->user()->hasPermission('payroll.view'))<x-nav-link :href="route('payslips.index')" :active="request()->routeIs('payslips.*')">Payslips</x-nav-link>@endif
                @if(auth()->user()->hasPermission('reports.view'))<x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">Reports</x-nav-link>@endif
                @if(auth()->user()->hasPermission('audit.view'))<x-nav-link :href="route('audit.index')" :active="request()->routeIs('audit.*')">Audit</x-nav-link>@endif
                @if(auth()->user()->hasPermission('ess.view'))<x-nav-link :href="route('ess.index')" :active="request()->routeIs('ess.*')">ESS</x-nav-link>@endif
                @if(auth()->user()->hasPermission('settings.view'))<x-nav-link :href="route('system-config.index')" :active="request()->routeIs('system-config.*')">Config</x-nav-link>@endif
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger"><button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-slate-600 bg-white hover:text-slate-800">{{ Auth::user()->name }}</button></x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">@csrf<x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link></form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
