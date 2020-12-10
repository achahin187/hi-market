@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.add') }}</h1>
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
                            <li class="breadcrumb-item"><a href="{{route('locations.index')}}">{{ __('admin.city') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('admin.add') }}</li>
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
                               
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div id="mapid" style="height: 500px;"></div>
                          
                            <form role="form" action=" {{route('city.update') }} " method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.city_ar') }}</label>
                                        <input type="text" value="{{ $city->name_ar }}" name="city_ar" id='city_ar' class="@error('city_ar') is-invalid @enderror form-control"  placeholder="Enter city" required>
                                        @error('city_ar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.city_en') }}</label>
                                        <input type="text" value=" {{ $city->name_en }}" name="city_en" id='city_en' class="@error('city_en') is-invalid @enderror form-control"  placeholder="Enter city_en" required>
                                        @error('city_en')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

       


                                </div>
                                <!-- /.card-body -->
                                  <button class="add-polygon btn btn-primary" >Add Location</button>
                              {{--   <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                                </div> --}}
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection


