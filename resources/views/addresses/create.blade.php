@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <a href="{{ route('addresses.index') }}" class="inline-block text-sm text-gray-600 mb-4">← Kembali ke Daftar Alamat</a>

    <div class="bg-white border rounded-lg shadow-sm">
        <header class="px-6 py-6 border-b">
            <h1 class="text-2xl font-semibold text-gray-800" >Tambah Alamat</h1>
            <p class="text-sm text-gray-500 mt-1">Simpan alamat baru ke profilmu untuk dipakai saat checkout.</p>
        </header>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-100 text-red-700 rounded">
                    Mohon perbaiki kesalahan pada form.
                </div>
            @endif

            @include('addresses.form')
        </div>
    </div>
</div>
@endsection
