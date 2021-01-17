@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.reasons') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @if(auth()->user()->can('reason-create'))
                            <li class="breadcrumb-item"><a href="{{route('reasons.create')}}">create new reason</a></li>
                            @endif
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

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.reasons') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example30" style="table-layout: fixed;" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>eng reason</th>
                                        <th>arab reason</th>

                                        @if(auth()->user()->can('reason-active'))
                                        <th>{{ __('admin.status') }}</th>
                                        @endif

                                     @if(auth()->user()->hasAnyPermission(['reason-delete','reason-edit']))
                                      <th>{{ __('admin.controls') }}</th>
                                      @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reasons as $reason)
                                        <tr>
                                            <td>{{$reason->eng_reason}}</td>
                                            <td>{{$reason->arab_reason}}</td>

                                        @if(auth()->user()->can('reason-active'))
                                            <td>

                                                @if($reason->status == 'active' )

                                                    <form action="{{ route('reason.status', $reason->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this reason?") }}') ? this.parentElement.submit() : ''" href="{{ route('supermarket.status', $reason->id) }}" class="btn btn-block btn-outline-success">active</button>
                                                    </form>

                                                @else

                                                    <form action="{{ route('reason.status', $reason->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this reason?") }}') ? this.parentElement.submit() : ''" href="{{ route('supermarket.status', $reason->id) }}" class="btn btn-block btn-outline-danger">inactive</button>
                                                    </form>

                                                @endif
                                            </td>
                                        @endif

                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">

                                                        @if(auth()->user()->can('reason-edit'))
                                                        <a class="dropdown-item" href="{{ route('reasons.edit',$reason->id) }}">{{ __('edit') }}</a>
                                                        @endif
                                                        @can("reason-delete")
                                                            <form action="{{route("reasons.destroy",$reason->id)}}" method="post">
                                                                @method("delete")
                                                                @csrf
                                                                <button  type="submit" class=" dropdown-item btn btn-danger">Delete</button>
                                                            </form>
                                                        @endcan
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




