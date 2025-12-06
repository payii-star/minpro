@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-6">Checkout</h1>

    {{-- Pilih alamat (submit GET supaya reload dengan selected address) --}}
    <form method="GET" action="{{ route('checkout.index') }}" class="mb-4">
        <label class="block text-sm font-medium mb-2">Pilih Alamat Pengiriman</label>
        <select name="address_id" onchange="this.form.submit()" class="mt-1 block w-full rounded border px-3 py-2">
            <option value="">-- Pilih alamat --</option>
            @foreach(auth()->user()->addresses as $addr)
                <option value="{{ $addr->id }}"
                    {{ (isset($selectedAddress) && $selectedAddress->id === $addr->id) ? 'selected' : '' }}>
                    {{ $addr->receiver_name }} — {{ \Illuminate\Support\Str::limit($addr->address, 60) }}
                    @if($addr->is_default) (Default) @endif
                </option>
            @endforeach
        </select>
    </form>

    {{-- Ringkasan alamat yang dipilih --}}
    @if($selectedAddress)
        <div class="mb-6 p-4 border rounded-xl bg-white shadow-sm">
            <div class="flex justify-between items-start gap-4">
                @php
                    $addr = $selectedAddress;
                @endphp

                <div class="space-y-1 text-sm text-gray-700">
                    {{-- Nama penerima + label --}}
                    <p class="font-semibold text-gray-900">
                        {{ $addr->receiver_name }}
                        @if($addr->label)
                            <span class="text-xs text-gray-500">
                                ({{ $addr->label }})
                            </span>
                        @endif
                    </p>

                    {{-- No HP --}}
                    <p>{{ $addr->phone }}</p>

                    {{-- Alamat lengkap: jalan, kota, provinsi --}}
                    <p>
                        {{ $addr->address }}
                        @if($addr->city), {{ $addr->city }}@endif
                        @if($addr->province), {{ $addr->province }}@endif
                    </p>

                    {{-- Kode pos --}}
                    @if($addr->postal_code)
                        <p class="text-xs text-gray-500">
                            Kode Pos: {{ $addr->postal_code }}
                        </p>
                    @endif
                </div>

                <div class="text-sm">
                    <a href="{{ route('addresses.edit', $selectedAddress) }}" class="text-indigo-600 hover:underline">
                        Edit
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="mb-6 p-4 border rounded bg-yellow-50 text-sm">
            Belum ada alamat.
            <a href="{{ route('addresses.create') }}" class="text-indigo-600 hover:underline">
                Tambah alamat
            </a>
        </div>
    @endif

    {{-- Form utama checkout --}}
    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        <input type="hidden" name="address_id" value="{{ $selectedAddress->id ?? '' }}">

        {{-- Nanti di sini bisa ditambah ringkasan cart, pilihan metode pembayaran, dll --}}
        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-black text-white rounded-full hover:bg-gray-900">
                Proses Checkout
            </button>
        </div>
    </form>
</div>
@endsection
