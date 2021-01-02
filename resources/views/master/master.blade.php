<?php
$settings = App\Models\Setting::all()->first();


?>

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Deliveritto | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Favicon -->
    <link rel="shortcut icon" type="{{ asset('logo.jpeg') }}" href="{{ asset('logo.jpeg') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
          href="{{ URL::asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/adminlte.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!--Color box -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/colorbox/colorbox.css') }}">

    <!-- Custom style for RTL -->
    @if(trans('menu.lang')=='ar')
        <link rel="stylesheet" href="{{ URL::asset('dist/css/custom.css') }}">
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet"
              href="{{ URL::asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    @endif
<!-- My style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/style.css') }}">
    <!--Scripts -->

    @if(App::getLocale() == 'ar')

        <link rel="stylesheet" href="{{ asset('css') }}/custom.css">

@endif

<!-- jQuery -->
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ URL::asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ URL::asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ URL::asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ URL::asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ URL::asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ URL::asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ URL::asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ URL::asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ URL::asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('dist/js/adminlte.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset('dist/js/demo.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ URL::asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ URL::asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <!-- Sweet alert -->
    <link href="http://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css" rel="stylesheet">
    <script src="http://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <!-- Multi file upload -->
    <script src="{{ URL::asset('plugins/Multi-file-upload/jquery.MultiFile.js')}}" type="text/javascript"
            language="javascript"></script>
    <!-- Color box -->
    <script src="{{ URL::asset('plugins/colorbox/jquery.colorbox-min.js')}}" type="text/javascript"
            language="javascript"></script>

    <!-- My Script -->
    <script src="{{ URL::asset('dist/js/functions.js') }}"></script>
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
                <a href="{{route('home')}}" class="nav-link">{{__('dashboard')}}</a>
            </li>

            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link"
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"> {{ $properties['native'] }}
                        <span class="sr-only">(current)</span></a>
                </li>
            @endforeach

        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

             @isset($notifications)
            <li class="nav-item dropdown " id="div1">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge" id="div2">{{auth()->user()->unreadNotifications->count()}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right " style="left: inherit; right: 0px;">
                   {{--  <span class="dropdown-item dropdown-header">{{$notifications->count()}}</span> --}}
                    <div class="dropdown-divider"></div>
                    @foreach($notifications as $notification)
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2">{{__($notification->data["data"],["num"=>$notification->data["id"]])}}</i>
                        <span class="float-right text-muted text-sm">{{$notification->created_at->format("Y-m-d")}}</span>
                             @php 
                              $notification->markAsRead()
                              @endphp 

                    </a>
                    @endforeach

                    <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            @endisset


            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @can('edit-profile')
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            {{ __('Profile') }}
                        </a>
                    @endcan


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


    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="{{ asset('logo.jpeg') }}" alt="Food code Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Delivertto</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('dist') }}/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->


                          
            @if(auth()->user()->hasAnyPermission(['admin-list','supermarketAdmin-list','client-list','point-list','branches-list', 'role-list','reason-list', 'logs-list']))

                        <li class="nav-item has-treeview">

                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    {{ __('admin.admin_managment') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>


                            <ul class="nav nav-treeview">

                                {{-- admin --}}
                                {{-- admin --}}
                                @if(auth()->user()->can('admin-list'))
                                    <li class="nav-item">
                                        <a href="{{route('admins.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{__('admin.admin')}}
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                {{-- supermarketAdmin --}}
                                @if(auth()->user()->can('supermarketAdmin-list'))
                                    {{-- supermarket-admin --}}
                                    <li class="nav-item">
                                        <a href="{{route('supermarket-admins.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ __('admin.supermarket_admin') }}
                                            </p>
                                        </a>
                                    </li>
                                 @endif 

                                   {{-- delivery-admin --}}
                                @if(auth()->user()->can('delivery-list'))
                                    <li class="nav-item">
                                        <a href="{{route('delivery-admins.index',['company_id'=>auth()->user()->company_id ])}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                  {{__('admin.delivery_management')}}
                                            </p>
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="{{route('delivery-companies.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{__('admin.delivery_company')}}
                                            </p>
                                        </a>
                                    </li>


                                @endif     
                                {{-- client --}}
                                 {{-- client --}}
                                @if(auth()->user()->can('client-list'))
                                   {{-- client --}}
                                    <li class="nav-item">
                                        <a href="{{route('clients.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ __('admin.client') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif    
                                {{-- role --}}
                                @if(auth()->user()->can('role-list'))
                                    <li class="nav-item">
                                        <a href="{{route('roles.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ __('admin.roles') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif 

                                {{-- point --}}
                                @if(auth()->user()->can('point-list'))
                                    <li class="nav-item">
                                        <a href="{{route('points.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ __('admin.points') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif  

                                {{-- reason --}}
                                @if(auth()->user()->can('reason-list'))
                                    <li class="nav-item">
                                        <a href="{{route('reasons.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ __('admin.reasons') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif  

                                {{-- logs --}}
                                @if(auth()->user()->can('logs-list'))
                                    <li class="nav-item">
                                        <a href="{{route('logs.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ __('admin.logs') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif      

                            </ul>
                        </li>
                    @endif
  {{-- location --}}
                          @if(auth()->user()->can('location-list'))
                            {{-- location --}}
                            <li class="nav-item has-treeview">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>
                                      {{ __('admin.location_managment') }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                   <li class="nav-item">
                                    <a href="{{route('locations.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.locations') }}</p>
                                    </a>
                                   </li>
                                   
                                </ul>
                            </li>
                          @endif   
                           {{-- category --}}
                          @if(auth()->user()->can('category-list'))

                                  <li class="nav-item has-treeview">
                                        
                                        <a href="" class="nav-link">
                                            <i class="nav-icon fas fa-chart-pie"></i>
                                            <p>
                                                {{ __('admin.category_managment') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        

                                       
                                        <ul class="nav nav-treeview">

                                                {{-- main category --}}
                                                <li class="nav-item">
                                                    <a href="{{route('categories.index')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>
                                                            {{ __('admin.category') }}
                                                        </p>
                                                    </a>
                                                </li>

                                {{-- sub category --}}
                                {{--  <li class="nav-item">
                                     <a href="{{route('subcategories.index')}}" class="nav-link">
                                         <i class="far fa-circle nav-icon"></i>
                                         <p>
                                              {{ __('admin.subcategory') }}
                                         </p>
                                     </a>
                                 </li> --}}


                                {{-- measures --}}
                                                 <li class="nav-item">
                                                    <a href="{{route('measures.index')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                       <p>{{ __('admin.measure') }}</p>
                                                    </a>
                                                </li>

                                                 {{-- sizes --}}
                                                <li class="nav-item">
                                                    <a href="{{route('sizes.index')}}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('admin.size') }}</p>
                                                    </a>
                                                </li>
                            </ul>
                        </li>
                    @endif

                    @if(auth()->user()->hasAnyPermission(['supermarket-list','branches-list','vendor-list','product-list','offer-list']))
                        {{-- supermarket --}}
                        <li class="nav-item has-treeview">


                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    {{ __('admin.supermarket_management') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>


                            <ul class="nav nav-treeview">
                                @if(auth()->user()->can('supermarket-list'))
                                    <li class="nav-item">
                                        <a href="{{route('supermarkets.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ __('admin.all_supermarkets') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->can('branches-list'))
                                    <li class="nav-item">
                                        <a href="{{route('branches.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('admin.branches') }}</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->can('vendor-list'))
                                    {{-- Vendors --}}
                                    <li class="nav-item">
                                        <a href="{{route('vendors.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ __('admin.vendor') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('product-list'))
                                    <li class="nav-item">
                                        <a href="{{route('products.index',0)}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('admin.list_product') }}</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{route('products.index',1)}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ __('admin.product_offers') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->can('offer-list'))
                                    {{-- offer --}}
                                    <li class="nav-item">
                                        <a href="{{route('offer.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ __('admin.offers') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif


                            </ul>
                        </li>
                    @endif

                    {{-- delivery --}}
                    @if(auth()->user()->can('delivery-list'))
                        {{-- delivery --}}
                        <li class="nav-item">
                            <a href="{{route('delivery.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>{{ __('admin.delivery') }}</p>
                            </a>
                        </li>
                    @endif

                    {{-- Orders --}}
              
                           @if(auth()->user()->can('order-list'))
                                @if(auth()->user()->hasRole('delivery_admin'))

                                    <li class="nav-item">
                                        <a href="{{ route('orders.index',['company_id'=>auth()->user()->company_id ]) }}" class="nav-link " >
                                            <i class="nav-icon fas fa-tachometer-alt"></i>
                                            <p>
                                                {{ __('admin.orders') }}
                                            </p>
                                        </a>
                                    </li>

                                @elseif(auth()->user()->hasRole('driver'))
                                  <li class="nav-item">
                                        <a href="{{route('orders.index',['driver_id'=>auth()->user()->id])}}" class="nav-link">
                                            <i class="nav-icon fas fa-tachometer-alt"></i>
                                            <p>
                                                {{ __('admin.orders') }}
                                            </p>
                                        </a>
                                    </li>
                                @else
                                  <li class="nav-item">
                                        <a href="{{route('orders.index')}}" class="nav-link">
                                            <i class="nav-icon fas fa-tachometer-alt"></i>
                                            <p>
                                                {{ __('admin.orders') }}
                                            </p>
                                        </a>
                                    </li>
                                @endif    
                           @endif
                        
                        

                    {{-- setting --}}
                    @if(auth()->user()->can('setting-list'))
                        <li class="nav-item">
                            <a href="{{route('settings.edit',$settings->id??"")}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    {{ __('admin.setting') }}
                                </p>
                            </a>
                        </li>
                    @endif



                    <li class="nav-item">

                        <a href="{{route('financials.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                financials
                            </p>
                        </a>
                    </li>

                      <li class="nav-item">

                        <a href="{{route('notifications.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                financials
                            </p>
                        </a>
                    </li>

                    @if(auth()->user()->hasRole('developer'))

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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
            @yield('content')
            <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2020-2021 <a href="http://adminlte.io">Eramint..com</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

</body>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function (event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    })
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': decodeURIComponent(/XSRF-Token=([^;]*)/ig.exec(document.cookie)[1])
        }
    });
    (function ($) {
        $.fn.inputFilter = function (inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        };
    }(jQuery));
</script>

@yield('scripts')
{{-- <script>
    setInterval(function(){
    $("#notification_count").load(window.location.href + "#notification_count");
    $("#unreadNotification").load(window.location.href + "#unreadNotification");

    },5000);
</script> --}}

</html>
