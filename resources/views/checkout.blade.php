<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Checkout</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-6 py-10">
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Alamat Pengiriman</h3>
            <form method="POST" action="{{ route('checkout.process') }}">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full p-2 border rounded">
                    @error('name') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">Alamat</label>
                    <textarea name="address" class="w-full p-2 border rounded">{{ old('address') }}</textarea>
                    @error('address') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full p-2 border rounded">
                    @error('phone') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold">Ringkasan Pesanan</h4>
                    @if(empty($cart))
                        <p class="text-sm text-gray-600">Keranjang kosong.</p>
                    @else
                        <ul class="mt-2 space-y-2">
                            @foreach($cart as $item)
                                <li class="flex justify-between"><span>{{ $item['name'] }} x {{ $item['qty'] }}</span><span>Rp {{ number_format($item['subtotal'],0,',','.') }}</span></li>
                            @endforeach
                        </ul>
                        <div class="mt-3 text-right font-semibold">Total: Rp {{ number_format($total,0,',','.') }}</div>
                    @endif
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('cart.index') }}" class="mr-2 px-4 py-2 border rounded">Kembali ke Keranjang</a>
                    <button class="px-4 py-2 bg-green-600 text-white rounded">Bayar / Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
