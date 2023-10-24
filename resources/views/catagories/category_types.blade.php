@extends('layouts.admin')
@section('content')
<div class="row mt-2">
    <div class="col-md-6 mt-2">
        <h3>{{$category->name}}</h3>
    </div>
    <div class="col-md-6 mt-2">
        <form id="searchProduct" action="{{route('search-product')}}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Search Product"
                    aria-label="Search Product" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
    </div>
</div>
<div class="row mt-3">
@foreach($category_types as $category_type)
    <div class="col-md-3">
        <div class="box bg-light">
           <a href="/category-type-products/{{$category->id}}/{{$category_type->id}}"><img src="{{asset('storage/types/'.$category_type->image)}}"style="object-fit: contain; height: 300px;  width: 200px;"></a>
            <div class="box-body">
                <h5>{{$category_type->name}}</h5>
            </div>
            <!-- <a href="#" class="btn btn-sm btn-primary">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Delete</a> -->
        </div>
    </div>
    @endforeach
</div>
@endsection