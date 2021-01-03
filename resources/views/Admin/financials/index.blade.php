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
                           {{--  @if(auth()->user()->can('delivery-list'))
                                <li class="breadcrumb-item"><a
                                        href="{{route('financials.create')}}">{{ __('admin.add_financials') }}</a>
                                </li>
                            @endif --}}
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
        {{-- table 1 --}} 
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.branch_financial') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example12" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.branch_name') }}</th>
                                        <th>{{ __('admin.commission') }}</th>
                                        <th>{{ __('admin.total_order') }}</th>
                                        <th>{{ __('admin.delivertto_money') }}</th>
                                        <th>{{ __('admin.branch_money') }}</th>
                                       
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($branches as $branch)
                                        <tr>
                                            
                                        
                                        <td>{{$branch->name }}</td>
                                        <td>{{$branch->commission }}</td>

                                        <td>{{ branchTotal($branch->id) }}</td>

                                        <td>{{branchTotal($branch->id) *$branch->commission/ 100  }}</td>

                                        <td>{{    branchTotal($branch->id) - (branchTotal($branch->id) * $branch->commission/ 100)  }}</td>
                          
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
       {{-- end table 1 --}} 

        {{-- table 2 --}} 
         <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.company_financial') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example13" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.branch_name') }}</th>
                                        <th>{{ __('admin.Commission') }}</th>
                                        <th>{{ __('admin.status') }}</th>
                                        <th>{{ __('admin.branches') }}</th>
                                        
                                        @if(auth()->user()->hasAnyPermission(['delivery-delete','delivery-edit']))
                                            <th>{{ __('admin.details') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($companies as $company)
                                        <tr>
                                            
                                        
                                        <td>{{$company->name }}</td>
                                        <td>{{$company->commission }}</td>
                                        <td>{{$company->status == 1 ?trans('admin.active') :trans('admin.inactive') }}</td>
                                        <td>
                                            @foreach($company->branches as $branches)
                                            <span class="badge badge-primary">{{ $branches->name }}</span>
                                            @endforeach
                                        </td>

                          
                                            @if(auth()->user()->hasAnyPermission(['delivery-delete','delivery-edit']))
                                                <td>
                                                
                                                            @if(auth()->user()->can('delivery-edit'))
                                                                <a  class="btn btn-primary" 
                                                                   href="{{ route('company.orders',$company->id) }}">{{ __('admin.details') }}</a>
                                                            @endif
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
  

    



 

@endsection


                                            