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
                                <li class="breadcrumb-item"><a href="{{route('countries.create')}}">{{__('admin.add_country')}}</a></li>
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
                                <h3 class="card-title">{{__('admin.countries')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{__('admin.name_ar')}}</th>
                                        <th>{{__('admin.name_en')}}</th>
                                        <th>{{__('admin.numcode')}}</th>
                                        <th>{{__('admin.phonecode')}}</th>
                                        <th>{{__('admin.phonelength')}}</th>
                                        <th>{{__('admin.status')}}</th>
                                        <th>{{__('admin.controls')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($countries as $country)
                                        <tr>
                                            <td>{{$country->name_ar}}</td>
                                            <td>{{$country->name_en}}</td>
                                            <td>{{$country->numcode}}</td>
                                            <td>{{$country->phonecode}}</td>
                                            <td>{{$country->phonelength}}</td>
                                            <td>

                                                @if($country->status == 'active' )

                                                    <form action="{{ route('countries.status', $country->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this reason?") }}') ? this.parentElement.submit() : ''" href="{{ route('countries.status', $country->id) }}" class="btn btn-block btn-outline-success">{{__('admin.active')}}</button>
                                                    </form>

                                                @else

                                                    <form action="{{ route('countries.status', $country->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this reason?") }}') ? this.parentElement.submit() : ''" href="{{ route('countries.status', $country->id) }}" class="btn btn-block btn-outline-danger">{{__('admin.inactive')}}</button>
                                                    </form>

                                                @endif


                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('countries.destroy', $country->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                                <a class="dropdown-item" href="{{ route('countries.edit', $country->id) }}">{{__('admin.modify')}}</a>



                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this vendor?") }}') ? this.parentElement.submit() : ''">{{__('admin.delete')}}</button>

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



