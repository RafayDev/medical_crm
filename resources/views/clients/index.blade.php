@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-10 mt-3">
        <h2 class="fs-5">Clients</h2>
    </div>
    <div class="col-md-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mt-2 float-right" data-bs-toggle="modal"
            data-bs-target="#addModal">
            <i class="fa fa-plus"></i> Client
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Client</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('add-client')}}" method="POST" enctype="multipart/form-data" id="addClientForm">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" id="logo" name="logo"
                                    placeholder="Enter Logo" required>
                            </div>
                            <div class="form-group">
                                <label for="client_name">Client Name</label>
                                <input type="text" class="form-control" id="client_name" name="client_name"
                                    placeholder="Enter Client Name" required>
                            </div>
                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name"
                                    placeholder="Enter Company Name" required>
                            </div>
                            <div class="form-group">
                                <label for="client_email">Email</label>
                                <input type="email" class="form-control" id="client_email" name="client_email"
                                    placeholder="Enter Email" required>
                            </div>
                            <div class="form-group">
                                <label for="client_phone">Client Phone</label>
                                <input type="text" class="form-control" id="client_phone" name="client_phone"
                                    placeholder="Enter Phone" required>
                            </div>
                            <div class="form-group">
                                <label for="client_address">Address</label>
                                <textarea class="form-control" id="client_address" name="client_address"
                                    placeholder="Enter Address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Categories</label>
                                <div id="categories">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-success" id="add_category"
                                                type="button">+</button>
                                        </div>
                                        <select id="category" name="category[]" class="form-select" required>
                                            <option selected>Choose...</option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password"
                                    placeholder="Enter Password" required>
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
    <div class="row">
        <div class="bg-light">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Client Name</th>
                        <th>Company Name </th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td><img src="{{asset('storage/logos/'.$client->logo)}}" alt="" width="50px"></td>
                        <td>{{$client->name}}</td>
                        <td>{{$client->company->name}}</td>
                        <td>{{$client->email}}</td>
                        <td>{{$client->company->address}}</td>
                        <td>
                        <button type="button" class="btn btn-primary btn-sm edit-btn" data-bs-toggle="modal"
                                data-client_id="{{$client->id}}" 
                                data-client_name = "{{$client->name}}"
                                data-company_name = "{{$client->company->name}}"
                                data-client_email = "{{$client->email}}"
                                data-client_phone = "{{$client->phone}}"
                                data-client_address = "{{$client->company->address}}"
                                data-client_categories = "{{$client->user_categories}}"
                                data-bs-target="#updateModal"><i
                                    class="fa fa-pencil"></i></button>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal"
                                data-client_id="{{$client->id}}" data-bs-target="#deleteModal"><i
                                    class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Client</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Are you sure you want to delete this client?</h6>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a type="button" href="#" id="modal-delete-btn" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Update Model -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Client</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('add-client')}}" method="POST" id="updateClientForm">
                        @csrf
                        <div class="modal-body">
                        <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" id="logo" name="logo"
                                    placeholder="Enter Logo" required>
                            </div>
                            <div class="form-group">
                                <label for="client_name">Client Name</label>
                                <input type="text" class="form-control" id="client_name" name="client_name"
                                    placeholder="Enter Client Name" required>
                            </div>
                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name"
                                    placeholder="Enter Company Name" required>
                            </div>
                            <div class="form-group">
                                <label for="client_email">Email</label>
                                <input type="email" class="form-control" id="client_email" name="client_email"
                                    placeholder="Enter Email" required>
                            </div>
                            <div class="form-group">
                                <label for="client_phone">Client Phone</label>
                                <input type="text" class="form-control" id="client_phone" name="client_phone"
                                    placeholder="Enter Phone" required>
                            </div>
                            <div class="form-group">
                                <label for="client_address">Address</label>
                                <textarea class="form-control" id="client_address" name="client_address"
                                    placeholder="Enter Address"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Categories</label>
                                <div id="Upadate_categories">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-success" id="add_category_update"
                                                type="button">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password"
                                    placeholder="Enter Password">
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
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            var client_id = $(this).data('client_id');
            $('#modal-delete-btn').attr('href', '/delete-client/' + client_id);
        });
        $('#add_category').click(function(){
            $('#categories').append('<div class="input-group mb-3"><div class="input-group-prepend"><button class="btn btn-outline-danger remove_category" type="button">-</button></div><select id="category" name="category[]" class="form-select" required><option selected>Choose...</option>@foreach($categories as $category)<option value="{{$category->id}}">{{$category->name}}</option>@endforeach</select></div>');
        });
        $(document).on('click', '.remove_category', function(){
            $(this).closest('.input-group').remove();
        });
        $('.edit-btn').click(function(){
            var client_id = $(this).data('client_id');
            var client_name = $(this).data('client_name');
            var company_name = $(this).data('company_name');
            var client_email = $(this).data('client_email');
            var client_phone = $(this).data('client_phone');
            var client_address = $(this).data('client_address');
            var client_categories = $(this).data('client_categories');
            $('#updateModal #client_name').val(client_name);
            $('#updateModal #company_name').val(company_name);
            $('#updateModal #client_email').val(client_email);
            $('#updateModal #client_phone').val(client_phone);
            $('#updateModal #client_address').val(client_address);
            $('#updateModal #updateClientForm').attr('action', '/update-client/' + client_id);
            // $('#Upadate_categories').empty();
            $.each(client_categories, function(index, value){
    var appendStr = '<div class="input-group mb-3">';
    appendStr += '<div class="input-group-prepend">';
    appendStr += '<button class="btn btn-outline-danger remove_category" type="button">-</button></div>';
    appendStr += '<select id="category" name="category[]" class="form-select" required>';
    appendStr += '<option>Choose...</option>';

    @foreach($categories as $category)
        if({{$category->id}} == value.category_id) {
            appendStr += '<option value="{{$category->id}}" selected>{{$category->name}}</option>';
        } else {
            appendStr += '<option value="{{$category->id}}">{{$category->name}}</option>';
        }
    @endforeach
    
    appendStr += '</select></div>';
    
    $('#Upadate_categories').append(appendStr);
});
        });
        $('#add_category_update').click(function(){
            $('#Upadate_categories').append('<div class="input-group mb-3"><div class="input-group-prepend"><button class="btn btn-outline-danger remove_category" type="button">-</button></div><select id="category" name="category[]" class="form-select" required><option selected>Choose...</option>@foreach($categories as $category)<option value="{{$category->id}}">{{$category->name}}</option>@endforeach</select></div>');
        });       
    });
    </script>
    @endsection