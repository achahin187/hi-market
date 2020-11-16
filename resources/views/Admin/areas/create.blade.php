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
                            <li class="breadcrumb-item"><a href="{{route('areas.index')}}">{{__('admin.areas')}}</a></li>
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

                                    @if(isset($area))
                                        {{__('admin.edit_area')}}
                                    @else
                                        {{__('admin.add_area')}}

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($area)){{route('areas.update',$area->id) }} @else {{route('areas.store') }} @endif" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if(isset($area))

                                    @method('PUT')

                                @endif

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name_ar')}}</label>
                                        <input type="text" value="@if(isset($area)){{$area->name_ar }} @endif" name="name_ar" class=" @error('name_ar') is-invalid @enderror form-control" required>
                                        @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name_en')}}</label>
                                        <input type="text" value="@if(isset($area)){{$area->name_en }} @endif" name="name_en" class=" @error('name_en') is-invalid @enderror form-control" required>
                                        @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>{{__('admin.city')}}</label>
                                        <select class=" @error('city') is-invalid @enderror select2"  name="city" data-placeholder="Select a State" style="width: 100%;" required>

                                            @if(isset($area))
                                                @foreach(\App\Models\City::where('status','active')->get() as $city)

                                                    <option <?php if($area->areacity->id == $city->id) echo 'selected'; ?> value="{{ $city->id }}">{{ $city->name_en }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\City::where('status','active')->get() as $city)

                                                    <option value="{{ $city->id }}">{{ $city->name_en }}</option>

                                                @endforeach

                                            @endif

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('admin.country')}}</label>
                                        <select class=" @error('country') is-invalid @enderror select2"  name="country" data-placeholder="Select a State" style="width: 100%;" required>

                                            @if(isset($area))
                                                @foreach(\App\Models\Country::where('status','active')->get() as $country)

                                                    <option <?php if($area->areacountry->id == $country->id) echo 'selected'; ?> value="{{ $country->id }}">{{ $country->name_ar }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Country::where('status','active')->get() as $country)

                                                    <option value="{{ $country->id }}">{{ $country->name_en }}</option>

                                                @endforeach

                                            @endif

                                        </select>
                                    </div>

                                    @if(!isset($area))

                                        <div class="form-group">
                                            <label>{{__('admin.status')}}</label>
                                            <select class=" @error('status') is-invalid @enderror select2"  name="status" data-placeholder="Select a State" style="width: 100%;" required>

                                                <option value="active">{{__('admin.active')}}</option>
                                                <option value="inactive">{{__('admin.inactive')}}</option>

                                            </select>
                                        </div>

                                    @endif

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">{{__('admin.add')}}</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection



