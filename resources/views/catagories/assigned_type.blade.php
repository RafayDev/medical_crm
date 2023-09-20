@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row">
        <div class="col-md-6">
            <h3>Assign Types for {{$category->name}}</h3>
        </div>
    </div>
    <form action="{{route('assign-types')}}" method="POST">
        @csrf
        <input type="hidden" name="category_id" value="{{$category->id}}">
    <div class="bg-light mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type Name</th>
                    <th>Select All</th>
                    <th> <!-- checkbox -->
                        <input type="checkbox" class="form-check-input" id="checkAll">
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($types as $type)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$type->name}}</td>
                    <td></td>
                    <td>
                        <!-- checkbox -->
                        <input type="checkbox" class="form-check-input" name="types[]" value="{{$type->id}}"
                            @foreach($category_types as $category_type)
                            @if($category_type->type_id == $type->id)
                            checked
                            @endif
                            @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Assign</button>
        </div>
    </div>
    </form>
</div>
@endsection
@section('scripts')
<script>
    //check all checkbox
    $('#checkAll').click(function () {
        if ($(this).is(':checked')) {
            $('input[type=checkbox]').prop('checked', true);
        } else {
            $('input[type=checkbox]').prop('checked', false);
        }
    });
</script>
@endsection