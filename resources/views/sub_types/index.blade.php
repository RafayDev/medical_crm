@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-10 mt-4">
        <h3>Sub Types</h3>
    </div>
    <div class="col-md-2 mt-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa fa-plus"></i> Sub-Type
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add type</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('add-sub-type')}}" method="POST" id="addSubtypeModel"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">Select Type</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Sub-Type Name: </label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter type Name">
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
<div class="container-fluid pt-4 px-4">
    <div class="row bg-light">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sub_types as $sub_type)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$sub_type->type->name}}</td>
                        <td>{{$sub_type->name}}</td>
                        <td>
                            <button class="btn btn-square btn-primary  edit-btn" type="button"
                                data-type_id="{{$sub_type->type_id}}" data-sub_type_id="{{$sub_type->id}}"
                                data-sub_type_name="{{$sub_type->name}}" data-bs-toggle="modal"
                                data-bs-target="#editModal"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-square btn-danger delete-btn" type="button"
                                data-sub_type_id="{{$sub_type->id}}" data-bs-toggle="modal"
                                data-bs-target="#deleteModal"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Sub-type</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Are you sure you want to delete this sub-type?</h6>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" href="#" id="modal-delete-btn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- editModal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add type</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="editSubtypeModel" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Sub-Type Name: </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter type Name">
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
//validate
$('#addSubtypeModel').validate({
    rules: {
        type: {
            required: true,
        },
        name: {
            required: true,
        },
    },
    messages: {
        type: {
            required: "Please select type",
        },
        name: {
            required: "Please enter sub type name",
        },
    },
    errorElement: "small",
    errorClass: "text-danger",
    submitHandler: function(form) {
        form.submit();
    }
});
//delete
$('.delete-btn').click(function() {
    var sub_type_id = $(this).data('sub_type_id');
    $('#modal-delete-btn').attr('href', '/delete-sub-type/' + sub_type_id);
});
//edit
$('.edit-btn').click(function() {
    var type_id = $(this).data('type_id');
    var sub_type_id = $(this).data('sub_type_id');
    var sub_type_name = $(this).data('sub_type_name');
    $('#editSubtypeModel').attr('action', '/edit-sub-type/' + sub_type_id);
    $('#editSubtypeModel #type').val(type_id);
    $('#editSubtypeModel #name').val(sub_type_name);
});
</script>
@endsection