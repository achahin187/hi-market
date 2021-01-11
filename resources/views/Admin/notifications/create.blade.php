@extends('layouts.admin_layout')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> create notification</h1>
                        @include('includes.errors')
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('notifications.index')}}">Notifications</a></li>
                            <li class="breadcrumb-item active"> create notification</li>
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
                                  
                                        create notification

                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action=" {{route('notifications.store') }} " method="POST">
                                @csrf


                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('admin.title_ar')}}</label>
                                            <input type="text" value="" name="title_ar" class=" @error('title_ar') is-invalid @enderror form-control" required>
                                            @error('title_ar')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('admin.title_en')}}</label>
                                            <input type="text" value="" name="title_en" class=" @error('title_en') is-invalid @enderror form-control" required>
                                            @error('title_en')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('admin.body_ar')}}</label>
                                            <input type="text" value="" name="body_ar" class=" @error('body_ar') is-invalid @enderror form-control" required>
                                            @error('body_ar')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('admin.body_en')}}</label>
                                            <input type="text" value="" name="body_en" class=" @error('body_en') is-invalid @enderror form-control" required>
                                            @error('body_en')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
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


