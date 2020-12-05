@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @include('includes.errors')
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">


                            @if(isset($supermarket_id))

                                <li class="breadcrumb-item"><a href="{{route('supermarket.branches',$supermarket_id)}}">{{__('admin.supermarket_branches')}}</a></li>

                            @else

                                <li class="breadcrumb-item"><a href="{{route('branches.index')}}">{{__('admin.branches')}}</a></li>

                            @endif


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

                                    @if(isset($branch))
                                        {{__('admin.edit_branch')}}

                                    @elseif(isset($supermarket_id) && !isset($branch))

                                        {{__('admin.add_supermarket_branch')}}

                                    @elseif(isset($supermarket_id) && isset($branch))

                                        {{__('admin.edit_supermarket_branch')}}
                                    @else
                                        {{__('admin.add_branch')}}

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="



                                @if(isset($branch) && !isset($supermarket_id))

                                    {{route('branches.update',$branch->id) }}

                                @elseif(isset($supermarket_id) && !isset($branch))

                                    {{route('branches.store',$supermarket_id) }}

                                @elseif(isset($supermarket_id) && isset($branch))

                                    {{route('branches.update',['id' => $branch->id,'supermarket_id' => $supermarket_id]) }}

                                @else

                                    {{route('branches.store') }}


                                @endif"

                                  method="POST" enctype="multipart/form-data">


                                @csrf

                                @if(isset($branch))

                                    @method('PUT')

                                @endif

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name_ar')}}</label>
                                        <input type="text" value="@if(isset($branch)){{$branch->name_ar }} @endif" name="name_ar" class=" @error('name_ar') is-invalid @enderror form-control" required>
                                        @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name_en')}}</label>
                                        <input type="text" name="name_en" value="@if(isset($branch)){{$branch->name_en }} @endif" class=" @error('name_en') is-invalid @enderror form-control" required>
                                        @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('admin.supermarket')}} </label>
                                        <select class=" @error('supermarket_id') is-invalid @enderror select2" name="supermarket_id" data-placeholder="Select a State" style="width: 100%;" @if(isset($supermarket_id)) disabled @endif required>
                                            @if(isset($branch))
                                                @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                    <option <?php if($branch->supermarket->id == $branch->id) echo 'selected'; ?> value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                                @endforeach

                                            @elseif(isset($supermarket_id))

                                                @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                    <option <?php if($supermarket_id == $supermarket->id) echo 'selected'; ?> value="{{ $supermarket->id }}">


                                                        @if(App::getLocale() == 'en')

                                                            {{ $supermarket->eng_name }}

                                                        @else

                                                            {{ $supermarket->arab_name }}

                                                        @endif


                                                    </option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                    <option value="{{ $supermarket->id }}">

                                                        @if(App::getLocale() == 'en')

                                                            {{ $supermarket->eng_name }}

                                                        @else

                                                            {{ $supermarket->arab_name }}

                                                        @endif

                                                    </option>

                                                @endforeach

                                            @endif
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>{{__('admin.category')}}</label>
                                        <select class=" @error('categories') is-invalid @enderror select2"  name="categories[]" data-placeholder="Select a State" style="width: 100%;" required multiple>

                                            @if(isset($branch))
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
                                            @if(isset($branch))
                                                @foreach(\App\Models\Area::all() as $area)

                                                    <option <?php if($branch->area->id == $area->id) echo 'selected'; ?> value="{{ $area->id }}">{{ $area->name_en }}</option>

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
                                            @if(isset($branch))
                                                @foreach(\App\Models\City::all() as $city)

                                                    <option <?php if($branch->city->id == $city->id) echo 'selected'; ?> value="{{ $city->id }}">{{ $city->name_en }}</option>

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
                                            @if(isset($branch))
                                                @foreach(\App\Models\Country::all() as $country)

                                                    <option <?php if($branch->country->id == $country->id) echo 'selected'; ?> value="{{ $country->id }}">{{ $country->name_en }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Country::all() as $country)

                                                    <option value="{{ $country->id }}">{{ $country->name_en }}</option>

                                                @endforeach

                                            @endif
                                        </select>
                                    </div> 


                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('admin.priority')}}</label>
                                        <input type="number" name="priority" min="0" @if(isset($branch)) value="{{$branch->priority}}" @else value="0" @endif class=" @error('priority') is-invalid @enderror form-control" required>
                                        @error('priority')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('admin.commission')}}</label>
                                        <input type="number" name="commission" min="0"  step="0.01" @if(isset($branch)) value="{{$branch->commission}}" @else value="0" @endif class=" @error('commission') is-invalid @enderror form-control" required>
                                        @error('commission')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('admin.rating')}}</label>
                                        <input type="number" name="rating" min="0"  step="0.01" @if(isset($branch)) value="{{$branch->rating}}" @else value="0" @endif class=" @error('rating') is-invalid @enderror form-control" required>
                                        @error('rating')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="bootstrap-timepicker">
                                                <div class="form-group">
                                                    <label>{{__('admin.start_time')}}</label>

                                                    <div class="input-group date" id="startpicker" data-target-input="nearest">
                                                        <input type="text" name="start_time" @if(isset($branch)) value="{{$branch->start_time}}" @endif class="@error('start_time') is-invalid @enderror form-control datetimepicker-input" data-target="#startpicker"/>
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
                                                        <input type="text" name="end_time" class="@error('end_time') is-invalid @enderror form-control datetimepicker-input" @if(isset($branch)) value="{{$branch->end_time}}" @endif data-target="#endpicker"/>
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


                                    @if(isset($supermarket_id))

                                        <input type="hidden" name="supermarket_id" value="{{$supermarket_id}}">
                                    @endif

                                    @if(!isset($branch))

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



                                    @if(isset($branch) && $branch->image != null)

                                        <div class="form-group">
                                            <label for="exampleInputFile">Photo</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                    <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('images') }}/{{$branch->image}}" class="card-img-top" alt="Course Photo">

                                                    <input type="checkbox" checked style="margin-right:10px;" name="checkedimage" value="{{$branch->image}}">

                                                    <input name="image" type="file">

                                                </div>
                                               
                                            </div>
                                        </div>
                                    @else

                                {{--         <div class="form-group">
                                            <label for="exampleInputFile">{{ __('admin.image') }}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="image" type="file" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">{{ __('admin.image') }}</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="form-group" style="margin-top: 40px">
                                            
                                            <div class="input-group">
                                               
                                                  <div class="form-group">
                                                <label for="exampleFormControlFile1">{{ __('admin.image') }}</label>
                                                <input type="file"  name="image" class="form-control-file" id="exampleFormControlFile1">
                                              </div>

                                            </div>
                                        </div>


                                    @endif


                                    @if(isset($branch) && $branch->logo != null)

                                        <div class="form-group" style="margin-top: 40px">
                                            <label for="exampleInputFile"> {{ __('admin.logo') }}</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                    <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('images') }}/{{$branch->logo}}" class="card-img-top" alt="Course Photo">

                                                    <input type="checkbox" checked style="margin-right:10px;" name="checkedlogo" value="{{$branch->logo}}">

                                                    <input name="logo_image" type="file">

                                                </div>
                                              
                                            </div>
                                        </div>
                                    @else

                                        <div class="form-group" style="margin-top: 40px">
                                            
                                            <div class="input-group">
                                               
                                                  <div class="form-group">
                                                <label for="exampleFormControlFile1">{{ __('admin.logo') }}</label>
                                                <input type="file"  name="logo_image" class="form-control-file" id="exampleFormControlFile1">
                                              </div>

                                            </div>
                                        </div>


                                    @endif


                                </div>
                                <!-- /.card-body -->

                                @if(isset($branch))

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">{{__('admin.edit')}}</button>
                                    </div>

                                @else

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">{{__('admin.add')}}</button>
                                    </div>

                                @endif
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection



