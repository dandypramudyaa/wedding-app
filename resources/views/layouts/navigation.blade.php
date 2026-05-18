<aside
    class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 transform transition-transform duration-200 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <div class="h-full flex flex-col">
        {{-- Brand --}}
        <div class="h-16 flex items-center justify-between px-5 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
                <x-application-logo class="block h-7 w-auto text-gray-800" />
                <span class="font-serif-display text-xl text-gray-900 tracking-wide">Wedding App</span>
            </a>
            <button
                @click="sidebarOpen = false"
                class="lg:hidden p-1 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100"
                aria-label="Close sidebar"
            >
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Nav links --}}
        @php
            $linkBase = 'flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition';
            $linkActive = 'bg-gray-100 text-gray-900';
            $linkIdle = 'text-gray-600 hover:bg-gray-100 hover:text-gray-900';
        @endphp

        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-gray-400">Menu</p>

            <a href="{{ route('dashboard') }}"
               class="{{ $linkBase }} {{ request()->routeIs('dashboard') ? $linkActive : $linkIdle }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V10" />
                </svg>
                <span>{{ __('Dashboard') }}</span>
            </a>

            <a href="{{ route('profile.edit') }}"
               class="{{ $linkBase }} {{ request()->routeIs('profile.*') ? $linkActive : $linkIdle }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 14a4 4 0 10-8 0M12 11a3 3 0 100-6 3 3 0 000 6zm-8 9a8 8 0 0116 0" />
                </svg>
                <span>{{ __('Profile') }}</span>
            </a>

            @auth
                @if(auth()->user()->hasRole('admin'))
                    <p class="px-3 pt-5 pb-2 text-[11px] font-semibold uppercase tracking-wider text-gray-400">Administration</p>

                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ $linkBase }} {{ request()->routeIs('admin.dashboard') ? $linkActive : $linkIdle }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h6v6H4zM14 5h6v6h-6zM4 13h6v6H4zM14 13h6v6h-6z" />
                        </svg>
                        <span>{{ __('Admin Dashboard') }}</span>
                    </a>

                    <a href="{{ route('admin.master-data-columns.index') }}"
                       class="{{ $linkBase }} {{ request()->routeIs('admin.master-data-columns.*') ? $linkActive : $linkIdle }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h10M4 18h7" />
                        </svg>
                        <span>{{ __('Master Data Columns') }}</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="{{ $linkBase }} {{ request()->routeIs('admin.users.*') ? $linkActive : $linkIdle }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6zm-12 0a3 3 0 100-6 3 3 0 000 6z" />
                        </svg>
                        <span>{{ __('Users') }}</span>
                    </a>
                @endif
            @endauth
        </nav>

        {{-- Footer / Logout --}}
        @auth
            <div class="border-t border-gray-200 p-3">
                <div class="flex items-center gap-3 px-2 py-2">
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-200 text-gray-700 font-semibold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ Auth::user()->roles->pluck('name')->join(', ') ?: 'member' }}
                        </p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full mt-1 flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>{{ __('Log Out') }}</span>
                    </button>
                </form>
            </div>
        @endauth
    </div>
</aside>
