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
                                <li class="breadcrumb-item"><a href="{{route('offers.create')}}">add new offer</a></li>
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
                                <h3 class="card-title">Admins</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>arab description</th>
                                        <th>eng description</th>
                                        <th>offer type</th>
                                        <th>value type</th>
                                        <th>status</th>
                                        <th>start date</th>
                                        <th>end date</th>
                                        <th>promocode</th>
                                        <th>controls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($offers as $offer)
                                        <tr>
                                            <td>{{$offer->arab_description}}</td>
                                            <td>{{$offer->eng_description}}</td>
                                            <td>

                                                @if($offer->promocode == null)

                                                    navigable offer


                                                @else

                                                    promocode offer

                                                @endif


                                            </td>

                                            <td>{{$offer->value_type}}</td>
                                            <td>

                                                @if($offer->status == 'active' )

                                                    <form action="{{ route('offers.status', $offer->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this offer ?") }}') ? this.parentElement.submit() : ''" href="{{ route('offers.status', $offer->id) }}" class="btn btn-block btn-outline-success">active</button>
                                                    </form>

                                                @else

                                                    <form action="{{ route('offers.status', $offer->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this offer ?") }}') ? this.parentElement.submit() : ''" href="{{ route('offers.status', $offer->id) }}" class="btn btn-block btn-outline-danger">inactive</button>
                                                    </form>

                                                @endif


                                            </td>
                                            <td>{{$offer->start_date}}</td>
                                            <td>{{$offer->end_date}}</td>
                                            <td>{{$offer->promocode}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('offers.destroy', $offer->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                            @if(auth()->user()->can('admin-edit'))

                                                                <a class="dropdown-item" href="{{ route('offers.edit', $offer->id) }}">{{ __('edit') }}</a>
                                                            @endif
                                                            @if(auth()->user()->can('admin-delete'))
                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this offer?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
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

