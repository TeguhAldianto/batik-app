<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batik Tulis Lasem - Sekar Jagad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-batik-cream font-sans text-stone-800 antialiased">

    <nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-batik-red rounded-full flex items-center justify-center text-white font-serif font-bold shadow-md group-hover:bg-red-900 transition">B</div>
                    <span class="text-xl font-serif font-bold tracking-widest text-batik-red">BATIK LASEM</span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-stone-600 hover:text-batik-red font-medium transition duration-300">Katalog</a>

                    @auth
                        <div class="relative group" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 text-stone-600 hover:text-batik-red transition font-medium">
                                <span>{{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>

                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 hidden group-hover:block border border-stone-100 transform origin-top-right transition-all">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-red-50 hover:text-batik-red">Dashboard</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-red-50 hover:text-batik-red">Profile</a>
                                <div class="border-t border-stone-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="text-stone-600 hover:text-batik-red font-medium transition">Masuk</a>
                            <a href="{{ route('register') }}" class="bg-batik-red text-white text-sm font-bold px-6 py-2.5 rounded-full hover:bg-red-900 transition shadow-lg shadow-red-200">Daftar</a>
                        </div>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <a href="{{ route('login') }}" class="text-batik-red font-bold text-sm">Masuk / Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-stone-900 text-stone-400 py-16 mt-20 border-t-4 border-batik-red">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h3 class="text-2xl font-serif font-bold text-white tracking-widest mb-2">SEKAR JAGAD LASEM</h3>
            <p class="text-stone-500 mb-8 italic">Mahakarya Batik Tulis Warisan Nusantara</p>
            <div class="flex justify-center gap-6 mb-8">
                <a href="#" class="w-10 h-10 bg-stone-800 rounded-full flex items-center justify-center hover:bg-batik-red hover:text-white transition">IG</a>
                <a href="#" class="w-10 h-10 bg-stone-800 rounded-full flex items-center justify-center hover:bg-batik-red hover:text-white transition">WA</a>
            </div>
            <p class="text-sm border-t border-stone-800 pt-8">&copy; {{ date('Y') }} Batik Lasem. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
