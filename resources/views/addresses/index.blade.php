@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Alamat</h1>

        <a href="{{ route('addresses.create') }}"
           class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 transition">
            + Tambah Alamat
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 rounded-md border border-green-200 bg-green-50 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(auth()->user()->addresses->isEmpty())
        <div class="p-6 text-center bg-gray-50 border rounded-lg">
            <p class="text-gray-600">Belum ada alamat tersimpan.</p>
            <a href="{{ route('addresses.create') }}" class="text-indigo-600 hover:underline text-sm">Tambah sekarang</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach(auth()->user()->addresses as $addr)
                <div class="border rounded-lg shadow-sm bg-white p-5 hover:shadow-md transition">

                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="font-semibold text-gray-800 text-lg">
                                    {{ $addr->label ?? 'Alamat' }}
                                </h2>

                                @if($addr->is_default)
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">
                                        Default
                                    </span>
                                @endif
                            </div>

                            <p class="text-gray-600 text-sm mt-1">
                                {{ $addr->receiver_name }} • {{ $addr->phone }}
                            </p>

                            <p class="text-gray-700 text-sm mt-2 leading-relaxed">
                                {{ $addr->address }}
                                @if($addr->city), {{ $addr->city }}@endif
                                @if($addr->postal_code) • {{ $addr->postal_code }}@endif
                                @if($addr->province)
                                    <br><span class="text-xs text-gray-500">{{ $addr->province }}</span>
                                @endif
                            </p>
                        </div>

                        <div class="flex flex-col items-end gap-2 text-sm">
                            <a href="{{ route('addresses.edit', $addr) }}"
                               class="text-indigo-600 hover:underline">Edit</a>

                            <form method="POST" action="{{ route('addresses.destroy', $addr) }}"
                                  onsubmit="return confirm('Hapus alamat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>

                            @if(!$addr->is_default)
                                <form method="POST" action="{{ route('addresses.set-default', $addr) }}">
                                    @csrf
                                    <button type="submit"
                                            class="text-gray-700 hover:underline">
                                        Jadikan Default
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
