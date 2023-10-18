@extends('layouts.admin')
@section('content')
<style>
button,
input,
select,
textarea {
    font: inherit;
}

a {
    color: inherit;
}

/* End basic CSS override */

:root {
    --c-primary: #1d4ed8;
    --c-secondary: #dbeafe;
    --c-stepper-bg: #fff;
}

.stepper {
    display: flex;
    flex-direction: column;
    counter-reset: stepper;
    gap: 8px;
    border: 2px solid var(--c-secondary);
    background-color: var(--c-stepper-bg);
    padding: 2rem;
    border-radius: 10px;
}

.stepper-item {
    display: grid;
    grid-template-rows: [text-row] auto [line-row] 20px;
    grid-template-columns: [counter-column] 28px [text-column] auto;
    column-gap: 16px;
    row-gap: 8px;
    position: relative;

    &.complete {
        .stepper-counter {
            background-color: var(--c-secondary);
            color: var(--c-primary);
            position: relative;

            &:after {
                position: absolute;
                content: "";
                display: block;
                width: 16px;
                height: 16px;
                border-radius: 50%;
                background-color: var(--c-stepper-bg);
                right: -6px;
                bottom: -6px;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath fill='none' d='M0 0h24v24H0z'/%3E%3Cpath fill='%231d4ed8' d='M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z'/%3E%3C/svg%3E");
                background-size: 12px;
                background-repeat: no-repeat;
                background-position: center center;
            }
        }
    }

    &:last-child {
        grid-template-rows: [text-row] auto;
    }
}

.stepper-line {
    display: block;
    width: 2px;
    background-color: #8f8f8f;
    height: 100%;
    justify-self: center;

    .stepper-item:last-child & {
        display: none;
    }
}

.stepper-counter {
    flex-shrink: 0;
    counter-increment: stepper;

    &:before {
        content: counter(stepper);
    }

    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background-color: var(--c-primary);
    color: #fff;
    border-radius: 50%;
    line-height: 1;
}

.stepper-link {
    display: flex;
    gap: 12px;
    text-decoration: none;
    color: var(--c-primary);

    span {
        padding-top: calc((28px - 1.5em) / 2);
        font-weight: 600;
        border-bottom: 2px solid transparent;
    }

    &:after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    &:hover {
        span {
            border-color: currentcolor;
        }
    }

    &:focus {
        outline-offset: 4px;
        outline-color: var(--c-primary);
        outline-width: 2px;
        border-radius: 4px;
    }
}
</style>
<div class="row">
    <div class="col-md-12 mt-4">
        <h3>Orders & Tracking</h3>
    </div>
</div>
@if(auth()->user()->user_type == 'client')
<div class="row">
    @foreach($orders as $order)
    <div class="col-md-4">
        <ol class="stepper">
            <h6> Invoice No: AML-{{$order->invoice->id}}</h6>
            <li class="stepper-item {{ ($order->status == 'in-process' || $order->status == 'manufacturing' || $order->status == 'in-transit') ? 'complete' : '' }}">
                <span class="stepper-counter"></span>
                <a href="#" class="stepper-link">
                    @if($order->status == 'in-process')
                    <span>Your Payment has been recevied. Your order will be in manufacturing process soon </span>
                    @else
                    <span>In-Process</span>
                    @endif
                </a>
                <span class="stepper-line"></span>
            </li>

            <li class="stepper-item {{ ($order->status == 'in-transit' || $order->status == 'manufacturing') ? 'complete' : '' }} ">
                <span class="stepper-counter"></span>
                <a href="#" class="stepper-link">
                    @if($order->status == 'manufacturing')
                    <span>Your Order against the AML-{{$order->invoice->id}} in manufacturing process</span>
                    @else
                    <span>Munufacturing</span>
                    @endif
                </a>
                <span class="stepper-line"></span>
            </li>
            <li class="stepper-item {{ $order->status == 'in-transit' ? 'complete' : '' }}">
                <span class="stepper-counter"></span>
                <a href="#" class="stepper-link">
                    @if($order->status == 'in-transit')
                    <span>Your Order is In-Transit your Tracking No. is {{$order->tracking_no}} via
                        {{$order->courier}}.</span>
                    @else
                    <span>In Transit</span>
                    @endif
                </a>
                <span class="stepper-line"></span>
            </li>
        </ol>
    </div>
    @endforeach
    <div class="text-center">
        {{$orders->links()}}
    </div>
</div>
@endif
@if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'internal')
<div class="row bg-light">
    <div class="col-md-12 mt-4">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Invoice No.</th>
                    <th>Client Name</th>
                    <th>Order Date</th>
                    <th>Order Status</th>
                    <th>Tracking No.</th>
                    <th>Courier</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>AML-{{$order->invoice->id}}</td>
                    @if(!empty($order->invoice->user->name))
                    <td>{{$order->invoice->user->name}}</td>
                    @else
                    <td>Client Deleted</td>
                    @endif
                    <td>{{$order->created_at->format('d-m-Y')}}</td>
                    <td>
                        @if($order->status == 'in-process')
                        <span class="badge badge-primary">In-Process</span>
                        @elseif($order->status == 'manufacturing')
                        <span class="badge badge-warning">Manufacturing</span>
                        @elseif($order->status == 'in-transit')
                        <span class="badge badge-success">In-Transit</span>
                        @endif
                    </td>
                    <td>{{$order->tracking_no}}</td>
                    <td>{{$order->courier}}</td>
                    <td>
                        <a href="{{route('view-invoice',$order->invoice_id)}}" class="btn btn-success btn-sm"><i
                                class="fa-solid fa-eye"></i></a>
                        <button data-bs-toggle="modal" data-order_id="{{$order->id}}" data-status="{{$order->status}}"
                            data-tracking_no="{{$order->tracking_no}}" data-courier="{{$order->courier}}"
                            data-bs-target="#statusModel" class="btn btn-primary btn-sm"><i
                                class="fa-solid fa-pencil"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {{$orders->links()}}
    </div>
</div>
<!-- Status Modal -->
<div class="modal fade" id="statusModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Change Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('change-order-status')}}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="in-process">In-Process</option>
                            <option value="manufacturing">Manufacturing</option>
                            <option value="in-transit">In-Transit</option>
                        </select>
                    </div>
                    <div id="track_details">
                        <div class="form-group">
                            <label for="tracking_no">Tracking No.</label>
                            <input type="text" name="tracking_no" id="tracking_no" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="courier">Courier</label>
                            <input type="text" name="courier" id="courier" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script>
$(document).ready(function() {
	$('#statusModel').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var order_id = button.data('order_id')
		var status = button.data('status')
		var tracking_no = button.data('tracking_no')
		var courier = button.data('courier')
		var modal = $(this)
		modal.find('.modal-body #order_id').val(order_id)
		modal.find('.modal-body #status').val(status)
		modal.find('.modal-body #tracking_no').val(tracking_no)
		modal.find('.modal-body #courier').val(courier)
	})
})
</script>
@endsection
