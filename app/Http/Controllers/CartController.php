<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        if (!empty($cart)) {
            // safe: jika tidak ada 'subtotal' gunakan 0
            $subtotals = array_column($cart, 'subtotal') ?: [];
            $total = array_sum($subtotals);
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $id = $request->input('id');
        $qty = max(1, (int) $request->input('qty', 1));

        if (! $id) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Product id tidak diberikan'], 422);
            }
            return redirect()->back()->with('error', 'Product id tidak diberikan');
        }

        $product = Product::find($id);
        if (! $product) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        // ----- robust image resolution -----
        $imageUrl = null;

        // 1) coba accessor cover_url (jika ada)
        if (isset($product->cover_url) && $product->cover_url) {
            $imageUrl = $product->cover_url;
        }

        // 2) kalau belum, coba photos field (bisa string atau array)
        if (! $imageUrl && ! empty($product->photos)) {
            $photos = $product->photos;

            // kalau disimpan sebagai JSON string di DB (kadang terjadi), decode dulu
            if (is_string($photos)) {
                $decoded = json_decode($photos, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $photos = $decoded;
                } else {
                    // treat as single path string
                    $photos = [$photos];
                }
            }

            // ambil first non-empty
            if (is_array($photos)) {
                foreach ($photos as $p) {
                    if (! $p) continue;

                    // kalau sudah full URL
                    if (preg_match('/^https?:\\/\\//i', $p)) {
                        $imageUrl = $p;
                        break;
                    }

                    // kalau path relatif di disk 'public', gunakan Storage helper
                    // contoh path disimpan: "products/abc.jpg"
                    if (Storage::disk('public')->exists(ltrim($p, '/'))) {
                        $imageUrl = Storage::disk('public')->url(ltrim($p, '/')); // biasanya '/storage/..'
                        break;
                    }

                    // kalau p diawali "storage/" dan file ada di public path
                    if (str_starts_with($p, 'storage/') && file_exists(public_path($p))) {
                        $imageUrl = asset($p);
                        break;
                    }

                    // kalau file path di public path (misal 'images/..')
                    if (file_exists(public_path($p))) {
                        $imageUrl = asset($p);
                        break;
                    }
                }
            }
        }

        // 3) fallback ke placeholder kalau belum ada
        if (! $imageUrl) {
            $imageUrl = asset('model.jpg'); // ganti sesuai placeholder lo
        }

        // ----- simpan ke cart session -----
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
            $cart[$id]['subtotal'] = $cart[$id]['quantity'] * $cart[$id]['price'];
        } else {
            $price = (float) $product->price;
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $price,
                'quantity' => $qty,
                'subtotal' => $price * $qty,
                'image' => $imageUrl,
            ];
        }

        session(['cart' => $cart]);

        // Response untuk AJAX agar frontend bisa update tanpa reload
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => count($cart),
                'cart_total' => array_sum(array_column($cart, 'subtotal') ?: []),
                'item' => $cart[$id],
            ]);
        }

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $qty = max(1, (int) $request->input('qty', 1));
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $qty;
            $cart[$id]['subtotal'] = $cart[$id]['price'] * $qty;
            session(['cart' => $cart]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => count($cart),
                'cart_total' => array_sum(array_column($cart, 'subtotal') ?: []),
            ]);
        }

        return redirect()->back()->with('success', 'Keranjang diperbarui');
    }

    public function remove(Request $request)
    {
        $id = $request->input('id');
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => count($cart),
                'cart_total' => array_sum(array_column($cart, 'subtotal') ?: []),
            ]);
        }

        return redirect()->back()->with('success', 'Item dihapus dari keranjang');
    }
}
