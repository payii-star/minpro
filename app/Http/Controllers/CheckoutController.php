<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan halaman checkout.
     */
    public function index(Request $request)
    {
        // Ambil cart dari session (default empty array)
        $cartAssoc = session()->get('cart', []);

        // Jika tidak ada cart di session tetapi ada product_id di query (Buy Now flow),
        // buat satu item sementara untuk ditampilkan di checkout (tidak disimpan ke session).
        if ((empty($cartAssoc) || count($cartAssoc) === 0) && $request->filled('product_id')) {
            $productId = (int) $request->product_id;

            // TODO: kalau ada model Product, ambil data produk di sini untuk nama & price
            $cart = [
                [
                    'id' => $productId,
                    'name' => 'Produk #' . $productId,
                    'price' => 0,
                    'quantity' => 1,
                    'subtotal' => 0,
                ],
            ];
        } else {
            // Ubah associative cart (keyed by product id) jadi indexed array
            $cart = array_values($cartAssoc);
        }

        if (!is_array($cart)) {
            $cart = [];
        }

        // Hitung total (aman terhadap struktur yang mungkin tidak punya subtotal)
        $total = array_reduce($cart, function ($carry, $item) {
            $price = isset($item['price']) ? (float)$item['price'] : 0;
            $qty = isset($item['quantity']) ? (int)$item['quantity'] : (isset($item['qty']) ? (int)$item['qty'] : 1);
            $subtotal = isset($item['subtotal']) ? (float)$item['subtotal'] : ($price * $qty);
            return $carry + $subtotal;
        }, 0);

        // Determine selected address (priority: request->address_id, default, first)
        $selectedAddress = null;

        if ($request->filled('address_id')) {
            $selectedAddress = UserAddress::where('id', $request->address_id)
                ->where('user_id', auth()->id())
                ->first();
        }

        if (! $selectedAddress) {
            $selectedAddress = auth()->user()->addresses()->where('is_default', true)->first();
        }

        if (! $selectedAddress) {
            $selectedAddress = auth()->user()->addresses()->first();
        }

        return view('checkout', compact('cart', 'total', 'selectedAddress'));
    }

    /**
     * Proses checkout: buat Order & OrderItems, snapshot alamat, kosongkan cart.
     */
    public function process(Request $request)
    {
        $data = $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            // tambahkan validasi lain (payment_method, dsb.) kalau perlu
        ]);

        // ambil address dan pastikan milik user
        $address = UserAddress::where('id', $data['address_id'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // ambil cart dari session
        $cartAssoc = session()->get('cart', []);
        $cart = array_values($cartAssoc);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong. Tambahkan produk sebelum checkout.');
        }

        // hitung total ulang (safety)
        $total = array_reduce($cart, function ($carry, $item) {
            $price = isset($item['price']) ? (float)$item['price'] : 0;
            $qty = isset($item['quantity']) ? (int)$item['quantity'] : (isset($item['qty']) ? (int)$item['qty'] : 1);
            $subtotal = isset($item['subtotal']) ? (float)$item['subtotal'] : ($price * $qty);
            return $carry + $subtotal;
        }, 0);

        DB::beginTransaction();

        try {
            // buat order utama
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'pending',
                'address_snapshot' => $address->toArray(),
                'meta' => null,
            ]);

            // simpan tiap item
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'] ?? null,
                    'name' => $item['name'] ?? 'Unnamed',
                    'price' => $item['price'] ?? 0,
                    'quantity' => $item['quantity'] ?? $item['qty'] ?? 1,
                    'subtotal' => $item['subtotal'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? $item['qty'] ?? 1)),
                    'meta' => $item['meta'] ?? null,
                ]);
            }

            DB::commit();

            // kosongkan cart
            session()->forget('cart');

            // redirect ke halaman detail order supaya user langsung lihat hasilnya
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Checkout berhasil. Nomor order: ' . $order->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat membuat order: ' . $e->getMessage());
        }
    }
}
