@extends('layouts.app')

@section('content')
@if(Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif
<div class="container mt-5">
    <h1>Product Details</h1>
    <div class="card">
        <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text"><strong>Description:</strong> {{ $product->description }}</p>
                <p class="card-text"><strong>Price:</strong> ₨ {{ $product->price }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Back to List</a>
        </div>
    </div>
</div>
@endsection
