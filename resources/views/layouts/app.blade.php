<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Velora Co') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tempat untuk CSS tambahan dari child views --}}
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-900 min-h-screen flex flex-col">

    {{-- navigation --}}
    @include('layouts.navigation')

    {{-- Optional header section (child views dapat men-set @section('header') ) --}}
    @hasSection('header')
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('header')
            </div>
        </header>
    @endif

    {{-- Main content area: child views harus @section('content') --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer: include sekali di layout, setelah main --}}
    @include('layouts.footer')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // Ambil semua form add to cart
    document.querySelectorAll('form[action="{{ route('cart.add') }}"]').forEach(form => {
        form.addEventListener("submit", async function (e) {
            e.preventDefault(); // Stop reload

            const btn = form.querySelector("button");
            const card = form.closest(".group") || form.closest(".product-card");
            const cartIcon = document.querySelector(".cart-icon");
            const formData = new FormData(form);

            btn.disabled = true;
            btn.classList.add("opacity-50");

            // kirim AJAX
            const res = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "Accept": "application/json",
                },
                body: formData
            });

            const json = await res.json();

            btn.disabled = false;
            btn.classList.remove("opacity-50");

            // ✔ ANIMASI 1: tombol berubah hijau
            btn.classList.add("bg-green-600");
            setTimeout(() => btn.classList.remove("bg-green-600"), 600);

            // ✔ ANIMASI 2: produk goyang
            if (card) {
                card.classList.add("shake");
                setTimeout(() => card.classList.remove("shake"), 500);
            }

            // ✔ ANIMASI 3: keranjang bounce
            if (cartIcon) {
                cartIcon.classList.add("cart-bounce");
                setTimeout(() => cartIcon.classList.remove("cart-bounce"), 700);
            }

            // ✔ update badge cart count
            const badge = document.querySelector(".cart-count");
            if (badge) badge.textContent = json.cart_count;
        });
    });
});
</script>

<style>
/* Shake effect item */
.shake {
    animation: shakeAnim 0.4s ease;
}
@keyframes shakeAnim {
    0% { transform: translateX(0); }
    25% { transform: translateX(-4px); }
    50% { transform: translateX(4px); }
    75% { transform: translateX(-3px); }
    100% { transform: translateX(0); }
}

/* Bounce icon cart */
.cart-bounce {
    animation: cartBounce 0.6s ease;
}
@keyframes cartBounce {
    0% { transform: scale(1); }
    40% { transform: scale(1.2); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); }
}
</style>

</body>
</html>
