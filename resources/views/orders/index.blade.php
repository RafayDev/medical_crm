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
	<li class="stepper-item {{ $order->status == 'in-process' ? 'complete' : '' }}">
		<span class="stepper-counter"></span>
		<a href="#" class="stepper-link">
			<span>In-Process</span>
		</a>
		<span class="stepper-line"></span>
	</li>

	<li class="stepper-item {{ $order->status == 'manufacturing' ? 'complete' : '' }} ">
		<span class="stepper-counter"></span>
		<a href="#" class="stepper-link">
			<span>Munufacturing</span>
		</a>
		<span class="stepper-line"></span>
	</li>
	<li class="stepper-item {{ $order->status == 'in-transit' ? 'complete' : '' }}">
		<span class="stepper-counter"></span>
		<a href="#" class="stepper-link">
			<span>In Transit</span>
		</a>
		<span class="stepper-line"></span>
	</li>
</ol>
    </div>
    @endforeach
</div>
@endif
@endsection
