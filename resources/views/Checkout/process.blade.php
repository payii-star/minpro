@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Konfirmasi & Pembayaran</h1>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-50 border text-green-700">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 rounded bg-red-50 border text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- KIRI: alamat + daftar barang --}}
        <div class="lg:col-span-8 space-y-6">

        <!-- KOTAK DIKIRIM KE -->
            <div class="bg-white border rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-gray-900">Dikirim ke</h2>

                <div class="mt-4 rounded-xl border bg-gray-50 p-4">
                    @php
                        $addr = $selectedAddress ?? $address ?? null;
                    @endphp

                    @if ($addr)
                        <div class="space-y-1 text-sm text-gray-700">
                            {{-- Nama penerima + label alamat --}}
                            <p class="font-semibold text-gray-900">
                                {{ $addr->receiver_name }}
                                <span class="text-xs text-gray-500">
                                    ({{ $addr->label }})
                                </span>
                            </p>

                            {{-- No HP --}}
                            <p>{{ $addr->phone }}</p>

                            <p>
                                {{ $addr->address }},
                                {{ $addr->city }},
                                {{ $addr->province }}
                            </p>

                            {{-- Kode Pos --}}
                            <p class="text-xs text-gray-500">
                                Kode Pos: {{ $addr->postal_code }}
                            </p>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">
                            Alamat tidak ditemukan. Silakan kembali dan pilih alamat pengiriman.
                        </p>
                    @endif
                </div>
            </div>
        </section>

            {{-- Daftar barang --}}
            <section class="bg-white border rounded-lg shadow-sm p-5">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">
                    Ringkasan Barang
                </h2>

                <div class="divide-y">
                    @foreach($cart as $item)
                        <div class="py-3 flex items-start justify-between gap-4">
                            <div class="flex gap-3 items-start">
                                {{-- Thumbnail kalau ada --}}
                                @php
                                    $img = $item['image'] ?? null;
                                    if ($img && !preg_match('/^https?:\\/\\//i', $img)) {
                                        if (!str_starts_with($img, 'storage/')) {
                                            $img = asset('storage/' . ltrim($img, '/'));
                                        } else {
                                            $img = asset($img);
                                        }
                                    }
                                @endphp

                                <div class="w-14 h-14 rounded-md bg-gray-100 overflow-hidden flex items-center justify-center">
                                    @if(!empty($img))
                                        <img src="{{ $img }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs text-gray-400">No Image</span>
                                    @endif
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $item['name'] ?? 'Produk' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Qty: {{ $item['quantity'] ?? $item['qty'] ?? 1 }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-right text-sm text-gray-800">
                                Rp {{ number_format($item['subtotal'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? $item['qty'] ?? 1)), 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        {{-- KANAN: total + metode pembayaran --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Total --}}
            <section class="bg-white border rounded-lg shadow-sm p-5">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">
                    Ringkasan Pembayaran
                </h2>

                <div class="space-y-3">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                    </div>

                    {{-- kalau nanti ada ongkir / diskon, tinggal tambahin di sini --}}

                    <div class="border-t pt-3 flex justify-between items-center">
                        <span class="text-sm text-gray-700">Total</span>
                        <span class="text-2xl font-semibold text-gray-900">
                            Rp {{ number_format($total ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </section>

            {{-- Metode pembayaran --}}
            <section class="bg-white border rounded-lg shadow-sm p-5">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">
                    Metode Pembayaran
                </h2>

                {{-- NANTI ini diganti Midtrans. Sekarang dummy pilihan manual --}}
                <form>
                    <div class="space-y-3 text-sm text-gray-700">
                        <label class="flex items-start gap-2">
                            <input type="radio" name="payment_method" value="bank_transfer" checked>
                            <div>
                                <p class="font-medium">Transfer Bank (Manual)</p>
                                <p class="text-xs text-gray-500">
                                    Setelah konfirmasi, kamu akan melihat instruksi transfer (BCA / BRI / lainnya).
                                </p>
                            </div>
                        </label>

                        <label class="flex items-start gap-2 opacity-60 cursor-not-allowed">
                            <input type="radio" disabled>
                            <div>
                                <p class="font-medium">Virtual Account / E-Wallet (Midtrans)</p>
                                <p class="text-xs text-gray-500">
                                    Segera hadir — akan otomatis generate VA / QRIS dari Midtrans.
                                </p>
                            </div>
                        </label>
                    </div>

                    {{-- Tombol ini sementara belum benar-benar membuat transaksi --}}
                    <button type="button"
                            class="mt-5 w-full px-4 py-3 bg-black text-white rounded-full text-sm font-medium hover:bg-black-700">
                        Konfirmasi & Bayar (Dummy)
                    </button>

                    <p class="mt-2 text-xs text-gray-500">
                        ⚠️ Saat ini tombol di atas belum terhubung ke Midtrans. Nanti kita sambung ke pembayaran sesungguhnya.
                    </p>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
