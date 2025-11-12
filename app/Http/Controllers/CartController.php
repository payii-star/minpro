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

        $qty = $data['qty'] ?? 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$data['id']])) {
            $cart[$data['id']]['qty'] += $qty;
            $cart[$data['id']]['subtotal'] = $cart[$data['id']]['qty'] * $cart[$data['id']]['price'];
        } else {
            $cart[$data['id']] = [
                'id' => $data['id'],
                'name' => $data['name'],
                'price' => $data['price'],
                'qty' => $qty,
                'subtotal' => $data['price'] * $qty,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    // Tampilkan isi keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + $item['subtotal'];
        }, 0);

        return view('cart', compact('cart', 'total'));
    }

    // Update kuantitas
    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'qty' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$data['id']])) {
            $cart[$data['id']]['qty'] = $data['qty'];
            $cart[$data['id']]['subtotal'] = $cart[$data['id']]['qty'] * $cart[$data['id']]['price'];
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
