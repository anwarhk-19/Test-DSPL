@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome to the Laravel Application</h1>
    <div class="mt-4">
        <!-- Button 1: Product CRUD with Action -->
        <a href="{{ route('products.index') }}" class="btn btn-primary">Product CRUD with Action</a>
        
        <!-- Button 2: Product CRUD with Ajax -->
        <a href="{{ route('products-ajax-action.index') }}" class="btn btn-success">Product CRUD with Ajax</a>
        
        <!-- Button 3: Dialer -->
        <a href="{{ route('dailer') }}" class="btn btn-warning">Dialer</a>
    </div>
</div>
@endsection