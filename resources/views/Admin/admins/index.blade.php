@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.admin') }}</h1>
                    </div>
                    
                    @if(auth()->user()->can('admin-create'))
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('admins.create')}}">{{ __('admin.add') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{route('admins.export')}}">{{ __('admin.export') }}</a></li>
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
                                <h3 class="card-title">{{ __('admin.admin') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.name') }}</th>
                                        <th>{{ __('admin.email') }}</th>
                                        <th>{{ __('admin.role') }}</th>
                                        <th>{{ __('admin.team') }}</th>
                                        @if(auth()->user()->hasAnyPermission(['admin-delete','admin-edit'])) 
                                        <th> {{ __('admin.controls') }}</th>
                                        @endif
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

                                                <td>{{$admin->team->arab_name ?? ""}}</td>

                                            @else

                                                <td>{{$admin->team->eng_name ?? ''}}</td>

                                            @endif
                                            @if(auth()->user()->hasAnyPermission(['admin-delete','admin-edit']))  
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                    @if(auth()->user()->can('admin-delete'))    
                                                        <form action="{{ route('admins.destroy', $admin->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')


                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this admin?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                        </form>
                                                    @endif    
                                                    @if(auth()->user()->can('admin-edit'))
                                                                <a class="dropdown-item" href="{{ route('admins.edit', $admin->id) }}">{{ __('edit') }}</a>
                                                    @endif            
                                                    </div>
                                                </div>
                                            </td>
                                            @endif
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

