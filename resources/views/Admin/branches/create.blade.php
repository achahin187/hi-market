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


                            @if(isset($supermarket_id))

                                <li class="breadcrumb-item"><a href="{{route('supermarket.branches',$supermarket_id)}}">supermarket branches</a></li>
                                <li class="breadcrumb-item active">supermarket branch Form</li>

                            @else

                                <li class="breadcrumb-item"><a href="{{route('branches.index')}}">branches</a></li>
                                <li class="breadcrumb-item active">branch Form</li>

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
                                        edit branch

                                    @elseif(isset($supermarket_id) && !isset($branch))

                                        add supermarket branch

                                    @elseif(isset($supermarket_id) && isset($branch))

                                        edit supermarket branch
                                    @else
                                        create branch

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
                                        <label for="exampleInputEmail1">{{__('admin.branch_arabname')}}</label>
                                        <input type="text" value="@if(isset($branch)){{$branch->name_ar }} @endif" name="name_ar" class=" @error('name_ar') is-invalid @enderror form-control" required>
                                        @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.branch_engname')}}</label>
                                        <input type="text" name="name_en" value="@if(isset($branch)){{$branch->name_en }} @endif" class=" @error('name_en') is-invalid @enderror form-control" required>
                                        @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>branch supermarket </label>
                                        <select class=" @error('supermarket_id') is-invalid @enderror select2" name="supermarket_id" data-placeholder="Select a State" style="width: 100%;" @if(isset($supermarket_id)) disabled @endif required>
                                            @if(isset($branch))
                                                @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                    <option <?php if($branch->supermarket->id == $branch->id) echo 'selected'; ?> value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                                @endforeach

                                            @elseif(isset($supermarket_id))

                                                @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                    <option <?php if($supermarket_id == $supermarket->id) echo 'selected'; ?> value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                                @endforeach
                                            @else
                                                @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                    <option value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                                @endforeach

                                            @endif
                                        </select>
                                    </div>

                                    @if(isset($supermarket_id))

                                        <input type="hidden" name="supermarket_id" value="{{$supermarket_id}}">
                                    @endif

                                    @if(!isset($branch))

                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="@error('status') is-invalid @enderror select2" name="status" data-placeholder="Select a State" style="width: 100%;" required>

                                                    <option value="active">active</option>
                                                    <option value="inactive">inactive</option>

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
                                            <label for="exampleInputFile">File input</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                    <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('images') }}/{{$branch->image}}" class="card-img-top" alt="Course Photo">

                                                    <input type="checkbox" checked style="margin-right:10px;" name="checkedimage" value="{{$branch->image}}">

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



