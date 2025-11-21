@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
    @endif

    @if(empty($cart) || count($cart) === 0)
        <div class="bg-white border rounded-xl shadow p-6">
            <p class="text-gray-700 mb-4">Keranjang kosong. <a href="{{ url('/') }}" class="text-indigo-600 hover:underline">Lihat produk</a></p>
            <a href="{{ url('/') }}" class="inline-block bg-black text-white px-4 py-2 rounded-full text-sm hover:bg-gray-800">Belanja Sekarang</a>
        </div>
    @else
        <div class="bg-white border rounded-xl shadow overflow-hidden">
            <div class="p-4 border-b">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Ringkasan Keranjang</h2>
                        <p class="text-sm text-gray-500">Periksa barang dan jumlah sebelum melanjutkan ke checkout.</p>
                    </div>
                    <div class="text-sm text-gray-600">Item: {{ count($cart) }}</div>
                </div>
            </div>

            <div class="p-4 overflow-x-auto">
                <table class="w-full min-w-[720px]">
                    <thead class="bg-gray-50 text-left text-sm text-gray-600">
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
                            <td class="p-3 align-top">
                                <div class="flex items-center space-x-3">
                                    @if(!empty($item['image'] ?? null))
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-md">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center text-sm text-gray-400">No Image</div>
                                    @endif
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $item['name'] }}</div>
                                        @if(!empty($item['options'] ?? null))
                                            <div class="text-xs text-gray-500">{{ $item['options'] }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="p-3 align-top text-sm text-gray-700">Rp {{ number_format($item['price'],0,',','.') }}</td>

                            <td class="p-3 align-top">
                                <form method="POST" action="{{ route('cart.update') }}" class="flex items-center">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="w-20 p-1 border rounded">
                                    <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white rounded">Update</button>
                                </form>
                            </td>

                            <td class="p-3 align-top text-sm font-semibold">Rp {{ number_format($item['subtotal'],0,',','.') }}</td>

                            <td class="p-3 align-top">
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t flex flex-col md:flex-row items-center md:justify-between gap-3">
                <div class="text-sm text-gray-600">
                    <div>Total item: <span class="font-medium text-gray-800">{{ count($cart) }}</span></div>
                </div>

                <div class="text-right">
                    <div class="text-lg font-semibold">Total: Rp {{ number_format($total,0,',','.') }}</div>
                    <div class="mt-3 flex items-center gap-3 justify-end">
                        <a href="{{ url('/') }}" class="inline-block bg-gray-100 text-gray-800 px-4 py-2 rounded-full text-sm hover:bg-gray-200">Lanjut Belanja</a>
                        <a href="{{ route('checkout.index') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-full text-sm hover:bg-green-700">Lanjut ke Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
