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

                            @csrf
                       
                                  

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
                                                    <select name="supermarket_id" id='supermarket_6'  class="form-control select2">
                                                    
                                                <option  selected  disabled>Please Select Source</option>

                                                    @foreach( $supermarkets as  $supermarket) 
                                            <option  
                                            @if(session()->get('supermarket_id') != $supermarket->id && session()->get('supermarket_id') != null)            selected disabled
                                            @endif 
                                                        value="{{ $supermarket->id }}">{{$supermarket->name}}
                                                    </option>
                                                    @endforeach

                                                    </select>
                                                </div>

                                            @if(session()->get('branch_id'))

                                                 <div class="form-group"  >
                                                    <label for="branch">Branch</label>
                                                    <select name="branch_id"  class="form-control select2">
                                                    @php
                                                    $branch = \App\Models\Branch::find(session()->get('branch_id'))
                                                    @endphp
                                                        <option value="{{ $branch->id }}" selected > {{ $branch->name  }}</option>
                                                           
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

                                            <a href="{{ route('change.order') }}" style="margin-top: 30px;" class=" btn btn-primary">
                                                    Cahnge Order


                                            </a >
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

                                            <form role="form" action="{{ route('store.product.client') }}" method="POST" enctype="multipart/form-data">

                                                <div class="card-body">

                                                    @csrf

                                                    <div class="row">

                                                        <div class="col-md-3">

                                                            <div class="form-group">

                                                                <label>{{ __('admin.select_product') }}</label>


                                                                        <select class="product_9 @error('product_id') is-invalid @enderror select2 product" name="product_id" 
                                                                         data-placeholder="Select a product" style="width: 100%;" required>

                                                                           


                                                                           
                                                                        </select>

                                                                    @endif

                                                            </div>
                                                        </div>
 <input type="hidden" class="branch_product_id" name="branch_id" value="">
 <input type="hidden" class="supermarket_data_id" name="supermarket_id" value="">

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">{{__('admin.quantity')}}</label>
                                                                <input type="number" name="quantity" min="1" value="1" class="product_qty @error('quantity') is-invalid @enderror form-control " required>

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
                                                        <div class="div_inputs"></div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <button style="margin-top: 30px;" class=" btn btn-primary">
                                                                           {{ __('admin.add') }}


                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="card-body">
                                                
                                                <table  class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>{{ __('admin.name') }}</th>
                                                        <th>{{ __('admin.quantity') }}</th>
                                                        <th>{{ __('admin.price') }}</th>
                                                        <th>{{ __('admin.delete') }}</th>
                                                    </tr>
                                                    </thead>
                                                      
                                                      @foreach($orders as $order)
                                                        <tr>
                                                        <td>{{ $order->product_name }}</td>
                                                        <td>{{ $order->quantity }}</td>
                                                        <td>{{ $order->price }}</td>
                                                        <td><a href="{{ route('manual.order.delete',$order->id) }}" class="btn btn-danger">Delete</a></td>
                                                         </tr>
                                                        @endforeach
                                                      
                                                         </tbody>
                                                </table>
                                            </div>
                                        </div>
                                     
                                                {{-- Endproduct --}}

                                              
                                            </div>
                                        
                                    </div>

                            @endif


                                      
                                    </div>
                                    
                    <form action="{{ route('store.order') }}" method="POST">
                        @csrf
                               <div class="col-md-3">

                                @foreach( $orders  as $index=>$order)
                                <input type="hidden" name="order[]" value="{{ $order }}">
                                <input type="hidden" class="branch_id" name="branch_id" value="{{ session()->get('branch_id') }}">
                               
                                @endforeach
                                        <div class="form-group">
                                            <button style="margin-top: 30px;" class=" btn btn-primary">
                                                    Add Order


                                            </button>
                                        </div>
                                    </div>               
                         </form>   

                         {{--    @endif --}}

                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </section>




    @endsection




@push('scripts')
<script>

        $("#supermarket_6").change(function(){
            $.ajax({
               
                url: "{{ route('get_supermarket_branches') }}?supermarket_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('.branch_9').html('');
                    data.forEach(function(x){
                        
                    $('.branch_9').append(new Option(x.name_ar,x.id,false,false)).trigger("change");
                    })
                }
            });
        });
    
</script>


<script>

        $(".branch_9").change(function(){
            $.ajax({
                url: "{{ route('get_branch_product') }}?branch_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('.product_9').html('');
                    data.forEach(function(x,i){
                

                    $('.product_9').append(new Option(x.name_ar,x.id,false,false)).trigger("change");

                     $('.price').val(x.price);
                
                    })

                       

                   
                }
            });
                  
                    var selectedStatus      = $(this).find('option:selected').val();
                    var selectedsuperMarket = $('#supermarket_6').find('option:selected').val();
                    $('.branch_id').val(selectedStatus);
                     $('.branch_product_id').val(selectedStatus);
                     $('.supermarket_data_id').val(selectedsuperMarket);
                     
                    
        });

        $('.product_9').change(function(){

            $.ajax({
                url: "{{ route('get_product') }}?product_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                 
                 //$('.price').val(data.price);
                   


                }
            });
        });


        $('.product_qty').change(function(){

            $.ajax({
                url: "{{ route('get_product') }}?product_id=" + $('.product_9').val(),
                method: 'GET',
                success: function(data) {
                 var price = parseInt(data.price) ;
                 var qty =  parseInt($('.product_qty').val());

                 $('.price').val( price  * qty ) ;
                   


                }
            });
        });
    
</script>




@endpush