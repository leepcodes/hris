<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">Edit Position</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-6">
        <form method="POST" action="{{ route('job-positions.update', $jobPosition) }}" class="space-y-4 bg-white p-6 border rounded">
            @csrf
            @method('PUT')

            <div>
                <label for="department_id" class="block text-sm font-medium">Department</label>
                <select id="department_id" name="department_id" class="w-full border rounded p-2">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" @selected(old('department_id', $jobPosition->department_id) == $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
            </div>

            <div>
                <label for="title" class="block text-sm font-medium">Title</label>
                <input id="title" name="title" class="w-full border rounded p-2" value="{{ old('title', $jobPosition->title) }}">
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <label for="salary_grade" class="block text-sm font-medium">Salary Grade</label>
                <input id="salary_grade" name="salary_grade" class="w-full border rounded p-2" value="{{ old('salary_grade', $jobPosition->salary_grade) }}">
                <x-input-error :messages="$errors->get('salary_grade')" class="mt-2" />
            </div>

            <div>
                <label for="basic_salary" class="block text-sm font-medium">Basic Salary</label>
                <input id="basic_salary" name="basic_salary" type="number" step="0.01" class="w-full border rounded p-2" value="{{ old('basic_salary', $jobPosition->basic_salary) }}">
                <x-input-error :messages="$errors->get('basic_salary')" class="mt-2" />
            </div>

            <button class="px-3 py-2 bg-slate-900 text-white rounded">Update</button>
        </form>
    </div>
</x-app-layout>
