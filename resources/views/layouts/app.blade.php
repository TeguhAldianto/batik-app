<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Batik Lasem') }} - {{ $title ?? 'Kain Tradisional Berkualitas' }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Figtree:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Meta Description -->
    <meta name="description" content="Batik Lasem - Warisan budaya Indonesia dengan motif khas Tionghoa-Jawa. Kain batik premium berkualitas tinggi.">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🪡</text></svg>">

    <style>
        :root {
            --color-batik-red: #b91c1c;
            --color-batik-gold: #d97706;
            --color-batik-cream: #fef3c7;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-sans {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased text-stone-800 bg-gradient-to-b from-batik-cream/20 to-white min-h-screen">
    <!-- Background Pattern -->
    <div class="fixed inset-0 z-[-1] opacity-[0.02] pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/batik.png')]"></div>

    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="flex-1">
            <!-- Page Header -->
            @isset($header)
                <div class="relative overflow-hidden">
                    <!-- Background Decoration -->
                    <div class="absolute inset-0 bg-gradient-to-r from-batik-red/5 to-batik-gold/5"></div>
                    <div class="absolute top-0 right-0 w-64 h-64 -translate-y-32 translate-x-32 bg-batik-red/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 translate-y-32 -translate-x-32 bg-batik-gold/10 rounded-full blur-3xl"></div>

                    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <!-- Main Content -->
            <div class="relative">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-stone-900 to-stone-800 text-white mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="text-center md:text-left">
                        <a href="{{ route('dashboard') }}" class="font-serif font-bold text-2xl text-batik-gold tracking-wider inline-block hover:scale-105 transition-transform duration-300">
                            BATIK LASEM
                        </a>
                        <p class="text-stone-400 text-sm mt-2">Warisan Budaya Indonesia sejak 1850</p>
                    </div>

                    <div class="text-center md:text-right">
                        <p class="text-stone-400 text-sm">&copy; {{ date('Y') }} Sekar Jagad Lasem. All rights reserved.</p>
                        <p class="text-stone-500 text-xs mt-1">Crafted with ❤️ in Lasem, Central Java</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Script for interactive elements -->
    <script>
        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
