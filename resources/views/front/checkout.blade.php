<x-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Kolom kiri: Detail produk --}}
            <div class="lg:w-1/3">
                <div class="sticky top-24 space-y-6">
                    <div class="bg-gradient-to-br from-white to-stone-50 rounded-2xl shadow-lg border border-stone-200 overflow-hidden">
                        {{-- Product Image --}}
                        <div class="h-48 bg-gradient-to-r from-batik-cream/50 to-stone-100 flex items-center justify-center relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-tr from-batik-red/10 to-batik-gold/10 mix-blend-multiply"></div>
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <div class="mb-4">
                                <h2 class="font-serif font-bold text-xl text-stone-800 mb-2">{{ $product->name }}</h2>
                                <p class="text-sm text-stone-600 line-clamp-2">{{ $product->category }}</p>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="flex items-center justify-between">
                                    <span class="text-stone-600">Harga</span>
                                    <span class="text-2xl font-bold text-batik-red">Rp {{ number_format($product->price) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-stone-600">Berat</span>
                                    <span class="font-medium text-stone-800">{{ number_format($product->weight ?? 200) }} gram</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom kanan: Form checkout --}}
            <div class="lg:w-2/3">
                {{-- PERBAIKAN: Tambahkan 'front.' karena file ada di folder front --}}
                @include('front.checkout-form', ['product' => $product])
            </div>
        </div>
    </div>
</x-layout>
