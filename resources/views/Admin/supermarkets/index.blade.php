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
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('supermarkets.create')}}">add new supermarket</a></li>
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
                                <h3 class="card-title">Supermarkets</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>arab_name</th>
                                        <th>eng_name</th>
                                        <th>commission</th>
                                        <th>priority</th>
                                        <th>status</th>
                                        <th>products</th>
                                        <th>controls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($supermarkets as $supermarket)
                                        <tr>
                                            <td>{{$supermarket->arab_name}}</td>
                                            <td>{{$supermarket->eng_name}}</td>
                                            <td>{{$supermarket->commission}}</td>
                                            <td>{{$supermarket->priority}}</td>
                                            <td><button type="button" data-toggle="modal" data-target="#showproducts" class="btn btn-primary">super market products</button></td>
                                            <td><button type="button" data-toggle="modal" data-target="#showoffers" class="btn btn-primary">super market offers</button></td>
                                            <td>

                                                @if($supermarket->status == 'active' )

                                                    <form action="{{ route('supermarket.status', $supermarket->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this supermarket?") }}') ? this.parentElement.submit() : ''" href="{{ route('supermarket.status', $supermarket->id) }}" class="btn btn-block btn-outline-success">active</button>
                                                    </form>

                                                @else

                                                    <form action="{{ route('supermarket.status', $supermarket->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this supermarket?") }}') ? this.parentElement.submit() : ''" href="{{ route('supermarket.status', $supermarket->id) }}" class="btn btn-block btn-outline-danger">inactive</button>
                                                    </form>

                                                @endif


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

                                                            <a class="dropdown-item" href="{{ route('supermarkets.edit', $supermarket->id) }}">{{ __('edit') }}</a>
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this supermarket?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="showproducts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Cancel Order</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="col-md-6">


                                                                @foreach($supermarket->products as $product)

                                                                    <button class="btn-danger">{{$product->arab_name}}</button>

                                                                    <div class="dropdown">
                                                                        <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                                            <i class="fas fa-ellipsis-v"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                            <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                                                                @csrf
                                                                                @method('delete')

                                                                                <a class="dropdown-item">{{ __('edit') }}</a>
                                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this supermarket?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                            </form>

                                                                        </div>
                                                                    </div>

                                                                @endforeach
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="showproducts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Cancel Order</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="col-md-6">


                                                                @foreach($supermarket->offers as $offer)

                                                                    <button class="btn-danger">{{$offer->arab_name}}</button>

                                                                    <div class="dropdown">
                                                                        <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                                            <i class="fas fa-ellipsis-v"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                            <form action="{{ route('product_offers.destroy', $offer->id) }}" method="post">
                                                                                @csrf
                                                                                @method('delete')

                                                                                <a class="dropdown-item" href="{{ route('product_offers.edit', $offer->id) }}">{{ __('edit') }}</a>
                                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this offer?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                            </form>

                                                                        </div>
                                                                    </div>

                                                                @endforeach
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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




