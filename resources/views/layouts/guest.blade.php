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
            .wedding-bg {
                background-color: #fdf8f4;
                background-image:
                    radial-gradient(at 20% 10%, rgba(244, 200, 200, 0.45) 0px, transparent 50%),
                    radial-gradient(at 80% 0%, rgba(225, 200, 230, 0.4) 0px, transparent 50%),
                    radial-gradient(at 0% 100%, rgba(230, 215, 195, 0.55) 0px, transparent 50%),
                    radial-gradient(at 90% 90%, rgba(248, 220, 200, 0.45) 0px, transparent 50%);
            }

            #global-loader {
                position: fixed;
                inset: 0;
                z-index: 9999;
                display: none;
                align-items: center;
                justify-content: center;
                background: rgba(253, 248, 244, 0.8);
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
                border: 1px solid rgba(254, 205, 211, 1);
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
                color: #9f1239;
                letter-spacing: 0.02em;
            }
            @keyframes loader-spin {
                to { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{-- Global loading overlay --}}
        <div id="global-loader" role="status" aria-live="polite" aria-hidden="true">
            <div class="loader-card">
                <div class="loader-spinner"></div>
                <div class="loader-text">Loading...</div>
            </div>
        </div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 wedding-bg">
            <div class="text-center mb-6">
                <a href="/" class="inline-flex flex-col items-center">
                    <x-application-logo class="w-14 h-14 text-rose-400" />
                    <span class="font-serif-display text-3xl text-rose-700 mt-2 tracking-wide">Wedding App</span>
                    <span class="text-xs uppercase tracking-[0.3em] text-rose-400 mt-1">Forever &amp; Always</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-white/80 backdrop-blur shadow-xl overflow-hidden sm:rounded-2xl border border-rose-100">
                {{ $slot }}
            </div>

            <p class="mt-6 text-xs text-rose-500/70 tracking-widest uppercase">
                &copy; {{ date('Y') }} Wedding App
            </p>
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
