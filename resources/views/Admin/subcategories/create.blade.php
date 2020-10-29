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
                            <li class="breadcrumb-item"><a href="{{route('categories.index')}}">subcategories</a></li>
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

                                    @if(isset($category))
                                        edit subcategory
                                    @else
                                        create subcategory

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($subcategory)){{route('subcategories.update',$subcategory->id) }} @else {{route('subcategories.store') }} @endif" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if(isset($subcategory))

                                    @method('PUT')

                                @endif

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.subcategory_arabname')}}</label>
                                        <input type="text" value="@if(isset($subcategory)){{$subcategory->arab_name }} @endif" name="arab_name" class=" @error('arab_name') is-invalid @enderror form-control" required>
                                        @error('arab_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.subcategory_engname')}}</label>
                                        <input type="text" name="eng_name" value="@if(isset($subcategory)){{$subcategory->eng_name }} @endif" class=" @error('eng_name') is-invalid @enderror form-control" required>
                                        @error('eng_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>category</label>
                                        <select class=" @error('category_id') is-invalid @enderror select2"  name="category_id" data-placeholder="Select a State" style="width: 100%;" required>

                                            @if(isset($vendor))
                                                @foreach(\App\Models\Category::all() as $category)

                                                    <option <?php if($subcategory->category->id == $category->id) echo 'selected'; ?> value="{{ $category->id }}">{{ $category->name_en }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Category::all() as $category)

                                                    <option value="{{ $category->id }}">{{ $category->name_en }}</option>

                                                @endforeach

                                            @endif

                                        </select>
                                    </div>


                                    @if(isset($subcategory) && $subcategory->image != null)

                                        <div class="form-group">
                                            <label for="exampleInputFile">File input</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                        <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('subcategory_images') }}/{{$subcategory->image}}" class="card-img-top" alt="Course Photo">

                                                        <input type="checkbox" checked style="margin-right:10px;" name="checkedimage" value="{{$subcategory->image}}">

                                                    <input name="image" accept=".png,.jpg,.jpeg" type="file">

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
                                                    <input name="image" accept=".png,.jpg,.jpeg"  type="file" class="custom-file-input" id="exampleInputFile">
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



