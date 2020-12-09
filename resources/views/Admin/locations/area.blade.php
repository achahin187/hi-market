@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.delivery_admin') }}</h1>
                    </div>


                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @if(auth()->user()->can('location-create'))
                                <li class="breadcrumb-item"><a href="{{route('delivery-admins.create')}}">{{ __('admin.add_delivery_admin') }}</a></li>
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
                                <h3 class="card-title">{{ __('admin.delivery_admin') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.area_ar') }}</th>
                                        <th>{{ __('admin.area_en') }}</th>
                                        <th>{{ __('admin.map') }}</th>
                                        <th>{{ __('admin.status') }}</th>
                                  
                                      
                                    @if(auth()->user()->hasAnyPermission(['location-delete','location-edit']))
                                        <th>{{ __('admin.controls') }}</th>
                                    @endif    
                                    </tr>
                                    </thead>
                                    <tbody>
                                @if(isset($areaLists))        
                                    @foreach($areaLists as $areaList)
                                        <tr>
                                            <td>{{$areaList->name_ar}}</td>
                                            <td>{{$areaList->name_en}}</td>
                                            <td>
                                            <a href='{{ route('locations.area.show',$areaList->id) }}' class="btn btn-primary">Zone</a></td>
                                            <td>
                                                    <form action="{{ route('areaList.status', ['id'=>$areaList->id]) }}" method="POST">

                                                        @csrf
                                                      
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this supermarket?") }}') ? this.parentElement.submit() : ''" href="{{ route('areaList.status', ['id'=>$areaList->id]) }}" class="{{ $areaList->status == 'active' ?'btn btn-block btn-outline-success' :'btn btn-block btn-outline-danger '}}">{{ $areaList->status }}</button>
                                                    </form>
                                                </td>
                                           
                                        @if(auth()->user()->hasAnyPermission(['location-delete','location-edit']))
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                    @if(auth()->user()->can('location-delete'))
                                                        <form action="{{ route('delivery-admins.destroy', $areaList->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')



                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this vendor?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                        </form>
                                                    @endif
                                                    @if(auth()->user()->can('location-edit'))
                                                                <a class="dropdown-item" href="{{ route('delivery-admins.edit', $areaList->id) }}">{{ __('edit') }}</a>
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



