<x-app-layout><x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Create User</h2></x-slot><div class="max-w-3xl mx-auto px-4 py-6"><form method="POST" action="{{ route('users.store') }}" class="space-y-4 bg-white p-6 border rounded">@csrf
<label class="block text-sm font-medium">Name</label><input name="name" class="w-full border rounded p-2" value="{{ old('name') }}">
<label class="block text-sm font-medium">Email</label><input name="email" class="w-full border rounded p-2" value="{{ old('email') }}">
<label class="block text-sm font-medium">Password</label><input type="password" name="password" class="w-full border rounded p-2">
<label class="block text-sm font-medium">Confirm Password</label><input type="password" name="password_confirmation" class="w-full border rounded p-2">
<label class="block text-sm font-medium">Roles</label><select name="role_ids[]" multiple class="w-full border rounded p-2">@foreach($roles as $role)<option value="{{ $role->id }}">{{ $role->name }}</option>@endforeach</select>
<label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" checked>Active</label><button class="px-3 py-2 bg-slate-900 text-white rounded">Save</button></form></div></x-app-layout>
