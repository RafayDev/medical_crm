@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12 mt-4">
        <h3>Inquiries</h3>
    </div>
</div>
<div class="container-fluid bg-light">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Query Status</th>
                    <th>Query Date</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($queries as $query)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$query->user->name}}</td>
                        @if($query->status == 'pending')
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        @elseif($query->status == 'approved')
                        <td><span class="badge bg-success text-dark">Approved</span></td>
                        @endif
                        <td>{{$query->created_at->format('d-m-Y')}}</td>
                        <td>
                            <a href="{{route('view-query',$query->id)}}" class="btn btn-success btn-sm"><i
                                    class="fa-solid fa-eye"></i></a>
                            <!-- Approve  -->
                            @if($query->status == 'pending' && auth()->user()->user_type == 'admin')
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#productsModal" data-query_id="{{$query->id}}"><i
                                    class="fa-solid fa-check"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$queries->links()}}
        </div>
    </div>
</div>
<!-- Appprove Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Approve Query</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Are you sure you want to Approve?</h6>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" href="#" id="modal-approve-btn" class="btn btn-success">Approve</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Query Products Modal -->
<div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Products</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('approve-query')}}" method="post">
                @csrf
                <input type="hidden" id="query_id" name="query_id">
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
                        <button type="submit" class="btn btn-success">Create Invoice</button>
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
    var query_id = button.data('query_id')
    $('#query_id').val(query_id)
    var modal = $(this)
    $.ajax({
        url: "/get-query-products/" + query_id,
        type: "GET",
        success: function(response) {
            $('#products').html(response);
        }
    })
})
</script>
@endsection