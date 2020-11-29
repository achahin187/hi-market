@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.SuperMarket Admin') }}</h1>
                    </div>


                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @if(auth()->user()->can('supermarketAdmin-create'))
                                <li class="breadcrumb-item"><a href="{{route('supermarket-admins.create')}}">{{ __('admin.add_supermarket_admin') }}</a></li>
                                @endif
                            </ol>
                        </div>


                    <div class="col-12">

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" admin="alert">
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
                                <h3 class="card-title">admins</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>name</th>
                                        <th>email</th>
                                    @if(auth()->user()->hasAnyPermission(['supermarketAdmin-delete','supermarketAdmin-edit']))
                                        <th>controls</th>
                                    @endif    
                                    </tr>
                                    </thead>
                                    <tbody>
                                @if(isset($supermarket_admins))        
                                    @foreach($supermarket_admins as $supermarket_admin)
                                        <tr>
                                            <td>{{$supermarket_admin->name}}</td>
                                            <td>{{$supermarket_admin->email}}</td>
                                        @if(auth()->user()->hasAnyPermission(['supermarketAdmin-delete','supermarketAdmin-edit']))
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                    @if(auth()->user()->can('supermarketAdmin-delete'))
                                                        <form action="{{ route('supermarket-admins.destroy', $supermarket_admin->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')



                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this vendor?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                        </form>
                                                    @endif
                                                    @if(auth()->user()->can('supermarketAdmin-edit'))
                                                                <a class="dropdown-item" href="{{ route('supermarket-admins.edit', $supermarket_admin->id) }}">{{ __('edit') }}</a>
                                                    @endif            
                                                    </div>
                                                </div>
                                            </td>
                                        @endif    
                                        </tr>
                                    @endforeach
                                @endif
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



