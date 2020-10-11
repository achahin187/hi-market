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
                            <li class="breadcrumb-item"><a href="{{route('points.index')}}">points</a></li>
                            <li class="breadcrumb-item active">points Form</li>
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

                                @if(isset($point))

                                    edit points range

                                @else

                                    create points range

                                @endif
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="@if(isset($point)){{route('points.update',$point->id) }} @else {{route('points.store') }} @endif" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if(isset($point))

                                @method('PUT')

                            @endif

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.points_from')}}</label>
                                    <input type="number" name="from" min="0" @if(isset($point)) value="{{$point->from}}" @else value="0" @endif class=" @error('from') is-invalid @enderror form-control" >
                                    @error('from')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.points_to')}}</label>
                                    <input type="number" name="to" min="0" @if(isset($point)) value="{{$point->to}}" @else value="0" @endif class=" @error('to') is-invalid @enderror form-control" >
                                    @error('to')
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.points_value')}}</label>
                                    <input type="number" name="value" min="0" step="0.01" @if(isset($point)) value="{{$point->value}}" @else value="0" @endif class=" @error('value') is-invalid @enderror form-control" >
                                    @error('value')
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>type </label>
                                    <select class="@error('type') is-invalid @enderror select2" name="type" data-placeholder="Select a State" style="width: 100%;" required>


                                        @if(isset($point))

                                            <option <?php if($point->type == 0) echo 'selected'; ?> value="0">discount</option>
                                            <option <?php if($point->type == 1) echo 'selected'; ?> value="1">gift</option>

                                        @else

                                            <option value="0">discount</option>
                                            <option value="1">gift</option>\

                                        @endif

                                    </select>

                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                @if(!isset($point))

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

                                <div class="form-group">
                                    <label>start_date</label>
                                    <input type="datetime-local" class=" @error('start_date') is-invalid @enderror form-control" id="start" name="start_date" @if(isset($point)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($point->start_date)) }}" @endif data-placeholder="Select a point start_date" style="width: 100%;" >

                                    @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>end_date</label>
                                    <input type="datetime-local" class=" @error('end_date') is-invalid @enderror form-control"  name="end_date" @if(isset($point)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($point->end_date)) }}" @endif data-placeholder="Select a point end_date" style="width: 100%;" >

                                    @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <!-- /.card-body -->

                                @if(isset($point))

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </div>

                                @else

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>

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



