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

    {{-- Tampilkan ringkasan alamat yang dipilih (otomatis default/first jika ada) --}}
    @if($selectedAddress)
        <div class="mb-6 p-4 border rounded bg-white">
            <div class="flex justify-between items-start">
                <div>
                    <div class="font-semibold">{{ $selectedAddress->receiver_name }} @if($selectedAddress->label) ({{ $selectedAddress->label }}) @endif</div>
                    <div class="text-sm text-gray-600">{{ $selectedAddress->phone }}</div>
                    <div class="mt-2 text-sm">{{ $selectedAddress->address }}@if($selectedAddress->city), {{ $selectedAddress->city }}@endif</div>
                    @if($selectedAddress->postal_code) <div class="text-xs text-gray-500 mt-1">Kode Pos: {{ $selectedAddress->postal_code }}</div> @endif
                </div>

                <div class="text-sm">
                    <a href="{{ route('addresses.edit', $selectedAddress) }}" class="text-indigo-600">Edit</a>
                </div>
            </div>
        </div>
    @else
        <div class="mb-6 p-4 border rounded bg-yellow-50">Belum ada alamat. <a href="{{ route('addresses.create') }}" class="text-black">Tambah alamat</a></div>
    @endif

    {{-- Form utama checkout --}}
    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        <input type="hidden" name="address_id" value="{{ $selectedAddress->id ?? '' }}">

        {{-- tampilkan ringkasan cart, total, payment fields, dll --}}
        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-black text-white rounded-full">Proses Checkout</button>
        </div>
    </form>
</div>
@endsection
