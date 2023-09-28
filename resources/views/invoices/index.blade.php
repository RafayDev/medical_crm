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
                    <th>Tracking No</th>
                    <th>Courier</th>
                    <th>invoice Date</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$invoice->user->name}}</td>
                        <td>{{$invoice->tracking_no}}</td>
                        <td>{{$invoice->courier}}</td>
                        <td>{{$invoice->created_at->format('d-m-Y')}}</td>
                        <td>
                            <a href="{{route('view-invoice',$invoice->id)}}" class="btn btn-success btn-sm"><i
                                    class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$invoices->links()}}
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection