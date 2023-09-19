@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h1>Product List</h1>
    <button type="button" class="btn btn-primary mb-2" id="add-product-btn" data-toggle="modal" data-target="#productModal" data-action="create">
        Add Product
    </button>
    <table class="table table-bordered" id="productList">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>₨ {{ $product->price }}</td>
                <td>
                    <button class="btn btn-primary btn-sm edit-product" data-action="edit" data-id="{{ $product->id }}">Edit</button>
                    <button class="btn btn-success btn-sm view-product" data-action="view" data-id="{{ $product->id }}">View</button>
                    <button class="btn btn-danger btn-sm delete-product" data-id="{{ $product->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product Details</h5>
            </div>
            <div class="modal-body">
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
                    <button type="submit" class="btn btn-primary" id="saveButton">Save Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#productForm').submit(function (event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var productId = $('#productId').val();
            var action = $('#productModal').data('action');
            var url = '';
            var method = '';
            if (action === 'create') {
                url = '{{ route('products-ajax-action.store') }}';
                method = 'POST';
            } else if (action === 'edit') {
                url = '{{ route('products-ajax-action.update', '') }}/' + productId;
                method = 'PUT';
            }
            $.ajax({
                type: method,
                url: url,
                data: formData,
                success: function (response) {
                    if (action === 'create') {
                        appendProductToTable(response.product);
                    }
                    else if (action === 'edit') {
                        replaceProductInTable(response.product);
                    }
                    $('#productModal').modal('hide');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        $(document).on('click', '#add-product-btn', function () {
            $('#productId').val('');
            $('#name').val('');
            $('#description').val('');
            $('#price').val('');
            $('#productModal').data('action', 'create');
            $('#saveButton').css('display','block');
            $('#productModal').modal('show');
        });

        $(document).on('click', '.edit-product, .view-product', function () {
            var action = $(this).data('action');
            var productId = $(this).data('id');

            var modalTitle = (action === 'edit') ? 'Edit Product' : 'View Product';
            $('#productModal').data('action', action);
            $('#productModalLabel').text(modalTitle);
            $('#saveButton').css('display','block');
            $.ajax({
                type: 'GET',
                url: '/products-ajax-action/' + productId,
                success: function (product) {
                    $('#productId').val(product.id);
                    $('#name').val(product.name);
                    $('#description').val(product.description);
                    $('#price').val(product.price);
                    if (action === 'view') {
                        $('#name, #description, #price, #category, #stock').attr('readonly', true);
                        $('#saveButton').css('display','none');
                    } else {
                        $('#name, #description, #price, #category, #stock').removeAttr('readonly');
                    }
                    var formAction = (action === 'edit') ? '/products-ajax-action/' + product.id : '';
                    $('#productForm').attr('action', formAction);
                    $('#productModal').modal('show');
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });

        $(document).on('click', '.delete-product', function () {
            var productId = $(this).data('id');
            var clickedButton = $(this);

            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route('products-ajax-action.destroy', '') }}/' + productId,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        clickedButton.closest('tr').remove();
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            }
        });
    });

    function appendProductToTable(product) {
        var newRow = '<tr>' +
            '<td>' + product.name + '</td>' +
            '<td>' + product.description + '</td>' +
            '<td> Rs' + product.price + '</td>' +
            '<td>' +
            '<button class="btn btn-primary btn-sm edit-product" data-action="edit" data-id="' + product.id + '">Edit</button> ' +
            '<button class="btn btn-success btn-sm view-product" data-action="view" data-id="' + product.id + '">View</button> ' +
            '<button class="btn btn-danger btn-sm delete-product" data-id="' + product.id + '">Delete</button>' +
            '</td>' +
            '</tr>';
        $('#productList tbody').append(newRow);
    }

    function replaceProductInTable(product) {
        var rowToUpdate = $('#productList tbody').find('button[data-id="' + product.id + '"]').closest('tr');
        rowToUpdate.find('td:eq(0)').text(product.name);
        rowToUpdate.find('td:eq(1)').text(product.description);
        rowToUpdate.find('td:eq(2)').text('$' + product.price);
    }
</script>
@endsection