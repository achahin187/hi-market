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
                            @if($order->request != 0)

                                <li class="breadcrumb-item active"> <button type="button" data-toggle="modal" data-target="#showvideo" class="btn btn-primary">cart description</button></li>
                            @endif
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
                            <form role="form" action="{{route('order_client.update',$order->id) }} " method="POST" enctype="multipart/form-data">
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

                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> client mobile number</label>
                                            <input type="text" value="{{$order->mobile_delivery }} " name="mobile_number" class="@error('mobile_number') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                            @error('mobile_number')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> client location</label>
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
                                            <button type="submit" class="btn btn-primary">Save</button>
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

                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label>select product</label>

                                                        @if(isset($orderproduct))

                                                        <select class=" @error('product_id') is-invalid @enderror select2 product" name="product_id" data-placeholder="Select a State" style="width: 100%;" required disabled>

                                                            @foreach(\App\Models\Product::all() as $editproduct)

                                                                <option data-price="{{$editproduct->price}}" <?php if($orderproduct->id == $editproduct->id) echo 'selected'; ?> value="{{ $editproduct->id }}">
                                                                    @if(App::getLocale() == 'ar')

                                                                        {{ $editproduct->arab_name }}

                                                                    @else

                                                                        {{ $editproduct->eng_name }}

                                                                    @endif

                                                                </option>

                                                            @endforeach

                                                        </select>

                                                        <input type="hidden" name="product_id" value="{{$orderproduct->id}}" />

                                                        @else

                                                            <select class=" @error('product_id') is-invalid @enderror select2 product" name="product_id" data-placeholder="Select a State" style="width: 100%;" required>

                                                                @foreach(\App\Models\Product::all() as $editproduct)

                                                                    <option data-price="{{$editproduct->price}}" value="{{ $editproduct->id }}">

                                                                        @if(App::getLocale() == 'ar')

                                                                            {{ $editproduct->arab_name }}

                                                                        @else

                                                                            {{ $editproduct->eng_name }}

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
                                                    <input type="number" name="quantity" min="1" value="@if(isset($orderproduct)){{$quantity}} @endif" class="@error('quantity') is-invalid @enderror form-control quantity" required>

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

                                                        @if(isset($orderproduct))

                                                            save

                                                        @else

                                                            add

                                                        @endif

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                    <div class="card-body">
                                        <h3>Order Products</h3>
                                        <h5>Total : {{$total_price}}</h5>
                                        <table id="example1" class="table table-bordered table-hover">
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

        @if($order->request !=0)

            <div class="modal fade" id="showvideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Cancel Order</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>cart description</label>
                                <textarea disabled class=" @error('notes') is-invalid @enderror form-control" name="notes" rows="3" placeholder="Enter ...">

                                    {{$request->cart_description}}
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    @endsection




