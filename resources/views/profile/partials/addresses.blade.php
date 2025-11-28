{{-- resources/views/profile/partials/addresses.blade.php --}}
<div class="mt-8">
    <h2 class="text-xl font-semibold mb-3">Alamat Saya</h2>

    @if(auth()->user()->addresses->isEmpty())
        <div class="p-3 bg-yellow-50 border rounded">
            Belum ada alamat. <a href="{{ route('addresses.create') }}" class="text-indigo-600">Tambah sekarang</a>.
        </div>
    @else
        @foreach(auth()->user()->addresses as $addr)
            <div class="border rounded p-3 mb-3">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-medium">
                            {{ $addr->label ?? 'Alamat' }} @if($addr->is_default) <span class="text-sm text-blue-600">(Default)</span> @endif
                        </div>
                        <div class="text-sm text-gray-600">{{ $addr->receiver_name }} — {{ $addr->phone }}</div>
                    </div>

                    <div class="space-x-2 text-right">
                        <a href="{{ route('addresses.edit', $addr) }}" class="text-indigo-600 text-sm">Edit</a>

                        <form action="{{ route('addresses.destroy', $addr) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 text-sm" onclick="return confirm('Hapus alamat ini?')">Hapus</button>
                        </form>

                        @if(! $addr->is_default)
                            <form action="{{ route('addresses.set-default', $addr) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-gray-700">Jadikan Default</button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="mt-2 text-sm text-gray-700">
                    {{ $addr->address }}
                    @if($addr->city), {{ $addr->city }}@endif
                    @if($addr->postal_code) — {{ $addr->postal_code }}@endif
                    @if($addr->province) <br><span class="text-xs text-gray-500">{{ $addr->province }}</span> @endif
                </div>
            </div>
        @endforeach

        <a href="{{ route('addresses.create') }}" class="inline-block mt-2 text-sm text-indigo-600">+ Tambah alamat baru</a>
    @endif
</div>
