@extends('layouts.app')

@section('content')
<!-- Hero -->
<section class="pt-20 pb-16 bg-gray-100 slide-up">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div class="text-center md:text-left space-y-6 order-2 md:order-1">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                Tampil Percaya Diri <br> Dengan Gaya Minimalis ✨
            </h2>
            <p class="text-gray-600 text-lg">
                Pakaian kami hadir untuk kamu yang ingin tetap stylish, rapi, dan berkelas di setiap momen.
            </p>
            <a href="#products" id="btn-beli"
                class="inline-block bg-black text-white px-6 md:px-8 py-3 rounded-full btn-anim">
                Belanja Sekarang
            </a>
        </div>

        <div class="relative rounded-3xl overflow-hidden shadow-lg order-1 md:order-2 w-full md:w-[420px] h-[420px] md:h-[520px] ml-auto md:mr-8">
            <img src="{{ asset('modelvelora2.jpg') }}" alt="Model Fashion" class="absolute inset-0 w-full h-full object-cover rounded-3xl">
        </div>
    </div>
</section>

<!-- Main produk -->
<main class="max-w-7xl mx-auto px-6 py-10 space-y-16">

    @php
        // Pastikan $products disediakan oleh route/controller (collection atau paginator)
        $allProducts = $products ?? collect();

        // Pembagian berdasarkan posisi (tanpa DB category)
        $baju   = $allProducts->slice(0, 10);
        $celana = $allProducts->slice(10, 10);
        $jaket  = $allProducts->slice(20, 10);
    @endphp

    <!-- All products anchor (bila mau direct ke list) -->
    <div id="products"></div>

    {{-- Render section hanya kalau ada --}}
    @if($baju->isNotEmpty())
    <!-- Baju -->
    <section id="section-baju" class="slide-up">
        <h3 class="text-2xl font-bold mb-6 border-b pb-2 border-gray-300">Produk</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($baju as $product)
                <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <img src="{{ $product->cover_url ?? asset('model.jpg') }}" alt="{{ $product->name }}" class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="p-4 space-y-2">
                        <h4 class="font-semibold text-gray-800">{{ $product->name }}</h4>

                        @if(!empty($product->description))
                            <p class="text-gray-500 text-sm line-clamp-2">{{ $product->description }}</p>
                        @endif

                        <p class="text-gray-700 font-semibold">Rp {{ $product->formatted_price ?? number_format($product->price ?? 0, 0, ',', '.') }}</p>

                        @if(isset($product->stock))
                            @if($product->stock > 0)
                                <p class="text-gray-500 text-sm">Stok: {{ $product->stock }}</p>
                            @else
                                <p class="text-red-600 text-sm font-semibold">Stok habis</p>
                            @endif
                        @endif

                        <div class="flex gap-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <input type="hidden" name="qty" value="1">
                                <button class="w-full bg-black text-white text-sm py-2 rounded-full btn-anim" type="submit">Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($celana->isNotEmpty())
    <!-- Celana -->
    <section id="section-celana" class="slide-up">
        <h3 class="text-2xl font-bold mb-6 border-b pb-2 border-gray-300">Celana Panjang</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($celana as $product)
                <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <img src="{{ $product->cover_url ?? asset('model.jpg') }}" alt="{{ $product->name }}" class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="p-4 space-y-2">
                        <h4 class="font-semibold text-gray-800">{{ $product->name }}</h4>

                        @if(!empty($product->description))
                            <p class="text-gray-500 text-sm line-clamp-2">{{ $product->description }}</p>
                        @endif

                        <p class="text-gray-700 font-semibold">Rp {{ $product->formatted_price ?? number_format($product->price ?? 0, 0, ',', '.') }}</p>

                        @if(isset($product->stock))
                            @if($product->stock > 0)
                                <p class="text-gray-500 text-sm">Stok: {{ $product->stock }}</p>
                            @else
                                <p class="text-red-600 text-sm font-semibold">Stok habis</p>
                            @endif
                        @endif

                        <div class="flex gap-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <input type="hidden" name="qty" value="1">
                                <button class="w-full bg-black text-white text-sm py-2 rounded-full btn-anim" type="submit">Keranjang</button>
                            </form>

                            <form action="{{ route('checkout.index') }}" method="GET" class="flex-1">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="w-full bg-gray-900 text-white text-sm py-2 rounded-full btn-anim" type="submit">Checkout</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($jaket->isNotEmpty())
    <!-- Jaket -->
    <section id="section-jaket" class="slide-up">
        <h3 class="text-2xl font-bold mb-6 border-b pb-2 border-gray-300">Jaket</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($jaket as $product)
                <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <img src="{{ $product->cover_url ?? asset('model.jpg') }}" alt="{{ $product->name }}" class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="p-4 space-y-2">
                        <h4 class="font-semibold text-gray-800">{{ $product->name }}</h4>

                        @if(!empty($product->description))
                            <p class="text-gray-500 text-sm line-clamp-2">{{ $product->description }}</p>
                        @endif

                        <p class="text-gray-700 font-semibold">Rp {{ $product->formatted_price ?? number_format($product->price ?? 0, 0, ',', '.') }}</p>

                        @if(isset($product->stock))
                            @if($product->stock > 0)
                                <p class="text-gray-500 text-sm">Stok: {{ $product->stock }}</p>
                            @else
                                <p class="text-red-600 text-sm font-semibold">Stok habis</p>
                            @endif
                        @endif

                        <div class="flex gap-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <input type="hidden" name="qty" value="1">
                                <button class="w-full bg-black text-white text-sm py-2 rounded-full btn-anim" type="submit">Keranjang</button>
                            </form>

                            <form action="{{ route('checkout.index') }}" method="GET" class="flex-1">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="w-full bg-gray-900 text-white text-sm py-2 rounded-full btn-anim" type="submit">Checkout</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Jika semua section kosong, tampilkan placeholder umum --}}
    @if($baju->isEmpty() && $celana->isEmpty() && $jaket->isEmpty())
        <div class="py-10 text-center text-gray-600">
            <p class="text-lg font-medium">Produk belum tersedia.</p>
            <p class="mt-2">Cek kembali nanti atau tambahkan produk lewat admin.</p>
        </div>
    @endif

</main>

@push('styles')
<style>
    .slide-up { opacity: 0; transform: translateY(20px); animation: slideUp 0.8s ease forwards; }
    @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }

    .btn-anim { transition: all 0.3s ease; }
    .btn-anim:hover { transform: scale(1.05); background-color: #000000ff; }

    /* optional small helper (Tailwind plugin line-clamp recommended) */
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener("click", function (e) {
            const href = this.getAttribute("href");
            if (!href || href === '#') return;
            const targetElement = document.querySelector(href);
            if (!targetElement) return;
            e.preventDefault();
            window.scrollTo({ top: targetElement.offsetTop - 100, behavior: "smooth" });
            targetElement.classList.add("slide-up");
            setTimeout(() => targetElement.classList.remove("slide-up"), 800);
        });
    });

    const belanjaBtn = document.getElementById('btn-beli');
    if (belanjaBtn) {
        belanjaBtn.addEventListener("click", () => {
            belanjaBtn.classList.add("bg-red-600");
            setTimeout(() => belanjaBtn.classList.remove("bg-red-600"), 500);
        });
    }
});
</script>
@endpush
@endsection
