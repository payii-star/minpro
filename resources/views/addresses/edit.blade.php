@extends('layouts.app')

@section('content')
<div class="container px-4 py-6">
    <h1 class="text-2xl mb-4">Edit Alamat</h1>
    @include('addresses.form', ['address' => $address])
</div>
@endsection
