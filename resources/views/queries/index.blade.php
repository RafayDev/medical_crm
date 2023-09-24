@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12 mt-4">
        <h3>Queries</h3>
    </div>
</div>
<div class="container-fluid bg-light">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Query Date</th>
                    <th>Query Status</th>
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
                            <a href="{{route('view-query',$query->id)}}" class="btn btn-success btn-sm"><i class="fa-solid fa-eye"></i></a>
                            <!-- Approve  -->
                            @if($query->status == 'pending' && auth()->user()->user_type == 'admin')
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal" data-query_id="{{$query->id}}"><i class="fa-solid fa-check"></i></button>
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
@endsection
@section('scripts')
<script>
    $('#approveModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var query_id = button.data('query_id')
        var modal = $(this)
        modal.find('.modal-footer #modal-approve-btn').attr("href", "/approve-query/" + query_id);
    })
</script>
@endsection