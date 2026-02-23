<x-layout>
    <div class="bg-batik-red text-white py-20 text-center relative overflow-hidden">
        <div class="relative z-10 max-w-2xl mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4">Pesona Sekar Jagad</h1>
            <p class="text-lg text-red-100 mb-8 font-light">Koleksi Eksklusif Batik Tulis Lasem Asli.</p>
            <a href="#katalog"
                class="inline-block bg-batik-gold text-batik-red font-bold px-8 py-3 rounded-full hover:bg-white transition shadow-lg">Lihat
                Koleksi</a>
        </div>
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/batik.png')]">
        </div>
    </div>

    <div id="katalog" class="max-w-6xl mx-auto px-4 py-16">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-serif font-bold text-stone-800 tracking-wide mb-6">KOLEKSI TERBARU</h2>

            <div class="inline-flex flex-wrap justify-center gap-4">
                @php
                    $currentCat = request('category');
                @endphp

                <a href="{{ route('home') }}#katalog"
                    class="px-6 py-2 rounded-full border border-stone-200 transition duration-300 {{ !$currentCat ? 'bg-batik-red text-white border-batik-red shadow-md' : 'bg-white text-stone-600 hover:border-batik-red hover:text-batik-red' }}">
                    Semua
                </a>

                <a href="{{ route('home', ['category' => 'kain_batik']) }}#katalog"
                    class="px-6 py-2 rounded-full border border-stone-200 transition duration-300 {{ $currentCat == 'kain_batik' ? 'bg-batik-red text-white border-batik-red shadow-md' : 'bg-white text-stone-600 hover:border-batik-red hover:text-batik-red' }}">
                    Kain Batik
                </a>

                <a href="{{ route('home', ['category' => 'kemeja_pria']) }}#katalog"
                    class="px-6 py-2 rounded-full border border-stone-200 transition duration-300 {{ $currentCat == 'kemeja_pria' ? 'bg-batik-red text-white border-batik-red shadow-md' : 'bg-white text-stone-600 hover:border-batik-red hover:text-batik-red' }}">
                    Kemeja Pria
                </a>

                <a href="{{ route('home', ['category' => 'dress_wanita']) }}#katalog"
                    class="px-6 py-2 rounded-full border border-stone-200 transition duration-300 {{ $currentCat == 'dress_wanita' ? 'bg-batik-red text-white border-batik-red shadow-md' : 'bg-white text-stone-600 hover:border-batik-red hover:text-batik-red' }}">
                    Dress Wanita
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($products as $product)
                <a href="{{ route('product.show', $product) }}" class="group block">
                    <div
                        class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-stone-100">
                        <div class="aspect-[3/4] overflow-hidden bg-stone-200 relative">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700">

                            @if ($product->stock < 1)
                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                    <span class="bg-red-600 text-white px-3 py-1 text-sm font-bold rounded">HABIS</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <p class="text-xs text-batik-red font-bold uppercase mb-1 tracking-wider">
                                {{ str_replace('_', ' ', $product->category) }}
                            </p>
                            <h3
                                class="text-lg font-serif font-bold text-stone-900 mb-2 truncate group-hover:text-batik-red transition">
                                {{ $product->name }}</h3>
                            <div class="flex justify-between items-center">
                                <p class="text-stone-600 font-medium">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-stone-400">{{ $product->stock }} Stok</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if ($products->isEmpty())
            <div class="text-center py-20 bg-batik-cream rounded-lg border border-dashed border-stone-300">
                <p class="text-stone-500 font-serif text-lg">Kategori ini belum memiliki koleksi.</p>
                <a href="{{ route('home') }}"
                    class="text-batik-red text-sm font-bold hover:underline mt-2 inline-block">Lihat Semua Produk</a>
            </div>
        @endif
    </div>
</x-layout>
