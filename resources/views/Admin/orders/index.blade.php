@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.orders') }}</h1>
                    </div>
                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">

                            {{-- <li class="breadcrumb-item">

                                <a href="{{route('orders.index')}}">Orders</a>

                            </li> --}}
                            @if(auth()->user()->can('order-show-cancel'))
                                <li class="breadcrumb-item"><a href="{{route('orders.index',true)}}">CancelledOrders</a></li>
                            @endif    

                            @if(auth()->user()->can('order-create'))
                             <li class="breadcrumb-item"><a href="{{route('orders.index',true)}}">Add manual order</a></li>
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

                                @if(isset($cancelledorders))

                                   {{  __('admin.cancelled_orders') }}

                                @else

                                    {{ __('admin.orders') }}

                                @endif
                            </div>
                            <!-- /.card-header -->
                        @if(isset($cancelledorders))
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>order ID</th>
                                        @if(auth()->user()->hasAnyPermission(['order-delete','order-edit']))        
                                        <th>{{ __('admin.controls') }}</th>
                                @endif        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cancelledorders as $order)
                                        <tr>
                                            <td><a  href="{{route('order_details',$order->id)}}">{{$order->id}}</a></td>

                                            @if(auth()->user()->hasAnyPermission(['order-delete','order-edit']))
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                 @if(auth()->user()->can('order-delete'))        
                                                        <form action="{{ route('orders.delete', $order->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this order?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                        </form>
                                                 @endif       
                                                  @if(auth()->user()->can('order-edit'))           
                                                            <a class="dropdown-item" href="{{ route('orders.edit', $order->id) }}">{{ __('edit') }}</a>
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

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end w-100">
                                            <nav aria-label="Page navigation example">
                                                {{ $cancelledorders->links() }}
                                            </nav>
                                        </div>
                                    </div>
                                </div>

                            @else

                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>order ID</th>
                                            <th>assign to</th>
                                            <th>status</th>

                                            @if(auth()->user()->can('orders-cancel'))
                                            <th>cancel</th>
                                            @endif

                                            @if(auth()->user()->can('orders-rollback'))
                                            <th>rollback</th>
                                            @endif

                                        @if(auth()->user()->hasAnyPermission(['order-delete','order-edit']))    <th>{{ __('admin.controls') }}</th>
                                          @endif   

                                          {{--   @if(Auth()->user()->hasAnyPermission(['order-date', 'order-status', 'order-address','order-driver']) || auth()->user()->hasRole(['admin','delivery-manager']))
                                            @endif --}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td><a  href="{{route('order_details',$order->id)}}">{{$order->id}}</a></td>

                                                 <td>{{ $order->user->name ?? 'not assign'}}</td>

                                                <td>

                                                    <?php $status = ['new' => 0,'approved' => 1,'prepared' => 2,'shipping' => 3,'shipped' => 4,'received' => 6,'approved-rollback' => 7,'prepared-rollback' => 8 , 'shipping-rollback' => 9 , 'shipped-rollback' => 10];?>

                                                    @foreach ($status as $index => $state)

                                                            @if($order->status == $state )

                                                                <h5>{{$index}}</h5>

                                                            @endif
                                                   
                                                        @endforeach
                                                        


                                                </td>

                                                  @if(auth()->user()->can('orders-cancel'))
                                                <td>

                                                    @if($order->status >= $setting->cancellation || auth()->user()->hasRole('driver'))

                                                        <button type="button" data-toggle="modal" data-target="#my-modal-{{ $order->id }}"  disabled value="{{$order->id}}" class="btn btn-danger">cancel</button>

                                                    @else
                                                        <button type="button" data-toggle="modal" data-target="#my-modal-{{ $order->id }}" value="{{$order->id}}" class="btn btn-danger">cancel</button>
                                                    @endif

                                                </td>

                                                @endif
                                             @if(auth()->user()->can('orders-rollback'))
                                                <td>

                                                    @if(in_array($order->status,[1,2,3,4,6]) )

                                                        <button type="button" data-toggle="modal" data-target="#my-rollback-{{ $order->id }}" value="{{$order->id}}" class="btn btn-info">rollback</button>

                                                    @else
                                                        <button type="button" data-toggle="modal" data-target="#my-rollback-{{ $order->id }}" disabled value="{{$order->id}}" class="btn btn-info">rollback</button>
                                                    @endif

                                                </td>
                                             @endif   
                                               {{--  @if(Auth()->user()->hasAnyPermission(['order-date', 'order-status', 'order-address','order-driver']) || auth()->user()->hasRole(['admin','delivery-manager'])) --}}
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                <form action="{{ route('orders.delete', $order->id) }}" method="post">
                                                                    @csrf
                                                                    @method('delete')

                                                                    {{-- @if(Auth()->user()->hasAnyPermission(['order-date', 'order-status', 'order-address','order-driver'])) --}}
                                                                    {{-- @endif --}}


                                                                   {{--  @if(auth()->user()->hasRole(['admin','delivery-manager'])) --}}
                                                                        <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this order?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                                    {{-- @endif --}}
                                                            </form>
                                                              @if(auth()->user()->can('orders-assign'))
                                                                
                                                                    <a class="dropdown-item" href="{{ route('orders.assign', $order->id) }}">assign to</a>
                                                              @endif      
                                                          @if(auth()->user()->can('order-edit'))
                                                                        <a class="dropdown-item" href="{{ route('orders.edit', $order->id) }}">{{ __('edit') }}</a>
                                                          @endif              

                                                            </div>
                                                        </div>
                                                    </td>
                                                {{-- @endif --}}
                                            </tr>

                                            <div class="modal fade" id="my-modal-{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Cancel Order</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('orders.cancel','cancel') }}" method="POST">

                                                                @csrf

                                                                <div class="card-body">

                                                                    <input type="hidden" value="{{$order->id}}" name="order_id">

                                                                    <div class="form-group">
                                                                        <label>Cancellation Reason</label>
                                                                        <select class=" @error('reason_id') is-invalid @enderror select2"  name="reason_id" data-placeholder="Select a State" style="width: 100%;" required>

                                                                            @foreach(\App\Models\Reason::where('status','active')->get() as $reason)

                                                                                <option value="{{ $reason->id }}">{{ $reason->arab_reason }}</option>

                                                                            @endforeach

                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Notes</label>
                                                                        <textarea class=" @error('notes') is-invalid @enderror form-control" name="notes" rows="3" placeholder="Enter ..."></textarea>

                                                                        @error('notes')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="card-footer">
                                                                    <button type="submit"  class="btn btn-primary">cancel order</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="modal fade" id="my-rollback-{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Rollback Order</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('orders.cancel','rollback') }}" method="POST">

                                                                @csrf

                                                                <div class="card-body">

                                                                    <input type="hidden" value="{{$order->id}}" name="order_id">

                                                                    <div class="form-group">
                                                                        <label>Rollback Reason</label>
                                                                        <select class=" @error('reason_id') is-invalid @enderror select2"  name="reason_id" data-placeholder="Select a State" style="width: 100%;" required>

                                                                            @foreach(\App\Models\Reason::where('status','active')->get() as $reason)

                                                                                <option value="{{ $reason->id }}">{{ $reason->arab_reason }}</option>

                                                                            @endforeach

                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Notes</label>
                                                                        <textarea class=" @error('notes') is-invalid @enderror form-control" name="notes" rows="3" placeholder="Enter ..."></textarea>

                                                                        @error('notes')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="card-footer">
                                                                    <button type="submit"  class="btn btn-primary">rollback order</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            @endif
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


