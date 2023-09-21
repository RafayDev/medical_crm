@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-10">
        <h3>Products</h3>
    </div>
</div>
<div class="row">
@foreach($products as $product)
    <div class="col-md-3">
        <div class="box bg-light">
            <img src="{{asset('storage/products/'.$product->image)}}"height = "300px" width = "100%">
            <div class="box-body">
                <h5>{{$product->name}}</h5>
            </div>
            <!-- <a href="#" class="btn btn-sm btn-primary">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Delete</a> -->
        </div>
    </div>
    @endforeach
</div>
@endsection