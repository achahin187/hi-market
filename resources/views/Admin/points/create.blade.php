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
                            <li class="breadcrumb-item"><a href="{{route('products.index')}}">points</a></li>
                            <li class="breadcrumb-item active">points Form</li>
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

                                @if(isset($point))

                                    edit point

                                @else

                                    create points

                                @endif
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="@if(isset($point)){{route('points.update',$point->id) }} @else {{route('points.store') }} @endif" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if(isset($point))

                                @method('PUT')

                            @endif

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.product_from')}}</label>
                                    <input type="number" name="from" min="0" @if(isset($point)) value="{{$point->from}}" @else value="0" @endif class=" @error('from') is-invalid @enderror form-control" >
                                    @error('from')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.product_to')}}</label>
                                    <input type="number" name="to" min="0" @if(isset($point)) value="{{$point->to}}" @else value="0" @endif class=" @error('to') is-invalid @enderror form-control" >
                                    @error('to')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.product_value')}}</label>
                                    <input type="number" name="value" min="0" @if(isset($point)) value="{{$point->value}}" @else value="0" @endif class=" @error('value') is-invalid @enderror form-control" >
                                    @error('value')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>product vendor </label>
                                    <select class=" @error('vendor_id') is-invalid @enderror select2" name="vendor_id" data-placeholder="Select a State" style="width: 100%;" required>

                                        <option value="0">discount</option>
                                        <option value="1">gift</option>

                                    </select>
                                </div>

                            <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>


@endsection



