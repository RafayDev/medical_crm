@extends('layouts.admin')
@section('content')
<style>
    .custom-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s;
        background: #f0f0f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .custom-card:hover {
        transform: translateY(-5px);
    }

    .custom-card .card-body {
        position: relative;
    }

    .custom-card a {
        color: #333;
        font-weight: 600;
    }

    .custom-card i {
        font-size: 4em;
        color: #FF6B6B;
        transition: color 0.3s;
    }

    .custom-card:hover i {
        color: #FF8E8E;
    }

    .active-link {
        color: #FF6B6B !important;
    }
</style>

<div class="container mt-5">
    <div class="row">

        <!-- Dashboard Card -->
        <div class="col-md-4 mb-4">
            <div class="card custom-card shadow-lg h-100">
                <div class="card-body text-center py-5">
                    <i class="fa fa-tachometer-alt mb-3"></i>
                    <h5 class="card-title mt-3">
                        <a href="/home" class="{{ (request()->is('home')) ? 'active-link' : '' }} text-decoration-none">
                            Dashboard
                        </a>
                    </h5>
                </div>
            </div>
        </div>

        @if(Auth::user()->user_type == 'admin')
        <!-- Clients Card -->
        <div class="col-md-4 mb-4">
            <div class="card custom-card shadow-lg h-100">
                <div class="card-body text-center py-5">
                    <i class="fa fa-users mb-3"></i>
                    <h5 class="card-title mt-3">
                        <a href="/clients" class="{{ (request()->is('clients')) ? 'active-link' : '' }} text-decoration-none">
                            Clients
                        </a>
                    </h5>
                </div>
            </div>
        </div>
        @endif

        <!-- Categories Card -->
        <div class="col-md-4 mb-4">
            <div class="card custom-card shadow-lg h-100">
                <div class="card-body text-center py-5">
                    <i class="fa fa-bars mb-3"></i>
                    <h5 class="card-title mt-3">
                        <a href="/catagories" class="{{ (request()->is('catagories')) ? 'active-link' : '' }} text-decoration-none">
                            Categories
                        </a>
                    </h5>
                </div>
            </div>
        </div>

        @if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'internal')
        <!-- Types Card -->
        <div class="col-md-4 mb-4">
            <div class="card custom-card shadow-lg h-100">
                <div class="card-body text-center py-5">
                    <i class="fa fa-toolbox mb-3"></i>
                    <h5 class="card-title mt-3">
                        <a href="/types" class="{{ (request()->is('types')) ? 'active-link' : '' }} text-decoration-none">
                            Types
                        </a>
                    </h5>
                </div>
            </div>
        </div>

        <!-- Sub-Types Card -->
        <div class="col-md-4 mb-4">
            <div class="card custom-card shadow-lg h-100">
                <div class="card-body text-center py-5">
                    <i class="fa fa-toolbox mb-3"></i>
                    <h5 class="card-title mt-3">
                        <a href="/sub-types" class="{{ (request()->is('sub-types')) ? 'active-link' : '' }} text-decoration-none">
                            Sub-Types
                        </a>
                    </h5>
                </div>
            </div>
        </div>
        @endif

        <!-- Products Card -->
        <div class="col-md-4 mb-4">
            <div class="card custom-card shadow-lg h-100">
                <div class="card-body text-center py-5">
                    <i class="fa fa-boxes mb-3"></i>
                    <h5 class="card-title mt-3">
                        <a href="/products" class="{{ (request()->is('products')) ? 'active-link' : '' }} text-decoration-none">
                            All Products
                        </a>
                    </h5>
                </div>
            </div>
        </div>

        <!-- Inquiries Card -->
        <div class="col-md-4 mb-4">
            <div class="card custom-card shadow-lg h-100">
                <div class="card-body text-center py-5">
                    <i class="fa fa-question-circle mb-3"></i>
                    <h5 class="card-title mt-3">
                        <a href="/queries" class="{{ (request()->is('queries')) ? 'active-link' : '' }} text-decoration-none">
                            Inquiries
                        </a>
                    </h5>
                </div>
            </div>
        </div>

        <!-- Invoices Card -->
        <div class="col-md-4 mb-4">
            <div class="card custom-card shadow-lg h-100">
                <div class="card-body text-center py-5">
                    <i class="fa fa-file-invoice-dollar mb-3"></i>
                    <h5 class="card-title mt-3">
                        <a href="/invoices" class="{{ (request()->is('invoices')) ? 'active-link' : '' }} text-decoration-none">
                            Invoices
                        </a>
                    </h5>
                </div>
            </div>
        </div>

        <!-- Tracking Card -->
        <div class="col-md-4 mb-4">
            <div class="card custom-card shadow-lg h-100">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-boxes-packing mb-3"></i>
                    <h5 class="card-title mt-3">
                        <a href="/orders" class="{{ (request()->is('orders')) ? 'active-link' : '' }} text-decoration-none">
                            Tracking
                        </a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection