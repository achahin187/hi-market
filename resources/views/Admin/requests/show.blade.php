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
                            <li class="breadcrumb-item"><a href="{{route('requests.index')}}">Requests</a></li>

                            @if($request->converted == 1)
                                <li class="breadcrumb-item active"><a href="{{route('orders.edit',$order->id)}}">Edit order</a></li>
                            @else
                                <li class="breadcrumb-item active"><a href="{{route('orders.create',$request->id)}}">convert to order</a></li>
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

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('client name')}}</label>
                                    <input type="text" value="{{$request->client->name }}" name="name" class=" @error('name') is-invalid @enderror form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('client address')}}</label>
                                    <input type="text" value="{{$request->client->address }}" name="name" class=" @error('name') is-invalid @enderror form-control" disabled>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('Request Description')}}</label>
                                    <textarea class="form-control" rows="3" disabled>
                                        {{$request->cart_description }}
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Request Address</label>
                                    <input type="email" value="{{$request->address }} " name="email" class="@error('email') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" disabled>
                                </div>

                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection



