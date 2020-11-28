@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.sub_category') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @if(auth()->user()->can('subCategory-create'))
                            <li class="breadcrumb-item"><a href="{{route('subcategories.create')}}">{{__('admin.add_subcategory')}}</a></li>
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
                                <h3 class="card-title">{{__('admin.subcategories')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{__('admin.name_ar')}}</th>
                                        <th>{{__('admin.name_en')}}</th>
                                        <th>{{__('admin.category')}}</th>
                              @if(auth()->user()->hasAnyPermission(['subCategory-delete','subCategory-edit']))
                                        <th>{{__('admin.controls')}}</th>
                              @endif          
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subcategories as $subcategory)
                                        <tr>
                                            <td>{{$subcategory->arab_name}}</td>
                                            <td>{{$subcategory->eng_name}}</td>
                                            @if(App::getLocale() == 'ar')
                                                <td>{{$subcategory->category->arab_name}}</td>
                                            @else
                                                <td>{{$subcategory->category->eng_name}}</td>
                                            @endif
                                @if(auth()->user()->hasAnyPermission(['subCategory-delete','subCategory-edit']))            
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                 @if(auth()->user()->can('subCategory-delete'))        
                                                        <form action="{{ route('subcategories.destroy', $subcategory->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this subcategory?") }}') ? this.parentElement.submit() : ''">{{__('admin.delete')}}</button>
                                                        </form>
                                                 @endif       

                                                     @if(auth()->user()->can('subCategory-edit'))
                                                            <a class="dropdown-item" href="{{ route('subcategories.edit', $subcategory->id) }}">{{__('admin.edit')}}</a>
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


