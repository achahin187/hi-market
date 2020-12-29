@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.financials') }}</h1>
                    </div>


                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @if(auth()->user()->can('delivery-list'))
                                <li class="breadcrumb-item"><a
                                        href="{{route('financials.create')}}">{{ __('admin.add_financials') }}</a>
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
        {{-- table 2 --}} 
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.promocode') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.branch_name') }}</th>
                                        <th>{{ __('admin.company_name') }}</th>
                                        <th>{{ __('admin.total_order') }}</th>
                                        <th>{{ __('admin.delivertto_money') }}</th>
                                        <th>{{ __('admin.branch_money') }}</th>
                                        <th>{{ __('admin.branch_recieved') }}</th>
                                        <th>{{ __('admin.branch_remain') }}</th>
                                        <th>{{ __('admin.company_remain') }}</th>
                                        
                                     
                                        <th>{{ __('admin.status') }}</th>


                                        @if(auth()->user()->hasAnyPermission(['delivery-delete','delivery-edit']))
                                            <th>{{ __('admin.controls') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($financials as $financial)
                                        <tr>
                                            
                                        
                                        <td>{{$financial->branch->name}}</td>
                                        <td>{{$financial->company->name}}</td>
                                        <td>{{$financial->total_order}}</td>
                                        <td>{{$financial->delivertto_money}}</td>
                                        <td>{{$financial->branch_money}}</td>
                                        <td>{{$financial->branch_recieved}}</td>
                                        <td>{{$financial->branch_remain}}</td>
                                        <td>{{$financial->company_remain}}</td>
                                       
                                       
                                        <td> 
                                            <a href="{{ route('financials.status', ['status'=>$financial->status,'id'=>$financial->id]) }}" class="btn btn-block btn-outline-{{ $financial->status ==1 ? 'success': 'danger'}}">{{__($financial->status ==1 ? 'active': 'inactive')}}</a>
                                        </td>
                                        

                                          


                                            @if(auth()->user()->hasAnyPermission(['delivery-delete','delivery-edit']))
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                class="drop-down-button">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                            @if(auth()->user()->can('delivery-delete'))
                                                                <form
                                                                    action="{{ route('financials.destroy', $financial->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')


                                                                    <button type="button" class="dropdown-item"
                                                                            onclick="confirm('{{ __("Are you sure you want to delete this record?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                </form>
                                                            @endif
                                                            @if(auth()->user()->can('delivery-edit'))
                                                                <a class="dropdown-item"
                                                                   href="{{ route('financials.edit', $financial->id) }}">{{ __('edit') }}</a>
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
                        </div>
                    </div>
                </div>
             </div>                                
        </section>
       {{-- end table 2 --}} 

        {{-- table 3 --}} 
          <!-- Main content -->
   {{--      <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.points') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.type') }}</th>
                                        <th>{{ __('admin.source') }}</th>                                     
                                        <th>{{ __('admin.value') }}</th>
                                        <th>{{ __('admin.total_order_money') }}</th>       
                                        <th>{{ __('admin.status') }}</th>


                                        @if(auth()->user()->hasAnyPermission(['delivery-delete','delivery-edit']))
                                            <th>{{ __('admin.controls') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($financials as $financials)
                                        <tr>
                                            
                                        <td>{{$financials->type}}</td>
                                        <td>{{$financials->source}}</td>
                                        <
                                        <td>{{$financials->value}}</td>
                                        <td>{{$financials->total_order_money}}</td>
                                       
                                        <td> 
                                            <a href="{{ route('financials.status', ['status'=>$financials->status,'id'=>$financials->id]) }}" class="btn btn-block btn-outline-{{ $financials->status ==1 ? 'success': 'danger'}}">{{__($financials->status ==1 ? 'active': 'inactive')}}</a>
                                        </td>
                                        

                                          


                                            @if(auth()->user()->hasAnyPermission(['delivery-delete','delivery-edit']))
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                class="drop-down-button">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                            @if(auth()->user()->can('delivery-delete'))
                                                                <form
                                                                    action="{{ route('financials.destroy', $financials->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')


                                                                    <button type="button" class="dropdown-item"
                                                                            onclick="confirm('{{ __("Are you sure you want to delete this record?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                </form>
                                                            @endif
                                                            @if(auth()->user()->can('delivery-edit'))
                                                                <a class="dropdown-item"
                                                                   href="{{ route('financials.edit', $financials->id) }}">{{ __('edit') }}</a>
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
                        </div>
                    </div>
                </div>
             </div>                                
        </section>
 --}}
        {{-- table 2 --}} 

  
      

        {{-- table 2 --}} 

    



 

@endsection


                                            