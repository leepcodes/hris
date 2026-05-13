<nav x-data="{ open: false }" class="bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-2 text-sm flex-wrap">
                <a href="{{ route('dashboard') }}" class="font-semibold text-slate-800 mr-3">LOGO</a>


                <a href="{{ route('dashboard') }}" class=" text-slate-800 mr-3">Dashboard</a>



                @if(auth()->user()->hasPermission('employees.view'))

                    <a href="{{ route('employees.index') }}" class=" text-slate-700 mr-3">Employees</a>

                @endif

                @if(auth()->user()->hasPermission('attendance.view') || auth()->user()->hasPermission('leave.view') || auth()->user()->hasPermission('overtime.view'))
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 rounded-md text-slate-700 hover:bg-slate-100">Time & Attendance</button>
                        </x-slot>
                        <x-slot name="content">
                            @if(auth()->user()->hasPermission('attendance.view'))<x-dropdown-link :href="route('attendance-imports.index')">Attendance</x-dropdown-link>@endif
                            @if(auth()->user()->hasPermission('leave.view'))<x-dropdown-link :href="route('leave.index')">Leave</x-dropdown-link>@endif
                            @if(auth()->user()->hasPermission('overtime.view'))<x-dropdown-link :href="route('overtime.index')">Overtime</x-dropdown-link>@endif
                        </x-slot>
                    </x-dropdown>
                @endif

                @if(auth()->user()->hasPermission('payroll.view'))
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 rounded-md text-slate-700 hover:bg-slate-100">Compensation & Payroll</button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('payroll-periods.index')">Payroll Periods</x-dropdown-link>
                            <x-dropdown-link :href="route('payroll-runs.index')">Payroll Runs</x-dropdown-link>
                            <x-dropdown-link :href="route('payslips.index')">Payslips</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                @endif

                @if(auth()->user()->hasPermission('loans.view') || auth()->user()->hasPermission('deductions.view'))
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 rounded-md text-slate-700 hover:bg-slate-100">Employee Financials</button>
                        </x-slot>
                        <x-slot name="content">
                            @if(auth()->user()->hasPermission('loans.view'))<x-dropdown-link :href="route('loans.index')">Loans</x-dropdown-link>@endif
                            @if(auth()->user()->hasPermission('deductions.view'))<x-dropdown-link :href="route('gov-deductions.index')">Deductions</x-dropdown-link>@endif
                        </x-slot>
                    </x-dropdown>
                @endif

                @if(auth()->user()->hasPermission('reports.view') || auth()->user()->hasPermission('audit.view'))
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 rounded-md text-slate-700 hover:bg-slate-100">Reporting & Compliance</button>
                        </x-slot>
                        <x-slot name="content">
                            @if(auth()->user()->hasPermission('reports.view'))<x-dropdown-link :href="route('reports.index')">Reports</x-dropdown-link>@endif
                            @if(auth()->user()->hasPermission('audit.view'))<x-dropdown-link :href="route('audit.index')">Audit Trail</x-dropdown-link>@endif
                        </x-slot>
                    </x-dropdown>
                @endif

                @if(auth()->user()->hasPermission('users.view') || auth()->user()->hasPermission('settings.view'))
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 rounded-md text-slate-700 hover:bg-slate-100">Settings</button>
                        </x-slot>
                        <x-slot name="content">
                            @if(auth()->user()->hasPermission('users.view'))<x-dropdown-link :href="route('users.index')">Users</x-dropdown-link>@endif
                            @if(auth()->user()->hasPermission('settings.view'))<x-dropdown-link :href="route('system-config.index')">Config</x-dropdown-link>@endif
                        </x-slot>
                    </x-dropdown>
                @endif
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-slate-600 bg-white hover:text-slate-800">
                            {{ Auth::user()->name }}
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
