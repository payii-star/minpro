<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                    <a href="{{ url('/') }}" class="flex items-center gap-1">
                        <span class="text-black-900">Velora</span><span class="text-black-600"> Co</span>
                    </a>
                </h1>

                <!-- Navigation Links (desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="#baju" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Baju</a>
                    <a href="#celana" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Celana</a>
                    <a href="#jaket" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Jaket</a>
                </div>
            </div>

            <div class="flex items-center">
                <!-- Cart (desktop) -->
                <div class="hidden sm:flex sm:items-center sm:mr-4">
                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-gray-800 hover:bg-gray-50 transition ease-in-out duration-150">
                        <!-- Cart icon -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 6h14l-2-6M10 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>

                        <!-- Count badge -->
                        <span class="ml-2 text-sm">Cart</span>
                        <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-semibold leading-none bg-gray-100 text-gray-800">
                            {{ $cartCount ?? (session('cart') ? count(session('cart')) : 0) }}
                        </span>
                    </a>
                </div>

                <!-- Right side: auth links or user dropdown -->
                @guest
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-800">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-semibold text-gray-900 bg-gray-100 px-3 py-1 rounded-full hover:bg-gray-200">Register</a>
                        @endif
                    </div>
                @else
                    <!-- Settings Dropdown (desktop) -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-gray-800 focus:outline-none transition ease-in-out duration-150">
                                    <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="ml-2 hidden sm:inline">{{ Auth::user()->name }}</span>

                                    <svg class="ml-2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('dashboard')">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Mobile hamburger handled below -->
                @endguest

                <!-- Hamburger (mobile) -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" aria-controls="mobile-menu" aria-expanded="false">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="#baju" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-700 hover:bg-gray-50">Baju</a>
            <a href="#celana" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-700 hover:bg-gray-50">Celana</a>
            <a href="#jaket" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-700 hover:bg-gray-50">Jaket</a>
        </div>

        <!-- Mobile cart -->
        <div class="pt-2 pb-3 border-t border-gray-200 px-4">
            <a href="{{ route('cart.index') }}" class="flex items-center justify-between py-2">
                <div class="flex items-center gap-3">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 6h14l-2-6M10 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                    <span class="font-medium text-base text-gray-700">Cart</span>
                </div>
                <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-semibold leading-none bg-gray-100 text-gray-800">
                    {{ $cartCount ?? (session('cart') ? count(session('cart')) : 0) }}
                </span>
            </a>
        </div>

        @guest
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <a href="{{ route('login') }}" class="block text-base font-medium text-gray-800 py-2">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block mt-1 text-base font-medium text-gray-800 py-2">Register</a>
                    @endif
                </div>
            </div>
        @else
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endguest
    </div>
</nav>
