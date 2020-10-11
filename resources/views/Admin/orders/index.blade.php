@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
                    </div>
                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('orders.index')}}">Orders</a></li>
                            <li class="breadcrumb-item"><a href="{{route('orders.index',true)}}">CancelledOrders</a></li>
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

                                    Cancelled Orders

                                @else

                                    Orders

                                @endif
                            </div>
                            <!-- /.card-header -->
                        @if(isset($cancelledorders))
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>address</th>
                                        <th>order details</th>
                                        <th>status</th>
                                        <th>controls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cancelledorders as $order)
                                        <tr>
                                            <td>{{$order->address}}</td>
                                            <td><a class="btn btn-info" href="{{route('order_details',$order->id)}}">order details</a></td>
                                            <td>
                                                <button type="button" disabled class="btn btn-block btn-outline-danger">cancelled</button>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('orders.delete', $order->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                            <a class="dropdown-item" href="{{ route('orders.edit', $order->id) }}">{{ __('edit') }}</a>
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this order?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>
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
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>address</th>
                                            <th>order details</th>
                                            <th>status</th>
                                            <th>cancel</th>
                                            <th>reject</th>
                                            <th>controls</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>{{$order->address}}</td>
                                                <td><a class="btn btn-info" href="{{route('order_details',$order->id)}}">order details</a></td>

                                                <td>

                                                    @if($order->status == '0' )

                                                        <button type="button" data-toggle="modal"   value="{{$order->id}}" class="btn btn-block btn-outline-danger">new</button>

                                                    @elseif($order->status == '1' )

                                                        <button type="button" data-toggle="modal"  value="{{$order->id}}" class="btn btn-block btn-outline-danger cancel">approved</button>

                                                    @elseif($order->status == '2' )

                                                        <button type="button" data-toggle="modal"   value="{{$order->id}}" class="btn btn-block btn-outline-danger cancel">prepared</button>

                                                    @elseif($order->status == '3' )

                                                        <button type="button" data-toggle="modal"   value="{{$order->id}}" class="btn btn-block btn-outline-danger cancel">shipping</button>

                                                    @elseif($order->status == '4' )

                                                        <button type="button" data-toggle="modal"  value="{{$order->id}}" class="btn btn-block btn-outline-danger cancel">shipped</button>

                                                    @elseif($order->status == '6' )

                                                        <button type="button" data-toggle="modal"  value="{{$order->id}}" class="btn btn-block btn-outline-danger cancel">rejected</button>

                                                    @else

                                                        <button type="button" data-toggle="modal"   value="{{$order->id}}" class="btn btn-block btn-outline-danger cancel">received</button>


                                                    @endif


                                                </td>


                                                <td>

                                                    @if($order->status < $setting->cancellation)

                                                        <button type="button" data-toggle="modal" data-target="#my-modal-{{ $order->id }}"  value="{{$order->id}}" class="btn btn-block btn-outline-danger">cancel</button>

                                                    @else
                                                        <button type="button" data-toggle="modal" data-target="#my-modal-{{ $order->id }}"  disabled value="{{$order->id}}" class="btn btn-block btn-outline-danger">cancel</button>
                                                    @endif

                                                </td>
                                                <td>

                                                    @if($order->status == 6)

                                                        <button type="button" data-toggle="modal" data-target="#my-reject-{{ $order->id }}" value="{{$order->id}}" disabled class="btn btn-block btn-outline-danger">reject</button>

                                                    @else

                                                        <button type="button" data-toggle="modal" data-target="#my-reject-{{ $order->id }}" value="{{$order->id}}" class="btn btn-block btn-outline-danger">reject</button>

                                                    @endif

                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                            <form action="{{ route('orders.delete', $order->id) }}" method="post">
                                                                @csrf
                                                                @method('delete')

                                                                <a class="dropdown-item" href="{{ route('orders.edit', $order->id) }}">{{ __('edit') }}</a>
                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this order?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </td>
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


                                            <div class="modal fade" id="my-reject-{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">reject Order</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('orders.cancel','reject') }}" method="POST">

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
                                                                    <button type="submit"  class="btn btn-primary">reject order</button>
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


