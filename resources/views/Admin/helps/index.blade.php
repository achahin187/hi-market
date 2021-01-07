@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.help') }}</h1>
                    </div>


                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @if(auth()->user()->can('help-list'))
                                <li class="breadcrumb-item"><a
                                        href="{{route('helps.create')}}">{{ __('admin.helps') }}</a>
                                </li>
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
                                <h3 class="card-title">{{ __('admin.help') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.title_ar') }}</th>
                                        <th>{{ __('admin.title_en') }}</th>
                                        <th>{{ __('admin.describtion_ar') }}</th>
                                        <th>{{ __('admin.describtion_en') }}</th>
                                        <th>{{ __('admin.image') }}</th>
                                        @if(auth()->user()->hasAnyPermission(['help-delete','help-edit']))
                                            <th>{{ __('admin.controls') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($helps as $help)
                                        <tr>
                                            <td>{{$help->title_ar}}</td>
                                            <td>{{$help->title_en}}</td>
                                            <td>{{$help->description_ar}}</td>
                                            <td>{{$help->description_en}}</td>
                                            <td> <img style="width:100px; height: 100px;" src="{{ asset('help_images/'.$help->image) }}"></td>

                                  

                                            @if(auth()->user()->hasAnyPermission(['help-delete','help-edit']))
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                class="drop-down-button">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                            @if(auth()->user()->can('help-delete'))
                                                                <form
                                                                    action="{{ route('helps.destroy', $help->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')


                                                                    <button type="button" class="dropdown-item"
                                                                            onclick="confirm('{{ __("Are you sure you want to delete this record?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                </form>
                                                            @endif
                                                            @if(auth()->user()->can('help-edit'))
                                                                <a class="dropdown-item"
                                                                   href="{{ route('helps.edit', $help->id) }}">{{ __('edit') }}</a>
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



