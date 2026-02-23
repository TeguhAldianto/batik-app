<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-xl text-stone-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-batik-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 bg-white border-l-4 border-batik-red p-4 shadow-sm rounded-r-lg">
                <p class="text-stone-600">Halo, <strong>{{ Auth::user()->name }}</strong>. Berikut adalah riwayat belanja
                    batik Anda.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-stone-100">
                <div class="p-6 text-stone-900">

                    @if ($orders->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-stone-300 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-stone-700">Belum ada pesanan</h3>
                            <p class="text-stone-500 mb-6">Yuk, mulai koleksi Batik Lasem pertamamu.</p>
                            <a href="{{ route('home') }}"
                                class="inline-block bg-batik-red text-white px-6 py-2 rounded-full font-bold hover:bg-red-900 transition">
                                Belanja Sekarang
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="text-stone-500 border-b border-stone-200 text-sm uppercase tracking-wider">
                                        <th class="px-4 py-3">No. Invoice</th>
                                        <th class="px-4 py-3">Tanggal</th>
                                        <th class="px-4 py-3">Total</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @foreach ($orders as $order)
                                        <tr class="border-b border-stone-100 hover:bg-stone-50 transition">
                                            <td class="px-4 py-4 font-bold text-stone-800">
                                                {{ $order->number }}
                                                <div class="text-xs text-stone-500 font-normal mt-1">
                                                    {{ $order->items->count() }} Item
                                                </div>
                                                <div class="text-xs text-stone-400 font-normal mt-1 truncate max-w-[150px]"
                                                    title="{{ $order->shipping_address }}">
                                                    <span class="mr-1">📍</span>
                                                    {{ Str::limit($order->shipping_address, 20) }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-stone-600">
                                                {{ $order->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="px-4 py-4 font-bold text-batik-red">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-4">
                                                @php
                                                    $colors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'paid' => 'bg-green-100 text-green-800',
                                                        'processing' => 'bg-blue-100 text-blue-800',
                                                        'shipped' => 'bg-purple-100 text-purple-800',
                                                        'completed' => 'bg-green-100 text-green-800',
                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $labels = [
                                                        'pending' => 'Belum Bayar',
                                                        'paid' => 'Lunas',
                                                        'processing' => 'Diproses',
                                                        'shipped' => 'Dikirim',
                                                        'completed' => 'Selesai',
                                                        'cancelled' => 'Batal',
                                                    ];
                                                @endphp
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-bold {{ $colors[$order->status] ?? 'bg-gray-100' }}">
                                                    {{ $labels[$order->status] ?? $order->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                @if ($order->status == 'pending')
                                                    <button onclick="pay('{{ $order->snap_token }}')"
                                                        class="bg-batik-gold text-batik-red px-4 py-2 rounded-lg text-xs font-bold hover:bg-yellow-500 transition shadow-sm">
                                                        Bayar Sekarang
                                                    </button>
                                                @elseif($order->status == 'shipped')
                                                    <div class="text-xs text-left">
                                                        <span class="block text-stone-400">Resi:</span>
                                                        <span
                                                            class="font-mono font-bold select-all bg-stone-100 px-1 rounded">{{ $order->tracking_number ?? '-' }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-stone-400 text-xs">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        function pay(snapToken) {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    location.reload();
                },
                onPending: function(result) {
                    location.reload();
                },
                onError: function(result) {
                    location.reload();
                }
            });
        }
    </script>
</x-app-layout>
