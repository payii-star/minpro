<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Tambah item ke keranjang (session)
    public function add(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'qty' => 'nullable|integer|min:1'
        ]);

        // internal gunakan 'quantity' untuk konsistensi
        $quantity = $data['qty'] ?? 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$data['id']])) {
            $cart[$data['id']]['quantity'] += $quantity;
            $cart[$data['id']]['subtotal'] = $cart[$data['id']]['quantity'] * $cart[$data['id']]['price'];
        } else {
            $cart[$data['id']] = [
                'id' => $data['id'],
                'name' => $data['name'],
                'price' => $data['price'],
                'quantity' => $quantity,            // NOTE: pakai 'quantity'
                'subtotal' => $data['price'] * $quantity,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    // Tampilkan isi keranjang
    public function index()
    {
        $cartAssoc = session()->get('cart', []);
        $cart = array_values($cartAssoc); // jadikan indexed array untuk view

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['subtotal'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? 1)));
        }, 0);

        return view('cart', compact('cart', 'total'));
    }

    // Update kuantitas (menerima 'qty' atau 'quantity')
    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'qty' => 'nullable|integer|min:1',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $newQty = $data['qty'] ?? $data['quantity'] ?? null;

        if ($newQty === null) {
            return back()->with('error', 'Kuantitas tidak valid');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$data['id']])) {
            $cart[$data['id']]['quantity'] = (int) $newQty; // simpan ke key 'quantity'
            $cart[$data['id']]['subtotal'] = $cart[$data['id']]['quantity'] * $cart[$data['id']]['price'];
            session(['cart' => $cart]);
            return back()->with('success', 'Jumlah produk diperbarui');
        }

        return back()->with('error', 'Produk tidak ditemukan di keranjang');
    }

    // Hapus item
    public function remove(Request $request)
    {
        $data = $request->validate(['id' => 'required']);

        $cart = session()->get('cart', []);

        if (isset($cart[$data['id']])) {
            unset($cart[$data['id']]);
            session(['cart' => $cart]);
            return back()->with('success', 'Produk dihapus dari keranjang');
        }

        return back()->with('error', 'Produk tidak ditemukan');
    }
}
