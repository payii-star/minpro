@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-semibold text-gray-800 mb-8">Keranjang Belanja</h1>

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

    @php
        // $cart: array dari session atau dari controller
        $cart = $cart ?? session('cart', []);
        // total kalkulasi fallback
        $calculatedTotal = 0;
    @endphp

    @if(empty($cart))
        <div class="p-8 bg-white border rounded-lg shadow-sm text-center">
            <p class="text-lg text-gray-600">Keranjangmu masih kosong.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block px-4 py-2 bg-black text-white rounded-full hover:bg-black-700">Lanjut Belanja</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Items list -->
            <div class="lg:col-span-8">
                <div class="bg-white border rounded-lg shadow-sm divide-y">
                    @foreach($cart as $index => $item)
                        @php
                            // item['id'], item['name'], item['price'], item['quantity'] diharapkan ada
                            $id = $item['id'] ?? null;
                            $qty = intval($item['quantity'] ?? $item['qty'] ?? 1);
                            $price = $item['price'] ?? 0;

                            // coba ambil product dari DB supaya gambar/description/stok selalu up-to-date
                            $product = null;
                            if ($id) {
                                try {
                                    $product = \App\Models\Product::find($id);
                                } catch (\Throwable $e) {
                                    $product = null;
                                }
                            }

                            // Tentukan image: prioritas
                            // 1) kalau item punya image (session) -> gunakan (bisa absolute atau relatif)
                            // 2) kalau $product ada -> pakai cover_url accessor
                            // 3) fallback asset model.jpg
                            $img = $item['image'] ?? null;
                            if ($img) {
                                // jika relatif (tidak http...), anggap di storage
                                if (! preg_match('/^https?:\\/\\//i', $img)) {
                                    $img = asset('storage/' . ltrim($img, '/'));
                                }
                            } elseif ($product && ($product->cover_url ?? null)) {
                                $img = $product->cover_url;
                            } else {
                                $img = asset('model.jpg');
                            }

                            // tampilkan nama & description & stock jika ada product dari DB
                            $displayName = $product->name ?? ($item['name'] ?? 'Unnamed product');
                            $displayDesc = $product->description ?? ($item['description'] ?? null);
                            $displayStock = $product->stock ?? null;

                            // subtotal
                            $subtotal = ($item['subtotal'] ?? ($price * $qty));
                            $calculatedTotal += $subtotal;
                        @endphp

                        <div class="p-4 flex gap-4 items-start">
                            <!-- Thumbnail -->
                            <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-md overflow-hidden flex items-center justify-center">
                                <img src="{{ $img }}" alt="{{ $displayName }}" class="object-cover w-full h-full">
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="pr-4">
                                        <div class="font-medium text-gray-900 truncate">{{ $displayName }}</div>

                                        @if(!empty($displayDesc))
                                            <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ \Illuminate\Support\Str::limit($displayDesc, 120) }}</div>
                                        @endif

                                        @if(!is_null($displayStock))
                                            <div class="text-xs text-gray-500 mt-1">Stok: {{ $displayStock }}</div>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        <div class="text-gray-700 font-semibold">Rp {{ number_format($price, 0, ',', '.') }}</div>
                                        <div class="text-xs text-gray-400">/ pcs</div>
                                    </div>
                                </div>

                                <div class="mt-3 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <!-- Update qty form (buttons + input) -->
                                        <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-2" style="align-items:center;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button type="button" class="qty-decr inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded text-gray-700" data-id="{{ $id }}">−</button>

                                            <input type="number" name="qty" value="{{ $qty }}" min="1" class="w-16 text-center rounded border px-2 py-1" />

                                            <button type="button" class="qty-incr inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded text-gray-700" data-id="{{ $id }}">+</button>

                                            <button type="submit" class="ml-3 px-3 py-1 bg-black text-white rounded-full text-sm hover:bg-black-700">Update</button>
                                        </form>
                                    </div>

                                    <div class="text-sm text-gray-600">
                                        Subtotal<br>
                                        <span class="font-semibold text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="mt-3 flex items-center gap-3">
                                    <form method="POST" action="{{ route('cart.remove') }}" onsubmit="return confirm('Hapus item dari keranjang?')">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="text-red-600 text-sm hover:underline">Hapus</button>
                                    </form>

                                    {{-- optional: link to product detail jika product ada --}}
                                    @if($product)
                                        <a href="{{ route('products.show', $product->id ?? $id) }}" class="text-sm text-gray-600 hover:underline">Lihat detail</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Summary -->
            <div class="lg:col-span-4">
                <div class="bg-white border rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-medium text-gray-800">Ringkasan Pesanan</h3>

                    <div class="mt-4 space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <div>Subtotal</div>
                            <div class="font-medium text-gray-800">Rp {{ number_format($total ?? $calculatedTotal, 0, ',', '.') }}</div>
                        </div>

                        <div class="border-t pt-4 flex items-center justify-between">
                            <div class="text-sm text-gray-600">Total</div>
                            <div class="text-2xl font-semibold text-gray-900">Rp {{ number_format($total ?? $calculatedTotal, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('checkout.index') }}" class="block w-full text-center px-4 py-3 bg-black text-white rounded-full hover:bg-black-700">Proses Checkout</a>
                    </div>
                </div>

                {{-- Tips / actions --}}
                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:underline">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    /* optional helper */
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('click', function (e) {
    if (e.target.matches('.qty-incr')) {
        const form = e.target.closest('form');
        const input = form.querySelector('input[name="qty"]');
        input.value = Math.max(1, parseInt(input.value || 0) + 1);
    }
    if (e.target.matches('.qty-decr')) {
        const form = e.target.closest('form');
        const input = form.querySelector('input[name="qty"]');
        input.value = Math.max(1, (parseInt(input.value || 0) - 1));
    }
});
</script>
@endpush
@endsection
