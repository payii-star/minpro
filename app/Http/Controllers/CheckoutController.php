<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;

class CheckoutController extends Controller
{
public function index(Request $request)
{
    $user = $request->user();
    $cart = session('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')
            ->with('error', 'Keranjangmu masih kosong.');
    }

    // Ambil semua alamat milik user
    $addresses = $user->addresses()->get(); // pastikan relasi addresses() ada di model User

    if ($addresses->isEmpty()) {
        return redirect()->route('addresses.index')
            ->with('error', 'Tambahkan alamat pengiriman terlebih dahulu.');
    }

    // 🔥 Tentukan alamat yang dipilih
    $selectedAddress = null;

    // Kalau user kirim ?address_id=... lewat select
    if ($request->filled('address_id')) {
        $selectedAddress = $addresses->firstWhere('id', (int) $request->address_id);
    }

    // Kalau belum ada (pertama kali buka halaman), pakai default / alamat pertama
    if (! $selectedAddress) {
        $selectedAddress = $addresses->firstWhere('is_default', true)
            ?? $addresses->first();
    }

    $total = collect($cart)->sum('subtotal');

    // 🟢 SESUAI NAMA FILE: resources/views/checkout.blade.php
    return view('checkout', [
        'cart'            => $cart,
        'addresses'       => $addresses,
        'selectedAddress' => $selectedAddress,   // <--- dikirim ke Blade
        'total'           => $total,
    ]);
}


    /**
     * STEP 2: Halaman proses / konfirmasi checkout.
     * Route: POST /checkout/process
     */
    public function process(Request $request)
    {
        $user = $request->user();
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjangmu masih kosong.');
        }

        // Validasi alamat dipilih
        $request->validate([
            'address_id' => ['required', 'integer', 'exists:user_addresses,id'],
        ]);

        // Pastikan alamat milik user yang login
        /** @var \App\Models\UserAddress $address */
        $address = $user->addresses()
            ->where('id', $request->address_id)
            ->firstOrFail();

        $total = collect($cart)->sum('subtotal');

        // NANTI di sini kita bikin Order + Midtrans.
        // Sekarang cuma tampilkan halaman konfirmasi.
        return view('checkout.process', [
            'cart'    => $cart,
            'address' => $address,
            'total'   => $total,
        ]);
    }
}
