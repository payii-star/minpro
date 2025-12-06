<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Tampilkan halaman detail produk.
     */
    public function show(Product $product)
    {
        $product->load('category'); // load relasi kategori juga

        return view('products.show', compact('product'));
    }
}
