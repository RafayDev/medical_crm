@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-3">
            <h3>Cart</h3>
        </div>
    </div>
</div>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12  bg-light mt-3">
            <table class="table table-hover">
                <thead>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price Per Unit($)</th>
                    <th>Subtotal($)</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @php
                    $total = 0;
                    @endphp
                    @foreach($carts as $cart)

                    <tr>
                        <td>{{ $cart->product->name }}</td>
                        <td>{{ $cart->quantity }}</td>
                        <td>{{ $cart->product->price }} $</td>
                        <td>{{ $cart->quantity * $cart->product->price }} $</td>
                        <td>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-cart_id="{{$cart->id}}"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    @php
                    $total = $total + ($cart->quantity * $cart->product->price);
                    @endphp
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                        <td><strong>Total($)</strong></td>
                        <td><strong>{{ $total }} $</strong></td>
                    </tr>
                </tbody>
            </table>
            <a href="{{route('send-query',Auth::user()->id)}}" class="btn btn-primary  mt-3 mb-4 float-right"><i class="fa-solid fa-share-from-square"></i> Send Query</a>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Are you sure you want to delete this category?</h6>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" href="#" id="modal-delete-btn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('#deleteModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var cart_id = button.data('cart_id')
        var modal = $(this)
        modal.find('.modal-footer #modal-delete-btn').attr("href", "{{route('delete-cart', '')}}"+"/"+cart_id);
    })
</script>
@endsection