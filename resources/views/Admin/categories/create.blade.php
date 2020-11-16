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
                            <li class="breadcrumb-item"><a href="{{route('categories.index')}}">{{__('admin.categories')}}</a></li>
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
                                        {{__('admin.edit_category')}}
                                    @else
                                        {{__('admin.add_category')}}

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($category)){{route('categories.update',$category->id) }} @else {{route('categories.store') }} @endif" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if(isset($category))

                                    @method('PUT')

                                @endif

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name_ar')}}</label>
                                        <input type="text" value="@if(isset($category)){{$category->name_ar }} @endif" name="name_ar" class=" @error('name_ar') is-invalid @enderror form-control" required>
                                        @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name_en')}}</label>
                                        <input type="text" name="name_en" value="@if(isset($category)){{$category->name_en }} @endif" class=" @error('name_en') is-invalid @enderror form-control" required>
                                        @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    @if(isset($category) && $category->image != null)

                                        <div class="form-group">
                                            <label for="exampleInputFile">{{__('admin.image')}}</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                        <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('category_images') }}/{{$category->image}}" class="card-img-top" alt="Course Photo">

                                                        <input type="checkbox" checked style="margin-right:10px;" name="checkedimage" value="{{$category->image}}">

                                                    <input name="image" accept=".png,.jpg,.jpeg"  type="file">

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

                                @if(isset($category))

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">{{__('admin.modify')}}</button>
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



