@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.add_driver') }}</h1>
                        @include('includes.errors')
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
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admins.index')}}">{{ __('admin.delivery') }}</a></li>
                            <li class="breadcrumb-item active">{{ isset($driver) ?  __('admin.edit_driver') : __('admin.add_driver') }}</li>
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

                                    @if(isset($driver))
                                       {{ __('admin.edit_driver') }}
                                    @else
                                         {{ __('admin.add_driver') }}
                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($driver)){{route('delivery.update',$driver->id) }} @else {{route('delivery.store') }} @endif" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if(isset($driver))

                                    @method('PUT')

                                @endif

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name')}}</label>
                                        <input type="text" value="@if(isset($driver)){{$driver->name }} @endif" name="name" class=" @error('name') is-invalid @enderror form-control" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.email') }}</label>
                                        <input type="email" value="@if(isset($driver)){{$driver->email }} @endif" name="email" class="@error('email') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{ __('admin.password') }}</label>
                                        <input type="password" class="@error('password') is-invalid @enderror form-control" id="exampleInputPassword1" name="password" placeholder="Password" >
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>{{ __('admin.delivery_company') }} </label>
                                        <select class=" @error('company_id') is-invalid @enderror select2" name="company_id" data-placeholder="Select a State" style="width: 100%;" required>
                                            @if(isset($driver) && Auth('web')->user()->hasRole('super_admin'))
                                                @foreach($companies as $company)

                                                        <option <?php if($company->id == $driver->company->id) echo 'selected'; ?> value="{{ $company->id }}">{{ $company['name_'.App()->getLocale()] }}</option>


                                                @endforeach
                                            @elseif(Auth('web')->user()->hasRole('delivery_admin') )
                                                @foreach($companies as $company)


                                                        <option value="{{  Auth('web')->user()->company_id }}" >{{  Auth('web')->user()->companycompany['name_'.App()->getLocale()] }}
                                                            </option>


                                                @endforeach

                                            @endif
                                        </select>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">{{ isset($driver) ? __('admin.edit') :__('admin.add') }}</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection


