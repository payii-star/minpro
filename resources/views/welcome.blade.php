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
            <img src="{{ asset('modelvelora2.jpg') }}" alt="Model Fashion"
                 class="absolute inset-0 w-full h-full object-cover rounded-3xl">
        </div>
    </div>
</section>

<!-- Main produk -->
<main class="max-w-7xl mx-auto px-6 py-10 space-y-8">

    {{-- anchor untuk tombol belanja sekarang --}}
    <div id="products"></div>

    @php
        // Pastikan relasi kategori ke-load
        $products = ($products ?? collect())->load('category');
    @endphp

    {{-- FILTER BUTTON (tanpa refresh, pakai JS onclick) --}}
    <div class="flex flex-wrap gap-3 mb-6">
        <button type="button"
                class="filter-btn px-5 py-2 rounded-full border text-sm font-medium bg-black text-white"
                onclick="filterProducts('all')">
            Semua
        </button>

        <button type="button"
                class="filter-btn px-5 py-2 rounded-full border text-sm font-medium bg-white text-black"
                onclick="filterProducts('baju')">
            Baju
        </button>

        <button type="button"
                class="filter-btn px-5 py-2 rounded-full border text-sm font-medium bg-white text-black"
                onclick="filterProducts('celana')">
            Celana
        </button>

        <button type="button"
                class="filter-btn px-5 py-2 rounded-full border text-sm font-medium bg-white text-black"
                onclick="filterProducts('jaket')">
            Jaket
        </button>
    </div>

    <section class="slide-up">
        <h3 class="text-2xl font-bold mb-6 border-b pb-2 border-gray-300">
            Produk
        </h3>

        @if ($products->isNotEmpty())
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach ($products as $product)
                    <div class="product-card group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1"
                         data-category="{{ $product->category->slug ?? 'none' }}">
                        <img src="{{ $product->cover_url ?? asset('model.jpg') }}"
                             alt="{{ $product->name }}"
                             class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300">

                        <div class="p-4 space-y-2">
                            {{-- KATEGORI --}}
                            <p class="text-xs uppercase tracking-wide text-gray-400">
                                {{ $product->category?->name ?? 'Tanpa Kategori' }}
                            </p>

                            {{-- NAMA --}}
                            <h4 class="font-semibold text-gray-800">
                                {{ $product->name }}
                            </h4>

                            {{-- DESKRIPSI --}}
                            @if (!empty($product->description))
                                <p class="text-gray-500 text-sm line-clamp-2">
                                    {{ $product->description }}
                                </p>
                            @endif

                            {{-- HARGA --}}
                            <p class="text-gray-700 font-semibold">
                                Rp {{ $product->formatted_price ?? number_format($product->price ?? 0, 0, ',', '.') }}
                            </p>

                            {{-- STOK --}}
                            @if (isset($product->stock))
                                @if ($product->stock > 0)
                                    <p class="text-gray-500 text-sm">Stok: {{ $product->stock }}</p>
                                @else
                                    <p class="text-red-600 text-sm font-semibold">Stok habis</p>
                                @endif
                            @endif

                            {{-- BUTTON KERANJANG --}}
                            <div class="flex gap-2 mt-2">
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="name" value="{{ $product->name }}">
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button class="w-full bg-black text-white text-sm py-2 rounded-full btn-anim" type="submit">
                                        Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-10 text-center text-gray-600">
                <p class="text-lg font-medium">Produk belum tersedia.</p>
                <p class="mt-2">Cek kembali nanti atau tambahkan produk lewat admin.</p>
            </div>
        @endif
    </section>
</main>

@push('styles')
<style>
    .slide-up { opacity: 0; transform: translateY(20px); animation: slideUp 0.8s ease forwards; }
    @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }

    .btn-anim { transition: all 0.3s ease; }
    .btn-anim:hover { transform: scale(1.05); background-color: #000000ff; }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ANIMASI PRODUK MUNCUL */
    .product-card {
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .product-card.product-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

<script>
    // fungsi global, dipanggil dari onclick di tombol filter
    function filterProducts(filter) {
        const buttons = document.querySelectorAll('.filter-btn');
        const cards   = document.querySelectorAll('.product-card');

        if (!buttons.length || !cards.length) return;

        // reset style tombol
        buttons.forEach(btn => {
            btn.classList.remove('bg-black', 'text-white');
            btn.classList.add('bg-white', 'text-black');
        });

        // aktifkan tombol sesuai filter
        buttons.forEach(btn => {
            const onclick = btn.getAttribute('onclick') || '';
            if (onclick.includes("'" + filter + "'")) {
                btn.classList.add('bg-black', 'text-white');
                btn.classList.remove('bg-white', 'text-black');
            }
        });

        // show / hide produk + animasi muncul lagi saat difilter
        cards.forEach(card => {
            const cat = card.dataset.category || 'none';
            if (filter === 'all' || cat === filter) {
                card.style.display = 'block';
                card.classList.remove('product-visible');
                setTimeout(() => card.classList.add('product-visible'), 10);
            } else {
                card.style.display = 'none';
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        const belanjaBtn = document.getElementById('btn-beli');
        const cards = document.querySelectorAll('.product-card');
        const anchor = document.getElementById('products');

        // smooth scroll dengan OFFSET supaya filter kategori kelihatan
        if (belanjaBtn && anchor) {
            belanjaBtn.addEventListener("click", function (e) {
                e.preventDefault();

                // tinggi navbar kira-kira 100px, jadi geser sedikit lebih atas
                const offset = 80;
                const top = anchor.getBoundingClientRect().top + window.pageYOffset - offset;

                window.scrollTo({
                    top: top,
                    behavior: "smooth"
                });

                // animasi kecil di tombol
                belanjaBtn.classList.add("bg-red-600");
                setTimeout(() => belanjaBtn.classList.remove("bg-red-600"), 400);
            });
        }

        // ANIMASI PRODUK MUNCUL (IntersectionObserver)
        if ('IntersectionObserver' in window && cards.length) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('product-visible');
                        observer.unobserve(entry.target); // anim sekali
                    }
                });
            }, {
                threshold: 0.1
            });

            cards.forEach(card => observer.observe(card));
        } else {
            // fallback: langsung tampil kalau browser nggak support
            cards.forEach(card => card.classList.add('product-visible'));
        }

        // default: tampilkan semua produk
        filterProducts('all');
    });
</script>
@endsection
