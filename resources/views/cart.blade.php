<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Keranjang Belanja</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-6 py-10">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        @if(empty($cart))
            <p>Keranjang kosong. <a href="{{ url('/') }}" class="text-blue-600">Lihat produk</a></p>
        @else
        <div class="bg-white border rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="p-3">Produk</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Jumlah</th>
                        <th class="p-3">Subtotal</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $item['name'] }}</td>
                        <td class="p-3">Rp {{ number_format($item['price'],0,',','.') }}</td>
                        <td class="p-3">
                            <form method="POST" action="{{ route('cart.update') }}" class="flex items-center">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item['id'] }}">
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="w-20 p-1 border rounded">
                                <button class="ml-2 px-3 py-1 bg-blue-600 text-white rounded">Update</button>
                            </form>
                        </td>
                        <td class="p-3">Rp {{ number_format($item['subtotal'],0,',','.') }}</td>
                        <td class="p-3">
                            <form method="POST" action="{{ route('cart.remove') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item['id'] }}">
                                <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 text-right border-t">
                <div class="text-lg font-semibold">Total: Rp {{ number_format($total,0,',','.') }}</div>
                <a href="{{ route('checkout.index') }}" class="inline-block mt-3 bg-green-600 text-white px-4 py-2 rounded">Lanjut ke Checkout</a>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
