@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>General Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('requests.index')}}">Requests</a></li>

                            @if($request->converted == 1)
                                <li class="breadcrumb-item active"><a href="{{route('orders.edit',$order->id)}}">Edit order</a></li>
                            @else
                                <li class="breadcrumb-item active"><a href="{{route('orders.create',$request->id)}}">convert to order</a></li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('client name')}}</label>
                                    <input type="text" value="{{$request->client->name }}" name="name" class=" @error('name') is-invalid @enderror form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('client address')}}</label>
                                    <input type="text" value="{{$request->client->address }}" name="name" class=" @error('name') is-invalid @enderror form-control" disabled>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('Request Description')}}</label>
                                    <textarea class="form-control" rows="3" disabled>
                                        {{$request->cart_description }}
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Request Address</label>
                                    <input type="email" value="{{$request->address }} " name="email" class="@error('email') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" disabled>
                                </div>

                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection


    <!-- jQuery -->


        @if(isset($orderproduct))

            <script>

                $(document).ready(function() {
                    $('input[name="quantity"]').on('change',function() {
                        var amount = $(this).val()*$('input[name="editproduct_price"]').val();
                        $('input[name="price"]').val(amount);
                    })
                });

            </script>

        @else


            <script>

                $('.quantity').change(function () {

                    let total_price = $(this).val() * $('.addproduct_price').val();

                    $('.total_price').val(total_price);

                })

            </script>

        @endif

        <script src="{{ asset('plugins') }}/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('plugins') }}/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Select2 -->
        <script src="{{ asset('plugins') }}/select2/js/select2.full.min.js"></script>
        <!-- Bootstrap4 Duallistbox -->
        <script src="{{ asset('plugins') }}/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
        <!-- InputMask -->
        <script src="{{ asset('plugins') }}/moment/moment.min.js"></script>
        <script src="{{ asset('plugins') }}/inputmask/min/jquery.inputmask.bundle.min.js"></script>
        <!-- date-range-picker -->
        <script src="{{ asset('plugins') }}/daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap color picker -->
        <script src="{{ asset('plugins') }}/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ asset('plugins') }}/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- Bootstrap Switch -->
        <script src="{{ asset('plugins') }}/bootstrap-switch/js/bootstrap-switch.min.js"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('dist') }}/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('dist') }}/js/demo.js"></script>
        <!-- Page script -->
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
                $('#timepicker').datetimepicker({
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
        </body>
        </html>

