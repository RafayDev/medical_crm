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
                    <th>SKU</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price Per Unit ($)</th>
                    <th>Total Price ($)</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($carts as $cart)

                    <tr>
                        <td>{{ $cart->product->name }}</td>
                        <td>{{ $cart->product->sku }}</td>
                        <td>{{ $cart->product->size }}</td>
                        <td>{{ $cart->quantity }}</td>
                        <td>{{ $cart->product->price }} $</td>
                        <td>{{ $cart->product->price * $cart->quantity }} $</td>
                        <td>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-cart_id="{{$cart->id}}"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(Auth :: user() -> user_type == 'client')
            <button class="btn btn-primary mt-3 mb-4" data-bs-toggle="modal" data-bs-target="#productsModal" data-user_id="{{Auth::user()->id}}"><i class="fa-solid fa-file-circle-plus"></i> Create Invoice</button>
            @endif
            <a href="{{route('send-query',Auth::user()->id)}}" class="btn btn-primary  mt-3 mb-4 float-right"><i class="fa-solid fa-share-from-square"></i> Send Inquiry</a>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Are you sure you want to delete this product from cart?</h6>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" href="#" id="modal-delete-btn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Create Invoice Modal -->
<div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Products</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('create_client_invoice')}}" method="post">
                @csrf
                <input type="hidden" id="user_id" name="user_id">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <th>#</th>
                                <th>Item Description</th>
                                <th>SKU </th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price per Unit ($)</th>
                                <th>Total Price ($)</th>
                            </thead>
                            <tbody id="products">
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sales_tax">Sales Tax ($)</label>
                                <input type="number" name="sales_tax" id="sales_tax" class="form-control"
                                    placeholder="Enter Sales Tax" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="freight_charges">Freight Charges ($)</label>
                                <input type="number" name="freight_charges" id="freight_charges" class="form-control"
                                    placeholder="Enter Freight Charges" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Create Invoice</button>
                    </div>
            </form>
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
    $('#productsModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var user_id = button.data('user_id')
    $('#user_id').val(user_id)
    var modal = $(this)
    $.ajax({
        url: "/get-cart-products/" + user_id,
        type: "GET",
        success: function(response) {
            $('#products').html(response);
        }
    })
})
function calculate_total_price(price_per_unit, quantity, count) {
    var total_price = price_per_unit * quantity;
    $('#total-price-col'+ count).html(total_price + '$');
    $('input[name="total_price[]"]').eq(count - 1).val(total_price);
    var full_total = 0;
    $('input[name="total_price[]"]').each(function() {
        full_total += parseFloat($(this).val());
    });
    $('#full-total').html(full_total + '$');
}
</script>
@endsection