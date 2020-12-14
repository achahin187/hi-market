@extends('layouts.admin_layout')

@section('content')
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
                                                    <input type="text" value="{{$client->address }} " name="address" class="@error('address') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
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
                                         {{ __('admin.clients') }}
                                    </div>

                                  

                                            <div class="card-body">
                                                                          
                                                <div class="form-group ">
                                                    <label for="branch">SuperMarket</label>
                                                    <select name="supermarket_id" id='supermarket_6'  class="form-control select2">
                                                    
                                                        <option  selected  disabled>Please Select Source</option>
                                                    @foreach( $supermarkets as  $supermarket) 
                                                        <option  @if(old("supermarket_id") == $supermarket->id) selected
                                                                    @endif value="{{$supermarket->id}}">{{$supermarket->name}}</option>
                                                    @endforeach             
                                                    </select>
                                                </div>

                                                 <div class="form-group"  >
                                                    <label for="branch">Branch</label>
                                                    <select name="branch_id"  class="branch_9 form-control select2">
                                                    
                                                        <option  selected  disabled>Please Select Branch</option>
                                                           
                                                    </select>
                                                </div>

                                                <div class="form-group"  >
                                                    <label for="branch">category</label>
                                                    <select name="branch_id" id="category_9"  class="form-control select2">
                                                    
                                                        <option  selected  disabled>Please Select category</option>
                                                           
                                                    </select>
                                                </div>

                                                {{-- product --}}
                                                    <!--third card-->
                                    @if(Auth()->user()->can('order-edit-client-product'))
                                        <div class="card card-primary">

                                            <div class="card-header">
                                                @if(isset($productorder) && isset($order) && !isset($offer))

                                                    {{ __('admin.add_product') }}

                                                @else

                                                    {{ __('admin.edit_product') }}

                                                @endif

                                            </div>

                                            <form role="form" action="#" method="POST" enctype="multipart/form-data">

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

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">{{__('admin.quantity')}}</label>
                                                                <input type="number" name="quantity" min="1" value="" class="@error('quantity') is-invalid @enderror form-control quantity" required>

                                                                @error('quantity')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

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
                                                                <a href="#" id="add-product-btn"style="margin-top: 30px;" class="btn btn-primary">
                                                                           {{ __('admin.add') }}


                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="card-body">
                                                <h5 class="total-price">{{ __('admin.total') }} :Totall</h5>
                                                <table  class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>{{ __('admin.name') }}</th>
                                                        <th>{{ __('admin.quantity') }}</th>
                                                        <th>{{ __('admin.price') }}</th>
                                                        <th>{{ __('admin.controls') }}</th>
                                                    </tr>
                                                    </thead>
                                                      <tbody class="order-list">

                                       
                                                         </tbody>
                                                </table>
                                            </div>
                                        </div>
                                     
                                                {{-- Endproduct --}}

                                              
                                            </div>
                                        
                                    </div>

                            @endif
                                      
                                    </div>


                           {{--  @endif --}}

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
                    data.forEach(function(x){
                    
                    $('.product_9').append(new Option(x.name_ar,x.id,false,false)).attr('data-price',data.price).trigger("change");
                    })

                }
            });
        });
    
</script>

<script>

        $(".product_9").change(function(){
            
            console.log($(this).data('price'));
        });
    
</script>


@endpush