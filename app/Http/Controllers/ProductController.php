<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Tampilkan halaman detail produk.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
