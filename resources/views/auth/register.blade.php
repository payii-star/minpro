<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex items-center justify-center 
    bg-gradient-to-br from-gray-900 via-black to-gray-950 font-sans">

    <div class="w-[950px] bg-white rounded-3xl shadow-xl flex overflow-hidden border border-gray-200">

        <!-- Bagian kiri -->
        <div class="w-1/2 bg-gray-50 flex flex-col justify-center items-center p-10">
            <h1 class="text-4xl font-bold mb-4 text-gray-800 text-center">Buat Akun Baru</h1>
            <p class="text-gray-600 text-center text-sm leading-relaxed">
                “Daftar sekarang dan dapatkan akses ke koleksi eksklusif, promo spesial, dan inspirasi fashion terkini setiap harinya!”😘   
            </p>
        </div>

        <!-- Bagian kanan -->
        <div class="w-1/2 p-10 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Silahkan daftar</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Isi data kamu di bawah ini dengan benar</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input id="name" name="name" type="text" required autofocus
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-black focus:border-black bg-white"
                        placeholder="Masukkan nama kamu">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required autocomplete="username"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-black focus:border-black bg-white"
                        placeholder="contoh@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password (with show/hide toggle) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>

                    <div class="relative">
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-black focus:border-black bg-white pr-10"
                            placeholder="Minimal 8 karakter">
                        <button type="button"
                                id="togglePassword"
                                aria-label="Tampilkan atau sembunyikan password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                            <!-- eye closed (visible) -->
                            <svg class="eye-closed h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.64-4.362m3.063-1.92A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.955 9.955 0 01-1.325 2.592M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3l18 18" />
                            </svg>

                            <!-- eye open (hidden) -->
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

                <!-- Konfirmasi Password (with show/hide toggle) -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>

                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-black focus:border-black bg-white pr-10"
                            placeholder="Ulangi kata sandi">
                        <button type="button"
                                id="togglePasswordConfirmation"
                                aria-label="Tampilkan atau sembunyikan konfirmasi password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                            <!-- eye closed (visible) -->
                            <svg class="eye-closed h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.64-4.362m3.063-1.92A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.955 9.955 0 01-1.325 2.592M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3l18 18" />
                            </svg>

                            <!-- eye open (hidden) -->
                            <svg class="eye-open hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Tombol -->
                <button type="submit"
                    class="w-full bg-black hover:bg-gray-900 active:scale-95 text-white font-semibold py-2.5 rounded-lg shadow transition-all duration-150">
                    Daftar Sekarang
                </button>


                <p class="text-center text-sm text-gray-600 mt-3">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-black hover:text-gray-800 font-medium">
                        Masuk di sini
                    </a>
                </p>
            </form>
        </div>
    </div>

    <!-- Toggle scripts: show/hide for both fields -->
    <script>
    (function(){
        // generic function to attach toggle behavior
        function attachToggle(toggleId, inputId) {
        const btn = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        if (!btn || !input) return;

        const eyeOpen = btn.querySelector('.eye-open');
        const eyeClosed = btn.querySelector('.eye-closed');

        btn.addEventListener('click', function(e){
            e.preventDefault();
            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');

            if (eyeOpen && eyeClosed) {
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
            }

            // keep focus and caret at end
            input.focus();
            const val = input.value;
            input.value = '';
            input.value = val;
        });
        }

        // attach to both password fields
        attachToggle('togglePassword', 'password');
        attachToggle('togglePasswordConfirmation', 'password_confirmation');
    })();
    </script>
</body>
</html>
