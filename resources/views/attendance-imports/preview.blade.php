<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">Attendance Import Preview</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">
        <div class="bg-white border rounded p-4">
            <p><span class="font-medium">File:</span> {{ $filename }}</p>
            <p><span class="font-medium">Total Rows:</span> {{ $totalRows }}</p>
            <p><span class="font-medium text-emerald-700">Valid Rows:</span> {{ count($validRows) }}</p>
            <p><span class="font-medium text-red-700">Invalid Rows:</span> {{ count($errors) }}</p>
        </div>

        @if($errors)
            <div class="bg-white border rounded p-4">
                <h3 class="font-semibold mb-3 text-red-700">Row Errors</h3>
                <ul class="space-y-2 text-sm">
                    @foreach($errors as $error)
                        <li>Row {{ $error['row'] }}: {{ $error['message'] }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border rounded overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="p-3 text-left">No.</th>
                        <th class="text-left">Name</th>
                        <th class="text-left">Department</th>
                        <th class="text-left">Date/Time</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Location</th>
                        <th class="text-left">ID Number</th>
                        <th class="text-left">Verify Code</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($validRows as $row)
                        <tr class="border-b">
                            <td class="p-3">{{ $row['employee_no'] }}</td>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['department'] }}</td>
                            <td>{{ $row['date_time'] }}</td>
                            <td>{{ $row['status'] }}</td>
                            <td>{{ $row['location'] }}</td>
                            <td>{{ $row['id_number'] }}</td>
                            <td>{{ $row['verification_code'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="p-4 text-slate-500">No valid rows found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <form method="POST" action="{{ route('attendance-imports.store') }}">
            @csrf
            <input type="hidden" name="preview_token" value="{{ $token }}">
            <button class="px-4 py-2 bg-slate-900 text-white rounded" @disabled(count($validRows) === 0)>Confirm Import</button>
            <a href="{{ route('attendance-imports.index') }}" class="ml-2 text-slate-600">Cancel</a>
        </form>
    </div>
</x-app-layout>
