<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Batik Lasem') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-stone-800 antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-batik-cream relative overflow-hidden">

        <div
            class="absolute inset-0 opacity-5 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/batik.png')]">
        </div>

        <div class="relative z-10 mb-6 text-center">
            <a href="/" class="flex flex-col items-center gap-2 group">
                <div
                    class="w-16 h-16 bg-batik-red rounded-full flex items-center justify-center text-white font-serif text-2xl font-bold shadow-lg group-hover:scale-110 transition duration-300">
                    B
                </div>
                <span class="font-serif text-2xl font-bold text-batik-red tracking-widest">BATIK LASEM</span>
            </a>
        </div>

        <div
            class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-xl overflow-hidden sm:rounded-xl border border-stone-100">
            {{ $slot }}
        </div>

        <div class="relative z-10 mt-8 text-stone-500 text-sm">
            &copy; {{ date('Y') }} Sekar Jagad Lasem
        </div>
    </div>
</body>

</html>
