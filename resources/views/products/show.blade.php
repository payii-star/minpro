@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    <!-- breadcrumb optional -->
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:underline">Home</a> /
        <span>{{ $product->name }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        <!-- Product Image -->
        <div class="w-full">
            <img src="{{ $product->cover_url ?? asset('model.jpg') }}"
                    class="rounded-xl shadow w-full object-cover"
                    alt="{{ $product->name }}">
        </div>

        <!-- Product Info -->
        <div class="flex flex-col space-y-4">

            <h1 class="text-3xl font-bold text-gray-900">
                {{ $product->name }}
            </h1>

            @if($product->description)
                <p class="text-gray-600 leading-relaxed">
                    {{ $product->description }}
                </p>
            @endif

            <p class="text-2xl font-semibold text-black">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            @if($product->stock > 0)
                <p class="text-green-600 font-medium">
                    Stok tersedia: {{ $product->stock }}
                </p>
            @else
                <p class="text-red-600 font-medium">
                    Stok habis
                </p>
            @endif

            <!-- Add to cart -->
            <form action="{{ route('cart.add') }}" method="POST" class="pt-4">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="price" value="{{ $product->price }}">
                <input type="hidden" name="qty" value="1">
            </form>

        </div>

    </div>

</div>
@endsection
