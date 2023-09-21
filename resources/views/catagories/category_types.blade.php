@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-10">
        <h3>{{$category->name}}-Types</h3>
    </div>
</div>
<div class="row">
@foreach($category_types as $category_type)
    <div class="col-md-3">
        <div class="box bg-light">
           <a href="/category-type-products/{{$category->id}}/{{$category_type->type_id}}"><img src="{{asset('storage/types/'.$category_type->type->image)}}"height = "100px" width = "100%"></a>
            <div class="box-body">
                <h5>{{$category_type->type->name}}</h5>
            </div>
            <!-- <a href="#" class="btn btn-sm btn-primary">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Delete</a> -->
        </div>
    </div>
    @endforeach
</div>
@endsection