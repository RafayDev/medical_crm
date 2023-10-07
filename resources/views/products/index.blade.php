@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-10 mt-4">
        <h3>Products</h3>
    </div>
    <div class="col-md-2 mt-3">
        <!-- Button trigger modal -->
        @if(Auth::user()->user_type == 'admin')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa fa-plus"></i> Product
        </button>
        @endif
        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('add-product')}}" id="addProductForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="image">Product Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>
                            <div class="from-group">
                                <label for="name">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter Product Name">
                            </div>
                            <div class="form-group">
                                <label for="category">Product Catagory</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select Catagory</option>
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type">Product Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">Select Type</option>
                                    @foreach ($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sub_type">Product Sub Type</label>
                                <select name="sub_type" id="sub_type" class="form-control">
                                    <option value="">Select Sub Type</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" name="price" id="price" class="form-control"
                                    placeholder="Enter Product Price">
                            </div>
                            <div class="form-group">
                                <label for="despription">Product Description</label>
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                    placeholder="Enter Product Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    @foreach($products as $product)
    <div class="col-md-3">
        <div class="box bg-light">
            <img src="{{asset('storage/products/'.$product->image)}}" alt="{{$product->name}}" height="400px"
                width="100%">
            <div class="mt-3">
                <h5>{{$product->name}}</h5>
                <h5>{{$product->price}}$</h5>
                @if(Auth::user()->user_type == 'admin')
                <button class="btn btn-square btn-primary m-2 edit-btn" type="button" data-product_id="{{$product->id}}"
                    data-product_name="{{$product->name}}" data-product_category="{{$product->category_id}}"
                    data-product_type="{{$product->type_id}}" data-product_price="{{$product->price}}"
                    data-product_sub_type="{{$product->sub_type_id}}"
                    data-product_description="{{$product->description}}" data-bs-toggle="modal"
                    data-bs-target="#editModal"><i class="fa fa-edit"></i></button>
                <button class="btn btn-square btn-danger m-2 delete-btn" type="button"
                    data-product_id="{{$product->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                        class="fa fa-trash"></i></button>
                @endif
                @if(Auth::user()->user_type == 'client')
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
                @endif
            </div>
            <!-- <a href="#" class="btn btn-sm btn-primary">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Delete</a> -->
        </div>
    </div>
    @endforeach
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
                <h6>Are you sure you want to delete this product?</h6>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" href="#" id="modal-delete-btn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>
                    <div class="from-group">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Product Name">
                    </div>
                    <div class="form-group">
                        <label for="category">Product Catagory</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select Catagory</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type">Product Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="">Select Type</option>
                            @foreach ($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sub_type">Product Sub Type</label>
                        <select name="sub_type" id="sub_type" class="form-control">
                            <option value="">Select Sub Type</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" id="price" class="form-control"
                            placeholder="Enter Product Price">
                    </div>
                    <div class="form-group">
                        <label for="despription">Product Description</label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                            placeholder="Enter Product Description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
//validation add product form
$(document).ready(function() {
    $('#addProductForm').validate({
        rules: {
            image: {
                required: true,
                extension: "jpg|jpeg|png|gif"
            },
            name: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            category: {
                required: true
            },
            type: {
                required: true
            },
            description: {
                required: true,
                minlength: 3,
                maxlength: 255
            }
        },
        messages: {
            image: {
                required: 'Please select product image',
                extension: 'Please select only jpg, jpeg, png or gif image'
            },
            name: {
                required: 'Please enter product name',
                minlength: 'Product name must be minimum 3 characters',
                maxlength: 'Product name must be maximum 50 characters'
            },
            category: {
                required: 'Please select product catagory'
            },
            type: {
                required: 'Please select product type'
            },
            description: {
                required: 'Please enter product description',
                minlength: 'Product description must be minimum 3 characters',
                maxlength: 'Product description must be maximum 255 characters'
            }
        },
        errorElement: "small",
        errorClass: "text-danger",
        submitHandler: function(form) {
            form.submit();
        }
    });
});
//delete product
$(document).on('click', '.delete-btn', function() {
    var product_id = $(this).data('product_id');
    $('#modal-delete-btn').attr('href', '/delete-product/' + product_id);
});
//edit product
$(document).on('click', '.edit-btn', function() {
    var product_id = $(this).data('product_id');
    var product_name = $(this).data('product_name');
    var product_category = $(this).data('product_category');
    var product_type = $(this).data('product_type');
    var product_sub_type = $(this).data('product_sub_type');
    var product_price = $(this).data('product_price');
    var product_description = $(this).data('product_description');
    $.ajax({
        url: '/get-sub-type-by-type/' + product_type,
        method: 'GET',
        success: function(response) {
            var html = '';
            $.each(response, function(key, sub_type) {
                html += '<option value="' + sub_type.id + '">' + sub_type.name +
                    '</option>';
            });
            $('#editProductForm #sub_type').html(html);
            $('#editProductForm #sub_type').val(product_sub_type);
        }
    });
    $('#editProductForm #name').val(product_name);
    $('#editProductForm #category').val(product_category);
    $('#editProductForm #type').val(product_type);
    $('#editProductForm #price').val(product_price);
    $('#editProductForm #description').val(product_description);
    $('#editProductForm').attr('action', '/edit-product/' + product_id);
});
//get sub types by type
$(document).on('change', '#type', function() {
    var type_id = $(this).val();
    $.ajax({
        url: '/get-sub-type-by-type/' + type_id,
        method: 'GET',
        success: function(response) {
            var html = '';
            $.each(response, function(key, sub_type) {
                html += '<option value="' + sub_type.id + '">' + sub_type.name +
                    '</option>';
            });
            $('#sub_type').html(html);
        }
    });
});
</script>
@endsection