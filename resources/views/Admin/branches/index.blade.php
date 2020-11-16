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

                            @if(isset($supermarket_id))
                                <li class="breadcrumb-item"><a href="{{route('branches.create',$supermarket_id)}}">{{__('admin.add_supermarket_branch')}}</a></li>
                            @else

                                <li class="breadcrumb-item"><a href="{{route('branches.create')}}">{{__('admin.add_branch')}}</a></li>

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
                                <h3 class="card-title">{{__('admin.branches')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{__('admin.name_ar')}}</th>
                                        <th>{{__('admin.name_en')}}</th>
                                        <th>{{__('admin.supermarket')}}</th>
                                        <th>{{__('admin.status')}}</th>
                                        <th>{{__('admin.products')}}</th>
                                        <th>{{__('admin.offers')}}</th>
                                        <th>{{__('admin.controls')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($branches as $branch)
                                        <tr>
                                            <td>{{$branch->name_ar}}</td>
                                            <td>{{$branch->name_en}}</td>
                                            @if(App::getLocale() == 'ar')
                                                <td>{{$branch->supermarket->arab_name}}</td>
                                            @else
                                                <td>{{$branch->supermarket->eng_name}}</td>
                                            @endif
                                            <td>

                                                @if($branch->status == 'active' )

                                                    <form action="{{ route('branch.status', $branch->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this branch?") }}') ? this.parentElement.submit() : ''" href="{{ route('branch.status', $branch->id) }}" class="btn btn-block btn-outline-success">{{__('admin.active')}}</button>
                                                    </form>

                                                @else

                                                    <form action="{{ route('branch.status', $branch->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this branch ?") }}') ? this.parentElement.submit() : ''" href="{{ route('branch.status', $branch->id) }}" class="btn btn-block btn-outline-danger">{{__('admin.inactive')}}</button>
                                                    </form>

                                                @endif


                                            </td>
                                            <td>
                                                <a href="{{ route('branch.products', ['branch_id' => $branch->id , 'flag' => 0]) }}" class="btn btn-info">{{__('admin.products')}}</a>
                                            </td>

                                            <td>
                                                <a href="{{ route('branch.products', ['branch_id' => $branch->id , 'flag' => 1]) }}" class="btn btn-info">{{__('admin.product_offers')}}</a>
                                            </td>

                                            <td>
                                                <a href="{{ route('branch.offers', $branch->id) }}" class="btn btn-info">{{__('admin.offers')}}</a>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('branches.destroy', $branch->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                            <a class="dropdown-item" href="@if(isset($supermarket_id)) {{ route('branches.edit', ['id' => $branch->id , 'supermarket_id' => $supermarket_id]) }} @else {{ route('branches.edit', $branch->id) }} @endif ">{{__('admin.modify')}}</a>
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




