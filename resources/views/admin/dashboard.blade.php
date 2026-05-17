<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-rose-500">Administrator</p>
            <h2 class="font-serif-display text-3xl text-rose-800 leading-tight">Admin Dashboard</h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php
                $cards = [
                    ['label' => 'Total Users',  'value' => $stats['users'],       'icon' => '&#128101;'],
                    ['label' => 'Administrators','value' => $stats['admins'],     'icon' => '&#128737;'],
                    ['label' => 'Roles',        'value' => $stats['roles'],       'icon' => '&#127895;'],
                    ['label' => 'Permissions',  'value' => $stats['permissions'], 'icon' => '&#128272;'],
                ];
            @endphp

            @foreach($cards as $card)
                <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-widest text-rose-500">{{ $card['label'] }}</p>
                            <p class="font-serif-display text-4xl text-gray-800 mt-2">{{ $card['value'] }}</p>
                        </div>
                        <span class="text-3xl">{!! $card['icon'] !!}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-serif-display text-2xl text-rose-700">Quick Actions</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('admin.users.index') }}" class="block p-5 rounded-xl border border-rose-100 hover:border-rose-300 hover:bg-rose-50/50 transition">
                    <p class="font-medium text-gray-800">Manage Users</p>
                    <p class="text-sm text-gray-500 mt-1">Add, edit and assign roles to users.</p>
                </a>
                <a href="{{ route('admin.users.create') }}" class="block p-5 rounded-xl border border-rose-100 hover:border-rose-300 hover:bg-rose-50/50 transition">
                    <p class="font-medium text-gray-800">Invite New User</p>
                    <p class="text-sm text-gray-500 mt-1">Create a new account with specific roles.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
