
<?php
$settings = App\Models\Setting::all()->first();

?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin LTE 4</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/daterangepicker/daterangepicker.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/datatables-bs4/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('plugins') }}/datatables-responsive/css/responsive.bootstrap4.min.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/select2/css/select2.min.css">

    <link rel="stylesheet" href="{{ asset('plugins') }}/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist') }}/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    @if(App::getLocale() == 'ar')

        <link rel="stylesheet" href="{{ asset('css') }}/custom.css">

    @endif

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="../../index3.html" class="nav-link">{{__('admin.home')}}</a>
            </li>

            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link"
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"> {{ $properties['native'] }}
                        <span class="sr-only">(current)</span></a>
                </li>
            @endforeach

        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->


    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="../../index3.html" class="brand-link">
            <img src="../../dist/img/AdminLTELogo.png"
                 alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Alexander Pierce</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    @if(auth()->user()->can('product-create') || auth()->user()->can('product-delete') || auth()->user()->can('product-edit') || auth()->user()->can('product-list'))
                        <li class="nav-item">
                            <a href="{{route('products.index',0)}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Products
                                </p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a href="{{route('categories.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                categories
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('subcategories.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                subcategories
                            </p>
                        </a>
                    </li>

                    @if(auth()->user()->can('vendor-create') || auth()->user()->can('vendor-delete') || auth()->user()->can('vendor-edit') || auth()->user()->can('vendor-list'))

                        <li class="nav-item">
                            <a href="{{route('vendors.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Vendors
                                </p>
                            </a>
                        </li>

                    @endif

                    @if(auth()->user()->can('admin-create') || auth()->user()->can('admin-delete') || auth()->user()->can('admin-edit') || auth()->user()->can('admin-list'))

                        <li class="nav-item">
                            <a href="{{route('admins.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Admins
                                </p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a href="{{route('orders.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Orders
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('products.index',1)}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Product Offers
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('requests.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Requests
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('settings.edit',$settings->id)}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Settings
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('reasons.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Reasons
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('points.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Points
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('supermarkets.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Supermarkets
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('teams.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                teams
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('clients.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                clients
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('offers.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                offers
                            </p>
                        </a>
                    </li>

                    @if(auth()->user()->can('role-create') || auth()->user()->can('role-delete') || auth()->user()->can('role-edit') || auth()->user()->can('role-list'))

                        <li class="nav-item">
                            <a href="{{route('roles.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Roles
                                </p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->flag == 1)

                        <li class="nav-item">
                            <a href="{{route('permissions.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Permissions
                                </p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>


    @yield('content')

</div>
<!-- ./wrapper -->

<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>


<!-- jQuery -->
<script src="{{ asset('plugins') }}/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="{{ asset('plugins') }}/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="{{ asset('plugins') }}/datatables/jquery.dataTables.min.js"></script>

<script src="{{ asset('plugins') }}/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script src="{{ asset('plugins') }}/datatables-responsive/js/dataTables.responsive.min.js"></script>

<script src="{{ asset('plugins') }}/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- AdminLTE App -->
<script src="{{ asset('dist') }}/js/adminlte.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist') }}/js/demo.js"></script>

<!-- Select2 -->
<script src="{{ asset('plugins') }}/select2/js/select2.full.min.js"></script>

<!-- date-range-picker -->
<script src="{{ asset('plugins') }}/daterangepicker/daterangepicker.js"></script>

<!-- bootstrap color picker -->
<script src="{{ asset('plugins') }}/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

<!-- Bootstrap Switch -->
<script src="{{ asset('plugins') }}/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- InputMask -->
<script src="{{ asset('plugins') }}/moment/moment.min.js"></script>

<script src="{{ asset('plugins') }}/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<script>

    $(function () {

        $('.quantity').on('change', function () {

            let product_price = $('.product').find(':selected').data('price');
            let quantity = $(this).val();

            let total_price = product_price * quantity;

            $('.price').val(total_price);
        });

    });

</script>

<!-- Page script -->
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

</body>
</html>


