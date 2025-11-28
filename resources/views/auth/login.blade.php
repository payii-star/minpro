<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Akun Anda</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex items-center justify-center 
    bg-gradient-to-br from-gray-900 via-black to-gray-950 font-sans">

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
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                            focus:ring-black focus:border-black bg-white"
                        placeholder="contoh@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password (with show/hide toggle) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>

                    <div class="relative">
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                                focus:ring-black focus:border-black bg-white pr-10"
                            placeholder="Masukkan kata sandi">

                        <!-- toggle button -->
                        <button type="button"
                                id="togglePassword"
                                aria-label="Tampilkan atau sembunyikan password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                            <!-- eye closed (visible by default) -->
                            <svg class="eye-closed h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.64-4.362m3.063-1.92A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.955 9.955 0 01-1.325 2.592M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3l18 18" />
                            </svg>

                            <!-- eye open (hidden by default) -->
                            <svg class="eye-open hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                        class="text-sm text-black hover:text-gray-800 font-medium">                            
                        </a>
                    @endif
                </div>

                <!-- Tombol -->
                <button type="submit"
                    class="w-full bg-black hover:bg-gray-900 active:scale-95 text-white font-semibold py-2.5 rounded-lg shadow transition-all duration-150">
                    Masuk Sekarang
                </button>


                <p class="text-center text-sm text-gray-600 mt-3">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-black hover:text-gray-800 font-medium">
                        Daftar di sini
                    </a>
                </p>
            </form>
        </div>
    </div>

    <!-- Toggle script: show/hide password -->
    <script>
    (function(){
        const toggleBtn = document.getElementById('togglePassword');
        if (!toggleBtn) return;

        const passwordInput = document.getElementById('password');
        const eyeOpen = toggleBtn.querySelector('.eye-open');
        const eyeClosed = toggleBtn.querySelector('.eye-closed');

        toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();

          // toggle input type
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

          // toggle icons
        if (eyeOpen && eyeClosed) {
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        }

          // keep focus on input and put caret at the end
            passwordInput.focus();
            const val = passwordInput.value;
            passwordInput.value = '';
            passwordInput.value = val;
        });
    })();
    </script>
</body>
</html>
