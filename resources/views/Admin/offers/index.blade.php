@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.offers') }}</h1>
                    </div>


                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @if(auth()->user()->can('offer-create'))
                                <li class="breadcrumb-item"><a
                                        href="{{route('offer.create')}}">{{ __('admin.add_offer') }}</a>
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
                                        <th>{{ __('admin.type') }}</th>
                                        <th>{{ __('admin.source') }}</th>
                                        <th>{{ __('admin.promocode_name') }}</th>
                                        <th>{{ __('admin.promocode_type') }}</th>
                                        <th>{{ __('admin.discount_on') }}</th>
                                        <th>{{ __('admin.value') }}</th>
                                        
                                     
                                        <th>{{ __('admin.status') }}</th>


                                        @if(auth()->user()->hasAnyPermission(['offer-delete','offer-edit']))
                                            <th>{{ __('admin.controls') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($offers->where('type', 'promocode') as $offer)
                                        <tr>
                                            
                                        <td>{{$offer->type}}</td>
                                        <td>{{$offer->source}}</td>
                                        <td>{{$offer->promocode_name}}</td>
                                        <td>{{$offer->promocode_type}}</td>
                                        <td>{{$offer->discount_on}}</td>
                                        <td>{{$offer->value}}</td>
                                       
                                       
                                        <td> 
                                            <a href="{{ route('offer.status', ['status'=>$offer->status,'id'=>$offer->id]) }}" class="btn btn-block btn-outline-{{ $offer->status ==1 ? 'success': 'danger'}}">{{__($offer->status ==1 ? 'active': 'inactive')}}</a>
                                        </td>
                                        

                                          


                                            @if(auth()->user()->hasAnyPermission(['offer-delete','offer-edit']))
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                class="drop-down-button">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                            @if(auth()->user()->can('offer-delete'))
                                                                <form
                                                                    action="{{ route('offer.destroy', $offer->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')


                                                                    <button type="button" class="dropdown-item"
                                                                            onclick="confirm('{{ __("Are you sure you want to delete this record?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                </form>
                                                            @endif
                                                            @if(auth()->user()->can('offer-edit'))
                                                                <a class="dropdown-item"
                                                                   href="{{ route('offer.edit', $offer->id) }}">{{ __('edit') }}</a>
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
        <section class="content">
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


                                        @if(auth()->user()->hasAnyPermission(['offer-delete','offer-edit']))
                                            <th>{{ __('admin.controls') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($offers->where('type', 'point') as $offer)
                                        <tr>
                                            
                                        <td>{{$offer->type}}</td>
                                        <td>{{$offer->source}}</td>
                                      
                                        <td>{{$offer->value}}</td>
                                        <td>{{$offer->total_order_money}}</td>
                                       
                                        <td> 
                                            <a href="{{ route('offer.status', ['status'=>$offer->status,'id'=>$offer->id]) }}" class="btn btn-block btn-outline-{{ $offer->status ==1 ? 'success': 'danger'}}">{{__($offer->status ==1 ? 'active': 'inactive')}}</a>
                                        </td>
                                        

                                          


                                            @if(auth()->user()->hasAnyPermission(['offer-delete','offer-edit']))
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                class="drop-down-button">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                            @if(auth()->user()->can('offer-delete'))
                                                                <form
                                                                    action="{{ route('offer.destroy', $offer->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')


                                                                    <button type="button" class="dropdown-item"
                                                                            onclick="confirm('{{ __("Are you sure you want to delete this record?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                </form>
                                                            @endif
                                                            @if(auth()->user()->can('offer-edit'))
                                                                <a class="dropdown-item"
                                                                   href="{{ route('offer.edit', $offer->id) }}">{{ __('edit') }}</a>
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

        {{-- table 2 --}} 

  {{-- table 2 --}} 
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.free_offer') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example3" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.type') }}</th>
                                        <th>{{ __('admin.source') }}</th>
                                        <th>{{ __('admin.total_order_money') }}</th>
                                       
                                        <th>{{ __('admin.status') }}</th>


                                        @if(auth()->user()->hasAnyPermission(['offer-delete','offer-edit']))
                                            <th>{{ __('admin.controls') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($offers->where('type','free offer') as $offer)
                                        <tr>
                                            
                                        <td>{{$offer->type}}</td>
                                        <td>{{$offer->source}}</td>
                                        <td>{{$offer->total_order_money}}</td>
                                        <td> 
                                            <a href="{{ route('offer.status', ['status'=>$offer->status,'id'=>$offer->id]) }}" class="btn btn-block btn-outline-{{ $offer->status ==1 ? 'success': 'danger'}}">{{__($offer->status ==1 ? 'active': 'inactive')}}</a>
                                        </td>
                                        

                                          


                                            @if(auth()->user()->hasAnyPermission(['offer-delete','offer-edit']))
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                class="drop-down-button">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                            @if(auth()->user()->can('offer-delete'))
                                                                <form
                                                                    action="{{ route('offer.destroy', $offer->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')


                                                                    <button type="button" class="dropdown-item"
                                                                            onclick="confirm('{{ __("Are you sure you want to delete this record?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                </form>
                                                            @endif
                                                            @if(auth()->user()->can('offer-edit'))
                                                                <a class="dropdown-item"
                                                                   href="{{ route('offer.edit', $offer->id) }}">{{ __('edit') }}</a>
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
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.product_offer') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example4" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('admin.type') }}</th>
                                        <th>{{ __('admin.product') }}</th>
                                        <th>{{ __('admin.supermarket') }}</th>
                                        <th>{{ __('admin.status') }}</th>


                                        @if(auth()->user()->hasAnyPermission(['offer-delete','offer-edit']))
                                            <th>{{ __('admin.controls') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($offers->where('type', 'product Offer') as $offer)
                                        <tr>
                                            
                                        <td>{{$offer->type}}</td>
        
                                        <td>{{$offer->product->name ?? ''  }}</td>
                                        <td>{{$offer->supermarket->name ?? ''  }} </td>
                                       
                                        <td> 
                                            <a href="{{ route('offer.status', ['status'=>$offer->status,'id'=>$offer->id]) }}" class="btn btn-block btn-outline-{{ $offer->status ==1 ? 'success': 'danger'}}">{{__($offer->status ==1 ? 'active': 'inactive')}}</a>
                                        </td>
                                        

                                          


                                            @if(auth()->user()->hasAnyPermission(['offer-delete','offer-edit']))
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                class="drop-down-button">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                            @if(auth()->user()->can('offer-delete'))
                                                                <form
                                                                    action="{{ route('offer.destroy', $offer->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')


                                                                    <button type="button" class="dropdown-item"
                                                                            onclick="confirm('{{ __("Are you sure you want to delete this record?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                </form>
                                                            @endif
                                                            @if(auth()->user()->can('offer-edit'))
                                                                <a class="dropdown-item"
                                                                   href="{{ route('offer.edit', $offer->id) }}">{{ __('edit') }}</a>
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


        {{-- table 2 --}} 

    



 

@endsection


                                            