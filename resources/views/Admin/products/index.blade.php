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

                    @if(auth()->user()->can('product-create'))
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('products.create',0)}}">create new product</a></li>
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
                                <h3 class="card-title">products</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>arab_name</th>
                                        <th>eng_name</th>
                                        <th>eng_description</th>
                                        <th>arab_description</th>
                                        <th>price</th>
                                        <th>category</th>
                                        <th>vendor</th>
                                        <th>barcode</th>
                                        <th>controls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{$product->arab_name}}</td>
                                            <td>{{$product->eng_name}}</td>
                                            <td>{{$product->eng_description}}</td>
                                            <td>{{$product->arab_description}}</td>
                                            <td>{{$product->price}}</td>
                                            <td>{{$product->category->eng_name}}</td>
                                            <td>{{$product->vendor->eng_name}}</td>
                                            <td>{{$product->barcode}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                            @if(auth()->user()->can('product-edit'))

                                                                <a class="dropdown-item" href="{{ route('products.edit', ['id' => $product->id,'flag' => $product->flag]) }}">{{ __('edit') }}</a>

                                                            @endif

                                                            @if(auth()->user()->can('product-delete'))

                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this product?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>

                                                            @endif
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end w-100">
                                        <nav aria-label="Page navigation example">
                                            {{ $products->links() }}
                                        </nav>
                                    </div>
                                </div>
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



