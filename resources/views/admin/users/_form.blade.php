@php
    $user = $user ?? null;
    $userRoles = $userRoles ?? [];
@endphp

<div>
    <x-input-label for="name" value="Full Name" />
    <x-text-input id="name" name="name" type="text" required
        class="block mt-1 w-full border-rose-200 focus:border-rose-400 focus:ring-rose-400 rounded-lg"
        value="{{ old('name', $user?->name) }}" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="username" value="Username (used to sign in)" />
    <x-text-input id="username" name="username" type="text" required
        class="block mt-1 w-full border-rose-200 focus:border-rose-400 focus:ring-rose-400 rounded-lg"
        value="{{ old('username', $user?->username) }}" />
    <x-input-error :messages="$errors->get('username')" class="mt-2" />
</div>

<div>
    <x-input-label for="email" value="Email (optional)" />
    <x-text-input id="email" name="email" type="email"
        class="block mt-1 w-full border-rose-200 focus:border-rose-400 focus:ring-rose-400 rounded-lg"
        value="{{ old('email', $user?->email) }}" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<div>
    <x-input-label for="password" :value="$user ? 'New Password (leave blank to keep current)' : 'Password'" />
    <x-text-input id="password" name="password" type="password" {{ $user ? '' : 'required' }}
        class="block mt-1 w-full border-rose-200 focus:border-rose-400 focus:ring-rose-400 rounded-lg" />
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<div>
    <x-input-label for="password_confirmation" value="Confirm Password" />
    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
        class="block mt-1 w-full border-rose-200 focus:border-rose-400 focus:ring-rose-400 rounded-lg" />
</div>

<div>
    <x-input-label value="Roles" />
    <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 gap-3">
        @foreach($roles as $role)
            <label class="flex items-center gap-2 px-3 py-2 border border-rose-100 rounded-lg cursor-pointer hover:bg-rose-50">
                <input type="checkbox" name="roles[]" value="{{ $role }}"
                    class="rounded border-rose-300 text-rose-500 focus:ring-rose-400"
                    {{ in_array($role, old('roles', $userRoles)) ? 'checked' : '' }}>
                <span class="text-sm text-gray-700 capitalize">{{ $role }}</span>
            </label>
        @endforeach
    </div>
    <x-input-error :messages="$errors->get('roles')" class="mt-2" />
</div>
