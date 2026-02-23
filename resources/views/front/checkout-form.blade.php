{{-- resources/views/checkout-form.blade.php --}}
<div class="md:col-span-2">
    <form action="{{ route('checkout.process', $product) }}" method="POST" class="bg-gradient-to-br from-white to-stone-50 p-6 rounded-2xl shadow-lg border border-stone-200 transition-all duration-300 hover:shadow-xl">
        @csrf

        {{-- Hidden untuk dikirim ke backend --}}
        <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
        <input type="hidden" name="total_price" id="total_price" value="{{ $product->price }}">
        <input type="hidden" name="destination_city_id" id="destination_city_id">

        {{-- Badge Status --}}
        <div class="flex items-center gap-2 mb-6">
            <div class="w-2 h-2 rounded-full bg-batik-red animate-pulse"></div>
            <span class="text-xs font-medium text-batik-red uppercase tracking-wide">Lengkapi Data Pengiriman</span>
        </div>

        {{-- Alamat Pengiriman --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 rounded-full bg-batik-gold/20 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-batik-red" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="font-bold text-lg text-stone-800">Alamat Pengiriman</h3>
            </div>

            <div class="space-y-5">
                <div>
                    <div class="text-sm font-semibold text-stone-700 mb-2 flex items-center gap-1">
                        <span>Nama Penerima</span>
                        <span class="text-red-500">*</span>
                    </div>
                    <div class="relative">
                        <input
                            type="text"
                            name="receiver_name"
                            class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-batik-red focus:ring-2 focus:ring-batik-red/20 transition-all duration-200 text-sm placeholder-stone-400"
                            required
                            placeholder="Nama lengkap penerima"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-4 h-4 text-stone-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="text-sm font-semibold text-stone-700 mb-2 flex items-center gap-1">
                        <span>No. HP</span>
                        <span class="text-red-500">*</span>
                    </div>
                    <div class="relative">
                        <input
                            type="text"
                            name="receiver_phone"
                            class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-batik-red focus:ring-2 focus:ring-batik-red/20 transition-all duration-200 text-sm placeholder-stone-400"
                            required
                            placeholder="08xxxxxxxxxx"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-4 h-4 text-stone-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- PROVINSI & KOTA --}}
                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <div class="text-sm font-semibold text-stone-700 mb-2 flex items-center gap-1">
                            <span>Provinsi</span>
                            <span class="text-red-500">*</span>
                        </div>
                        <div class="relative">
                            <select id="province" class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-batik-red focus:ring-2 focus:ring-batik-red/20 transition-all duration-200 text-sm appearance-none bg-white">
                                <option value="">-- Pilih Provinsi --</option>
                            </select>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-4 h-4 text-stone-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="text-sm font-semibold text-stone-700 mb-2 flex items-center gap-1">
                            <span>Kota / Kabupaten</span>
                            <span class="text-red-500">*</span>
                        </div>
                        <div class="relative">
                            <select id="city" class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-batik-red focus:ring-2 focus:ring-batik-red/20 transition-all duration-200 text-sm appearance-none bg-white" disabled>
                                <option value="">-- Pilih Provinsi Dulu --</option>
                            </select>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-4 h-4 text-stone-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ALAMAT DETAIL --}}
                <div>
                    <div class="text-sm font-semibold text-stone-700 mb-2 flex items-center gap-1">
                        <span>Alamat Lengkap</span>
                        <span class="text-red-500">*</span>
                    </div>
                    <div class="relative">
                        <textarea
                            name="shipping_address"
                            rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-batik-red focus:ring-2 focus:ring-batik-red/20 transition-all duration-200 text-sm placeholder-stone-400 resize-none"
                            required
                            placeholder="Contoh: Jl. Diponegoro No. 10 RT 01 / RW 02"
                        ></textarea>
                        <div class="absolute right-3 top-3">
                            <svg class="w-4 h-4 text-stone-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kurir Pengiriman --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 rounded-full bg-batik-gold/20 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-batik-red" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1h4v1a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H20a1 1 0 001-1V5a1 1 0 00-1-1H3z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-lg text-stone-800">Kurir Pengiriman</h3>
            </div>

            <div class="grid md:grid-cols-2 gap-5 mb-4">
                <div>
                    <div class="text-sm font-semibold text-stone-700 mb-2">Pilih Kurir</div>
                    <div class="relative">
                        <select id="courier" class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-batik-red focus:ring-2 focus:ring-batik-red/20 transition-all duration-200 text-sm appearance-none bg-white">
                            <option value="">-- Pilih Kurir --</option>
                            <option value="jne" class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                                JNE
                            </option>
                            <option value="pos">
                                <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                POS Indonesia
                            </option>
                            <option value="tiki">
                                <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                TIKI
                            </option>
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <svg class="w-4 h-4 text-stone-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="text-sm font-semibold text-stone-700 mb-2">Layanan Pengiriman</div>
                    <div class="relative">
                        <select
                            id="service"
                            name="courier_service"
                            class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-batik-red focus:ring-2 focus:ring-batik-red/20 transition-all duration-200 text-sm appearance-none bg-white"
                            disabled
                        >
                            <option value="">-- Cek Ongkir Dulu --</option>
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <svg class="w-4 h-4 text-stone-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Indikator Loading --}}
            <div id="loading-indicator" class="hidden items-center justify-center py-4">
                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-batik-red"></div>
                <span class="ml-2 text-sm text-stone-600">Menghitung ongkir...</span>
            </div>
        </div>

        {{-- Ringkasan Pembayaran --}}
        <div class="bg-gradient-to-r from-white to-stone-50 border border-stone-200 rounded-xl p-5 mb-6 shadow-sm">
            <h4 class="font-bold text-stone-800 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-batik-red" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4z" clip-rule="evenodd"/>
                    <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                </svg>
                Ringkasan Pembayaran
            </h4>

            <div class="space-y-3">
                <div class="flex justify-between items-center pb-3 border-b border-stone-100">
                    <span class="text-stone-600">Subtotal Produk</span>
                    <span class="font-medium text-stone-800">Rp {{ number_format($product->price) }}</span>
                </div>

                <div class="flex justify-between items-center pb-3 border-b border-stone-100">
                    <span class="text-stone-600">Ongkos Kirim</span>
                    <span class="font-medium text-stone-800" id="shipping-cost-display">Rp 0</span>
                </div>

                <div class="flex justify-between items-center pt-3">
                    <span class="text-lg font-bold text-stone-800">Total Pembayaran</span>
                    <span class="text-xl font-bold text-batik-red" id="total-price-display">
                        Rp {{ number_format($product->price) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Tombol Submit --}}
        <button
            type="submit"
            id="btn-submit"
            class="w-full bg-gradient-to-r from-stone-300 to-stone-400 text-stone-600 px-4 py-4 rounded-xl font-bold text-sm cursor-not-allowed transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 disabled:transform-none disabled:hover:shadow-md"
            disabled
        >
            <div class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                </svg>
                <span>Pilih Ongkir Dulu</span>
            </div>
        </button>

        {{-- Info Tambahan --}}
        <p class="text-xs text-stone-500 text-center mt-4">
            <svg class="w-3 h-3 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            Data Anda aman dan terlindungi
        </p>
    </form>
</div>

{{-- Script --}}
<script>
    const productPrice  = {{ $product->price }};
    const productWeight = {{ $product->weight ?? 1000 }}; // gram
    const csrfToken     = '{{ csrf_token() }}';

    const provinceSelect  = document.getElementById('province');
    const citySelect      = document.getElementById('city');
    const courierSelect   = document.getElementById('courier');
    const serviceSelect   = document.getElementById('service');
    const loadingIndicator = document.getElementById('loading-indicator');

    const shippingCostDisplay = document.getElementById('shipping-cost-display');
    const totalPriceDisplay   = document.getElementById('total-price-display');

    // --------------- 1. LOAD PROVINSI ---------------
    async function loadProvinces() {
        try {
            const res  = await fetch('{{ route('shipping.provinces') }}');
            const data = await res.json();

            provinceSelect.innerHTML = '<option value="">-- Pilih Provinsi --</option>';

            data.data.forEach(function (prov) {
                const opt   = document.createElement('option');
                opt.value   = prov.id;
                opt.textContent = prov.name;
                provinceSelect.appendChild(opt);
            });
        } catch (e) {
            console.error(e);
            alert('Gagal memuat daftar provinsi');
        }
    }

    // --------------- 2. LOAD KOTA SAAT PROVINSI DIPILIH ---------------
    provinceSelect.addEventListener('change', async function () {
        const provinceId = this.value;

        citySelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
        citySelect.disabled  = true;

        serviceSelect.innerHTML = '<option value="">-- Cek Ongkir Dulu --</option>';
        serviceSelect.disabled  = true;

        resetOngkir();

        if (!provinceId) return;

        try {
            // Add loading state
            citySelect.classList.add('opacity-50');

            const url = '{{ route('shipping.cities') }}' + '?province_id=' + encodeURIComponent(provinceId);
            const res = await fetch(url);
            const data = await res.json();

            citySelect.disabled = false;
            citySelect.classList.remove('opacity-50');

            data.data.forEach(function (city) {
                const opt   = document.createElement('option');
                opt.value   = city.id;
                opt.textContent = city.name;
                citySelect.appendChild(opt);
            });
        } catch (e) {
            console.error(e);
            alert('Gagal memuat daftar kota');
            citySelect.classList.remove('opacity-50');
        }
    });

    // --------------- 3. HITUNG ONGKIR SAAT KOTA / KURIR BERUBAH ---------------
    citySelect.addEventListener('change', function () {
        document.getElementById('destination_city_id').value = this.value || '';
        checkShippingCost();
    });

    courierSelect.addEventListener('change', checkShippingCost);

    async function checkShippingCost() {
        const cityId  = citySelect.value;
        const courier = courierSelect.value;

        serviceSelect.innerHTML = '<option value="">-- Cek Ongkir Dulu --</option>';
        serviceSelect.disabled  = true;
        resetOngkir();

        if (!cityId || !courier) return;

        try {
            // Show loading indicator
            loadingIndicator.classList.remove('hidden');
            serviceSelect.classList.add('opacity-50');

            const res = await fetch('{{ route('shipping.calculate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    origin_id: {{ (int) config('rajaongkir.origin_city_id') }},
                    destination_id: cityId,
                    weight: productWeight,
                    courier: courier,
                }),
            });

            const data = await res.json();

            // Hide loading indicator
            loadingIndicator.classList.add('hidden');
            serviceSelect.classList.remove('opacity-50');

            if (!res.ok) {
                console.error(data);
                alert(data.message || 'Gagal menghitung ongkir');
                return;
            }

            serviceSelect.innerHTML = '<option value="">-- Pilih Layanan --</option>';

            data.data.forEach(function (service) {
                const opt = document.createElement('option');
                opt.value = service.service_code;
                opt.textContent = service.service_name + ' (' + service.etd + ' hari)';
                opt.dataset.cost = service.cost;

                // Add color coding based on service
                if (service.service_name.toLowerCase().includes('express') || service.service_name.toLowerCase().includes('cepat')) {
                    opt.classList.add('text-green-600');
                } else if (service.service_name.toLowerCase().includes('reguler')) {
                    opt.classList.add('text-blue-600');
                } else if (service.service_name.toLowerCase().includes('ekonomi')) {
                    opt.classList.add('text-orange-600');
                }

                serviceSelect.appendChild(opt);
            });

            serviceSelect.disabled = false;
        } catch (e) {
            console.error(e);
            alert('Gagal menghitung ongkir');
            loadingIndicator.classList.add('hidden');
            serviceSelect.classList.remove('opacity-50');
        }
    }

    // --------------- 4. SAAT LAYANAN DIPILIH: UPDATE ONGKIR & TOTAL ---------------
    serviceSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const ongkir   = selected.dataset.cost ? parseInt(selected.dataset.cost, 10) : 0;

        const total    = productPrice + ongkir;

        // Animate price change
        shippingCostDisplay.style.transform = 'scale(1.1)';
        totalPriceDisplay.style.transform = 'scale(1.1)';

        setTimeout(() => {
            shippingCostDisplay.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(ongkir);
            totalPriceDisplay.innerText   = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);

            shippingCostDisplay.style.transform = 'scale(1)';
            totalPriceDisplay.style.transform = 'scale(1)';
        }, 150);

        document.getElementById('shipping_cost').value = ongkir;
        document.getElementById('total_price').value   = total;

        const btn = document.getElementById('btn-submit');
        btn.disabled = false;
        btn.classList.remove('from-stone-300', 'to-stone-400', 'text-stone-600', 'cursor-not-allowed');
        btn.classList.add('from-batik-gold', 'to-yellow-500', 'text-batik-red', 'hover:from-yellow-400', 'hover:to-yellow-600');
        btn.innerHTML = `
            <div class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>Lanjut ke Pembayaran</span>
            </div>
        `;
    });

    // --------------- UTIL: RESET ONGKIR ---------------
    function resetOngkir() {
        shippingCostDisplay.innerText = 'Rp 0';
        totalPriceDisplay.innerText   = 'Rp ' + new Intl.NumberFormat('id-ID').format(productPrice);
        document.getElementById('shipping_cost').value = 0;
        document.getElementById('total_price').value   = productPrice;

        const btn = document.getElementById('btn-submit');
        btn.disabled = true;
        btn.classList.remove('from-batik-gold', 'to-yellow-500', 'text-batik-red', 'hover:from-yellow-400', 'hover:to-yellow-600');
        btn.classList.add('from-stone-300', 'to-stone-400', 'text-stone-600', 'cursor-not-allowed');
        btn.innerHTML = `
            <div class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                </svg>
                <span>Pilih Ongkir Dulu</span>
            </div>
        `;
    }

    // Add hover effects to form inputs
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-batik-red/10', 'rounded-xl');
        });

        element.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-batik-red/10', 'rounded-xl');
        });
    });

    // Panggil saat halaman pertama kali dibuka
    loadProvinces();
</script>
