<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Attendance Records</h2></x-slot>
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-4">
        <form method="POST" action="{{ route('attendance-records.store') }}" class="bg-white border rounded p-4 grid grid-cols-2 gap-3">@csrf
            <div><label class="block text-sm font-medium">Employee</label><select name="employee_id" class="border rounded p-2 w-full">@foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->employee_code }} - {{ $e->last_name }}, {{ $e->first_name }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium">Employee Code</label><input name="employee_code" class="border rounded p-2 w-full"></div>
            <div><label class="block text-sm font-medium">Attendance Date</label><input type="date" name="attendance_date" class="border rounded p-2 w-full"></div>
            <div><label class="block text-sm font-medium">Time In</label><input type="time" name="time_in" class="border rounded p-2 w-full"></div>
            <div><label class="block text-sm font-medium">Time Out</label><input type="time" name="time_out" class="border rounded p-2 w-full"></div>
            <div><label class="block text-sm font-medium">Break Hours</label><input type="number" step="0.01" name="break_hours" class="border rounded p-2 w-full" value="1"></div>
            <div><label class="block text-sm font-medium">Late Minutes</label><input type="number" name="late_minutes" class="border rounded p-2 w-full" value="0"></div>
            <div><label class="block text-sm font-medium">Undertime Minutes</label><input type="number" name="undertime_minutes" class="border rounded p-2 w-full" value="0"></div>
            <div><label class="block text-sm font-medium">Overtime Hours</label><input type="number" step="0.01" name="overtime_hours" class="border rounded p-2 w-full" value="0"></div>
            <div class="flex items-end"><label class="flex gap-2"><input type="checkbox" name="is_absent" value="1">Is Absent</label></div>
            <button class="px-3 py-2 bg-slate-900 text-white rounded col-span-2">Add Manual Attendance</button>
        </form>

        <div class="bg-white border rounded overflow-x-auto">
            <table class="min-w-full text-sm"><thead><tr class="border-b"><th class="p-2">Date</th><th>Employee</th><th>In</th><th>Out</th><th>Late</th><th>UT</th><th>OT</th><th></th></tr></thead><tbody>
                @foreach($records as $record)
                    <tr class="border-b"><td class="p-2">{{ $record->attendance_date }}</td><td>{{ $record->employee?->employee_code }}</td><td>{{ $record->time_in }}</td><td>{{ $record->time_out }}</td><td>{{ $record->late_minutes }}</td><td>{{ $record->undertime_minutes }}</td><td>{{ $record->overtime_hours }}</td><td class="flex gap-2"><a class="text-blue-700" href="{{ route('attendance-records.edit',$record) }}">Edit</a><form method="POST" action="{{ route('attendance-records.destroy',$record) }}">@csrf @method('DELETE')<button class="text-red-700">Delete</button></form></td></tr>
                @endforeach
            </tbody></table>
        </div>
        {{ $records->links() }}
    </div>
</x-app-layout>
