<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-rose-500">Administrator</p>
            <h2 class="font-serif-display text-3xl text-rose-800 leading-tight">Edit User</h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-rose-100 p-8">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
                @csrf
                @method('PUT')

                @include('admin.users._form')

                <div class="flex justify-end gap-3 pt-3">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button class="px-5 py-2 rounded-lg bg-rose-500 text-white hover:bg-rose-600">Update User</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
