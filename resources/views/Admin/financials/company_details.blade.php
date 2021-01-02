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
                                <h3 class="card-title">{{ __('admin.promocode') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example15" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.id') }}</th>
                                        <th>{{ __('admin.branch_name') }}</th>
                                        <th>{{ __('admin.commission') }}</th>
                                        <th>{{ __('admin.total_shipping') }}</th>
                                        <th>{{ __('admin.delivertto_money') }}</th>
                                        <th>{{ __('admin.company_money') }}</th>
                                        <th>{{ __('admin.delivertto_dicount') }}</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($orders as $order)
                                        <tr>
                                            
                                        
                                        <td> <a  href="{{ route('orders.show.details',$order->id ) }}"> {{ $order->id }}</td>
                                        <td>{{$order->branch->name ?? "" }}</td>

                                        <td>{{$company->commission  }}</td>

                                        <td>{{ '10'   }}</td>

                                        <td>{{$order->shipping_before * $company->commission/ 100  }}</td>

                                        <td>{{   $order->shipping_before - ($order->shipping_before * $company->commission/ 100)  }}</td>

                                        <td>{{ $order->shipping_before - $order->shipping_fee }}</td>
                          
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

@endsection


                                            