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
                            <li class="breadcrumb-item"><a href="{{route('categories.index')}}">categories</a></li>
                            <li class="breadcrumb-item active">General Form</li>
                        </ol>
                    </div>
                    <div class="col-12">

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
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
                            <div class="card-header">
                                <h3 class="card-title">

                                    order settings
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{route('settings.update',$setting->id) }}" method="POST">
                                @csrf
                                @method('PUT')


                                <div class="card-body">
                                    <div class="form-group">
                                        <label>tax</label>
                                        <select class=" @error('tax') is-invalid @enderror select2"  name="tax" data-placeholder="Select a State" style="width: 100%;" required>

                                                <option <?php if($setting->tax == 1) echo 'selected'; ?> value="1">percentage</option>
                                                <option <?php if($setting->tax == 0) echo 'selected'; ?> value="0">value</option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('tax_value')}}</label>
                                        <input type="number" min="0" step="0.01" name="tax_value" value="{{$setting->tax_value}}" class=" @error('tax_value') is-invalid @enderror form-control" >
                                        @error('tax_value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>tax on product</label>
                                        <select class=" @error('tax_on_product') is-invalid @enderror select2"  name="tax_on_product" data-placeholder="Select a State" style="width: 100%;" required>

                                                <option <?php if($setting->tax_on_product == 1) echo 'selected'; ?> value="1">product price contains tax</option>
                                                <option <?php if($setting->tax_on_product == 0) echo 'selected'; ?> value="0">product price doesn't contain tax</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>delivery</label>
                                        <input type="number" min="0" step="0.01" name="delivery" value="{{$setting->delivery}}" class=" @error('delivery') is-invalid @enderror form-control" >
                                        @error('delivery')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Cancellation disabled when order</label>
                                        <select class=" @error('tax') is-invalid @enderror select2"  name="cancellation" data-placeholder="Select a State" style="width: 100%;" required>

                                            <option <?php if($setting->cancellation == 0) echo 'selected'; ?> value="0">new</option>
                                            <option <?php if($setting->cancellation == 1) echo 'selected'; ?> value="1">approved</option>
                                            <option <?php if($setting->cancellation == 2) echo 'selected'; ?> value="2">prepared</option>

                                        </select>
                                    </div>


                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection


    <!-- jQuery -->
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

