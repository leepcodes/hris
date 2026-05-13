<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">Edit Employee</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-6">
        <form method="POST" action="{{ route('employees.update', $employee) }}" class="space-y-4 bg-white p-6 border rounded">
            @csrf
            @method('PUT')

            <div>
                <label for="employee_code" class="block text-sm font-medium">Employee Code</label>
                <input id="employee_code" name="employee_code" class="w-full border rounded p-2" value="{{ old('employee_code', $employee->employee_code) }}">
                <x-input-error :messages="$errors->get('employee_code')" class="mt-2" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium">First Name</label>
                    <input id="first_name" name="first_name" class="border rounded p-2 w-full" value="{{ old('first_name', $employee->first_name) }}">
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium">Last Name</label>
                    <input id="last_name" name="last_name" class="border rounded p-2 w-full" value="{{ old('last_name', $employee->last_name) }}">
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" name="email" class="w-full border rounded p-2" value="{{ old('email', $employee->email) }}">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="department_id" class="block text-sm font-medium">Department</label>
                <select id="department_id" name="department_id" class="w-full border rounded p-2">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id) === $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
            </div>

            <div>
                <label for="job_position_id" class="block text-sm font-medium">Job Position</label>
                <select id="job_position_id" name="job_position_id" class="w-full border rounded p-2">
                    @foreach($jobPositions as $position)
                        <option value="{{ $position->id }}" @selected(old('job_position_id', $employee->job_position_id) === $position->id)>{{ $position->title }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('job_position_id')" class="mt-2" />
            </div>

            <div>
                <label for="employment_status" class="block text-sm font-medium">Employment Status</label>
                <select id="employment_status" name="employment_status" class="w-full border rounded p-2">
                    @foreach(['active', 'probationary', 'regular', 'on_leave', 'resigned', 'terminated'] as $status)
                        <option value="{{ $status }}" @selected(old('employment_status', $employee->employment_status) === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('employment_status')" class="mt-2" />
            </div>

            <div>
                <label for="basic_salary" class="block text-sm font-medium">Basic Salary</label>
                <input id="basic_salary" name="basic_salary" type="number" step="0.01" class="w-full border rounded p-2" value="{{ old('basic_salary', $employee->basic_salary) }}">
                <x-input-error :messages="$errors->get('basic_salary')" class="mt-2" />
            </div>

            <button class="px-3 py-2 bg-slate-900 text-white rounded">Update</button>
        </form>
    </div>
</x-app-layout>
