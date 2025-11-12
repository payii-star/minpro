<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velora Co - Shop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .slide-up {
            opacity: 0;
            transform: translateY(50px);
            animation: slideUp 0.7s ease forwards;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 0;
            height: 2px;
            background: #000000ff; /* Merah */
            transition: width 0.3s ease;
        }
        .nav-link:hover {
            color: #000000ff;
        }
        .nav-link:hover::after {
            width: 100%;
        }

        /* Tombol animasi klik */
        .btn-anim {
            transition: all 0.3s ease;
        }
        .btn-anim:hover {
            background-color: #000000ff;
            transform: scale(1.05);
        }
        .btn-anim:active {
            transform: scale(0.95);
        }
    </style>
</head>

<body class="bg-white text-gray-900 font-sans">

<!-- 🌐 Navbar -->
<nav class="flex justify-between items-center px-10 py-4 bg-white shadow-sm sticky top-0 z-50 rounded-b-2xl">
    <h1 class="text-3xl font-extrabold tracking-tight">
        <span class="text-black-900">Velora</span><span class="text-black-600"> Co</span>
    </h1>

    <div class="flex space-x-8">
        <a href="#baju" class="nav-link text-black-800 font-medium">Baju</a>
        <a href="#celana" class="nav-link text-black-800 font-medium">Celana</a>
        <a href="#jaket" class="nav-link text-black-800 font-medium">Jaket</a>
    </div>

    <div class="flex items-center space-x-3 cursor-pointer group">
        <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center text-sm font-semibold group-hover:bg-black-600 transition-colors duration-300">
            V
        </div>
        <a href="#" class="nav-link font-semibold">Logout</a>
    </div>
</nav>

<!-- 💫 Hero Section -->
<section class="pt-24 pb-20 bg-gray-100 slide-up">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

        <!-- Slogan -->
        <div class="text-center md:text-left space-y-6 order-2 md:order-1">
            <h2 class="text-4xl font-bold text-gray-900 leading-tight">
                Tampil Percaya Diri <br> Dengan Gaya Minimalis ✨
            </h2>
            <p class="text-gray-600 text-lg">
                Pakaian kami hadir untuk kamu yang ingin tetap stylish, rapi, dan berkelas di setiap momen.</p>
            <a href="#baju" id="btn-beli"
            class="inline-block bg-black text-white px-8 py-3 rounded-full btn-anim">
                Belanja Sekarang
            </a>
        </div>

        <!-- Foto Model -->
        <div class="relative rounded-3xl overflow-hidden shadow-lg order-1 md:order-2 w-[420px] h-[520px] ml-auto md:mr-8">
            <img src="{{ asset('model.jpg') }}"
                alt="Model Fashion"
                class="absolute inset-0 w-full h-full object-cover rounded-3xl">
        </div>

    </div>
</section>

<!-- 🛍️ Section Produk -->
<main class="max-w-7xl mx-auto px-6 py-10 space-y-16">

    @php
        // 💰 Daftar harga produk 
        $hargaBaju = [150000, 135000, 150000, 165000, 175000, 190000, 200000, 215000, 225000, 240000];
        $hargaCelana = [180000, 190000, 200000, 210000, 220000, 230000, 250000, 260000, 270000, 280000];
        $hargaJaket = [250000, 260000, 275000, 290000, 300000, 310000, 325000, 340000, 360000, 380000];
    @endphp

    <!-- 🧥 Baju -->
    <section id="baju" class="slide-up">
        <h3 class="text-2xl font-bold mb-6 border-b pb-2 border-gray-300">Baju</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @for ($i = 1; $i <= 10; $i++)
            <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 slide-up">
                <img src="model.jpg={{ $i }}" alt="Baju {{ $i }}"
                    class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="p-4 space-y-2">
                    <h4 class="font-semibold text-gray-800">Baju Trendy {{ $i }}</h4>
                    <p class="text-gray-500 text-sm">Rp {{ number_format($hargaBaju[$i - 1], 0, ',', '.') }}</p>
                    <div class="flex gap-2">
                        <button class="flex-1 bg-black text-white text-sm py-2 rounded-full btn-anim">Keranjang</button>
                        <button class="flex-1 bg-gray-900 text-white text-sm py-2 rounded-full btn-anim">Checkout</button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </section>

    <!-- 👖 Celana -->
    <section id="celana" class="slide-up">
        <h3 class="text-2xl font-bold mb-6 border-b pb-2 border-gray-300">Celana Panjang</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @for ($i = 11; $i <= 20; $i++)
            <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 slide-up">
                <img src="model.jpg={{ $i }}" alt="Celana {{ $i - 10 }}"
                    class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="p-4 space-y-2">
                    <h4 class="font-semibold text-gray-800">Celana Panjang {{ $i - 10 }}</h4>
                    <p class="text-gray-500 text-sm">Rp {{ number_format($hargaCelana[$i - 11], 0, ',', '.') }}</p>
                    <div class="flex gap-2">
                        <button class="flex-1 bg-black text-white text-sm py-2 rounded-full btn-anim">Keranjang</button>
                        <button class="flex-1 bg-gray-900 text-white text-sm py-2 rounded-full btn-anim">Checkout</button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </section>

    <!-- 🧥 Jaket -->
    <section id="jaket" class="slide-up">
        <h3 class="text-2xl font-bold mb-6 border-b pb-2 border-gray-300">Jaket</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @for ($i = 21; $i <= 30; $i++)
            <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 slide-up">
                <img src="model.jpg={{ $i }}" alt="Jaket {{ $i - 20 }}"
                    class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="p-4 space-y-2">
                    <h4 class="font-semibold text-gray-800">Jaket Stylish {{ $i - 20 }}</h4>
                    <p class="text-gray-500 text-sm">Rp {{ number_format($hargaJaket[$i - 21], 0, ',', '.') }}</p>
                    <div class="flex gap-2">
                        <button class="flex-1 bg-black text-white text-sm py-2 rounded-full btn-anim">Keranjang</button>
                        <button class="flex-1 bg-gray-900 text-white text-sm py-2 rounded-full btn-anim">Checkout</button>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </section>

</main>

<!-- ✨ Animasi slide-up -->
<style>
    .slide-up {
        opacity: 0;
        transform: translateY(20px);
        animation: slideUp 0.8s ease forwards;
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-anim {
        transition: all 0.3s ease;
    }

    .btn-anim:hover {
        transform: scale(1.05);
        background-color: #6b21a8; /* ungu elegan */
    }
</style>


<!-- 🧾 Footer -->
<footer class="bg-gray-100 text-center py-6 text-sm text-gray-600 border-t border-gray-200 rounded-t-2xl">
    © {{ date('Y') }} Velora Co. All rights reserved.
</footer>

<!-- ⚙️ Script Animasi Scroll dan Klik -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll('a[href^="#"]');

    links.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            const targetId = this.getAttribute("href");
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                // Scroll halus ke section
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: "smooth"
                });

                // Efek muncul dari bawah
                targetElement.classList.add("slide-up");
                setTimeout(() => targetElement.classList.remove("slide-up"), 800);
            }
        });
    });

    // Efek saat klik "Belanja Sekarang"
    const belanjaBtn = document.getElementById('btn-beli');
    if (belanjaBtn) {
        belanjaBtn.addEventListener("click", () => {
            belanjaBtn.classList.add("bg-red-600");
            setTimeout(() => belanjaBtn.classList.remove("bg-red-600"), 500);
        });
    }
});
</script>

</body>
</html>
