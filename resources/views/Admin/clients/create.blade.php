@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.add_client') }}</h1>
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
                            <li class="breadcrumb-item"><a href="{{route('clients.index')}}">{{ __('admin.clients') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('admin.add_client') }}</li>
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

                                    @if(isset($client))
                                        {{ __('admin.edit') }}
                                    @else
                                        {{ __('admin.add') }}

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($client)){{route('clients.update',$client->id) }} @else {{route('clients.store') }} @endif" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if(isset($client))

                                    @method('PUT')

                                @endif

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name')}}</label>
                                        <input type="text" value="@if(isset($client)){{$client->name }} @endif" name="name" class=" @error('name') is-invalid @enderror form-control" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.email') }}</label>
                                        <input type="email" value="@if(isset($client)){{$client->email }} @endif" name="email" class="@error('email') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.address') }}</label>
                                        <input type="text" value="@if(isset($client)){{$client->address }}@endif " name="address" class="@error('address') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter address" required>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
{{-- 
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> {{ __('admin.city') }}</label>
                                        <input type="text" value="@if(isset($client)){{$client->city }}@endif " name="city" class="@error('city') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter city" required>
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
 --}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> {{ __('admin.phone') }}</label>
                                        <input type="text" value="@if(isset($client)){{$client->mobile_number }} @endif" name="mobile_number" class="@error('mobile_number') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                        @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                   




                                    @if(!isset($client))

                                        <div class="form-group">
                                            <label>{{ __('admin.status') }}</label>
                                            <select class="@error('status') is-invalid @enderror select2" name="status" data-placeholder="Select a State" style="width: 100%;" required>


                                                <option value="active">{{ __('admin.active') }}</option>
                                                <option value="inactive">{{ __('admin.inactive') }}</option>

                                            </select>

                                            @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    @endif

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{ __('admin.password') }}</label>
                                        <input type="password" class="@error('password') is-invalid @enderror form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                                        <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-lg" placeholder="{{ __('admin.confirm_password') }}" value="">
                                    </div>

                                <!-- /.card-body -->

                                <div class="card-footer">
                                      @if(isset($client))
                                    <button type="submit" class="btn btn-primary">{{ __('admin.edit') }}</button>
                                    @else

                              <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>

                                    @endif
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection


