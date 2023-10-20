@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-10 mt-3">
        <h2 class="fs-5">Users</h2>
    </div>
    <div class="col-md-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mt-2 float-right" data-bs-toggle="modal"
            data-bs-target="#addModal">
            <i class="fa fa-plus"></i> User
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('add-internal')}}" method="POST" id="addClientForm">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="client_name">Name</label>
                                <input type="text" class="form-control" id="client_name" name="client_name"
                                    placeholder="Enter Client Name" required>
                            </div>
                            <div class="form-group">
                                <label for="client_email">Email</label>
                                <input type="email" class="form-control" id="client_email" name="client_email"
                                    placeholder="Enter Email" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="">Select Role</option>
                                    <option value="internal">Internal</option>
                                    <option value="tracker">Tracker</option>\
                                </select>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{$client->name}}</td>
                        <td>{{$client->email}}</td>
                        <td>{{$client->user_type}}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit-btn" data-bs-toggle="modal"
                                data-client_id="{{$client->id}}" data-client_name="{{$client->name}}"
                                data-client_email="{{$client->email}}" data-client_phone="{{$client->phone}}"
                                data-role = "{{$client->user_type}}"
                                data-bs-target="#updateModal"><i class="fa fa-pencil"></i></button>
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
                    <h6>Are you sure you want to delete this User?</h6>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('add-client')}}" method="POST" id="updateClientForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="client_name">Name</label>
                            <input type="text" class="form-control" id="client_name" name="client_name"
                                placeholder="Enter Client Name" required>
                        </div>
                        <div class="form-group">
                            <label for="client_email">Email</label>
                            <input type="email" class="form-control" id="client_email" name="client_email"
                                placeholder="Enter Email" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="internal">Internal</option>
                                <option value="tracker">Tracker</option>\
                            </select>
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
    @endsection
    @section('scripts')
    <script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            var client_id = $(this).data('client_id');
            $('#modal-delete-btn').attr('href', '/delete-internal/' + client_id);
        });
        $('.edit-btn').click(function() {
            var client_id = $(this).data('client_id');
            var client_name = $(this).data('client_name');
            var company_name = $(this).data('company_name');
            var client_email = $(this).data('client_email');
            var role = $(this).data('role');
            $('#updateModal #client_name').val(client_name);
            $('#updateModal #company_name').val(company_name);
            $('#updateModal #client_email').val(client_email);
            $('#updateModal #role').val(role);
            $('#updateModal #updateClientForm').attr('action', '/update-internal/' + client_id);
        });
    });
    </script>
    @endsection