@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> {{ __('admin.add') }}</h1>
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
                            <li class="breadcrumb-item"><a href="{{route('admins.index')}}"> {{ __('admin.dashboard') }}</a></li>
                            <li class="breadcrumb-item active"> {{ __('admin.add_admin') }}</li>
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

                                    @if(isset($admin))
                                         {{ __('admin.edit') }}
                                    @else
                                        {{ __('admin.add') }}

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($admin)){{route('admins.update',$admin->id) }} @else {{route('admins.store') }} @endif" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if(isset($admin))

                                    @method('PUT')

                                @endif

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name')}}</label>
                                        <input type="text" value="@if(isset($admin)){{$admin->name }} @endif" name="name" class=" @error('name') is-invalid @enderror form-control" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> {{ __('admin.email') }}</label>
                                        <input type="email" value="@if(isset($admin)){{$admin->email }} @endif" name="email" class="@error('email') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1"> {{ __('admin.password') }}</label>

                                        <input type="password" class="@error('password') is-invalid @enderror form-control" id="exampleInputPassword1" name="password" placeholder="Password" value="">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.roles')}}</label>

                                        @if(isset($admin))

                                            @foreach($roles as $role)
                                                <div class="form-group">
                                                    <div class="custom-control">
                                                        <input  value="{{$role->name}}" type="radio"  name="role" <?php if(in_array($role->name, $userRole)) echo 'checked' ?>>

                                                        <label class="form-check-label">
                                                                {{$role->name}}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach

                                        @else

                                            @foreach($roles as $role)
                                                <div class="form-group">
                                                    <div class="custom-control ">
                                                        <input value="{{$role->name}}" type="radio"  name="role">

                                                        @if(App::getLocale() == 'ar')
                                                         <label class="form-check-label" for="exampleCheck1">{{$role->arab_name}}</label>
                                                           
                                                        @else
                                                            <label class="form-check-label" for="exampleCheck1">{{$role->eng_name}}</label>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach

                                        @endif

                                    </div>

                                  

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">


                                @if(isset($admin))
                                    <button type="submit" class="btn btn-primary"> {{ __('admin.edit') }}</button>

                                @else
                                 <button type="submit" class="btn btn-primary"> {{ __('admin.add') }}</button>

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


