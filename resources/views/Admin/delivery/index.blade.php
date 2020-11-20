@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ trans('admin.delivery') }}</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item"><a href="{{route('delivery.create')}}">{{ trans('admin.add_driver') }}</a></li>
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
                                <h3 class="card-title">{{ __('admin.delivery') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.name') }}</th>
                                        <th>{{ __('admin.email') }}</th>
                                        <th>{{ __('admin.role') }}</th>
                                        <th>{{ __('admin.status') }}</th>
                                        <th>{{ __('admin.controls') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($delivery as $driver)
                                        <tr>
                                            <td>{{$driver->name}}</td>
                                            <td>{{$driver->email}}</td>
                                            <td>

                                                @foreach($driver->roles as $role)

                                                    @if(App::getLocale() == 'ar')

                                                        [{{$role->arab_name}}]

                                                    @else

                                                        [{{$role->eng_name}}]

                                                    @endif

                                                @endforeach

                                            </td>


                                            @if($driver->orders->count() == 0)

                                                <td>{{ __('admin.available') }}</td>

                                            @else

                                                <td>{{ __('admin.not_available') }}</td>

                                            @endif

                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('delivery.destroy', $driver->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                            <a class="dropdown-item" href="{{ route('delivery.edit', $driver->id) }}">{{ __('admin.edit') }}</a>

                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this driver?") }}') ? this.parentElement.submit() : ''">{{ __('admin.delete') }}</button>
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

