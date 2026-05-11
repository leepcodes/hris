<x-app-layout>
    <x-slot name="header"><div class="flex justify-between"><h2 class="font-semibold text-xl text-slate-800">Users</h2><a href="{{ route('users.create') }}" class="px-3 py-2 bg-slate-900 text-white rounded">New User</a></div></x-slot>
    <div class="max-w-7xl mx-auto px-4 py-6">
        @if(session('status'))<div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white border rounded overflow-x-auto"><table class="min-w-full text-sm"><thead><tr class="border-b"><th class="p-3 text-left">Name</th><th>Email</th><th>Roles</th><th>Status</th><th></th></tr></thead><tbody>@foreach($users as $user)<tr class="border-b"><td class="p-3">{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->roles->pluck('name')->join(', ') }}</td><td>{{ $user->is_active ? 'Active':'Inactive' }}</td><td><a class="text-blue-600" href="{{ route('users.edit',$user) }}">Edit</a></td></tr>@endforeach</tbody></table></div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</x-app-layout>
