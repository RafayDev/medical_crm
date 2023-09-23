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
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-2">
                    <label for="">Select All</label>
                    <input type="checkbox" id="checkAll">
                </div>
            </div>
            @foreach($types as $type)
            <div class="container-fluid mb-4">
                @if(!$type->subtypes->isEmpty())
                <h4>{{$type->name}}</h4>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">#</th>
                            <th width="70%">Name</th>
                            <th width="20%">Select</th>
                        </tr>
                    </thead>
                    @foreach($type->subtypes as $subtype)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$subtype->name}}</td>
                        <td>
                            @if($category_types->contains('sub_type_id', $subtype->id))
                            <input type="checkbox" name="subtypes[]" value="{{$subtype->id}}" checked>
                            @else
                            <input type="checkbox" name="subtypes[]" value="{{$subtype->id}}">
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>

                @endif
            </div>
            @endforeach
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
$('#checkAll').click(function() {
    if ($(this).is(':checked')) {
        $('input[type=checkbox]').prop('checked', true);
    } else {
        $('input[type=checkbox]').prop('checked', false);
    }
});
</script>
@endsection