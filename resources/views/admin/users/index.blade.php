<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-rose-500">Administrator</p>
                <h2 class="font-serif-display text-3xl text-rose-800 leading-tight">Users</h2>
            </div>
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-full bg-rose-500 text-white text-sm font-medium hover:bg-rose-600 transition">
                + New User
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 overflow-hidden">
            <table class="min-w-full divide-y divide-rose-100">
                <thead class="bg-rose-50/60">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-rose-700">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-rose-700">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-rose-700">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-rose-700">Roles</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-rose-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rose-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-rose-50/30">
                            <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-mono">{{ $user->username }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @forelse($user->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 text-xs font-medium me-1">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400">—</span>
                                @endforelse
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-rose-600 hover:underline me-3">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">No users yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
