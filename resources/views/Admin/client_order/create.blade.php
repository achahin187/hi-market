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

                                                <input type="hidden" name="name" value="{{$client->name }}">

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
                                                    <input type="text" value="" name="mobile_number" class="@error('mobile_number') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                                    @error('mobile_number')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> {{ __('admin.location') }}</label>
                                                    <input type="text" value="" name="address" class="@error('address') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
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

                                                 <input type="hidden" name="client_id" value="{{ request()->client_id }}">

                                           
                                                <div class="form-group"  >
                                                    <label for="branch">Branch</label>
                                                    <select name="branch_id"  class="branch_9 form-control select2">
                                                    
                                                        <option  selected  disabled>Please Select Branch</option>
                                                           
                                                    </select>
                                                </div>

                                       

                                            <a href="{{ route('change.order',['client_id'=>request()->client_id]) }}" style="margin-top: 30px;" class=" btn btn-primary">
                                                    Reset Order


                                            </a >
                                            <br>  
                                            <br>  
                                            <br>  

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
                                                        <h4>@lang('site.total_product') : <span class="total-price">0</span></h4>

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
                                                                <input type="number" name="quantity[]" min="1" value="1" class=" @error('quantity') is-invalid @enderror form-control product-quantity" required>
                                                            </td>
                                                            <td class="product-price">  
                                                              
                                                            </td>
                                                            <td>
                                                               
                                                                <a href="#" class="add_input btn btn-info"><i class="fa fa-plus">اضافة</i></a>
                                                            </td>
                                                        </tr>
                                                           

                                                    </tbody>

                                                </table><!-- end of table -->
                                            </div>
                                @endif

                                <div class="card card-primary">

                                            <div class="card-header">
                                                @if(isset($productorder) && isset($order) && !isset($offer))

                                                    {{ __('admin.add_offer') }}

                                                @else

                                                    Products

                                                @endif

                                            </div>

                                           
                                                <div class="card-body">
                                                       

                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                       
                                                        <th>@lang('site.delivery')</th>
                                                        <th>@lang('site.dicount')</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody class="offer-list">

                                                   
                                                        <tr>
                                                            <td>  
                                                                <input type="number" name="delivery"  min="1" value="1" class="delivery-money @error('quantity') is-invalid @enderror form-control" required>
                                                            </td>

                                                            <td>  
                                                                <input type="number" name="discount" min="1" value="1" class="discount-money @error('quantity') is-invalid @enderror form-control" required>
                                                            </td>
                                                           
                                                           <td>  
                                                                <a href="#" class="btn btn-primary  total-price-offer" >Add total</a>
                                                            </td>
                                                        </tr>
                                                           

                                                    </tbody>

                                                </table><!-- end of table -->

                                                {{-- product total --}}
                                                 <h4>@lang('site.total_product') : <span class="total-price-product">0</span></h4>

                                                 <input type="hidden" name="order_price" class="order_price" value="">
                                                  {{-- delivery --}}
                                                  <h4>@lang('site.total_delivery') : <span class="total-price-delivery">0</span></h4>

                                                  {{-- dicount --}}
                                                  <h4>@lang('site.total_discount') : <span class="total-price-discount">0</span></h4>

                                                  {{--  final total --}}
                                                  <h4>@lang('site.total') : <span class="total-price-result">0</span></h4>
                                            </div>

                                                         <input type="hidden" class="branch_product_id" name="branch_id" value="">



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

                     $('.product_9').append(new Option('select Product',0,true,true));

                       
                    data.data.forEach(function(x){
                

                    $('.product_9').append(new Option(x.name_ar,x.id,false,false)).trigger("change");

                     $('.product-price').val(parseInt(x.price));
                    $(".product_qty").attr("data-price", x.price);
                     //$('.product_9').attr('name', 'product['+x.id+'][quantity]');
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

        //$('.product_9').change(function(){
        $('body').on('keyup change', '.product_9', function() {    

            $.ajax({
                url: "{{ route('get_product') }}?product_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                 
                  $('.product-price').html(data.price);
                  console.log(data);
                   calculateTotal();
                   //$('.product_9').attr('name', 'product['+data.id+'][quantity]');
                }
            });
        });

    

        $('body').on('keyup change', '.product-quantity', function() {

      
            var quantity = parseInt($(this).val()); //2
            var self = this;
            $.ajax({
                url: "{{ route('get_product') }}?product_id=" + $('.product_9').val(),
                method: 'GET',
                success: function(data) {
             $(self).closest('tr').find('.product-price').html(quantity * data.price);
           
              //$('.product_9').attr('name', 'product['+data.id+'][quantity]');
                calculateTotal(); 
                }
        });//end of ajax quantity change  
    });//end of product quantity change

            var x = 1;
    $('.add_input').click( function () {

        var max_input = 9;
        var options = $("#hamdyinput").html();
       
          
        if (x < max_input) {
              $('.order-list').append(`<tr>
                        <td> 
                            <select class="product_9 @error('product_id') is-invalid @enderror select2 product" name="products[]" id="hamdyinput${x}" 
                            data-placeholder="Select a product" style="width: 100%;" required>
                                ${options}
                            </select>
                        </td>
                        <td>  
                            <input type="number" name="quantity[]" min="1" value="1" class=" @error('quantity') is-invalid @enderror form-control product-quantity" required>
                        </td>
                        <td class="product-price">  
                         
                        </td>
                        <td>
                            <a href="#" class="remove_input btn btn-danger" style="width: 73px;height: 46px;"><i class="fa fa-trash">حذف</i></a> 

                                            </button> 
                        </td>
                    </tr>`
                    );
              
           // $('#select2-hamdyinput'+x+'-container').append($options);
            $('.product_9').select2();
            x++;
        }
        return false;
    });

     $('.total-price-offer').click( function (e) {
        e.preventDefault();
         var delivery = $('.delivery-money').val();
         var discount = $('.discount-money').val();
         var total    = $('.total-price').html();

         calculateTotalOffer(parseInt(delivery), parseInt(total),  parseInt(discount));
      
    });

  $(document).on('click', '.remove_input', function () {
        $(this).closest('tr').remove();
         calculateTotal();
        x--;
        return false;
    });

    //calculate the total
function calculateTotal() {


    var price = 0;

    $('.order-list .product-price').each(function(index) {
        
        price += parseFloat($(this).html());

    });//end of product price
   console.log(price);
    $('.total-price').html(price);

   

 }
   function calculateTotalOffer(delivery, total, discount) {


    var price = 0;
    var productTotal = $('.total-price').html();
    $('.order-list .product-price').each(function(index) {
        
        price += parseFloat($(this).html());

    });//end of product price
    
    var result = total-discount;

    if (result <= 0) {
                
        $('.total-price-result').html((total * {{ $setting->reedem_point /100 }})+delivery);

        $('.total-price-delivery').html(delivery);
        $('.total-price-discount').html(total * {{ (100 - $setting->reedem_point) /100 }});
        $('.total-price-product').html(productTotal);
        $('.order_price').val(productTotal);
  
    }else{
         $('.total-price-result').html(result+delivery);
         $('.total-price-delivery').html(delivery);
         $('.total-price-discount').html(discount);
         $('.total-price-product').html((total * {{ $setting->reedem_point /100 }})+delivery);
         $('.order_price').val(productTotal);
        }
    
   

 }
   

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