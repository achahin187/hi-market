@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('points.create')}}">add new points</a></li>
                        </ol>
                    </div>

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
            </div><!-- /.container-fluid -->
        </section>

        <form role="form" action="@if(isset($point)){{route('points.update',$point->id) }} @else {{route('points.store') }} @endif" method="POST" enctype="multipart/form-data">
            @csrf

            @if(isset($point))

                @method('PUT')

            @endif

            <div class="card-body">

                <div class="form-group">
                    <label for="exampleInputPassword1">{{__('admin.product_from')}}</label>
                    <input type="number" name="from" min="0" @if(isset($point)) value="{{$point->from}}" @else value="0" @endif class=" @error('from') is-invalid @enderror form-control" >
                    @error('from')
                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">{{__('admin.product_to')}}</label>
                    <input type="number" name="to" min="0" @if(isset($point)) value="{{$point->to}}" @else value="0" @endif class=" @error('to') is-invalid @enderror form-control" >
                    @error('to')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">{{__('admin.product_value')}}</label>
                    <input type="number" name="value" min="0" @if(isset($point)) value="{{$point->value}}" @else value="0" @endif class=" @error('value') is-invalid @enderror form-control" >
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

                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">points</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>from</th>
                                        <th>to</th>
                                        <th>type</th>
                                        <th>value</th>
                                        <th>controls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($points as $point)
                                        <tr>
                                            <td>{{$point->from}}</td>
                                            <td>{{$point->to}}</td>
                                            <td>
                                                @if($point->type == 0)

                                                    discount

                                                @else

                                                    gift

                                                @endif


                                            </td>
                                            <td>{{$point->value}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('points.destroy', $point->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                            <a class="dropdown-item" href="{{ route('points.edit',$point->id) }}">{{ __('edit') }}</a>
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this range?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection



