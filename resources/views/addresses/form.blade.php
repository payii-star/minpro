@php $isEdit = isset($address); @endphp

<form method="POST" action="{{ $isEdit ? route('addresses.update', $address) : route('addresses.store') }}">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Label (Rumah / Kantor)</label>
            <input type="text" name="label" value="{{ old('label', $address->label ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   placeholder="Contoh: Rumah, Kantor, Orang Tua">
            @error('label') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Penerima</label>
            <input type="text" name="receiver_name" required value="{{ old('receiver_name', $address->receiver_name ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('receiver_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">No. HP</label>
            <input type="text" name="phone" required value="{{ old('phone', $address->phone ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   placeholder="0812xxxx">
            @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
            <textarea name="address" required rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                      placeholder="Jalan, Blok/No, RT/RW, Kecamatan">{{ old('address', $address->address ?? '') }}</textarea>
            @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Kota</label>
            <input type="text" name="city" value="{{ old('city', $address->city ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Provinsi</label>
            <input type="text" name="province" value="{{ old('province', $address->province ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Kode Pos</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="md:col-span-2 flex items-center space-x-3">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_default" value="1"
                       {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-700">Jadikan default</span>
            </label>
        </div>
    </div>

    <div class="mt-6 flex items-center space-x-3">
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm">
            {{ $isEdit ? 'Update Alamat' : 'Simpan Alamat' }}
        </button>

        <a href="{{ route('addresses.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
    </div>
</form>

<script>
    // fokus ke field pertama agar UX lebih nyaman
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.querySelector('input[name="label"]');
        if (el) el.focus();
    });
</script>
