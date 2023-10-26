@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12 mt-4">
        <h3>Invoices</h3>
    </div>
</div>
<div class="container-fluid bg-light">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>Quotation No</th>
                    <th>invoice Date</th>
                    <th>Status</th>
                    <th>Payment Link</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$invoice->user->company->quotation_series}}-{{$invoice->query_id}}</td>
                        <td>{{$invoice->created_at->format('d-m-Y')}}</td>
                        <td>
                            @if($invoice->status == "pending")
                            <span class="badge bg-warning">Pending</span>
                            @elseif($invoice->status =="accected")
                            <span class="badge bg-success">Accepted</span>
                            @elseif($invoice->status =="rejected")
                            <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($invoice->status == "pending")
                            <a href="{{$invoice->payment_proof}}" target="_blank" class="btn btn-primary"><i
                                    class="fa-solid fa-link"></i> Click to Pay Invoice</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('view-invoice',$invoice->id)}}" class="btn btn-success btn-sm"><i
                                    class="fa-solid fa-eye"></i></a>
                            @if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'internal')
                            <button data-bs-toggle="modal" data-invoice_id="{{$invoice->id}}"
                                data-invoice_sales_tax="{{$invoice->sales_tax}}"
                                data-invoice_freight_charges="{{$invoice->freight_charges}}"
                                data-invoice_payment_proof = "{{$invoice->payment_proof}}"
                                data-bs-target="#productsModal" class="btn btn-primary btn-sm"><i
                                    class="fa-solid fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-invoice_id="{{$invoice->id}}"><i
                                    class="fa-solid fa-trash"></i></button>
                                    @if($invoice->status == "pending")
                                    <button class="btn btn-primary approve-btn" data-bs-toggle="modal"
                                data-bs-target="#approveModal" data-invoice_id="{{$invoice->id}}"><i
                                    class="fa-solid fa-check"></i> Create Order</button>
                                    @endif
                            @endif
                        </td>
                        @endforeach
                </tbody>
            </table>
            {{$invoices->links()}}
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Invoice</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Are you sure you want to delete this invocie?</h6>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" href="#" id="modal-delete-btn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Approve Invoice</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="approve_modal_form" method="post" enctype="multipart/form-data" action="{{route('create-order')}}">
                @csrf
                <input type="hidden" id="invoice_id" name="invoice_id">
                <div class="modal-body">
                    <!-- <div class="form-group">
                        <label for="payment_proof">Proof of Payment</label>
                        <input type="file" name="payment_proof" id="payment_proof" class="form-control"
                            placeholder="Enter Payment Proof" required> -->
                    Do you want to create order?
                    <!-- </div> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Accept</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- Invoice Products Modal -->
<div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Products</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('approve-query')}}" method="post">
                @csrf
                <input type="hidden" id="invoice_id" name="invoice_id">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <th>#</th>
                                <th>Item Description</th>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="payment_proof">Payment Link</label>
                                <input type="text" name="payment_proof" id="payment_proof" class="form-control"
                                    placeholder="Enter Payment Link" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Edit Invoice</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script>
$('#productsModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var invoice_id = button.data('invoice_id')
    var sales_tax = button.data('invoice_sales_tax')
    var freight_charges = button.data('invoice_freight_charges')
    $('#invoice_id').val(invoice_id)
    $('#productsModal #sales_tax').val(sales_tax)
    $('#productsModal #freight_charges').val(freight_charges)
    $('#productsModal #payment_proof').val(button.data('invoice_payment_proof'))
    //form attribute
    $('#productsModal form').attr('action', '/update-invoice/' + invoice_id);
    var modal = $(this)
    $.ajax({
        url: "/get-invoice-products/" + invoice_id,
        type: "GET",
        success: function(response) {
            $('#products').html(response);
        }
    })
})
$('#approveModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var invoice_id = button.data('invoice_id')
    $('#invoice_id').val(invoice_id)
})
$('#deleteModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var invoice_id = button.data('invoice_id')
    $('#modal-delete-btn').attr('href', '/delete-invoice/' + invoice_id);
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