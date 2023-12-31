@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-10 mt-3">
        <h3>Categories</h3>
    </div>
    <div class="col-md-2 mt-3">
        <!-- Button trigger modal -->
        @if(Auth::user()->user_type == 'admin')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa fa-plus"></i> Category
        </button>
        @endif
        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('add-catagory')}}" method="POST" id="addCategoryModel"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Category Name: </label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter Category Name">
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
<div class="row mt-5">
    @foreach($categories as $category)

    <div class="col-md-4">
        <a href="/category-types/{{$category->id}}">
            <div class="text-center" style="border:2px solid black; padding: 10px;">
                <h5>{{$category->name}}</h5>
            </div>
        </a>
        @if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'internal')
        <div class="text-center mt-2">
            <button type="button" class="btn btn-sm btn-primary edit-btn" data-bs-toggle="modal"
                data-bs-target="#editModal" data-category_id="{{$category->id}}"
                data-category_name="{{$category->name}}"><i class="fa fa-edit"></i></button>
            <button type="button" class="btn btn-sm btn-danger delete-btn" data-bs-toggle="modal"
                data-bs-target="#deleteModal" data-category_id="{{$category->id}}"><i class="fa fa-trash"></i></button>
        </div>
        @endif
    </div>

    @endforeach
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
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="editCategoryForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Category Name: </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Category Name">
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
    $('#addCategoryModel').validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 50
            }
        },
        messages: {
            name: {
                required: "Please enter category name",
                minlength: "Category name must be at least 3 characters long",
                maxlength: "Category name must be less than 50 characters long"
            }
        },
        errorElement: "small",
        errorClass: "text-danger",
        submitHandler: function(form) {
            form.submit();
        }
    });
});
$('#editCategoryForm').validate({
    rules: {
        name: {
            required: true,
            minlength: 3,
            maxlength: 50
        }
    },
    messages: {
        name: {
            required: "Please enter category name",
            minlength: "Category name must be at least 3 characters long",
            maxlength: "Category name must be less than 50 characters long"
        }
    },
    errorElement: "small",
    errorClass: "text-danger",
    submitHandler: function(form) {
        form.submit();
    }
});
$(document).on('click', '.delete-btn', function() {
    var category_id = $(this).data('category_id');
    var url = "{{route('delete-catagory', ':category_id')}}";
    url = url.replace(':category_id', category_id);
    $('#modal-delete-btn').attr('href', url);
});
$(document).on('click', '.edit-btn', function() {
    var category_id = $(this).data('category_id');
    var category_name = $(this).data('category_name');
    var url = "{{route('edit-catagory', ':category_id')}}";
    url = url.replace(':category_id', category_id);
    $('#editCategoryForm').attr('action', url);
    $('#editCategoryForm #name').val(category_name);
});
</script>
@endsection