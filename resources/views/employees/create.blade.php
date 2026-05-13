<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">Create Employee 201 File</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <form method="POST" action="{{ route('employees.store') }}" class="space-y-6 bg-white p-6 border rounded-lg" data-submit-loading>
            @csrf
            @if ($errors->any())
                <div class="rounded border border-red-200 bg-red-50 p-3">
                    <x-input-error :messages="$errors->all()" class="mt-0" />
                </div>
            @endif

            <div>
                <h3 class="text-base font-semibold text-slate-900">Employment Assignment</h3>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="employee_code" class="block text-sm font-medium text-slate-700">Employee Code</label>
                        <input id="employee_code" name="employee_code" value="{{ old('employee_code') }}" class="mt-1 w-full border rounded p-2">
                        @error('employee_code') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-slate-700">Department</label>
                        <select id="department_id" name="department_id" class="mt-1 w-full border rounded p-2" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="job_position_id" class="block text-sm font-medium text-slate-700">Job Position</label>
                        <select id="job_position_id" name="job_position_id" class="mt-1 w-full border rounded p-2" required>
                            <option value="">Select Job Position</option>
                            @foreach($jobPositions as $position)
                                <option value="{{ $position->id }}" @selected(old('job_position_id') == $position->id)>{{ $position->title }}</option>
                            @endforeach
                        </select>
                        @error('job_position_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-slate-900">Personal Information</h3>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-slate-700">First Name</label>
                        <input id="first_name" name="first_name" value="{{ old('first_name') }}" class="mt-1 w-full border rounded p-2" required>
                        @error('first_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="middle_name" class="block text-sm font-medium text-slate-700">Middle Name</label>
                        <input id="middle_name" name="middle_name" value="{{ old('middle_name') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-slate-700">Last Name</label>
                        <input id="last_name" name="last_name" value="{{ old('last_name') }}" class="mt-1 w-full border rounded p-2" required>
                        @error('last_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="suffix_name" class="block text-sm font-medium text-slate-700">Suffix</label>
                        <select id="suffix_name" name="suffix_name" class="mt-1 w-full border rounded p-2">
                            <option value="">Select Suffix</option>
                            @foreach(['Jr.', 'Sr.', 'II', 'III', 'IV'] as $suffix)
                                <option value="{{ $suffix }}" @selected(old('suffix_name') == $suffix)>{{ $suffix }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-slate-700">Birth Date</label>
                        <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-slate-700">Gender</label>
                        <select id="gender" name="gender" class="mt-1 w-full border rounded p-2">
                            <option value="">Select Gender</option>
                            <option value="Male" @selected(old('gender') == 'Male')>Male</option>
                            <option value="Female" @selected(old('gender') == 'Female')>Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="civil_status" class="block text-sm font-medium text-slate-700">Civil Status</label>
                        <select id="civil_status" name="civil_status" class="mt-1 w-full border rounded p-2">
                            <option value="">Select Civil Status</option>
                            <option value="Single" @selected(old('civil_status') == 'Single')>Single</option>
                            <option value="Married" @selected(old('civil_status') == 'Married')>Married</option>
                            <option value="Widowed" @selected(old('civil_status') == 'Widowed')>Widowed</option>
                            <option value="Separated" @selected(old('civil_status') == 'Separated')>Separated</option>
                        </select>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full border rounded p-2">
                        @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-slate-900">Contact Information</h3>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="mobile_number" class="block text-sm font-medium text-slate-700">Mobile Number</label>
                        <input id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div class="md:col-span-2">
                        <label for="address_line" class="block text-sm font-medium text-slate-700">Address</label>
                        <input id="address_line" name="address_line" value="{{ old('address_line') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-slate-700">City</label>
                        <input id="city" name="city" value="{{ old('city') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="province" class="block text-sm font-medium text-slate-700">Province</label>
                        <input id="province" name="province" value="{{ old('province') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-slate-700">Zip Code</label>
                        <input id="zip_code" name="zip_code" value="{{ old('zip_code') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-slate-900">Emergency Contact</h3>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-medium text-slate-700">Contact Name</label>
                        <input id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="emergency_contact_relationship" class="block text-sm font-medium text-slate-700">Relationship</label>
                        <input id="emergency_contact_relationship" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="emergency_contact_number" class="block text-sm font-medium text-slate-700">Contact Number</label>
                        <input id="emergency_contact_number" name="emergency_contact_number" value="{{ old('emergency_contact_number') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-slate-900">Government IDs</h3>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="sss_no" class="block text-sm font-medium text-slate-700">SSS No.</label>
                        <input id="sss_no" name="sss_no" value="{{ old('sss_no') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="philhealth_no" class="block text-sm font-medium text-slate-700">PhilHealth No.</label>
                        <input id="philhealth_no" name="philhealth_no" value="{{ old('philhealth_no') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="pagibig_no" class="block text-sm font-medium text-slate-700">Pag-IBIG No.</label>
                        <input id="pagibig_no" name="pagibig_no" value="{{ old('pagibig_no') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="tin_no" class="block text-sm font-medium text-slate-700">TIN No.</label>
                        <input id="tin_no" name="tin_no" value="{{ old('tin_no') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-slate-900">Employment & Compensation</h3>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="employment_status" class="block text-sm font-medium text-slate-700">Employment Status</label>
                        <select id="employment_status" name="employment_status" class="mt-1 w-full border rounded p-2" required>
                            @foreach(['active', 'probationary', 'regular', 'on_leave', 'resigned', 'terminated'] as $status)
                                <option value="{{ $status }}" @selected(old('employment_status', 'active') === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
                            @endforeach
                        </select>
                        @error('employment_status') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="hired_at" class="block text-sm font-medium text-slate-700">Hired Date</label>
                        <input id="hired_at" type="date" name="hired_at" value="{{ old('hired_at') }}" class="mt-1 w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="basic_salary" class="block text-sm font-medium text-slate-700">Basic Salary</label>
                        <input id="basic_salary" name="basic_salary" type="number" step="0.01" value="{{ old('basic_salary') }}" class="mt-1 w-full border rounded p-2" required>
                        <x-input-error :messages="$errors->get('basic_salary')" class="mt-2" />
                    </div>
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-slate-700">Account Status</label>
                        <select id="is_active" name="is_active" class="mt-1 w-full border rounded p-2">
                            <option value="1" @selected(old('is_active', '1') == '1')>Active</option>
                            <option value="0" @selected(old('is_active') == '0')>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded" data-save-button data-saving-text="Saving...">Save Employee</button>
            </div>
        </form>
    </div>
</x-app-layout>
