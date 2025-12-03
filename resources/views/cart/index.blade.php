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
        // $cart dari controller: array keyed by product id
        $cart = $cart ?? session()->get('cart', []);
        $total = $total ?? array_sum(array_column($cart, 'subtotal') ?: []);
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
                    @foreach($cart as $id => $item)
                        <div class="p-4 flex gap-4 items-start">
                            <!-- Thumbnail (robust handling: full URL OR relative storage path) -->
                            <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-md overflow-hidden flex items-center justify-center">
                                @php
                                    $img = $item['image'] ?? null;

                                    if ($img) {
                                        // jika bukan full URL
                                        if (!preg_match('/^https?:\\/\\//i', $img)) {
                                            // hindari double 'storage/storage'
                                            if (!str_starts_with($img, 'storage/')) {
                                                $img = asset('storage/' . ltrim($img, '/'));
                                            } else {
                                                $img = asset($img);
                                            }
                                        }
                                        // jika $img sekarang empty string -> null
                                        if ($img === '') {
                                            $img = null;
                                        }
                                    }
                                @endphp

                                @if(!empty($img))
                                    <img src="{{ $img }}" alt="{{ $item['name'] ?? 'Product' }}" class="object-cover w-full h-full">
                                @else
                                    <svg class="w-10 h-10 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h18v18H3z" />
                                    </svg>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="font-medium text-gray-900 truncate">{{ $item['name'] ?? 'Unnamed product' }}</div>
                                        @if(!empty($item['options'] ?? null))
                                            <div class="text-xs text-gray-500 mt-1">{{ $item['options'] }}</div>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        <div class="text-gray-700 font-semibold">Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</div>
                                        <div class="text-xs text-gray-400">/ pcs</div>
                                    </div>
                                </div>

                                <div class="mt-3 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <!-- Update qty form -->
                                        <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item['id'] ?? $id }}">
                                            <button type="button" class="qty-decr inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded text-gray-700">−</button>

                                            <input type="number" name="qty" value="{{ $item['quantity'] ?? $item['qty'] ?? 1 }}" min="1" class="w-16 text-center rounded border px-2 py-1" />

                                            <button type="button" class="qty-incr inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded text-gray-700">+</button>

                                            <button type="submit" class="ml-3 px-3 py-1 bg-black text-white rounded-full text-sm hover:bg-black-700">Update</button>
                                        </form>
                                    </div>

                                    <div class="text-sm text-gray-600">
                                        Subtotal<br>
                                        <span class="font-semibold text-gray-800">Rp {{ number_format($item['subtotal'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? $item['qty'] ?? 1)), 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="mt-3 flex items-center gap-3">
                                    <form method="POST" action="{{ route('cart.remove') }}" onsubmit="return confirm('Hapus item dari keranjang?')">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item['id'] ?? $id }}">
                                        <button type="submit" class="text-red-600 text-sm hover:underline">Hapus</button>
                                    </form>
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
                            <div class="font-medium text-gray-800">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</div>
                        </div>

                        <div class="border-t pt-4 flex items-center justify-between">
                            <div class="text-sm text-gray-600">Total</div>
                            <div class="text-2xl font-semibold text-gray-900">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('checkout.index') }}" class="block w-full text-center px-4 py-3 bg-black text-white rounded-full hover:bg-black-700">Proses Checkout</a>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:underline">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('click', function (e) {
    if (e.target.matches('.qty-incr')) {
        const container = e.target.closest('form');
        const input = container.querySelector('input[name="qty"]');
        input.value = Math.max(1, parseInt(input.value || 0) + 1);
    }
    if (e.target.matches('.qty-decr')) {
        const container = e.target.closest('form');
        const input = container.querySelector('input[name="qty"]');
        input.value = Math.max(1, (parseInt(input.value || 0) - 1));
    }
});
</script>
@endpush
