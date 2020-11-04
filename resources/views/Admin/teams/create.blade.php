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

                                    @if(isset($team))
                                        edit team
                                    @else
                                        create team

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($team)){{route('teams.update',$team->id) }} @else {{route('teams.store') }} @endif" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if(isset($team))

                                    @method('PUT')

                                @endif

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.team_arabname')}}</label>
                                        <input type="text" value="@if(isset($team)){{$team->arab_name }} @endif" name="arab_name" class=" @error('arab_name') is-invalid @enderror form-control" required>
                                        @error('arab_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.team_engname')}}</label>
                                        <input type="text" name="eng_name" value="@if(isset($team)){{$team->eng_name }} @endif" class=" @error('eng_name') is-invalid @enderror form-control" required>
                                        @error('eng_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('team.arab_description')}}</label>
                                        <textarea class=" @error('arab_description') is-invalid @enderror form-control" name="arab_description" rows="3" placeholder="Enter ...">

                                        @if(isset($team))
                                                {{$team->arab_description }}
                                            @endif
                                    </textarea>
                                        @error('arab_description')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('team.eng_description')}}</label>
                                        <textarea class=" @error('eng_description') is-invalid @enderror form-control" name="eng_description" rows="3" placeholder="Enter ...">

                                        @if(isset($team))
                                                {{$team->eng_description }}
                                            @endif
                                    </textarea>
                                        @error('eng_description')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('team.roles')}}</label>

                                        @if(isset($team))

                                            @foreach($roles as $role)
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" value="{{$role->id}}" type="radio" id="customRadio{{$role->name}}" name="role_id" <?php if(in_array($role->name, $teamRole)) echo 'checked' ?>>

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
                                                        <input class="custom-control-input" value="{{$role->id}}" type="radio" id="customRadio{{$role->name}}" name="role_id">
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


