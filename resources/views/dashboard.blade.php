<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-semibold text-gray-900 leading-tight">
                Dashboard
            </h1>
            <p class="text-sm text-gray-500">Welcome back, {{ Auth::user()->name }}.</p>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-rose-100">
                <div class="p-8 text-gray-900">
                    <h3 class="font-serif-display text-2xl text-rose-700 mb-2">You're all signed in</h3>
                    <p class="text-gray-600">Use the navigation above to access the parts of the wedding portal available to your role.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-6">
                    <div class="text-rose-500 text-3xl">&#9825;</div>
                    <h4 class="font-serif-display text-xl mt-2 text-gray-800">Your Permissions</h4>
                    <ul class="mt-3 space-y-1 text-sm text-gray-600">
                        @forelse(Auth::user()->getAllPermissions() as $perm)
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                {{ $perm->name }}
                            </li>
                        @empty
                            <li class="text-gray-400 italic">No permissions yet</li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-6">
                    <div class="text-rose-500 text-3xl">&#10024;</div>
                    <h4 class="font-serif-display text-xl mt-2 text-gray-800">Quick Links</h4>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a class="text-rose-600 hover:underline" href="{{ route('profile.edit') }}">Edit my profile</a></li>
                        @if(auth()->user()->hasRole('admin'))
                            <li><a class="text-rose-600 hover:underline" href="{{ route('admin.dashboard') }}">Admin dashboard</a></li>
                            <li><a class="text-rose-600 hover:underline" href="{{ route('admin.users.index') }}">Manage users</a></li>
                        @endif
                    </ul>
                </div>

                <div class="bg-gradient-to-br from-rose-500 to-pink-500 rounded-2xl shadow-sm p-6 text-white">
                    <div class="text-3xl">&#128144;</div>
                    <h4 class="font-serif-display text-xl mt-2">A beautiful journey</h4>
                    <p class="mt-2 text-sm text-white/90">Thank you for being part of our wedding planning. More features coming soon!</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
