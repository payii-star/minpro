@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Halo, {{ Auth::user()->name }} 👋</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Kartu ringkasan pesanan -->
        <div class="bg-white border rounded-xl shadow p-5">
            <h2 class="font-semibold text-gray-700 text-lg mb-2">Pesanan Saya</h2>
            <p class="text-gray-500 mb-3 text-sm">Lihat dan kelola semua pesanan kamu.</p>
            <a href="{{ route('checkout.index') }}" class="inline-block bg-black text-white px-4 py-2 rounded-full text-sm hover:bg-gray-800">Lihat Pesanan</a>
        </div>

        <!-- Kartu ringkasan keranjang -->
        <div class="bg-white border rounded-xl shadow p-5">
            <h2 class="font-semibold text-gray-700 text-lg mb-2">Keranjang Belanja</h2>
            <p class="text-gray-500 mb-3 text-sm">Masih ada barang yang ingin kamu beli?</p>
            <a href="{{ route('cart.index') }}" class="inline-block bg-black text-white px-4 py-2 rounded-full text-sm hover:bg-gray-800">Lihat Keranjang</a>
        </div>

        <!-- Kartu ringkasan profil -->
        <div class="bg-white border rounded-xl shadow p-5">
            <h2 class="font-semibold text-gray-700 text-lg mb-2">Profil Akun</h2>
            <p class="text-gray-500 mb-3 text-sm">Ubah informasi akun kamu, seperti nama atau email.</p>
            <a href="{{ route('profile.edit') }}" class="inline-block bg-black text-white px-4 py-2 rounded-full text-sm hover:bg-gray-800">Edit Profil</a>
        </div>

    </div>

    <!-- Seksi tambahan -->
    <div class="mt-10 bg-gray-50 border rounded-xl p-6">
        <h2 class="font-semibold text-gray-800 mb-3">Pesanan Terakhir</h2>
        <p class="text-gray-600 text-sm mb-3">Kamu belum memiliki pesanan aktif.</p>
        <a href="{{ url('/') }}" class="text-indigo-600 hover:underline text-sm">Belanja sekarang →</a>
    </div>
</div>
@endsection
