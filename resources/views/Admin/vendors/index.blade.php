@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.vendor') }}</h1>
                    </div>

                    @if(auth()->user()->can('vendor-create'))
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('vendors.create')}}">{{ __('admin.vendor_create') }}</a></li>

                                <li class="breadcrumb-item"><a href="{{route('vendor.export')}}">{{__('admin.export')}}</a></li>
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
                                <h3 class="card-title">{{ __('admin.vendors') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.name_ar') }}</th>
                                        <th>{{ __('admin.name_en') }}</th>
                             
                                  
                                        <th>{{ __('admin.status') }}</th>
                                @if(auth()->user()->hasAnyPermission(['vendor-delete','vendor-edit']))
                                        <th>{{__('admin.controls')}}</th>
                                 @endif  
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vendors as $vendor)
                                        <tr>
                                            <td>{{$vendor->arab_name}}</td>
                                            <td>{{$vendor->eng_name}}</td>
                                   
                                            <td>
                                                @if($vendor->sponsor == 1 )

                                                   {{ __('admin.sponser') }}

                                                @else

                                                    {{ __('admin.vendor') }}

                                                @endif

                                            </td>
                                 @if(auth()->user()->hasAnyPermission(['vendor-delete','vendor-edit']))            
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                 @if(auth()->user()->can('vendor-delete'))        
                                                        <form action="{{ route('vendors.destroy', $vendor->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')




                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this vendor?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>

                                                        </form>
                                                 @endif       
                                                     @if(auth()->user()->can('vendor-edit'))    
                                                                <a class="dropdown-item" href="{{ route('vendors.edit', $vendor->id) }}">{{ __('edit') }}</a>
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



