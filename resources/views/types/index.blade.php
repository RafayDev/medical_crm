@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-10 mt-3">
        <h3>Sub Categories</h3>
    </div>
    <div class="col-md-2 mt-3">
        <!-- Button trigger modal -->
        @if(auth()->user()->user_type == 'admin')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa fa-plus"></i> Sub Category
        </button>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Sub Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('add-type')}}" method="POST" id="addtypeModel" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="image">Sub Category Image: </label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="name">Sub Category Name: </label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter Sub Category Name">
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
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
    @foreach($types as $type)
    <div class="col-md-3">
        <div class="box bg-light text-center">
            <img src="{{asset('storage/types/'.$type->image)}}" alt="{{$type->name}}"
                style="object-fit: contain; height: 300px;  width: 200px;">
            <div class="box-body">
                <h5>{{$type->name}}</h5>
                @if(auth()->user()->user_type == 'admin')
                <button class="btn btn-square btn-primary m-2 edit-btn" type="button" data-type_id="{{$type->id}}"
                    data-type_name="{{$type->name}}" data-bs-toggle="modal" data-bs-target="#editModal"><i
                        class="fa fa-edit"></i></button>
                <button class="btn btn-square btn-danger m-2 delete-btn" type="button" data-type_id="{{$type->id}}"
                    data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Sub Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Are you sure you want to delete this Sub Category?</h6>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Sub Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="edittypeForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="image">Sub Category Image: </label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="name">Sub Category Name: </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter type Name">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
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
$(function() {
    $('#addtypeModel').validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            image: {
                required: true,
                extension: "jpg|jpeg|png|gif"
            },
            category: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter type name",
                minlength: "type name must be at least 3 characters long",
                maxlength: "type name must be less than 50 characters long"
            },
            image: {
                required: "Please select type image",
                extension: "Please select only jpg, jpeg, png or gif image"
            },
            category: {
                required: "Please select category"
            }
        },
        errorElement: "small",
        errorClass: "text-danger",
        submitHandler: function(form) {
            form.submit();
        }
    });
});
$('#edittypeForm').validate({
    rules: {
        name: {
            required: true,
            minlength: 3,
            maxlength: 50
        },
        image: {
            extension: "jpg|jpeg|png|gif"
        },
        category: {
            required: true
        }
    },
    messages: {
        name: {
            required: "Please enter type name",
            minlength: "type name must be at least 3 characters long",
            maxlength: "type name must be less than 50 characters long"
        },
        image: {
            extension: "Please select only jpg, jpeg, png or gif image"
        },
        category: {
            required: "Please select category"
        }
    },
    errorElement: "small",
    errorClass: "text-danger",
    submitHandler: function(form) {
        form.submit();
    }
});
$(document).on('click', '.delete-btn', function() {
    var type_id = $(this).data('type_id');
    var url = "{{route('delete-type', ':type_id')}}";
    url = url.replace(':type_id', type_id);
    $('#modal-delete-btn').attr('href', url);
});
$(document).on('click', '.edit-btn', function() {
    var type_id = $(this).data('type_id');
    var type_name = $(this).data('type_name');
    var url = "{{route('edit-type', ':type_id')}}";
    url = url.replace(':type_id', type_id);
    $('#edittypeForm').attr('action', url);
    $('#edittypeForm #name').val(type_name);
});
</script>
@endsection