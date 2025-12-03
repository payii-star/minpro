<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
  <!-- Primary Navigation Menu -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-3 items-center h-16">

      <!-- Left: Logo -->
      <div class="flex items-center">
        <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
          <a href="{{ url('/') }}" class="flex items-center gap-1">
            <span class="text-black-900">Velora</span><span class="text-black-600"> Co</span>
          </a>
        </h1>
      </div>

      <!-- Center: now empty (no categories) -->
      <div class="flex justify-center">
        {{-- intentionally left blank: categories removed --}}
      </div>

      <!-- Right: Cart + Auth + Hamburger -->
      <div class="flex items-center justify-end space-x-4">

<!-- Cart (desktop) -->
<div class="hidden sm:flex sm:items-center">
  <a href="{{ route('cart.index') }}"
     class="relative inline-flex items-center px-3 py-2 cart-icon">

      <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2 6h14l-2-6M10 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" />
      </svg>

      <span class="ml-2 text-sm">Cart</span>

      <span class="cart-count ml-2 inline-flex items-center justify-center
                   px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
        {{ $cartCount ?? count(session('cart', [])) }}
      </span>
  </a>
</div>


        <!-- Auth links / dropdown (desktop) -->
        <div class="hidden sm:flex sm:items-center">
          @guest
            <div class="flex items-center space-x-3">
              <a href="{{ route('login') }}" class="px-4 py-1.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-full hover:bg-gray-100 hover:border-gray-400 transition-all duration-200 active:scale-95">Login</a>
              @if(Route::has('register'))
                <a href="{{ route('register') }}" class="px-4 py-1.5 bg-black text-white text-sm font-semibold rounded-full hover:bg-gray-800 transition-all duration-200 shadow-sm active:scale-95">Register</a>
              @endif
            </div>
          @else
            <x-dropdown align="right" width="48">
              <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-gray-800 focus:outline-none transition ease-in-out duration-150">
                  <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center text-sm font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                  <span class="ml-2 hidden sm:inline">{{ Auth::user()->name }}</span>
                  <svg class="ml-2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
              </x-slot>
              <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                <x-dropdown-link :href="route('dashboard')">{{ __('Dashboard') }}</x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">@csrf
                  <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                </form>
              </x-slot>
            </x-dropdown>
          @endguest
        </div>

        <!-- Mobile hamburger -->
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
      {{-- categories removed --}}
    </div>

    <!-- Mobile cart -->
    <div class="pt-2 pb-3 border-t border-gray-200 px-4">
      <a href="{{ route('cart.index') }}" class="flex items-center justify-between py-2">
        <div class="flex items-center gap-3">
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 6h14l-2-6M10 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" /></svg>
          <span class="font-medium text-base text-gray-700">Cart</span>
        </div>
        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-semibold leading-none bg-gray-100 text-gray-800">{{ $cartCount ?? (session('cart') ? count(session('cart')) : 0) }}</span>
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
      <div class="pt-4 pb-1 border-t border-gray-200">
        <div class="px-4">
          <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
          <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>

        <div class="mt-3 space-y-1">
          <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
          <x-responsive-nav-link :href="route('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
          <form method="POST" action="{{ route('logout') }}">@csrf
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
          </form>
        </div>
      </div>
    @endguest
  </div>
</nav>
