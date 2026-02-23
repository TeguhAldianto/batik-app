<x-layout>
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

            <div class="bg-stone-100 rounded-xl overflow-hidden shadow-sm">
                <img src="{{ Storage::url($product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-auto object-cover hover:scale-105 transition duration-500">
            </div>

            <div class="flex flex-col justify-center">
                <div class="mb-2">
                    <span class="bg-stone-100 text-batik-red px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                        {{ str_replace('_', ' ', $product->category) }}
                    </span>
                    <span class="ml-2 text-stone-500 text-sm">Stok Tersedia: {{ $product->stock }}</span>
                </div>

                <h1 class="text-3xl md:text-4xl font-serif font-bold text-stone-900 mb-4">{{ $product->name }}</h1>

                <p class="text-3xl text-batik-red font-bold mb-8">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <div class="prose prose-stone mb-8 border-b border-stone-100 pb-8">
                    <h3 class="text-lg font-bold mb-2 font-serif text-stone-800">Filosofi & Detail:</h3>
                    <div class="text-stone-600 leading-relaxed">
                        {!! $product->description !!}
                    </div>
                </div>

                <div class="bg-stone-50 p-4 rounded-lg border border-stone-200 mb-8">
                    <p class="text-xs text-stone-500 uppercase font-bold mb-1">Spesifikasi Ukuran</p>
                    <p class="font-bold text-lg text-stone-800">{{ $product->size }}</p>
                </div>

                <div class="mt-4">
                    @if($product->stock > 0)
                        <a href="{{ route('checkout.show', $product) }}"
                           class="flex justify-center items-center gap-2 w-full bg-batik-red text-white py-4 px-6 rounded-full font-bold hover:bg-red-900 transition shadow-lg shadow-red-200 transform hover:-translate-y-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                            <span>Beli Sekarang</span>
                        </a>
                    @else
                        <button disabled class="w-full bg-stone-200 text-stone-400 py-4 px-6 rounded-full font-bold cursor-not-allowed">
                            Maaf, Stok Habis
                        </button>
                    @endif

                    <p class="text-center text-xs text-stone-400 mt-4 flex justify-center items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Garansi Batik Tulis Asli Lasem. Transaksi Aman.
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-layout>
