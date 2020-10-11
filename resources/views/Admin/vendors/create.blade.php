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
                            <li class="breadcrumb-item"><a href="{{route('vendors.index')}}">vendors</a></li>
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

                                    @if(isset($vendor))
                                        edit vendor
                                    @else
                                        create vendor

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
                                        <label>vendor category</label>
                                        <select class=" @error('category_id') is-invalid @enderror select2"  name="category_id" data-placeholder="Select a State" style="width: 100%;" required>

                                            @if(isset($vendor))
                                                @foreach(\App\Models\Category::all() as $category)

                                                    <option <?php if($vendor->category->id == $category->id) echo 'selected'; ?> value="{{ $category->id }}">{{ $category->eng_name }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Category::all() as $category)

                                                    <option value="{{ $category->id }}">{{ $category->eng_name }}</option>

                                                @endforeach

                                            @endif

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>vendor subcategory</label>
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
                                    </div>

                                    <div class="form-group">
                                        <label>status</label>
                                        <select class=" @error('sponsor') is-invalid @enderror select2"  name="sponsor" style="width: 100%;" required>

                                            @if(isset($vendor))

                                                <option  <?php if($vendor->sponsor == 'sponsor') echo 'selected'; ?> value="1">sponsor</option>
                                                <option <?php if($vendor->sponsor == 'vendor') echo 'selected'; ?> value="0">vendor</option>

                                            @else

                                                <option value="1">sponsor</option>
                                                <option value="0">vendor</option>

                                            @endif

                                        </select>
                                    </div>


                                    @if(isset($vendor) && $vendor->image != null)

                                        <div class="form-group">
                                            <label for="exampleInputFile">File input</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                    <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('vendor_images') }}/{{$vendor->image}}" class="card-img-top" alt="Course Photo">

                                                    <input type="checkbox" checked style="margin-right:10px;" name="checkedimage" value="{{$vendor->image}}">

                                                    <input name="image" type="file">

                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else

                                        <div class="form-group">
                                            <label for="exampleInputFile">File input</label>
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



