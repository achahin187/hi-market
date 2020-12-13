@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div style="margin-bottom: 5px" class="col-sm-6">
                    </div>

                    <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                               
                                @if(auth()->user()->can('product-import')) 
                                @endif
                                    <li class="breadcrumb-item">

                                        <a  href="{{ route('measure.export') }}">{{__('admin.import')}}</a>

                                       
                                    </li>
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


                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">

                                    @if(isset($unit))
                                        {{__('admin.edit_measure')}}
                                    @else
                                        {{__('admin.add_measure')}}

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($unit)){{route('measures.update',$unit->id) }} @else {{route('measures.store') }} @endif" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if(isset($unit))

                                    @method('PUT')

                                @endif

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name_ar')}}</label>
                                        <input type="text" value="@if(isset($unit)){{$unit->arab_name }} @endif" name="arab_name" class=" @error('arab_name') is-invalid @enderror form-control" required>
                                        @error('arab_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name_en')}}</label>
                                        <input type="text" name="eng_name" value="@if(isset($unit)){{$unit->eng_name }} @endif" class=" @error('eng_name') is-invalid @enderror form-control" required>
                                        @error('eng_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                @if(isset($unit))

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
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('admin.measure')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{__('admin.name_ar')}}</th>
                                        <th>{{__('admin.name_en')}}</th>
                                        <th>{{__('admin.controls')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($measures as $unit)
                                        <tr>
                                            <td>{{$unit->arab_name}}</td>
                                            <td>{{$unit->eng_name}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('measures.destroy', $unit->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')


                                                                <a class="dropdown-item" href="{{ route('measures.edit', $unit->id) }}">{{__('admin.edit')}}</a>


                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this vendor?") }}') ? this.parentElement.submit() : ''">{{__('admin.delete')}}</button>

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



