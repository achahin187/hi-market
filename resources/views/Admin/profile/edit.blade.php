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
                            <li class="breadcrumb-item"><a href="{{route('home')}}">dashboard</a></li>
                            <li class="breadcrumb-item active">Profile Form</li>
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

                                User Information
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{route('profile.update') }} " method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('name')}}</label>
                                            <input type="text" value="{{auth()->user()->name }}" name="name" class=" @error('name') is-invalid @enderror form-control" required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" value="{{auth()->user()->email }} " name="email" class="@error('email') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </div>
                                    </div>
                                </form>
                                    <!-- /.card-body -->

                                <form role="form" action="{{ route('profile.password') }}" method="POST" enctype="multipart/form-data">


                                    @csrf
                                    @method('put')

                                    <div class="card-body">

                                        @if (session('password_status'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('password_status') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <h3>change password</h3>

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Old Password</label>
                                            <input type="password" class="@error('old_password') is-invalid @enderror form-control" id="exampleInputPassword1" name="old_password" placeholder="Password">
                                            @error('old_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">New Password</label>
                                            <input type="password" class="@error('password') is-invalid @enderror form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                                            <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-lg" placeholder="{{ __('Confirm New Password') }}" value="">
                                        </div>


                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
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




