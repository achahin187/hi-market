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
                            <li class="breadcrumb-item"><a
                                    href="{{route('delivery-companies.index')}}">{{ __('admin.delivery_companies') }}</a>
                            </li>
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
                                <h3 class="card-title">

                                    {{ __('admin.add_delivery_company') }}


                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action=" {{route('delivery-companies.store') }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf


                                <div class="card-body">
                                     <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.title_ar') }}</label>
                                        <input type="text" value="{{ old('title_ar') }}"
                                                name="title_ar" 
                                               class=" @error('title_ar') is-invalid @enderror form-control" required>
                                        @error('title_ar')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.title_en') }}</label>
                                        <input type="text" value="{{ old('title_ar') }}" name="title_en"
                                               class=" @error('title_en') is-invalid @enderror form-control" required>
                                        @error('title_en')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.description_ar') }}</label>
                                        <input type="text" value="{{ old('description_ar') }}" name="description_ar"
                                               class=" @error('description_ar') is-invalid @enderror form-control" required>
                                        @error('description_ar')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.description_en') }}</label>
                                        <input type="text" value="{{ old('description_en') }}" name="description_en"
                                               class=" @error('description_en') is-invalid @enderror form-control" required>
                                        @error('description_en')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                  
                                      <div class="form-group">
                                        <label for="image">Icon</label>
                                        <input value="{{old("image")}}" type="file" name="image">
                                   

                                        @error('image')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


@endsection


