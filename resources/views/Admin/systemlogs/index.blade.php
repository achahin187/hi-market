@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.logs') }}</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('logs.index')}}">{{ __('admin.logs') }}</a></li>
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
                                <h3 class="card-title">{{ __('admin.logs') }}</h3>
                            </div>


                            <div class="row" style="margin-top: 10px">


                                <div class="col-md-6">


                                    <form role="form" id="datefilter" action="{{route('logs.filter','date') }}" method="GET">

                                        @csrf


                                        <div class="form-group col-md-6">
                                            <label>{{ __('admin.Date_range') }}:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                  </span>
                                                </div>
                                                <input type="text" class="form-control float-right datefilter" name="daterange" id="reservation">
                                            </div>
                                            <!-- /.input group -->
                                        </div>

                                    </form>

                                </div>

                                <div class="col-md-6">


                                    <form role="form" id="filteruser" action="{{route('logs.filter','user_id') }}" method="GET">

                                        @csrf


                                        <div class="form-group col-md-6">
                                            <label>{{ __('admin.users') }} </label>
                                            <select class=" @error('user_id') is-invalid @enderror select2 filteruser" name="user_id" data-placeholder="Select a State" style="width: 100%;" required>

                                                <option>{{ __('admin.no_user') }}</option>
                                                    @foreach(\App\User::all() as $user)

                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>

                                                    @endforeach
                                            </select>
                                        </div>

                                    </form>

                                </div>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th> {{ __('admin.name') }}</th>
                                        <th>{{ __('admin.description') }}</th>
                                        <th>{{ __('admin.subject_type') }}</th>
                                        <th>{{ __('admin.user') }}</th>
                                        <th>{{ __('admin.email') }}</th>
                                        <th>{{ __('admin.Date_range') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{$log->log_name}}</td>
                                            <td>{{$log->description}}</td>
                                            <td>{{$log->subject_type}}</td>
                                            <td>

                                                @if($log->causer_id != null)
                                                    {{App\User::where('id',$log->causer_id)->first()->name??  __('admin.no_user') }}
                                                @else
                                                    {{ __('admin.no_user') }}
                                                @endif

                                            </td>
                                            <td>

                                                @if($log->causer_id)
                                                    {{App\User::where('id',$log->causer_id)->first()->email ??  __('admin.no_user')}}
                                                @else
                                                    {{ __('admin.no_user') }}
                                                @endif

                                            </td>
                                            <td>{{$log->created_at}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                 {{ $logs->appends(request()->query())->links() }}
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




