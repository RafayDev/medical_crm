@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-10 mt-3">
        <h3>Products</h3>
    </div>
</div>
<div class="row">
    @foreach($products as $product)
    <div class="col-md-3">
        <div class="box bg-light">
            <img src="{{asset('storage/products/'.$product->image)}}" height="200px" width="100%">
            <div class="mt-2">
                <h5>{{$product->name}}</h5>

                <form action="{{route('add-to-cart')}}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="wrap mt-1">
                                <button type="button" id="sub" class="btn btn-sm btn-danger sub"
                                    style="width: 30px; hieght:30px; text-align: center;"><i
                                        class="fa-solid fa-minus"></i></button>
                                <input class="count" type="text" id="1" value="1" min="1" max="100" name="quantity"
                                    style="width: 50px; text-align: center;" />
                                <button type="button" id="add" class="btn btn-sm btn-success add"
                                    style="width: 30px; hieght:30px; text-align: center;"><i
                                        class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-3 mt-1">
                            <button type="submit" class="btn btn-sm btn-primary"><i
                                    class="fa-solid fa-cart-plus"></i></button>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <p data-toggle="collapse" data-target="#des{{$product->id}}"><i
                                class="fa-solid fa-chevron-down"></i>
                        </p>
                    </div>
                    <div id="des{{$product->id}}" class="collapse">
                        {{$product->description}}
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@section('scripts')
<script>
$('.add').click(function() {
    var th = $(this).closest('.wrap').find('.count');
    th.val(+th.val() + 1);
});
$('.sub').click(function() {
    var th = $(this).closest('.wrap').find('.count');
    if (th.val() > 1) th.val(+th.val() - 1);
});
</script>
@endsection