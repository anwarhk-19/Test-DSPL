@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mt-4 text-center">
        <a href="{{ route('products.index') }}" class="btn btn-primary">
            <i class="fas fa-cogs"></i> Product CRUD with Action
        </a>
        
        <a href="{{ route('products-ajax-action.index') }}" class="btn btn-success">
            <i class="fas fa-database"></i> Product CRUD with Ajax
        </a>
        
        <a href="{{ route('dailer') }}" class="btn btn-warning">
            <i class="fas fa-phone"></i> Dialer
        </a>
    </div>
</div>
@endsection