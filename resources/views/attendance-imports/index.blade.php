<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Attendance CSV Upload</h2></x-slot>
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">
        <a href="{{ route('attendance-records.index') }}" class="text-blue-700">Manual Attendance / Edit Uploaded Records</a>
        <form method="POST" action="{{ route('attendance-imports.preview') }}" enctype="multipart/form-data" class="bg-white border rounded p-6 space-y-4">@csrf
            <label class="block text-sm font-medium">Attendance CSV File</label>
            <input type="file" name="attendance_csv" accept=".csv,.txt" class="block w-full border rounded p-2">
            <button class="px-4 py-2 bg-slate-900 text-white rounded">Upload and Preview</button>
        </form>

        <div class="bg-white border rounded overflow-x-auto"><table class="min-w-full text-sm"><thead><tr class="border-b"><th class="p-3 text-left">Batch #</th><th>File</th><th>Rows</th><th>Valid</th><th>Invalid</th><th>Uploaded By</th><th>Imported At</th></tr></thead><tbody>@forelse($batches as $batch)<tr class="border-b"><td class="p-3">{{ $batch->id }}</td><td>{{ $batch->filename }}</td><td>{{ $batch->total_rows }}</td><td class="text-emerald-700">{{ $batch->valid_rows }}</td><td class="text-red-700">{{ $batch->invalid_rows }}</td><td>{{ $batch->uploader?->name }}</td><td>{{ optional($batch->imported_at)->format('Y-m-d H:i') }}</td></tr>@empty<tr><td colspan="7" class="p-4 text-slate-500">No imports yet.</td></tr>@endforelse</tbody></table></div>
        {{ $batches->links() }}
    </div>
</x-app-layout>
