@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.add_vendor') }}</h1>
                        @include('includes.errors')
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('vendors.index')}}">{{ __('admin.vendors') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('admin.add_vendor') }}</li>
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

                                    @if(isset($vendor))
                                        {{ __('admin.vendor_edit') }}
                                    @else
                                        {{ __('admin.add_vendor') }}

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($vendor)){{route('vendors.update',$vendor->id) }} @else {{route('vendors.store') }} @endif" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if(isset($vendor))

                                    @method('PUT')

                                @endif

                                


                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.product_arabname')}}</label>
                                        <input type="text" value="@if(isset($vendor)){{$vendor->arab_name }} @endif" name="arab_name" class=" @error('arab_name') is-invalid @enderror form-control" required>
                                        @error('arab_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.product_engname')}}</label>
                                        <input type="text" name="eng_name" value="@if(isset($vendor)){{$vendor->eng_name }} @endif" class=" @error('eng_name') is-invalid @enderror form-control" required>
                                        @error('eng_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label> {{ __('admin.category') }}</label>
                                        <select class=" @error('category_id') is-invalid @enderror select2"  name="category_id[]" data-placeholder="Select a State" style="width: 100%;" required multiple>

                                            @if(isset($vendor))

                                                @foreach(\App\Models\Category::all() as $category)

                                                    <option 
                                                      {{ $vendor->categories->where('id', $category->id)->count() != 0 ?  'selected' : ""  }}  value="{{ $category->id }}">{{ $category->name_en }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Category::all() as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name_en }}</option>

                                                @endforeach

                                            @endif

                                        </select>
                                    </div>
{{-- 
                                    <div class="form-group">
                                        <label> {{ __('admin.subcategory') }}</label>
                                        <select class=" @error('subcategory_id') is-invalid @enderror select2"  name="subcategory_id" data-placeholder="Select a State" style="width: 100%;" required>

                                            @if(isset($vendor))
                                                @foreach(\App\Models\SubCategory::all() as $subcategory)

                                                    <option <?php if($vendor->subcategory->id == $subcategory->id) echo 'selected'; ?> value="{{ $subcategory->id }}">{{ $subcategory->eng_name }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\SubCategory::all() as $subcategory)

                                                    <option value="{{ $subcategory->id }}">{{ $subcategory->eng_name }}</option>

                                                @endforeach

                                            @endif

                                        </select>
                                    </div> --}}

                                    <div class="form-group">
                                        <label>{{ __('admin.status') }}</label>
                                        <select class=" @error('sponsor') is-invalid @enderror select2"  name="sponsor" style="width: 100%;" required>

                                            @if(isset($vendor))

                                                <option <?php if($vendor->sponsor == 0) echo 'selected'; ?> value="0">{{ __('admin.vendor') }}</option>
                                                <option  <?php if($vendor->sponsor == 1) echo 'selected'; ?> value="1">{{ __('admin.sponser') }}</option>

                                            @else

                                                <option value="0">{{ __('admin.vendor') }}</option>
                                                <option value="1">{{ __('admin.sponser') }}</option>

                                            @endif

                                        </select>
                                    </div>


                                    @if(isset($vendor) && $vendor->image != null)

                                        <div class="form-group">
                                            <label for="exampleInputFile">{{ __('admin.logo') }}</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                    <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('vendor_images') }}/{{$vendor->image}}" class="card-img-top" alt="Course Photo">

                                                    <input type="checkbox" checked style="margin-right:10px;" name="checkedimage" value="{{$vendor->image}}">

                                                    <input name="image" type="file">

                                                </div>
                                            </div>
                                        </div>
                                    @else
                                    {{-- 
                                        <div class="form-group">
                                            <label for="exampleInputFile">{{ __('admin.logo') }}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="image" type="file" class="custom-file-input" id="exampleInputFile">
                                                   
                                                </div>
                                               
                                            </div>
                                        </div> --}}

                                    <div class="form-group">    
                                        <div class="form-group" style="margin-bottom: 10px">
                                            <label for="exampleInputFile">{{__('admin.logo')}}</label>
                                       
                                             <div class="form-group">
                                               
                                                <input type="file"   name="image" class="form-control-file" id="exampleFormControlFile1">
                                              </div>
                                        </div>
                                    </div>


                                    @endif

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    @if(isset($vendor) && $vendor->image != null)

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



