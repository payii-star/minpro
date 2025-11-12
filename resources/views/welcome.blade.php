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
            <a href="#baju" id="btn-beli"
               class="inline-block bg-black text-white px-6 md:px-8 py-3 rounded-full btn-anim">
                Belanja Sekarang
            </a>
        </div>

        <div class="relative rounded-3xl overflow-hidden shadow-lg order-1 md:order-2 w-full md:w-[420px] h-[420px] md:h-[520px] ml-auto md:mr-8">
            <img src="{{ asset('model.jpg') }}" alt="Model Fashion" class="absolute inset-0 w-full h-full object-cover rounded-3xl">
        </div>
    </div>
</section>

<!-- Main produk -->
<main class="max-w-7xl mx-auto px-6 py-10 space-y-16">

    @php
        // contoh daftar harga
        $hargaBaju = [150000,135000,150000,165000,175000,190000,200000,215000,225000,240000];
        $hargaCelana = [180000,190000,200000,210000,220000,230000,250000,260000,270000,280000];
        $hargaJaket = [250000,260000,275000,290000,300000,310000,325000,340000,360000,380000];
    @endphp

    <!-- Baju -->
    <section id="baju" class="slide-up">
        <h3 class="text-2xl font-bold mb-6 border-b pb-2 border-gray-300">Baju</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @for ($i = 1; $i <= 10; $i++)
                @php
                    $imgPath = file_exists(public_path("images/model-{$i}.jpg")) ? asset("images/model-{$i}.jpg") : asset('model.jpg');
                @endphp

                <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <img src="{{ $imgPath }}" alt="Baju {{ $i }}" class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="p-4 space-y-2">
                        <h4 class="font-semibold text-gray-800">Baju Trendy {{ $i }}</h4>
                        <p class="text-gray-500 text-sm">Rp {{ number_format($hargaBaju[$i - 1], 0, ',', '.') }}</p>
                        <div class="flex gap-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $i }}">
                                <input type="hidden" name="product_type" value="baju">
                                <button class="w-full bg-black text-white text-sm py-2 rounded-full btn-anim" type="submit">Keranjang</button>
                            </form>

                            <form action="{{ route('checkout.index') }}" method="GET" class="flex-1">
                                <input type="hidden" name="product_id" value="{{ $i }}">
                                <button class="w-full bg-gray-900 text-white text-sm py-2 rounded-full btn-anim" type="submit">Checkout</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <!-- Celana -->
    <section id="celana" class="slide-up">
        <h3 class="text-2xl font-bold mb-6 border-b pb-2 border-gray-300">Celana Panjang</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @for ($i = 1; $i <= 10; $i++)
                @php
                    $imgIndex = 10 + $i;
                    $imgPath = file_exists(public_path("images/model-{$imgIndex}.jpg")) ? asset("images/model-{$imgIndex}.jpg") : asset('model.jpg');
                @endphp

                <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <img src="{{ $imgPath }}" alt="Celana {{ $i }}" class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="p-4 space-y-2">
                        <h4 class="font-semibold text-gray-800">Celana Panjang {{ $i }}</h4>
                        <p class="text-gray-500 text-sm">Rp {{ number_format($hargaCelana[$i - 1], 0, ',', '.') }}</p>
                        <div class="flex gap-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $imgIndex }}">
                                <input type="hidden" name="product_type" value="celana">
                                <button class="w-full bg-black text-white text-sm py-2 rounded-full btn-anim" type="submit">Keranjang</button>
                            </form>

                            <form action="{{ route('checkout.index') }}" method="GET" class="flex-1">
                                <input type="hidden" name="product_id" value="{{ $imgIndex }}">
                                <button class="w-full bg-gray-900 text-white text-sm py-2 rounded-full btn-anim" type="submit">Checkout</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <!-- Jaket -->
    <section id="jaket" class="slide-up">
        <h3 class="text-2xl font-bold mb-6 border-b pb-2 border-gray-300">Jaket</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @for ($i = 1; $i <= 10; $i++)
                @php
                    $imgIndex = 20 + $i;
                    $imgPath = file_exists(public_path("images/model-{$imgIndex}.jpg")) ? asset("images/model-{$imgIndex}.jpg") : asset('model.jpg');
                @endphp

                <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <img src="{{ $imgPath }}" alt="Jaket {{ $i }}" class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="p-4 space-y-2">
                        <h4 class="font-semibold text-gray-800">Jaket Stylish {{ $i }}</h4>
                        <p class="text-gray-500 text-sm">Rp {{ number_format($hargaJaket[$i - 1], 0, ',', '.') }}</p>
                        <div class="flex gap-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $imgIndex }}">
                                <input type="hidden" name="product_type" value="jaket">
                                <button class="w-full bg-black text-white text-sm py-2 rounded-full btn-anim" type="submit">Keranjang</button>
                            </form>

                            <form action="{{ route('checkout.index') }}" method="GET" class="flex-1">
                                <input type="hidden" name="product_id" value="{{ $imgIndex }}">
                                <button class="w-full bg-gray-900 text-white text-sm py-2 rounded-full btn-anim" type="submit">Checkout</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </section>

</main>

<!-- Animasi slide-up (CSS ringan) -->
@push('styles')
<style>
    .slide-up { opacity: 0; transform: translateY(20px); animation: slideUp 0.8s ease forwards; }
    @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }

    .btn-anim { transition: all 0.3s ease; }
    .btn-anim:hover { transform: scale(1.05); background-color: #6b21a8; }
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
