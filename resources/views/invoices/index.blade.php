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
                    <th>Client Name</th>
                    <th>invoice Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$invoice->user->name}}</td>
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
                            <a href="{{route('view-invoice',$invoice->id)}}" class="btn btn-success btn-sm"><i
                                    class="fa-solid fa-eye"></i></a>
                                    @if($invoice->status == "pending" && auth()->user()->user_type == 'client')
                            <a href="{{route('create-order',$invoice->id)}}" class="btn btn-primary btn-sm"><i class="fa-solid fa-check"></i></a>    
                            @endif
                            @if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'internal')
                            <button data-bs-toggle="modal" data-invoice_id ="{{$invoice->id}}"
                            data-invoice_sales_tax ="{{$invoice->sales_tax}}"
                            data-invoice_freight_charges ="{{$invoice->freight_charges}}"
                                data-bs-target="#productsModal" class="btn btn-primary btn-sm"><i class="fa-solid fa-pencil"></i></button>
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
</script>
@endsection