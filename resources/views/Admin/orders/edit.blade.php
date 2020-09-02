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
                            <li class="breadcrumb-item"><a href="{{route('orders.index')}}">Orders</a></li>
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
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{route('orders.update',$order->id) }} " method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('client name')}}</label>
                                            <input type="text" value="{{$order->client->name }}" name="name" class=" @error('name') is-invalid @enderror form-control" disabled required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" value="{{$order->client->email }} " name="email" class="@error('email') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" disabled required>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        @if($order->request != 0)

                                            <div class="form-group">
                                                <label>{{__('order_description')}}</label>
                                                <textarea class="@error('cart_description') is-invalid @enderror form-control" name="cart_description" rows="3" placeholder="Enter ...">

                                                        {{$request->cart_description }}
                                                </textarea>
                                                @error('cart_description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        @endif

                                        <div class="form-group">
                                            <label>{{__('order_address')}}</label>
                                            <textarea3 class=" @error('address') is-invalid @enderror form-control" name="address" rows="3" placeholder="Enter ...">

                                                    {{$order->address }}
                                            </textarea3>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                    <!-- /.card-body -->

                                <form role="form" action="@if(isset($orderproduct)){{route('orderproduct.update',['order_id' => $order->id,'product_id' => $orderproduct->id]) }} @else {{route('products.store',$order->id) }} @endif" method="POST" enctype="multipart/form-data">

                                    <div class="card-body">

                                        @if(isset($orderproduct))

                                            <h3>Edit product</h3>

                                        @else

                                            <h3>Add product</h3>

                                        @endif

                                        @csrf

                                        @if(isset($orderproduct))

                                            @method('PUT')

                                        @endif


                                            <div class="row">


                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <label>select product</label>
                                                        <select class=" @error('product_id') is-invalid @enderror select2" name="product_id" data-placeholder="Select a State" style="width: 100%;" required>

                                                            @if(isset($orderproduct))

                                                                @foreach(\App\Models\Product::all() as $editproduct)

                                                                    <option <?php if($orderproduct->id == $editproduct->id) echo 'selected'; ?> value="{{ $editproduct->id }}">
                                                                        @if(App::getLocale() == 'ar')

                                                                            {{ $editproduct->arab_name }}

                                                                        @else

                                                                            {{ $editproduct->eng_name }}

                                                                        @endif

                                                                    </option>

                                                                @endforeach

                                                            @else

                                                                @foreach(\App\Models\Product::all() as $editproduct)

                                                                    <option value="{{ $editproduct->id }}">

                                                                        @if(App::getLocale() == 'ar')

                                                                            {{ $editproduct->arab_name }}

                                                                        @else

                                                                            {{ $editproduct->eng_name }}

                                                                        @endif

                                                                    </option>

                                                                @endforeach

                                                            @endif

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">{{__('admin.quantity')}}</label>
                                                        <input type="number" name="quantity" min="1" value="@if(isset($orderproduct)){{$quantity}} @endif" class=" quantity @error('quantity') is-invalid @enderror form-control" required>

                                                        @error('quantity')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">{{__('admin.price')}}</label>
                                                        <input type="number" name="price" min="0" max="99999.99" class=" quantity @error('price') is-invalid @enderror form-control">

                                                        @error('price')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>

                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>


                                    <div class="card-body">
                                        <h3>Order Products</h3>
                                        <h5>Total : {{$total_price}}</h5>
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>arab_name</th>
                                                <th>eng_name</th>
                                                <th>price</th>
                                                <th>quantity</th>
                                                <th>controls</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->products as $orderproduct)
                                                <tr>
                                                    <td>{{$orderproduct->arab_name}}</td>
                                                    <td>{{$orderproduct->eng_name}}</td>
                                                    <td>{{$orderproduct->price}}</td>
                                                    <td>{{$orderproduct->pivot->quantity}}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                <form action="{{ route('orderproduct.delete',['order_id' => $order->id,'product_id' => $orderproduct->id]) }}" method="post">
                                                                    @csrf
                                                                    @method('delete')

                                                                    <a class="dropdown-item" href="{{ route('orderproduct.edit',['order_id' => $order->id,'product_id' => $orderproduct->id]) }}">{{ __('edit') }}</a>
                                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this product?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>


                                            @endforeach

                                            </tbody>
                                        </table>
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

