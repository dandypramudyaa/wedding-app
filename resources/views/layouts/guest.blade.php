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
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
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
    </body>
</html>
