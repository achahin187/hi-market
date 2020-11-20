@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('supermarkets.create')}}">{{__('admin.add_supermarket')}}</a></li>

                             <li class="breadcrumb-item"><a href="{{route('supermarkets.create')}}">{{__('admin.import')}}</a></li>

                              <li class="breadcrumb-item"><a href="{{route('supermarket.export')}}">{{__('admin.export')}}</a></li>

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
                                <h3 class="card-title">{{__('admin.supermarkets')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{__('admin.name_ar')}}</th>
                                        <th>{{__('admin.name_en')}}</th>
                                        <th>{{__('admin.commission')}}</th>
                                        <th>{{__('admin.priority')}}</th>
                                        <th>{{__('admin.status')}}</th>
                                        <th>{{__('admin.products')}}</th>
                                        <th>{{__('admin.product_offers')}}</th>
                                        <th>{{__('admin.offers')}}</th>
                                        <th>{{__('admin.branches')}}</th>
                                        <th>{{__('admin.controls')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($supermarkets as $supermarket)
                                        <tr>
                                            <td>{{$supermarket->arab_name}}</td>
                                            <td>{{$supermarket->eng_name}}</td>
                                            <td>{{$supermarket->commission}}</td>
                                            <td>{{$supermarket->priority}}</td>
                                            <td>

                                                @if($supermarket->status == 'active' )

                                                    <form action="{{ route('supermarket.status', $supermarket->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this supermarket?") }}') ? this.parentElement.submit() : ''" href="{{ route('supermarket.status', $supermarket->id) }}" class="btn btn-block btn-outline-success">{{__('admin.active')}}</button>
                                                    </form>

                                                @else

                                                    <form action="{{ route('supermarket.status', $supermarket->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this supermarket?") }}') ? this.parentElement.submit() : ''" href="{{ route('supermarket.status', $supermarket->id) }}" class="btn btn-block btn-outline-danger">{{__('admin.inactive')}}</button>
                                                    </form>

                                                @endif


                                            </td>
                                            <td>
                                                <a href="{{ route('supermarket.products', ['supermarket_id' => $supermarket->id , 'flag' => 0]) }}" class="btn btn-info">{{__('admin.products')}}</a>
                                            </td>

                                            <td>
                                                <a href="{{ route('supermarket.products', ['supermarket_id' => $supermarket->id , 'flag' => 1]) }}" class="btn btn-info">{{__('admin.product_offers')}}</a>
                                            </td>

                                            <td>
                                                <a href="{{ route('supermarket.offers', $supermarket->id) }}" class="btn btn-info">{{__('admin.offers')}}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('supermarket.branches', $supermarket->id) }}" class="btn btn-info">{{__('admin.branches')}}</a>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('supermarkets.destroy', $supermarket->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                            <a class="dropdown-item" href="{{ route('supermarkets.edit', $supermarket->id) }}">{{__('admin.modify')}}</a>
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this supermarket?") }}') ? this.parentElement.submit() : ''">{{__('admin.delete')}}</button>
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




