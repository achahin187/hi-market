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

                                    <form role="form" action="{{route('order_client.update',$order->id) }} " method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{__('admin.name')}}</label>
                                                    <input type="text" value="{{$order->client->name }}" name="name" class=" @error('name') is-invalid @enderror form-control" disabled required>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{__('admin.email')  }}</label>
                                                    <input type="email" value="{{$order->client->email }} " name="email" class="@error('email') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" disabled required>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> {{__('admin.phone')  }}</label>
                                                    <input type="text" value="{{$order->mobile_delivery }} " name="mobile_number" class="@error('mobile_number') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                                    @error('mobile_number')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> {{ __('admin.location') }}</label>
                                                    <input type="text" value="{{$order->address }} " name="address" class="@error('address') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                                    @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                @if($order->status == "7" && $order->client_review != null)

                                                    <div class="form-group">
                                                        <label>{{__('client review')}}</label>
                                                        <textarea class=" @error('review') is-invalid @enderror form-control" name="review" rows="3" disabled placeholder="Enter ...">
                                                                {{$order->client_review }}
                                                        </textarea>
                                                                @error('arab_spec')
                                                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>


                                                    <div class="form-group">
                                                        <label>review status</label>
                                                        <select class="@error('status') is-invalid @enderror select2" name="review_status" data-placeholder="Select a State" style="width: 100%;" required>


                                                            <option value="1" <?php if($order->review_status == '1') echo 'selected'; ?>>approved</option>
                                                            <option value="0" <?php if($order->review_status == '0') echo 'selected'; ?>>rejected</option>


                                                        </select>

                                                        @error('status')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>

                                                @endif


                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                            @endif
                            
                                <!--second card-->
                                {{-- @if(Auth()->user()->hasAnyPermission(['order-date', 'order-status', 'order-address','order-driver'])) --}}
                                  @if(Auth()->user()->can('order-edit-client-product'))
                                    <div class="card card-primary">

                                        <div class="card-header">
                                            {{ __('admin.edit_order') }}
                                        </div>

                                        <form role="form" action="{{route('orders.update',$order->id) }} " method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')


                                            <div class="card-body">


                                                {{-- @if(Auth()->user()->can('order-status')) --}}

                                                <div class="form-group">
                                                    <label>{{ __('admin.status') }}</label>
                                                    <select class="@error('status') is-invalid @enderror select2" name="status" data-placeholder="Select a State" style="width: 100%;" required>


                                                        <option value="0" <?php if($order->status == '0') echo 'selected'; ?>>new</option>
                                                        <option value="1" <?php if($order->status == '1') echo 'selected'; ?>>approved</option>
                                                        <option value="2" <?php if($order->status == '2') echo 'selected'; ?>>prepared</option>
                                                        <option value="3" <?php if($order->status == '3') echo 'selected'; ?>>shipping</option>
                                                        <option value="4" <?php if($order->status == '4') echo 'selected'; ?>>shipped</option>
                                                        <option value="7" <?php if($order->status == '6') echo 'selected'; ?>>received</option>


                                                    </select>

                                                    @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                {{-- @endif
 --}}
                                              {{--   @if(auth()->user()->can('order-driver') && $order->status >= 2) --}}
                                                    <div class="form-group">
                                                        <label>{{ __('admin.assign_driver') }}</label>
                                                      <select class="@error('driver') is-invalid @enderror select2" name="driver" data-placeholder="Select a State" style="width: 100%;">

                                                            @if($order->user != null)
                                                                @foreach(\App\User::role(['driver'])->get() as $driver)

                                                                    <option <?php if($order->user->id == $driver->id) echo 'selected'; ?> value="{{ $driver->id }}">

                                                                            {{ $driver->name }}

                                                                    </option>

                                                                @endforeach
                                                            @else
                                                                @foreach(\App\User::role('driver')->get() as $driver)

                                                                    <option value="{{ $driver->id }}">


                                                                            {{ $driver->name }}


                                                                    </option>

                                                                @endforeach

                                                            @endif


                                                        </select>

                                                    @error('driver')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                             {{--    @endif --}}

                                              {{--    @if(Auth()->user()->can('order-address')) --}}
                                                <div class="form-group">
                                                    <label>{{__('admin.order_address')}}</label>
                                                    <textarea class=" @error('address') is-invalid @enderror form-control" name="address" rows="3" placeholder="Enter ...">

                                                                {{$order->address }}
                                                        </textarea>
                                                    @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                </div>
                                               {{--  @endif --}}


                                               {{--  @if(Auth()->user()->can('order-date')) --}}
                                                <div class="form-group">
                                                    <label>{{ __('admin.schedule-delivery_date') }}</label>
                                                    <input type="datetime-local" class=" @error('delivery_date') is-invalid @enderror form-control"  @if(isset($order)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($order->delivery_date)) }}" @endif name="delivery_date" data-placeholder="Select a expiration date" style="width: 100%;" required>

                                                    @error('delivery_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                {{-- @endif --}}


                                               {{--  @if(Auth()->user()->hasAnyPermission(['order-date', 'order-status', 'order-address'])) --}}
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                                                    </div>
                                               {{--  @endif --}}
                                            </div>
                                        </form>
                                    </div>
                                 @endif



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

                                            <form role="form" action="@if(isset($productorder) && !isset($offer)){{route('orderproduct.update',['order_id' => $order->id,'product_id' => $productorder->id]) }} @else {{route('products.store',$order->id) }} @endif" method="POST" enctype="multipart/form-data">

                                                <div class="card-body">

                                                    @csrf

                                                    @if(isset($productorder) && !isset($offer))

                                                        @method('PUT')

                                                    @endif

                                                    <div class="row">

                                                        <div class="col-md-3">

                                                            <div class="form-group">

                                                                <label>{{ __('admin.select_product') }}</label>

                                                                    @if(isset($productorder) && !isset($offer))

                                                                        <select class=" @error('product_id') is-invalid @enderror select2 product" name="product_id" data-placeholder="Select a State" style="width: 100%;" required disabled>

                                                                            @foreach(\App\Models\Product::where('status','active')->where('flag',0)->get() as $editproduct)

                                                                                <option data-price="{{$editproduct->price}}" <?php if($productorder->id == $editproduct->id) echo 'selected'; ?> value="{{ $editproduct->id }}">
                                                                                    @if(App::getLocale() == 'ar')

                                                                                        {{ $editproduct->name_ar }}

                                                                                    @else

                                                                                        {{ $editproduct->name_en }}

                                                                                    @endif

                                                                                </option>

                                                                            @endforeach

                                                                        </select>

                                                                        <input type="hidden" name="product_id" value="{{$productorder->id}}" />

                                                                    @else

                                                                        <select class=" @error('product_id') is-invalid @enderror select2 product" name="product_id" data-placeholder="Select a State" style="width: 100%;" required>

                                                                            @foreach(\App\Models\Product::where('status','active')->where('flag',0)->get() as $editproduct)

                                                                                <option data-price="{{$editproduct->price}}" value="{{ $editproduct->id }}">

                                                                                    @if(App::getLocale() == 'ar')

                                                                                        {{ $editproduct->name_ar }}

                                                                                    @else

                                                                                        {{ $editproduct->name_en }}

                                                                                    @endif

                                                                                </option>

                                                                            @endforeach
                                                                        </select>

                                                                    @endif

                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">{{__('admin.quantity')}}</label>
                                                                <input type="number" name="quantity" min="1" value="@if(isset($productorder) && !isset($offer)){{$quantity}} @endif" class="@error('quantity') is-invalid @enderror form-control quantity" required>

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
                                                                <input type="number" name="price" min="0" max="99999.99" class=" @error('price') is-invalid @enderror form-control price" required>

                                                                @error('price')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <button type="submit" style="margin-top: 30px;" class="btn btn-primary">

                                                                    @if(isset($productorder) && !isset($offer))

                                                                        {{ __('admin.add') }}

                                                                    @else

                                                                           {{ __('admin.add') }}

                                                                    @endif

                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="card-body">
                                                <h5>{{ __('admin.total') }} : {{$total_products_price}}</h5>
                                                <table id="example1" class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>{{ __('admin.name') }}</th>
                                                        <th>{{ __('admin.price') }}</th>
                                                        <th>{{ __('admin.quantity') }}</th>
                                                        <th>{{ __('admin.supermarket') }}</th>
                                                        <th>{{ __('admin.controls') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($order->products()->where('flag',0)->get() as $orderproduct)
                                                        <tr>
                                                            <td>{{$orderproduct->name_en}}</td>
                                                            <td>{{$orderproduct->price}}</td>
                                                            <td>{{$orderproduct->pivot->quantity}}</td>
                                                            <td>{{$orderproduct->supermarket->arab_name}}</td>
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
                             @endif           

                                        <!--fourth card-->

                                        <div class="card card-primary">

                                            <div class="card-header">
                                                @if(isset($productorder) && isset($order) && isset($offer))

                                                    {{ __('admin.Edit product offers') }}

                                                @else

                                                    {{ __('admin.Add product offer') }}

                                                @endif

                                            </div>

                                            <form role="form" action="@if(isset($productorder) && isset($offer)){{route('orderproduct.update',['order_id' => $order->id,'product_id' => $productorder->id]) }} @else {{route('products.store',$order->id) }} @endif" method="POST" enctype="multipart/form-data">

                                                <div class="card-body">

                                                    @csrf

                                                    @if(isset($productorder) && isset($offer))

                                                        @method('PUT')

                                                    @endif

                                                    <div class="row">

                                                        <div class="col-md-3">

                                                            <div class="form-group">

                                                                <label>{{ __('admin.select_product') }}</label>

                                                                @if(isset($productorder) && isset($offer))

                                                                    <select class=" @error('product_id') is-invalid @enderror select2 productoffer" name="product_id" data-placeholder="Select a State" style="width: 100%;" required disabled>

                                                                        @foreach(\App\Models\Product::where('status','active')->where('flag',1)->get() as $editproduct)

                                                                            <option data-price="{{$editproduct->price}}" <?php if($productorder->id == $editproduct->id) echo 'selected'; ?> value="{{ $editproduct->id }}">
                                                                                @if(App::getLocale() == 'ar')

                                                                                    {{ $editproduct->name_ar }}

                                                                                @else

                                                                                    {{ $editproduct->name_en }}

                                                                                @endif

                                                                            </option>

                                                                        @endforeach

                                                                    </select>

                                                                    <input type="hidden" name="product_id" value="{{$productorder->id}}" />

                                                                @else

                                                                    <select class=" @error('product_id') is-invalid @enderror select2 productoffer" name="product_id" data-placeholder="Select a State" style="width: 100%;" required>

                                                                        @foreach(\App\Models\Product::where('status','active')->where('flag',1)->get() as $editproduct)

                                                                            <option data-price="{{$editproduct->price}}" value="{{ $editproduct->id }}">

                                                                                @if(App::getLocale() == 'ar')

                                                                                    {{ $editproduct->name_ar }}

                                                                                @else

                                                                                    {{ $editproduct->name_en }}

                                                                                @endif

                                                                            </option>

                                                                        @endforeach
                                                                    </select>

                                                                @endif

                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">{{__('admin.quantity')}}</label>
                                                                <input type="number" name="quantity" min="1"  value="@if(isset($productorder) && isset($offer)){{$quantity}} @endif" class="@error('quantity') is-invalid @enderror form-control quantityoffer" required>

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
                                                                <input type="number" name="price" min="0" max="99999.99" class=" @error('price') is-invalid @enderror form-control priceoffer" required>

                                                                @error('price')
                                                                <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <button type="submit" style="margin-top: 30px;" class="btn btn-primary">

                                                                    @if(isset($productorder) && isset($offer))

                                                                        {{ __('admin.add') }}

                                                                    @else

                                                                       {{ __('admin.add') }}

                                                                    @endif

                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="card-body">
                                                <h5>{{ __('admin.total') }} : {{$total_product_offers_price}}</h5>
                                                <table id="example1" class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>{{ __('admin.name') }}</th>
                                                        <th>{{ __('admin.price') }}</th>
                                                        <th>{{ __('admin.quantity') }}</th>
                                                        <th>{{ __('admin.supermarket') }}</th>
                                                        <th>{{ __('admin.controls') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($order->products()->where('flag',1)->get() as $orderproduct)
                                                        <tr>
                                                            <td>{{$orderproduct->name_en}}</td>
                                                            <td>{{$orderproduct->price}}</td>
                                                            <td>{{$orderproduct->pivot->quantity}}</td>
                                                            <td>{{$orderproduct->supermarket->arab_name}}</td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                        <form action="{{ route('orderproduct.delete',['order_id' => $order->id,'product_id' => $orderproduct->id]) }}" method="post">
                                                                            @csrf
                                                                            @method('delete')

                                                                            <a class="dropdown-item" href="{{ route('orderproduct.edit',['order_id' => $order->id,'product_id' => $orderproduct->id]) }}">{{ __('admin.edit') }}</a>
                                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this product?") }}') ? this.parentElement.submit() : ''">{{ __('admin.delete') }}</button>
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
                                    </div>


                           {{--  @endif --}}

                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </section>




    @endsection




