
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

    <title>Deliveritto | Dashboard</title>

    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

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

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/adminlte.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/summernote/summernote-bs4.css') }}">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/daterangepicker/daterangepicker.css">

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
            <!-- Messages Dropdown Menu -->

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        {{ __('Profile') }}
                    </a>

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
        <a href="{{route('home')}}" class="brand-link">
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
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    @if(auth()->user()->hasRole('admin'))

                        <li class="nav-item has-treeview">
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    products
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{route('products.index',0)}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>list of products</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('measures.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>measuring units</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('sizes.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>sizes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('products.index',1)}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Product Offers
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Supermarkets
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{route('supermarkets.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            list Supermarkets
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('branches.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>branches</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    @endif

                    @if(auth()->user()->hasRole(['admin','delivery_manager']))
                         <li class="nav-item">
                            <a href="{{route('delivery.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>delivery</p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasRole(['admin','delivery_manager']))


                        <li class="nav-item has-treeview">
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                   location
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{route('countries.index',0)}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>country</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('cities.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>city</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('areas.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>area</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

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


                        <li class="nav-item">
                            <a href="{{route('vendors.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Vendors
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admins.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Admins
                                </p>
                            </a>
                        </li>

                    @endif

                    @if(auth()->user()->role('delivery'))
                        <li class="nav-item">
                            <a href="{{route('orders.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Orders
                                </p>
                            </a>
                        </li>

                    @endif


            {{--                    <li class="nav-item">
                                    <a href="{{route('requests.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-tachometer-alt"></i>
                                        <p>
                                            Requests
                                        </p>
                                    </a>
                                </li>--}}

                    @

                                <li class="nav-item">
                                    <a href="{{route('logs.index')}}" class="nav-link">
                                        <i class="nav-icon fas fa-tachometer-alt"></i>
                                        <p>
                                            system logs
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

            {{--                    <li class="nav-item">
                                <a href="{{route('notifications.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Notifications
                                    </p>
                                </a>
                            </li>--}}



                            <li class="nav-item">
                                <a href="{{route('roles.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Roles
                                    </p>
                                </a>
                            </li>

                    @endif


                        <li class="nav-item">
                            <a href="{{route('permissions.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Permissions
                                </p>
                            </a>
                        </li>
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
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2020-2021 <a href="http://adminlte.io">Eramint..com</a>.</strong> All rights
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

<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('plugins') }}/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

<!-- Select2 -->
<script src="{{ asset('plugins') }}/select2/js/select2.full.min.js"></script>

<!-- bootstrap color picker -->
<script src="{{ asset('plugins') }}/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

<!-- Bootstrap Switch -->
<script src="{{ asset('plugins') }}/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- InputMask -->
<script src="{{ asset('plugins') }}/moment/moment.min.js"></script>

<script src="{{ asset('plugins') }}/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins') }}/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('plugins') }}/bootstrap-switch/js/bootstrap-switch.min.js"></script>


<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
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
                ranges   : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#startpicker').datetimepicker({
            format: 'LT'
        })

        $('#endpicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    })
</script>

<script>

    $(function () {

        $('.quantity').on('change', function () {

            let product_price = $('.product').find(':selected').data('price');
            let quantity = $(this).val();

            let total_price = product_price * quantity;

            $('.price').val(total_price);
        });

        $('.quantityoffer').on('change', function () {

            let product_price = $('.productoffer').find(':selected').data('price');
            let quantity = $(this).val();

            let total_price = product_price * quantity;

            $('.priceoffer').val(total_price);
        });

        $('#cancel').on('click', function(){

            let ordervalue = $(this).val();


            $("#order").val(ordervalue);

        });

        $('.type').on('change', function(){

            let type = $(this).val();


            if(type == 2)
            {
                $('.offer_type').css('display','block');
                $(".offer_type").prop("disabled", false);
            }
            else
            {
                $('.offer_type').css('display','none');
                $(".offer_type").prop("disabled", true);
            }

        });

        $('.offer').on('change', function(){

            let type = $(this).val();


            if(type == 'points')
            {
                $('.money').css('display','block');
                $(".money").prop("disabled", false);
                $('.points').css('display','block');
                $(".points").prop("disabled", false);
                $('.value_type').css('display','block');
                $('.value_type').prop("disabled",true);
                $('.promocode').css('display','none');
                $(".promocode").prop("disabled", true);
            }
            else if(type == 'promocode')
            {
                $('.promocode').css('display','block');
                $(".promocode").prop("disabled", false);
                $('.money').css('display','none');
                $(".money").prop("disabled", true);
                $('.points').css('display','none');
                $(".points").prop("disabled", true);
            }
            else
            {
                $('.value_type').css('display','block');
                $(".value_type").prop("disabled", false);
                $('.money').css('display','none');
                $(".money").prop("disabled", true);
                $('.points').css('display','none');
                $(".points").prop("disabled", true);
                $('.promocode').css('display','none');
                $(".promocode").prop("disabled", true);
            }

        });

        $(".datefilter").on('change',function(){

            $("#datefilter").submit();
        });

        $(".filteruser").on('change',function(){

            $("#filteruser").submit();
        });

        $("#link").on('click',function(){

            $("#import").trigger('click');
        });

        $("#import").on('change',function(){

            $("#import-form").submit();
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

    $(document).ready(function () {
        $('#supermarket').on('change', function () {
            let id = $(this).val();
            $('#branch').empty();
            $('#branch').append(`<option value="0" disabled selected>Processing...</option>`);
            $.ajax({
                type: 'GET',
                url: 'productbranch/' + id,
                success: function (response) {
                    var response = JSON.parse(response);
                    console.log(response);
                    $('#branch').empty();
                    response.forEach(element => {
                        $('#branch').append(`<option value="${element['id']}">${element['name']}</option>`);
                    });
                }
            });
        });
    });

    //Date range picker
    $('#reservation').daterangepicker()

</script>



<!--
<script src="https://www.gstatic.com/firebasejs/7.21.1/firebase-analytics.js"></script>

<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/6.3.4/firebase.js"></script>
<script>
    $(document).ready(function(){
        const config = {
            apiKey: "<XXX>",
            authDomain: "<XXX>",
            databaseURL: "<XXX>",
            projectId: "<XXX>",
            storageBucket: "<XXX>",
            messagingSenderId: "<XXX>",
            appId: "<XXX>"
        };
        firebase.initializeApp(config);
        const messaging = firebase.messaging();

        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function(token) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/save-device-token') }}',
                    type: 'POST',
                    data: {
                        user_id: {!! json_encode($user_id ?? '') !!},
                        fcm_token: token
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response)
                    },
                    error: function (err) {
                        console.log(" Can't do because: " + err);
                    },
                });
            })
            .catch(function (err) {
                console.log("Unable to get permission to notify.", err);
            });

        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });
    });
</script> -->

<!-- date-range-picker -->
<script src="{{ asset('plugins') }}/daterangepicker/daterangepicker.js"></script>



</body>
</html>


