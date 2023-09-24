        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"> ARTEMA CRM</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="{{asset('frontend/img/user.jpg')}}" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{Auth::user()->name}}</h6>
                        <span>{{Auth::user()->user_type}}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="/home" class ="{{ (request()->is('home')) ? 'active' : '' }} nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="/clients" class="{{ (request()->is('clients')) ? 'active' : '' }} nav-item nav-link"><i class="fa fa-users me-2"></i>Clients</a>
                    <a href="/catagories" class="{{ (request()->is('catagories')) ? 'active' : '' }} nav-item nav-link"><i class="fa fa-bars me-2"></i>Catagories</a>
                    <a href="/types" class="{{ (request()->is('types')) ? 'active' : '' }} nav-item nav-link"><i class="fa fa-toolbox me-2"></i>Types</a>
                    <a href="/sub-types" class="{{ (request()->is('sub-types')) ? 'active' : '' }} nav-item nav-link"><i class="fa fa-toolbox me-2"></i>Sub Types</a>
                    <a href="/products" class="{{ (request()->is('products')) ? 'active' : '' }} nav-item nav-link"><i class="fa fa-boxes me-2"></i>Products</a>
                    <a href="/queries" class="{{ (request()->is('queries')) ? 'active' : '' }} nav-item nav-link"><i class="fa fa-question-circle me-2"></i>Queries</a>
                    <a href="/invoices" class="{{ (request()->is('invoices')) ? 'active' : '' }} nav-item nav-link"><i class="fa fa-file-invoice-dollar me-2"></i>Invocies</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->