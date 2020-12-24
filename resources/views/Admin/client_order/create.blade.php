@extends('layouts.admin_layout')

@section('content')

@php
 $orders = App\Models\ManualOrder::Where('client_id',request('client_id'))->get()
@endphp
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.edit') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('orders.index')}}">{{ __('admin.orders') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('admin.edit_order') }}</li>
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
                             <form role="form" action="{{ route('store.order') }}" method="POST" enctype="multipart/form-data">
        
                                     @csrf
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->

                            <div class="card-body">


                                <!--first card-->
                            @if(Auth()->user()->can('order-edit-client-info'))
                                <div class="card card-primary">

                                    <div class="card-header">
                                         {{ __('admin.clients') }}
                                    </div>
                       
                                  

                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{__('admin.name')}}</label>
                                                    <input type="text" value="{{$client->name }}" name="name" class=" @error('name') is-invalid @enderror form-control" disabled required>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{__('admin.email')  }}</label>
                                                    <input type="email" value="{{$client->email }} " name="email" class="@error('email') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" disabled required>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> {{__('admin.phone')  }}</label>
                                                    <input type="text" value="{{$client->mobile_number }} " name="mobile_number" class="@error('mobile_number') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                                    @error('mobile_number')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> {{ __('admin.location') }}</label>
                                                    <input type="text" value="{{$client->addresses->where('default',1)->first()->name ?? ""  }} " name="address" class="@error('address') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                                    @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        
                                    </div>

                            @endif
                            
                                <!--second card-->

                                    <!--first card-->
                            @if(Auth()->user()->can('order-edit-client-info'))
                                <div class="card card-primary">

                                    <div class="card-header">
                                         Choose SuperMaket 
                                    </div>

                                

                                            <div class="card-body">
                                                                      
                                                                    
                                                <div class="form-group ">
                                                    <label for="branch">SuperMarket</label>
                                                    <select name="supermarket_id" 
                                                   {{--  @if(session()->get('supermarket_id') != $supermarket->id) class="  
                                                     form-control select2 click_here" @else class="  
                                                     form-control select2"@endif  --}} class="  
                                                     form-control select2 supermarket_6">
                                                 
                                                <option    selected disabled="" >Please Select Source</option>

                                                    @foreach( $supermarkets as  $supermarket) 
                                                     <option
                                                      @if(session()->get('supermarket_id') != $supermarket->id && session()->get('supermarket_id') != null) selected disabled
                                                       @endif  
                                              
                                                        value="{{ $supermarket->id }}">{{$supermarket->name}}
                                                    </option>
                                                    @endforeach

                                                    </select>
                                                </div>
                                                 

                                            @if(session()->get('branch_id'))

                                                 <div class="form-group"  >
                                                    <label for="branch">Branch</label>
                                                    <select name="branch_id"  class=" branch_9 form-control select2">

                                                    @php
                                                    $branch = \App\Models\Branch::find(session()->get('branch_id'));
                                                    @endphp

                                                        <option
                                                         @if(session()->get('branch_id') != $branch->id && session()->get('branch') != null) selected disabled
                                                          @endif 
                                                         value="{{ $branch->id }}"  > {{ $branch->name_en  }}</option>
                                                           
                                                    </select>
                                                </div>

                                            @else
                                                <div class="form-group"  >
                                                    <label for="branch">Branch</label>
                                                    <select name="branch_id"  class="branch_9 form-control select2">
                                                    
                                                        <option  selected  disabled>Please Select Branch</option>
                                                           
                                                    </select>
                                                </div>

                                            @endif  

                                            <a href="{{ route('change.order',['client_id'=>request()->client_id]) }}" style="margin-top: 30px;" class=" btn btn-primary">
                                                    Reset Order


                                            </a >
                                            <br>  
                                            <br>  
                                            <br>  
{{-- 
                                                <div class="form-group"  >
                                                    <label for="branch">category</label>
                                                    <select name="branch_id" id="category_9"  class="form-control select2">
                                                    
                                                        <option  selected  disabled>Please Select category</option>
                                                           
                                                    </select>
                                                </div> --}}

                                                {{-- product --}}
                                                    <!--third card-->
                                    @if(Auth()->user()->can('order-edit-client-product'))
                                        <div class="card card-primary">

                                            <div class="card-header">
                                                @if(isset($productorder) && isset($order) && !isset($offer))

                                                    {{ __('admin.add_product') }}

                                                @else

                                                    Products

                                                @endif

                                            </div>

                                           
                                                <div class="card-body">


                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>@lang('site.product')</th>
                                        <th>@lang('site.quantity')</th>
                                        <th>@lang('site.price')</th>
                                    </tr>
                                    </thead>

                                    <tbody class="order-list">

                                   
                                        <tr>
                                            <td> 
                                                <select class="product_9 @error('product_id') is-invalid @enderror select2 product" name="products[]" id="hamdyinput" 
                                                data-placeholder="Select a product" style="width: 100%;" required>

                                                </select>
                                            </td>
                                            <td>  
                                                <input type="number" name="quantity[]" min="1" value="1" class="product_qty @error('quantity') is-invalid @enderror form-control " required>
                                            </td>
                                            <td class="product-price">  
                                              <input type="number" name="price" min="0" max="99999.99" class="price @error('price') is-invalid @enderror form-control" required>
                                            </td>
                                            <td>
                                               
                                                                    <a href="#" class="add_input btn btn-info"><i class="fa fa-plus">اضافة</i></a>
                                            </td>
                                        </tr>
                                           <div class="div_inputs"></div>

                                    </tbody>

                                </table><!-- end of table -->
                                @endif

{{-- 
                                                    <div class="row"style="align-items: flex-end; margin-bottom: 0px">
                                                         {{-- <input type="hidden" class="branch_product_id" name="branch_id" value="">
                                                          <input type="hidden" class="supermarket_id" name="supermarket_id" value=""> --}}

                                                      {{--   <div class="col-md-3">

                                                            <div class="form-group">

                                                                <label>{{ __('admin.select_product') }}</label>


                                                                    <select class="product_9 @error('product_id') is-invalid @enderror select2 product" name="products[]" id="hamdyinput" 
                                                                         data-placeholder="Select a product" style="width: 100%;" required>

                                                                        </select>

                                                                    @endif

                                                            </div>
                                                        </div>
  --}}

                                                     {{--    <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">{{__('admin.quantity')}}</label>
                                                                <input type="number" name="quantity[]" min="1" value="1" class="product_qty @error('quantity') is-invalid @enderror form-control " required>

                                                                @error('quantity')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="client_id" 
                                                        value="{{ $client->id }}">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">{{__('admin.price')}}</label>
                                                                <input type="number" name="price" min="0" max="99999.99" class="price @error('price') is-invalid @enderror form-control price" required>

                                                                @error('price')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                      
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                              {{--   <button style="margin-top: 30px;" class=" btn btn-primary">
                                                                           {{ __('admin.add') }}


                                                                </button> --}}


                                                                </div>
                                                            </div>
                                                              
                                                           

                                                        {{-- </div> --}} 
                                                    </div>
                                                </div>
                                            

                                            
                                        </div>
                                     
                                                {{-- Endproduct --}}

                                              
                                            </div>
                                        
                                    </div>

                            @endif


                                      
                                    </div>
                                    
                                        <div class="form-group">
                                            <button style="margin-top: 30px;" class=" btn btn-primary">
                                                    Add Order


                                            </button>
                                        </div>

                         {{--    @endif --}}

                                <!-- /.card -->
                            </form>
                            </div>
                        </div>
                    </div>
                </section>




    @endsection



{{-- Js Code  --}}
@push('scripts')
    {{-- supermarket ajax --}}
<script>
        $(".supermarket_6").change(function(){

            $.ajax({
               
                url: "{{ route('get_supermarket_branches') }}?supermarket_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {

                    $('.branch_9').html('');

                    $('.branch_9').append(new Option('select Branch',0,true,true));

                    data.forEach(function(x){
                        
                    $('.branch_9').append(new Option(x.name_ar,x.id,false,false));

                    })
                }
            });//end ajax


        });
</script>

{{-- branch Ajax --}}
<script>

        $(".branch_9").change(function(){

            $.ajax({

                url: "{{ route('get_branch_product') }}?branch_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('.product_9').html('');
                    data.forEach(function(x,i){
                

                    $('.product_9').append(new Option(x.name_ar,x.id,false,false)).trigger("change");

                     $('.price').val(parseInt(x.price));
                    $(".product_qty").attr("data-price", x.price);
                
                    })

                       

                   
                }
            });// end ajax

             $(".branch_9").attr("disabled", "disabled");
             $(".supermarket_6").attr("disabled", "disabled");
                  
                    var selectedStatus      = $(this).find('option:selected').val();
                    var selectedsuperMarket = $('.supermarket_6').find('option:selected').val();

                     $('.branch_id').val(selectedStatus);
                     $('.branch_product_id').val(selectedStatus);
                     $('.supermarket_id').val(selectedsuperMarket);
                     
                    
        });

        $('.product_9').change(function(){

            $.ajax({
                url: "{{ route('get_product') }}?product_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                 
                  $('.price').val(parseInt(data.price));
                   
                  

                }
            });
        });

      
        //  document.getElementsByClassName("product_qty").addEventListener("change", function() {
        //    console.log("function is run");
        // });

        // $('.product_qty').change(function(){

        //       var qty = $('.product_qty').val();   
        //       var price = $(this).data('price');   
        //          $('.price').val( price  * qty ) ;
            // $.ajax({
            //     url: "{   route('get_product') }}?product_id=" + $('.product_9').val(),
            //     method: 'GET',
            //     success: function(data) {
            //      var price = parseInt(data.price) ;
            //      var qty =  parseInt($('.product_qty').val());
            //      console.log(price);
            //      console.log(qty);
              
                   


            //     }
            // });
        //});

        $('body').on('keyup change', '.product_qty', function() {

        var quantity = $(this).val(); //2
        
        var unitPrice = $(this).data('price'); //150
        console.log(unitPrice);

            $.ajax({
                url: "{{     route('get_product') }}?product_id=" + $('.product_9').val(),
                method: 'GET',
                success: function(data) {
                 var quantity = parseInt(data.price) ;
                 var unitPrice =  parseInt($('.product_qty').val());
                 console.log(price);
                 console.log(qty);
              
        $(this).closest('tr').find('.price').val(quantity * unitPrice);
        

        });//end of ajax quantity change  
    });//end of product quantity change

            var x = 1;
    $('.add_input').click( function () {

        var max_input = 9;
        var options = $("#hamdyinput").html();
        console.log(options);

          
        if (x < max_input) {
              $('.div_inputs').append(`<tr>
                        <td> 
                            <select class="product_9 @error('product_id') is-invalid @enderror select2 product" name="products[]" id="hamdyinputx" 
                            data-placeholder="Select a product" style="width: 100%;" required>
                                ${options}
                            </select>
                        </td>
                        <td>  
                            <input type="number" name="quantity[]" min="1" value="1" class="product_qty @error('quantity') is-invalid @enderror form-control " required>
                        </td>
                        <td class="product-price">  
                          <input type="number" name="price" min="0" max="99999.99"class="price @error('price') is-invalid @enderror form-control price" required>
                        </td>
                        <td>
                            <a href="#" class="remove_input btn btn-danger" style="width: 73px;height: 46px;"><i class="fa fa-trash">حذف</i></a> 

                                            </button> 
                        </td>
                    </tr>`);
              
           // $('#select2-hamdyinput'+x+'-container').append($options);
            $('.product_9').select2();
            x++;
        }
        return false;
    });
    $(document).on('click', '.remove_input', function () {
        $(this).parent('div').remove();
        x--;
        return false;
    });
</script>



 {{--  // $('.div_inputs').append(`<span><div class="row" style="align-items: center;"> 

            //     <div class="col-md-4"> 
            //         <div class="form-group"> 
            //             <label> عنوان الحقل</label> 

            //             <select class="product_9 select2 product" id="hamdyinputx" name="products[]" data-placeholder="Select a product" style="width: 100%;" required> 
            //              ${options}
            //             </select>
                        
            //         </div> 
            //     </div>

            //     <div class="col-md-3"> 
            //         <div class="form-group"> 
            //             <label> الكية </label> 
            //             <input type="number"  name="quantity[]" min="1" value="1" class="product_qty form-control > 
            //         </div> 
            //     </div> 

            //     <div class="col-md-3"> 
            //         <div class="form-group"> 
            //         <label> السهر</label> 
            //         <input type="number" name="price[]"  min="0" max="99999.99" class="price form-control" > 
            //         </div> 
            //     </div>

            //     <div class="clearfix"></div> 
                

            //     <a href="#" class="remove_input btn btn-danger" style="width: 73px;height: 46px;"><i class="fa fa-trash">حذف</i></a> 
                
            //     </div> </span>`); --}}

{{-- hamdyinput --}}
{{-- <script type="text/javascript">
    var x = 1;
    $(document).on('click', '.add_input', function () {

        var max_input = 9;
        var options = $("#hamdyinput").html();
        console.log(options);
        if (x < max_input) {

            $('.div_inputs').append(`<div class="row" style="align-items: center;"> 
                <div class="col-md-4"> 
                <div class="form-group"> 
                <label> عنوان الحقل</label> 

                <select class="product_9 select2 product" id="hamdyinputx" name="products[]" data-placeholder="Select a product" style="width: 100%;" required> 
                 ${options}
                </select>
                    
                </div> 
                </div> 
                <div class="col-md-3"> 
                <div class="form-group"> 
                <label> الكية </label> 
                <input type="number"  name="quantity[]" min="1" value="1" class="product_qty form-control > 
                </div> 
                </div> 
                <div class="col-md-3"> 
                <div class="form-group"> 
                <label> السهر</label> 
                <input type="number" name="price[]"  min="0" max="99999.99" class="price form-control" name="price[]" > 
                </div> 
                </div> 
                <div class="clearfix"></div> 
                

                <a href="#" class="remove_input btn btn-danger" style="width: 73px;height: 46px;"><i class="fa fa-trash">حذف</i></a> 
                
                </div>`);
           // $('#select2-hamdyinput'+x+'-container').append($options);
            $('.product_9').select2();
            x++;
        }
        return false;
    });
    $(document).on('click', '.remove_input', function () {
        $(this).parent('div').remove();
        x--;
        return false;
    });
</script>
 --}}
@endpush