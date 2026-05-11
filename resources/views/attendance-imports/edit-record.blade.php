<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Edit Attendance Record</h2></x-slot>
    <div class="max-w-2xl mx-auto px-4 py-6">
        <form method="POST" action="{{ route('attendance-records.update',$attendanceRecord) }}" class="bg-white border rounded p-4 grid grid-cols-2 gap-3">@csrf @method('PUT')
            <div><label class="block text-sm font-medium">Time In</label><input type="time" name="time_in" class="border rounded p-2 w-full" value="{{ old('time_in',substr((string)$attendanceRecord->time_in,0,5)) }}"></div>
            <div><label class="block text-sm font-medium">Time Out</label><input type="time" name="time_out" class="border rounded p-2 w-full" value="{{ old('time_out',substr((string)$attendanceRecord->time_out,0,5)) }}"></div>
            <div><label class="block text-sm font-medium">Break Hours</label><input type="number" step="0.01" name="break_hours" class="border rounded p-2 w-full" value="{{ old('break_hours',$attendanceRecord->break_hours) }}"></div>
            <div><label class="block text-sm font-medium">Late Minutes</label><input type="number" name="late_minutes" class="border rounded p-2 w-full" value="{{ old('late_minutes',$attendanceRecord->late_minutes) }}"></div>
            <div><label class="block text-sm font-medium">Undertime Minutes</label><input type="number" name="undertime_minutes" class="border rounded p-2 w-full" value="{{ old('undertime_minutes',$attendanceRecord->undertime_minutes) }}"></div>
            <div><label class="block text-sm font-medium">Overtime Hours</label><input type="number" step="0.01" name="overtime_hours" class="border rounded p-2 w-full" value="{{ old('overtime_hours',$attendanceRecord->overtime_hours) }}"></div>
            <div class="flex items-end"><label class="flex gap-2"><input type="checkbox" name="is_absent" value="1" @checked($attendanceRecord->is_absent)>Is Absent</label></div>
            <button class="px-3 py-2 bg-slate-900 text-white rounded col-span-2">Update Record</button>
        </form>
    </div>
</x-app-layout>
