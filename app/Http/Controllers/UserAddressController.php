<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan semua alamat user
     */
    public function index()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('addresses.index', compact('addresses'));
    }

    /**
     * Form tambah alamat
     */
    public function create()
    {
        return view('addresses.create');
    }

    /**
     * Simpan alamat baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'nullable|string|max:100',
            'receiver_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string',
            'city' => 'nullable|string|max:150',
            'province' => 'nullable|string|max:150',
            'postal_code' => 'nullable|string|max:20',
            'is_default' => 'sometimes|boolean',
        ]);

        DB::transaction(function () use ($data) {
            if (!empty($data['is_default'])) {
                auth()->user()->addresses()->update(['is_default' => false]);
            }
            auth()->user()->addresses()->create($data);
        });

        return redirect()->route('addresses.index')->with('success','Alamat berhasil ditambahkan.');
    }

    /**
     * Form edit alamat
     */
    public function edit(UserAddress $address)
    {
        $this->authorize('manage', $address);
        return view('addresses.edit', compact('address'));
    }

    /**
     * Update alamat
     */
    public function update(Request $request, UserAddress $address)
    {
        $this->authorize('manage', $address);

        $data = $request->validate([
            'label' => 'nullable|string|max:100',
            'receiver_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string',
            'city' => 'nullable|string|max:150',
            'province' => 'nullable|string|max:150',
            'postal_code' => 'nullable|string|max:20',
            'is_default' => 'sometimes|boolean',
        ]);

        DB::transaction(function () use ($data, $address) {
            if (!empty($data['is_default'])) {
                auth()->user()->addresses()->update(['is_default' => false]);
            }
            $address->update($data);
        });

        return redirect()->route('addresses.index')->with('success','Alamat berhasil diupdate.');
    }

    /**
     * Hapus alamat
     */
    public function destroy(UserAddress $address)
    {
        $this->authorize('manage', $address);
        $address->delete();

        return redirect()->route('addresses.index')->with('success','Alamat berhasil dihapus.');
    }

    /**
     * Set alamat default
     */
    public function setDefault(UserAddress $address)
    {
        $this->authorize('manage', $address);

        DB::transaction(function () use ($address) {
            auth()->user()->addresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return back()->with('success','Alamat default berhasil diganti.');
    }
}
