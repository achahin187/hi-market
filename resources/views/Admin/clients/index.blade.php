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

                    @if(auth()->user()->can('client-create'))
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('clients.create')}}">add new client</a></li>
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
                                <h3 class="card-title">Clients</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>name</th>
                                        <th>email</th>
                                        <th>address</th>
                                        <th>gender</th>
                                        <th>city</th>
                                        <th>mobile number</th>
                                        <th>client orders</th>
                                @if(auth()->user()->can('client-active'))         
                                        <th>status</th>
                                @endif        
                                @if(auth()->user()->hasAnyPermission(['client-delete','client-edit']))        
                                        <th>{{__('admin.controls')}}</th>
                                @endif    
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($clients as $client)
                                        <tr>
                                            <td>{{$client->name}}</td>
                                            <td>{{$client->email}}</td>
                                            <td>{{$client->address}}</td>
                                            <td>{{$client->gender}}</td>
                                            <td>{{$client->city}}</td>
                                            <td>{{$client->mobile_number}}</td>
                                            <td><a href="{{route('client.orders',['client_id'=>$client->id])}}" class="btn btn-info">client orders</a></td>

                                         @if(auth()->user()->can('client-active'))    
                                            <td>

                                                @if($client->status == 'active' )

                                                    <form id="active" onsubmit="return confirm('Do you really want to change status of client?');" action="{{ route('clients.status',$client->id) }}"  method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button form="active" type="submit" class="btn btn-block btn-outline-success">active</button>
                                                    </form>

                                                @else

                                                    <form id="in-active" onsubmit="return confirm('Do you really want to submit the form?');" action="{{ route('clients.status',$client->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="submit" form="in-active" class="btn btn-block btn-outline-danger">inactive</button>
                                                    </form>

                                                @endif
                                            </td>
                                        @endif    
                                    @if(auth()->user()->hasAnyPermission(['client-delete','client-edit']))
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                     @if(auth()->user()->can('client-delete'))    
                                                        <form action="{{ route('clients.destroy', $client->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')


                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this client?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                        </form>
                                                    @endif    

                                                    @if(auth()->user()->can('client-edit'))
                                                        <a class="dropdown-item" href="{{ route('clients.edit', $client->id) }}">{{ __('edit') }}</a>
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

