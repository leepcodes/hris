<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-slate-800">Employee 201 File - {{ $employee->employee_code }}</h2>
            <a href="{{ route('employees.edit', $employee) }}" class="px-3 py-2 bg-slate-900 text-white rounded">Edit
                Core
            </a>
            <a href="{{ route('employees.index') }}" class="px-3 py-2 bg-gray-500 text-white rounded">Back to List</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">
        <form method="POST" action="{{ route('employees.update', $employee) }}"
            class="bg-white border rounded p-4 grid grid-cols-1 md:grid-cols-3 gap-3">@csrf @method('PUT')
            <div><label class="block text-sm font-medium">First Name</label><input name="first_name"
                    class="w-full border rounded p-2" value="{{ old('first_name', $employee->first_name) }}"></div>
            <div><label class="block text-sm font-medium">Middle Name</label><input name="middle_name"
                    class="w-full border rounded p-2" value="{{ old('middle_name', $employee->middle_name) }}"></div>
            <div><label class="block text-sm font-medium">Last Name</label><input name="last_name"
                    class="w-full border rounded p-2" value="{{ old('last_name', $employee->last_name) }}"></div>
            <div><label class="block text-sm font-medium">Suffix</label><input name="suffix_name"
                    class="w-full border rounded p-2" value="{{ old('suffix_name', $employee->suffix_name) }}"></div>
            <div><label class="block text-sm font-medium">Civil Status</label><input name="civil_status"
                    class="w-full border rounded p-2" value="{{ old('civil_status', $employee->civil_status) }}"></div>
            <div><label class="block text-sm font-medium">Birth Date</label><input type="date" name="birth_date"
                    class="w-full border rounded p-2"
                    value="{{ old('birth_date', optional($employee->birth_date)->format('Y-m-d')) }}"></div>
            <div><label class="block text-sm font-medium">Gender</label><input name="gender"
                    class="w-full border rounded p-2" value="{{ old('gender', $employee->gender) }}"></div>
            <div><label class="block text-sm font-medium">Email</label><input name="email"
                    class="w-full border rounded p-2" value="{{ old('email', $employee->email) }}"></div>
            <div><label class="block text-sm font-medium">Mobile</label><input name="mobile_number"
                    class="w-full border rounded p-2" value="{{ old('mobile_number', $employee->mobile_number) }}">
            </div>
            <div class="md:col-span-3"><label class="block text-sm font-medium">Address</label><input
                    name="address_line" class="w-full border rounded p-2"
                    value="{{ old('address_line', $employee->address_line) }}"></div>
            <div><label class="block text-sm font-medium">City</label><input name="city"
                    class="w-full border rounded p-2" value="{{ old('city', $employee->city) }}"></div>
            <div><label class="block text-sm font-medium">Province</label><input name="province"
                    class="w-full border rounded p-2" value="{{ old('province', $employee->province) }}"></div>
            <div><label class="block text-sm font-medium">Zip</label><input name="zip_code"
                    class="w-full border rounded p-2" value="{{ old('zip_code', $employee->zip_code) }}"></div>
            <div><label class="block text-sm font-medium">Emergency Contact Name</label><input
                    name="emergency_contact_name" class="w-full border rounded p-2"
                    value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}"></div>
            <div><label class="block text-sm font-medium">Relationship</label><input
                    name="emergency_contact_relationship" class="w-full border rounded p-2"
                    value="{{ old('emergency_contact_relationship', $employee->emergency_contact_relationship) }}">
            </div>
            <div><label class="block text-sm font-medium">Emergency Number</label><input name="emergency_contact_number"
                    class="w-full border rounded p-2"
                    value="{{ old('emergency_contact_number', $employee->emergency_contact_number) }}"></div>
            <div><label class="block text-sm font-medium">SSS No.</label><input name="sss_no"
                    class="w-full border rounded p-2" value="{{ old('sss_no', $employee->sss_no) }}"></div>
            <div><label class="block text-sm font-medium">PhilHealth No.</label><input name="philhealth_no"
                    class="w-full border rounded p-2" value="{{ old('philhealth_no', $employee->philhealth_no) }}">
            </div>
            <div><label class="block text-sm font-medium">Pag-IBIG No.</label><input name="pagibig_no"
                    class="w-full border rounded p-2" value="{{ old('pagibig_no', $employee->pagibig_no) }}"></div>
            <div><label class="block text-sm font-medium">TIN No.</label><input name="tin_no"
                    class="w-full border rounded p-2" value="{{ old('tin_no', $employee->tin_no) }}"></div>
            <input type="hidden" name="employee_code" value="{{ $employee->employee_code }}"><input type="hidden"
                name="department_id" value="{{ $employee->department_id }}"><input type="hidden"
                name="job_position_id" value="{{ $employee->job_position_id }}"><input type="hidden"
                name="employment_status" value="{{ $employee->employment_status }}"><input type="hidden"
                name="basic_salary" value="{{ $employee->basic_salary }}">
            <div class="md:col-span-3"><button class="px-3 py-2 bg-slate-900 text-white rounded">Update 201 Core
                    Info</button></div>
        </form>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white border rounded p-4 space-y-3">
                <h3 class="font-semibold">Dependents</h3>
                <form method="POST" action="{{ route('employees.dependents.store', $employee) }}"
                    class="grid grid-cols-1 gap-2">@csrf
                    <label class="text-sm">Full Name</label><input name="full_name" class="border rounded p-2">
                    <label class="text-sm">Relationship</label>
                    <select name="relationship" class="border rounded p-2">
                        <option value="">Select Relationship</option>
                        <option value="Spouse">Spouse</option>
                        <option value="Child">Child</option>
                        <option value="Parent">Parent</option>
                        <option value="Sibling">Sibling</option>
                        <option value="Other">Other</option>
                    </select>
                    <label class="text-sm">Birth Date</label><input name="birth_date" type="date"
                        class="border rounded p-2">
                    <button class="px-3 py-2 bg-slate-900 text-white rounded">Add Dependent</button>
                </form>
                @foreach ($employee->dependents as $dependent)
                    <div class="flex justify-between border-t pt-2 text-sm"><span>{{ $dependent->full_name }}
                            ({{ $dependent->relationship }})</span>
                        <form method="POST"
                            action="{{ route('employees.dependents.destroy', [$employee, $dependent]) }}">@csrf
                            @method('DELETE')<button class="text-red-700">Delete</button></form>
                    </div>
                @endforeach
            </div>

            <div class="bg-white border rounded p-4 space-y-3">
                <h3 class="font-semibold">Documents</h3>
                <form method="POST" action="{{ route('employees.documents.store', $employee) }}"
                    enctype="multipart/form-data" class="grid grid-cols-1 gap-2">@csrf
                    <label class="text-sm">Document Type</label><input name="document_type"
                        class="border rounded p-2" placeholder="Contract / ID / Certificate">
                    <label class="text-sm">File</label><input type="file" name="document_file"
                        class="border rounded p-2">
                    <button class="px-3 py-2 bg-slate-900 text-white rounded">Upload Document</button>
                </form>
                @foreach ($employee->documents as $document)
                    <div class="flex justify-between border-t pt-2 text-sm"><span>{{ $document->document_type }} -
                            {{ $document->original_name }}</span>
                        <form method="POST"
                            action="{{ route('employees.documents.destroy', [$employee, $document]) }}">@csrf
                            @method('DELETE')<button class="text-red-700">Delete</button></form>
                    </div>
                @endforeach
            </div>

            <div class="bg-white border rounded p-4 space-y-3">
                <h3 class="font-semibold">Education</h3>
                <form method="POST" action="{{ route('employees.educations.store', $employee) }}"
                    class="grid grid-cols-1 gap-2">@csrf
                    <label class="text-sm">School Name</label>
                    <input name="school_name" class="border rounded p-2">
                    <label class="text-sm">Degree</label>
                    <select name="degree" class="border rounded p-2">
                        <option value="">Select Degree</option>
                        <option value="High School">High School</option>
                        <option value="Associate's">Associate's</option>
                        <option value="Bachelor's">Bachelor's</option>
                        <option value="Master's">Master's</option>
                        <option value="Doctorate">Doctorate</option>
                    </select>
                    <label class="text-sm">Level</label>
                    <select name="level" class="border rounded p-2">
                        <option value="">Select Level</option>
                        <option value="Undergraduate">Undergraduate</option>
                        <option value="Graduate">Graduate</option>
                    </select>
                    <div class="grid grid-cols-2 gap-2">
                        <div><label class="text-sm">Start</label><input type="date" name="started_at"
                                class="border rounded p-2 w-full"></div>
                        <div><label class="text-sm">End</label><input type="date" name="ended_at"
                                class="border rounded p-2 w-full"></div>
                    </div>
                    <button class="px-3 py-2 bg-slate-900 text-white rounded">Add Education</button>
                </form>
                @foreach ($employee->educations as $education)
                    <div class="flex justify-between border-t pt-2 text-sm"><span>{{ $education->school_name }} -
                            {{ $education->degree }}</span>
                        <form method="POST"
                            action="{{ route('employees.educations.destroy', [$employee, $education]) }}">@csrf
                            @method('DELETE')<button class="text-red-700">Delete</button></form>
                    </div>
                @endforeach
            </div>

            <div class="bg-white border rounded p-4 space-y-3">
                <h3 class="font-semibold">Work History</h3>
                <form method="POST" action="{{ route('employees.work-histories.store', $employee) }}"
                    class="grid grid-cols-1 gap-2">@csrf
                    <label class="text-sm">Company Name</label>
                    <input name="company_name" class="border rounded p-2">
                    <label class="text-sm">Position Title</label>
                    <input name="position_title" class="border rounded p-2">
                    <div class="grid grid-cols-2 gap-2">
                        <div><label class="text-sm">Start</label><input type="date" name="started_at"
                                class="border rounded p-2 w-full"></div>
                        <div><label class="text-sm">End</label><input type="date" name="ended_at"
                                class="border rounded p-2 w-full"></div>
                    </div>
                    <label class="text-sm">Last Salary</label><input name="last_salary" type="number"
                        step="0.01" class="border rounded p-2">
                    <label class="text-sm">Notes</label>
                    <textarea name="notes" class="border rounded p-2"></textarea>
                    <button class="px-3 py-2 bg-slate-900 text-white rounded">Add Work History</button>
                </form>
                @foreach ($employee->workHistories as $history)
                    <div class="flex justify-between border-t pt-2 text-sm"><span>{{ $history->company_name }} -
                            {{ $history->position_title }}</span>
                        <form method="POST"
                            action="{{ route('employees.work-histories.destroy', [$employee, $history]) }}">@csrf
                            @method('DELETE')<button class="text-red-700">Delete</button></form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
