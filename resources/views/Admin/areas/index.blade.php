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

                    @if(auth()->user()->can('vendor-create'))
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('areas.create')}}">add new area</a></li>
                            </ol>
                        </div>
                    @endif


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

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">areas</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>name_ar</th>
                                        <th>name_en</th>
                                        <th>city</th>
                                        <th>country</th>
                                        <th>status</th>
                                        <th>controls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($areas as $area)
                                        <tr>
                                            <td>{{$area->name_ar}}</td>
                                            <td>{{$area->name_en}}</td>
                                            <td>{{$area->areacity->name_ar}}</td>
                                            <td>{{$area->areacountry->name_ar}}</td>
                                            <td>

                                                @if($area->status == 'active' )

                                                    <form action="{{ route('areas.status', $area->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this reason?") }}') ? this.parentElement.submit() : ''" href="{{ route('areas.status', $area->id) }}" class="btn btn-block btn-outline-success">active</button>
                                                    </form>

                                                @else

                                                    <form action="{{ route('areas.status', $area->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this reason?") }}') ? this.parentElement.submit() : ''" href="{{ route('areas.status', $area->id) }}" class="btn btn-block btn-outline-danger">inactive</button>
                                                    </form>

                                                @endif


                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('areas.destroy', $area->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                                <a class="dropdown-item" href="{{ route('areas.edit', $area->id) }}">{{ __('edit') }}</a>



                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this vendor?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>

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



