@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>General Form</h1>
                        @include('includes.errors')
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @if(($flag == 1))

                                <li class="breadcrumb-item"><a href="{{route('offers.index')}}">offers</a></li>
                                <li class="breadcrumb-item active">Offer Form</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{route('products.index')}}">products</a></li>
                                <li class="breadcrumb-item active">product Form</li>
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
                        <div class="card-header">
                            <h3 class="card-title">

                                @if(isset($product))

                                    @if($product->flag == 0)

                                        edit product
                                    @else

                                        edit offer

                                    @endif

                                @else
                                    @if($flag == 0)

                                        create product

                                    @else

                                        create offer

                                    @endif


                                @endif
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="@if(isset($product)){{route('products.update',['id' => $product->id,'flag' => $product->flag]) }} @else {{route('productsadd',$flag) }} @endif" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if(isset($product))

                                @method('PUT')

                            @endif

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('admin.product_arabname')}}</label>
                                    <input type="text" value="@if(isset($product)){{$product->arab_name }} @endif" name="arab_name" class=" @error('arab_name') is-invalid @enderror form-control" required>
                                    @error('arab_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('admin.product_engname')}}</label>
                                    <input type="text" name="eng_name" value="@if(isset($product)){{$product->eng_name }} @endif" class=" @error('eng_name') is-invalid @enderror form-control" required>
                                    @error('eng_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{__('admin.arab_description')}}</label>
                                    <textarea class=" @error('arab_description') is-invalid @enderror form-control" name="arab_description" rows="3" placeholder="Enter ...">

                                        @if(isset($product))
                                            {{$product->arab_description }}
                                        @endif
                                    </textarea>
                                    @error('arab_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{__('admin.eng_description')}}</label>
                                    <textarea class=" @error('eng_description') is-invalid @enderror form-control" name="eng_description" rows="3" placeholder="Enter ...">

                                        @if(isset($product))
                                            {{$product->eng_description }}
                                        @endif
                                    </textarea>
                                    @error('eng_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.product_price')}}</label>
                                    <input type="number" name="price" min="0" max="99999.99" step="0.01" @if(isset($product)) value="{{$product->price}}" @else value="0" @endif class=" @error('price') is-invalid @enderror form-control" >
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.product_points')}}</label>
                                    <input type="number" name="points" min="0" @if(isset($product)) value="{{$product->points}}" @else value="0" @endif class=" @error('points') is-invalid @enderror form-control" >
                                    @error('points')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>product category</label>
                                    <select class=" @error('category_id') is-invalid @enderror select2"  name="category_id" data-placeholder="Select a State" style="width: 100%;" required>

                                        @if(isset($product))
                                            @foreach(\App\Models\Category::all() as $category)

                                                <option <?php if($product->category->id == $category->id) echo 'selected'; ?> value="{{ $category->id }}">{{ $category->eng_name }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Category::all() as $category)

                                                <option value="{{ $category->id }}">{{ $category->eng_name }}</option>

                                            @endforeach

                                        @endif

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>product vendor </label>
                                    <select class=" @error('vendor_id') is-invalid @enderror select2" name="vendor_id" data-placeholder="Select a State" style="width: 100%;" required>
                                        @if(isset($product))
                                            @foreach(\App\Models\Vendor::all() as $vendor)

                                                <option <?php if($product->vendor->id == $vendor->id) echo 'selected'; ?> value="{{ $vendor->id }}">{{ $vendor->eng_name }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Vendor::all() as $vendor)

                                                <option value="{{ $vendor->id }}">{{ $vendor->eng_name }}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>


                                @if($flag == 1)

                                    <div class="form-group">
                                        <label>product status</label>
                                        <select class=" @error('status') is-invalid @enderror select2"  name="status" data-placeholder="Select a State" style="width: 100%;" required>

                                            @if(isset($product))

                                                <option  <?php if($product->status == 'active') echo 'selected'; ?> value="active">active</option>
                                                <option <?php if($product->status == 'inactive') echo 'selected'; ?> ="inactive">inactive</option>

                                            @else

                                                <option value="active">active</option>
                                                <option value="inactive">inactive</option>

                                            @endif

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>start_date</label>
                                        <input type="datetime-local" class=" @error('start_date') is-invalid @enderror form-control" id="start" name="start_date" data-placeholder="Select a offer start_date" style="width: 100%;" @if(!isset($product)) required @endif >

                                        @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>end_date</label>
                                        <input type="datetime-local" class=" @error('end_date') is-invalid @enderror form-control"  name="end_date" data-placeholder="Select a offer end_date" style="width: 100%;" @if(!isset($product)) required @endif >

                                        @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>



                                @endif

                                @if(isset($product))

                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">

                                                    @foreach($productimages as $image)

                                                        <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('product_images') }}/{{$image}}" class="card-img-top" alt="Course Photo">

                                                        <input type="checkbox" checked style="margin-right:10px;" name="image[]" value="{{$image}}">

                                                    @endforeach

                                                        <input name="images[]" multiple type="file">

                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                @else

                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="images[]" multiple type="file" class="custom-file-input @error('images') is-invalid @enderror" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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

                $("#start").datepicker({
                    minDate: 0 , /* This will be today */
                    format: 'Y-m-d H:i:s'
                });

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
