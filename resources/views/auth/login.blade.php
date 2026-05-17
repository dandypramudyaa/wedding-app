<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="font-serif-display text-3xl text-gray-800">Welcome Back</h2>
        <p class="text-sm text-gray-500 mt-1">Sign in to manage your wedding journey</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="username" :value="__('Username')" class="text-gray-700" />
            <x-text-input id="username"
                class="block mt-1 w-full border-rose-200 focus:border-rose-400 focus:ring-rose-400 rounded-lg"
                type="text" name="username" :value="old('username')" required autofocus autocomplete="username"
                placeholder="your.username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
            <x-text-input id="password"
                class="block mt-1 w-full border-rose-200 focus:border-rose-400 focus:ring-rose-400 rounded-lg"
                type="password" name="password" required autocomplete="current-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-rose-300 text-rose-500 shadow-sm focus:ring-rose-400" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <button type="submit"
            class="w-full inline-flex justify-center items-center px-4 py-3 bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-semibold rounded-lg shadow-md transition tracking-wide uppercase text-sm">
            {{ __('Sign In') }}
        </button>
    </form>
</x-guest-layout>
