<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Wedding App') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600,700|figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Figtree', 'ui-sans-serif', 'system-ui', '-apple-system', 'sans-serif'],
                        },
                    },
                },
            };
        </script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            .font-serif-display { font-family: 'Cormorant Garamond', serif; }
            [x-cloak] { display: none !important; }

            #global-loader {
                position: fixed;
                inset: 0;
                z-index: 9999;
                display: none;
                align-items: center;
                justify-content: center;
                background: rgba(255, 255, 255, 0.75);
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
                transition: opacity 0.15s ease;
            }
            #global-loader.is-active { display: flex; }
            #global-loader .loader-card {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.75rem;
                padding: 1.25rem 1.75rem;
                border-radius: 0.75rem;
                background: #ffffff;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                border: 1px solid rgba(229, 231, 235, 1);
            }
            #global-loader .loader-spinner {
                width: 2.25rem;
                height: 2.25rem;
                border-radius: 9999px;
                border: 3px solid rgba(244, 114, 182, 0.2);
                border-top-color: rgb(225, 29, 72);
                animation: loader-spin 0.8s linear infinite;
            }
            #global-loader .loader-text {
                font-size: 0.875rem;
                color: #4b5563;
                letter-spacing: 0.02em;
            }
            @keyframes loader-spin {
                to { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800">
        {{-- Global loading overlay --}}
        <div id="global-loader" role="status" aria-live="polite" aria-hidden="true">
            <div class="loader-card">
                <div class="loader-spinner"></div>
                <div class="loader-text">Loading...</div>
            </div>
        </div>

        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
            {{-- Mobile overlay --}}
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                @click="sidebarOpen = false"
                class="fixed inset-0 bg-gray-900/40 z-30 lg:hidden"
                style="display: none;"
            ></div>

            {{-- Sidebar --}}
            @include('layouts.navigation')

            {{-- Main content area --}}
            <div class="flex-1 flex flex-col min-w-0 lg:pl-64">
                {{-- Topbar --}}
                <header class="sticky top-0 z-20 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
                        <div class="flex items-center gap-3">
                            <button
                                @click="sidebarOpen = true"
                                class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none"
                                aria-label="Open sidebar"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>

                            @isset($header)
                                <div class="min-w-0">
                                    {{ $header }}
                                </div>
                            @endisset
                        </div>

                        <div class="flex items-center gap-3">
                            @auth
                                <x-dropdown align="right" width="56">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center gap-2 px-2 py-1.5 rounded-md text-sm text-gray-700 hover:bg-gray-100 focus:outline-none transition">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-700 font-semibold text-sm">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </span>
                                            <span class="hidden sm:flex flex-col items-start leading-tight">
                                                <span class="font-medium">{{ Auth::user()->name }}</span>
                                                <span class="text-[10px] uppercase tracking-widest text-gray-400">
                                                    {{ Auth::user()->roles->pluck('name')->join(', ') ?: 'member' }}
                                                </span>
                                            </span>
                                            <svg class="hidden sm:block h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endauth
                        </div>
                    </div>
                </header>

                @if (session('status'))
                    <div class="px-4 sm:px-6 lg:px-8 mt-4">
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md text-sm">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

                <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            (function () {
                const loader = document.getElementById('global-loader');
                if (!loader) return;

                let loaderTimer = null;

                function showLoader() {
                    if (loaderTimer) return;
                    loaderTimer = setTimeout(function () {
                        loader.classList.add('is-active');
                        loader.setAttribute('aria-hidden', 'false');
                    }, 120);
                }

                function hideLoader() {
                    if (loaderTimer) {
                        clearTimeout(loaderTimer);
                        loaderTimer = null;
                    }
                    loader.classList.remove('is-active');
                    loader.setAttribute('aria-hidden', 'true');
                }

                window.showGlobalLoader = showLoader;
                window.hideGlobalLoader = hideLoader;

                document.addEventListener('click', function (event) {
                    if (event.defaultPrevented) return;
                    if (event.button !== 0) return;
                    if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

                    const anchor = event.target.closest('a');
                    if (!anchor) return;

                    const href = anchor.getAttribute('href');
                    if (!href) return;
                    if (anchor.hasAttribute('download')) return;
                    if (anchor.target && anchor.target !== '' && anchor.target !== '_self') return;
                    if (anchor.dataset.noLoader !== undefined) return;

                    if (href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;

                    try {
                        const url = new URL(anchor.href, window.location.href);
                        if (url.origin !== window.location.origin) return;
                        if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) return;
                    } catch (e) {
                        return;
                    }

                    showLoader();
                }, true);

                document.addEventListener('submit', function (event) {
                    const form = event.target;
                    if (!form || form.tagName !== 'FORM') return;
                    if (form.dataset.noLoader !== undefined) return;
                    if (event.defaultPrevented) return;

                    showLoader();
                }, true);

                window.addEventListener('pageshow', function (event) {
                    if (event.persisted) hideLoader();
                });
                window.addEventListener('pagehide', hideLoader);
                document.addEventListener('DOMContentLoaded', hideLoader);
            })();
        </script>
    </body>
</html>
