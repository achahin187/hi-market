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
                            <li class="breadcrumb-item"><a href="{{route('admins.index')}}">admins</a></li>
                            <li class="breadcrumb-item active">General Form</li>
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
                                        edit admin
                                    @else
                                        create admin

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
                                        <label for="exampleInputEmail1">{{__('arabname')}}</label>
                                        <input type="text" value="@if(isset($admin)){{$admin->name }} @endif" name="name" class=" @error('name') is-invalid @enderror form-control" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" value="@if(isset($admin)){{$admin->email }} @endif" name="email" class="@error('email') is-invalid @enderror form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
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


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.roles')}}</label>

                                        @if(isset($admin))

                                            @foreach($roles as $role)
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" value="{{$role->name}}" type="radio" id="customRadio{{$role->name}}" name="roles" <?php if(in_array($role->name, $userRole)) echo 'checked' ?>>

                                                        @if(App::getLocale() == 'ar')

                                                            <label for="customRadio{{$role->name}}" class="custom-control-label">{{$role->arab_name}}</label>

                                                        @else

                                                            <label for="customRadio{{$role->name}}" class="custom-control-label">{{$role->eng_name}}</label>

                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach

                                        @else

                                            @foreach($roles as $role)
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" value="{{$role->name}}" type="radio" id="customRadio{{$role->name}}" name="roles">
                                                        @if(App::getLocale() == 'ar')

                                                            <label for="customRadio{{$role->name}}" class="custom-control-label">{{$role->arab_name}}</label>

                                                        @else

                                                            <label for="customRadio{{$role->name}}" class="custom-control-label">{{$role->eng_name}}</label>

                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach

                                        @endif

                                    </div>

                                    <div class="form-group">
                                        <label>admin team </label>
                                        <select class=" @error('team_id') is-invalid @enderror select2" name="team_id" data-placeholder="Select a State" style="width: 100%;" required>
                                            @if(isset($admin))
                                                @foreach(\App\Models\Team::all() as $team)

                                                    @if(App::getLocale() == 'ar')

                                                        <option <?php if($admin->team->id == $team->id) echo 'selected'; ?> value="{{ $team->id }}">{{ $team->arab_name }}</option>

                                                    @else

                                                        <option <?php if($admin->team->id == $team->id) echo 'selected'; ?> value="{{ $team->id }}">{{ $team->eng_name }}</option>

                                                    @endif

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Team::all() as $team)

                                                    @if(App::getLocale() == 'ar')

                                                        <option value="{{ $team->id }}">{{ $team->arab_name }}</option>

                                                    @else

                                                        <option value="{{ $team->id }}">{{ $team->eng_name }}</option>

                                                    @endif

                                                @endforeach

                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>manager</label>
                                        <select class=" @error('manager') is-invalid @enderror select2"  name="manager" data-placeholder="Select a State" style="width: 100%;" required>

                                            @if(isset($admin))

                                                <option  <?php if($admin->manager == '1') echo 'selected'; ?> value="1">true</option>
                                                <option <?php if($admin->manager == '0') echo 'selected'; ?> value="0">false</option>

                                            @else

                                                <option value="1">true</option>
                                                <option value="0">false</option>

                                            @endif

                                        </select>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection


