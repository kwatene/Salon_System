<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Salon Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ ucwords(auth()->user()->name??'') }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @can('view_dashboard')
                <li class="nav-item ">
                    <a href="{{ route('dashboard') }}" class="nav-link @if(Route::currentRouteName() == 'dashboard') active @endif">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @endcan
                @can('view_schedule', 'update_schedule', 'view_services', 'create_service', 'update_service', 'delete_service', 'active_service', 'inactive_service')
                <li class="nav-header">Product Management</li>
                @endcan
                @can('view_categories', 'create_category', 'update_category', 'delete_category', 'active_category', 'inactive_category')
                    <li class="nav-item ">
                        <a href="{{ route('categories') }}" class="nav-link @if(Route::currentRouteName() == 'categories' || Route::currentRouteName() == 'category.create'|| Route::currentRouteName() == 'category.edit') active @endif">
                            <i class="nav-icon fa fa-sitemap"></i>
                            <p>
                                Categories
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view_services', 'create_service', 'update_service', 'delete_service', 'active_service', 'inactive_service')
                <li class="nav-item ">
                    <a href="{{ route('services') }}" class="nav-link @if(Route::currentRouteName() == 'services' || Route::currentRouteName() == 'service.create'|| Route::currentRouteName() == 'service.edit') active @endif">
                        <i class="nav-icon fa fa-briefcase"></i>
                        <p>
                            Services
                        </p>
                    </a>
                </li>
                @endcan
                @can('view_schedule', 'update_schedule')
                <li class="nav-item ">
                    <a href="{{ route('schedule') }}" class="nav-link @if(Route::currentRouteName() == 'schedule') active @endif">
                    <i class="nav-icon fa fa-calendar"></i>
                        <p>
                            Schedule
                        </p>
                    </a>
                </li>
                @endcan
                @can('view_bookings', 'create_booking', 'update_booking', 'delete_booking', 'active_booking', 'inactive_booking')
                <li class="nav-header">Booking Management</li>
                <li class="nav-item ">
                    <a href="{{ route('bookings') }}" class="nav-link @if(Route::currentRouteName() == 'bookings') active @endif">
                        <i class="nav-icon fa fa-bookmark"></i>
                        <p>
                            Bookings
                        </p>
                    </a>
                </li>
                @endcan
                @can('view_customers', 'create_customer', 'update_customer', 'delete_customer', 'active_customer', 'inactive_customer', 'view_users', 'create_user', 'update_user', 'delete_user', 'active_user', 'inactive_user')
                <li class="nav-header">People Management</li>
                @endcan
                @can('view_customers', 'create_customer', 'update_customer', 'delete_customer', 'active_customer', 'inactive_customer')
                <li class="nav-item ">
                    <a href="{{ route('customers') }}" class="nav-link @if(Route::currentRouteName() == 'customers' || Route::currentRouteName() == 'customer.create'|| Route::currentRouteName() == 'customer.edit') active @endif">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            Customers
                        </p>
                    </a>
                </li>
                @endcan
                @can('view_users', 'create_user', 'update_user', 'delete_user', 'active_user', 'inactive_user')
                <li class="nav-item ">
                    <a href="{{ route('users') }}" class="nav-link @if(Route::currentRouteName() == 'users' || Route::currentRouteName() == 'user.create'|| Route::currentRouteName() == 'user.edit') active @endif">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                @endcan
                @can('view_roles', 'create_role', 'update_role', 'delete_role', 'active_role', 'inactive_role')
                <li class="nav-header">System Management</li>
                <li class="nav-item ">
                    <a href="{{ route('roles') }}" class="nav-link @if(Route::currentRouteName() == 'roles') active @endif">
                        <i class="nav-icon fa fa-id-badge"></i>
                        <p>
                            User Roles
                        </p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
