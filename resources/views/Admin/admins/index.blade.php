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

                    @if(auth()->user()->can('admin-create'))
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('admins.create')}}">add new admin</a></li>
                                <li class="breadcrumb-item"><a href="{{route('admins.export')}}">export</a></li>

                                <!--
                                <form action="{{route('admins.import') }}" method="POST" enctype="multipart/form-data">

                                    @csrf

                                    <input type="file" name="file" accept=".csv"/>

                                    <button type="submit" class="btn btn-primary">import</button>

                                </form>
                            </ol>
                        </div>

                        -->
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
                                <h3 class="card-title">Admins</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>name</th>
                                        <th>email</th>
                                        <th>Role</th>
                                        <th>Team</th>
                                        <th>controls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($admins as $admin)
                                        <tr>
                                            <td>{{$admin->name}}</td>
                                            <td>{{$admin->email}}</td>
                                            <td>

                                                @foreach($admin->roles as $role)

                                                    @if(App::getLocale() == 'ar')

                                                        [{{$role->arab_name}}]

                                                    @else

                                                        [{{$role->eng_name}}]

                                                    @endif

                                                @endforeach

                                            </td>

                                            @if(App::getLocale() == 'ar')

                                                {{-- <td>{{$admin->team->arab_name}}</td> --}}

                                            @else

                                               {{--  <td>{{$admin->team->eng_name}}</td> --}}

                                            @endif

                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('admins.destroy', $admin->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                                <a class="dropdown-item" href="{{ route('admins.edit', $admin->id) }}">{{ __('edit') }}</a>

                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this admin?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
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

