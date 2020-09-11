@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create order</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"> <button type="button" data-toggle="modal" data-target="#showvideo" class="btn btn-primary">cart description</button></li>
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
                            <form role="form" action="{{route('orders.store',$request->id) }}" method="POST" enctype="multipart/form-data">

                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('client name')}}</label>
                                        <input type="text" value="{{$request->client->name }}" name="name" class=" @error('name') is-invalid @enderror form-control" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Request Address</label>
                                        <input type="text" value="{{$request->address }} " name="address" class="@error('address') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>select product</label>
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
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">{{__('admin.quantity')}}</label>
                                                    <input type="number" name="quantity" min="1" class=" quantity @error('quantity') is-invalid @enderror form-control" required>

                                                    @error('quantity')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">{{__('product price')}}</label>
                                                    <input type="number" name="price" min="0" max="99999.99" class=" quantity @error('price') is-invalid @enderror form-control price">

                                                    @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


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


    @endsection



