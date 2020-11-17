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
                            <li class="breadcrumb-item"><a href="{{route('supermarkets.index')}}">{{__('admin.supermarkets')}}</a></li>
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

                                    @if(isset($supermarket))
                                        {{__('admin.edit_supermarket')}}
                                    @else
                                        {{__('admin.add_supermarket')}}

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($supermarket)){{route('supermarkets.update',$supermarket->id) }} @else {{route('supermarkets.store') }} @endif" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if(isset($supermarket))

                                    @method('PUT')

                                @endif

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name_ar')}}</label>
                                        <input type="text" value="@if(isset($supermarket)){{$supermarket->arab_name }} @endif" name="arab_name" class=" @error('arab_name') is-invalid @enderror form-control" required>
                                        @error('arab_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name_en')}}</label>
                                        <input type="text" name="eng_name" value="@if(isset($supermarket)){{$supermarket->eng_name }} @endif" class=" @error('eng_name') is-invalid @enderror form-control" required>
                                        @error('eng_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('admin.priority')}}</label>
                                        <input type="number" name="priority" min="0" @if(isset($supermarket)) value="{{$supermarket->priority}}" @else value="0" @endif class=" @error('priority') is-invalid @enderror form-control" required>
                                        @error('priority')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('admin.commission')}}</label>
                                        <input type="number" name="commission" min="0"  step="0.01" @if(isset($supermarket)) value="{{$supermarket->commission}}" @else value="0" @endif class=" @error('commission') is-invalid @enderror form-control" required>
                                        @error('commission')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>{{__('admin.category')}}</label>
                                        <select class=" @error('categories') is-invalid @enderror select2"  name="categories[]" data-placeholder="Select a State" style="width: 100%;" required multiple>

                                            @if(isset($supermarket))
                                                @foreach(\App\Models\Category::all() as $category)

                                                    <option <?php if(in_array($category->id,$category_ids)) echo 'selected'; ?> value="{{ $category->id }}">{{ $category->name_en }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Category::all() as $category)

                                                    <option value="{{ $category->id }}">{{ $category->name_en }}</option>

                                                @endforeach

                                            @endif

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('admin.area')}} </label>
                                        <select class=" @error('area_id') is-invalid @enderror select2" name="area_id" data-placeholder="Select a State" style="width: 100%;" required>
                                            @if(isset($supermarket))
                                                @foreach(\App\Models\Area::all() as $area)

                                                    <option <?php if($supermarket->area->id == $area->id) echo 'selected'; ?> value="{{ $area->id }}">{{ $area->name_en }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Area::all() as $area)

                                                    <option value="{{ $area->id }}">{{ $area->name_en }}</option>

                                                @endforeach

                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('admin.city')}} </label>
                                        <select class=" @error('city_id') is-invalid @enderror select2" name="city_id" data-placeholder="Select a State" style="width: 100%;" required>
                                            @if(isset($supermarket))
                                                @foreach(\App\Models\City::all() as $city)

                                                    <option <?php if($supermarket->city->id == $city->id) echo 'selected'; ?> value="{{ $city->id }}">{{ $city->name_en }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\City::all() as $city)

                                                    <option value="{{ $city->id }}">{{ $city->name_en }}</option>

                                                @endforeach

                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('admin.country')}} </label>
                                        <select class=" @error('country_id') is-invalid @enderror select2" name="country_id" data-placeholder="Select a State" style="width: 100%;" required>
                                            @if(isset($supermarket))
                                                @foreach(\App\Models\Country::all() as $country)

                                                    <option <?php if($supermarket->country->id == $country->id) echo 'selected'; ?> value="{{ $country->id }}">{{ $country->name_en }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Country::all() as $country)

                                                    <option value="{{ $country->id }}">{{ $country->name_en }}</option>

                                                @endforeach

                                            @endif
                                        </select>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="bootstrap-timepicker">
                                                <div class="form-group">
                                                    <label>{{__('admin.start_time')}}</label>

                                                    <div class="input-group date" id="startpicker" data-target-input="nearest">
                                                        <input type="text" name="start_time" @if(isset($supermarket)) value="{{$supermarket->start_time}}" @endif class="@error('start_time') is-invalid @enderror form-control datetimepicker-input" data-target="#startpicker"/>
                                                        <div class="input-group-append" data-target="#startpicker" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                        </div>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <!-- /.form group -->
                                            </div>
                                        </div>

                                        <div class="col-md-4">

                                            <div class="bootstrap-timepicker">
                                                <div class="form-group">
                                                    <label>{{__('admin.end_time')}}</label>

                                                    <div class="input-group date" id="endpicker" data-target-input="nearest">
                                                        <input type="text" name="end_time" class="@error('end_time') is-invalid @enderror form-control datetimepicker-input" @if(isset($supermarket)) value="{{$supermarket->end_time}}" @endif data-target="#endpicker"/>
                                                        <div class="input-group-append" data-target="#endpicker" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                        </div>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <!-- /.form group -->
                                            </div>

                                        </div>

                                    </div>

                                    @if(!isset($supermarket))

                                        <div class="form-group">
                                            <label>{{__('admin.status')}}</label>
                                            <select class="@error('status') is-invalid @enderror select2" name="status" data-placeholder="Select a State" style="width: 100%;" required>

                                                    <option value="active">{{__('admin.active')}}</option>
                                                    <option value="inactive">{{__('admin.inactive')}}</option>

                                            </select>

                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    @endif


                                    @if(isset($supermarket) && $supermarket->image != null)

                                        <div class="form-group" style="margin-bottom: 10px">
                                            <label for="exampleInputFile">{{__('admin.image')}}</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                    <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('images') }}/{{$supermarket->image}}" class="card-img-top" alt="Course Photo">

                                                    <input type="checkbox" checked style="margin-right:10px;" name="checkedimage" value="{{$supermarket->image}}">

                                                    <input name="image" type="file">

                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else

                                        <div class="form-group" style="margin-bottom: 10px">
                                            <label for="exampleInputFile">{{__('admin.image')}}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="image" type="file" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>


                                    @endif


                                    @if(isset($supermarket) && $supermarket->logo_image != null)

                                        <div class="form-group" style="margin-top: 40px">
                                            <label for="exampleInputFile">supermarket logo</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                    <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('images') }}/{{$supermarket->logo_image}}" class="card-img-top" alt="Course Photo">

                                                    <input type="checkbox" checked style="margin-right:10px;" name="checkedlogo" value="{{$supermarket->logo_image}}">

                                                    <input name="logo_image" type="file">

                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else

                                        <div class="form-group" style="margin-top: 40px">
                                            <label for="exampleInputFile">supermarket logo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="logo_image" type="file" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>


                                    @endif

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



