<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Akun Anda</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 font-sans">

    <div class="w-[950px] bg-white rounded-3xl shadow-xl flex overflow-hidden border border-gray-200">

        <!-- Bagian kiri -->
        <div class="w-1/2 bg-gray-50 flex flex-col justify-center items-center p-10">
            <h1 class="text-4xl font-bold mb-4 text-gray-800 text-center">Selamat Datang Kembali!</h1>
            <p class="text-gray-600 text-center text-sm leading-relaxed">
                “Masuk ke akunmu dan lanjutkan eksplorasi gaya terbaikmu.
                Outfit impian cuma sejauh satu klik dari tanganmu!”😍
            </p>
        </div>

        <!-- Bagian kanan -->
        <div class="w-1/2 p-10 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Masuk ke Akun Anda</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Silakan masukkan data login anda</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="username"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                        placeholder="contoh@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                        placeholder="Masukkan kata sandi">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <!-- Tombol -->
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg shadow transition-all duration-200">
                    Masuk Sekarang
                </button>

                <p class="text-center text-sm text-gray-600 mt-3">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">Daftar di sini</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>
