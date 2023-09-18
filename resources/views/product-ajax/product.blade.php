@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Product List</h1>

    <!-- Product List -->
    {{-- <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productList">
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>${{ $product->price }}</td>
                <td>
                    <button class="btn btn-primary btn-sm edit-product" data-id="{{ $product->id }}">Edit</button>
                    <button class="btn btn-success btn-sm view-product" data-id="{{ $product->id }}">View</button>
                    <button class="btn btn-danger btn-sm delete-product" data-id="{{ $product->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> --}}

    <hr>

    <!-- Product Create/Update Form -->
    <h2>Add/Edit Product</h2>
    <form id="productForm">
        @csrf
        <input type="hidden" name="id" id="productId">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" id="cancelEdit">Cancel</button>
    </form>
</div>

<script>
$(document).ready(function () {
    // Edit Product


    $(document).on('click', '.edit-product', function () {
        var productId = $(this).data('id');
        var product = getProductById(productId);
        $('#productId').val(product.id);
        $('#name').val(product.name);
        $('#description').val(product.description);
        $('#price').val(product.price);
    });

    // Cancel Edit
    $('#cancelEdit').click(function () {
        $('#productId').val('');
        $('#name').val('');
        $('#description').val('');
        $('#price').val('');
    });

    // View Product
    $(document).on('click', '.view-product', function () {
        var productId = $(this).data('id');
        var product = getProductById(productId);

        // Display the product details however you prefer, e.g., in a modal
        alert('Product Name: ' + product.name + '\nDescription: ' + product.description + '\nPrice: $' + product.price);
    });

    // Delete Product
    $(document).on('click', '.delete-product', function () {
        var productId = $(this).data('id');
        
        $.ajax({
            type: 'DELETE',
            url: '/products/' + productId,
            success: function (response) {
                // Remove the product from the list
                $(this).closest('tr').remove();
            },
            error: function (error) {
                // Handle error
                console.error(error);
            }
        });
    });

    // Handle Form Submission
    $('#productForm').submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var productId = $('#productId').val();

        if (productId) {
            // Update Product
            $.ajax({
                type: 'PUT',
                url: '/products/' + productId,
                data: formData,
                success: function (response) {
                    // Update the product in the list
                    updateProductInList(response);
                    clearForm();
                },
                error: function (error) {
                    // Handle error
                    console.error(error);
                }
            });
        } else {
            // Create Product
            $.ajax({
                type: 'POST',
                url: '/products',
                data: formData,
                success: function (response) {
                    // Add the new product to the list
                    appendProductToList(response);
                    clearForm();
                },
                error: function (error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    });

    // Helper function to get product data by ID
    function getProductById(productId) {
        // Implement logic to retrieve product data based on productId
        // For example, you can use an AJAX request to fetch product details
        // Return the product object with id, name, description, and price
    }

    // Helper function to update product data in the list
    function updateProductInList(product) {
        // Implement logic to update the product data in the product list
    }

    // Helper function to append a new product to the list
    function appendProductToList(product) {
        // Implement logic to add the new product to the product list
    }

    function clearForm() {
        $('#productId').val('');
        $('#name').val('');
        $('#description').val('');
        $('#price').val('');
    }
});
</script>
@endsection