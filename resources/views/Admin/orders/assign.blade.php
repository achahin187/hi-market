
  @extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Orders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('orders.index')}}">Orders</a></li>
                            <li class="breadcrumb-item active">Orders</li>
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

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->

                            <div class="card-body">


                                <!--second card-->
                                 @if(Auth()->user()->hasRole(['admin', 'delivery', 'driver' ,'delivery-manager']))
                                    <div class="card card-primary">

                                        <div class="card-header">
                                            edit order details
                                        </div>

                                        <form role="form" action="{{route('orders.update',$order->id) }} " method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')


                                            <div class="card-body">


                                                @if(Auth()->user()->hasRole(['admin','delivery-manager', 'delivery','driver']))

                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="@error('status') is-invalid @enderror select2" name="status" data-placeholder="Select a State" style="width: 100%;" required>


                                                        <option value="0" <?php if($order->status == '0') echo 'selected'; ?>>new</option>
                                                        <option value="1" <?php if($order->status == '1') echo 'selected'; ?>>approved</option>
                                                        <option value="2" <?php if($order->status == '2') echo 'selected'; ?>>prepared</option>
                                                        <option value="3" <?php if($order->status == '3') echo 'selected'; ?>>shipping</option>
                                                        <option value="4" <?php if($order->status == '4') echo 'selected'; ?>>shipped</option>
                                                        <option value="7" <?php if($order->status == '7') echo 'selected'; ?>>received</option>


                                                    </select>

                                                    @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                @endif

                                                @if(Auth()->user()->hasRole(['admin','delivery-manager', 'delivery']))
                                                <div class="form-group">
                                                    <label>assign driver</label>
                                                  <select class="@error('driver') is-invalid @enderror select2" name="driver" data-placeholder="Select a State" style="width: 100%;" required>

                                                        @if($order->user != null)
                                                            @foreach(\App\User::role(['delivery'])->where('manager',0)->get() as $driver)

                                                                <option <?php if($order->user->id == $driver->id) echo 'selected'; ?> value="{{ $driver->id }}">

                                                                        {{ $driver->name }}

                                                                </option>

                                                            @endforeach
                                                        @else
                                                            @foreach(\App\User::role('delivery')->where('manager',0)->get() as $driver)

                                                                <option value="{{ $driver->id }}">


                                                                        {{ $driver->name }}


                                                                </option>

                                                            @endforeach

                                                        @endif


                                                    </select>

                                                    @error('driver')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                @endif

                                                 @if(Auth()->user()->hasRole(['admin','delivery-manager', 'delivery', 'driver']))
                                                <div class="form-group">
                                                    <label>{{__('order_address')}}</label>
                                                    <textarea class=" @error('address') is-invalid @enderror form-control" name="address" rows="3" placeholder="Enter ...">

                                                                {{$order->address }}
                                                        </textarea>
                                                    @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                    @enderror
                                                </div>
                                                @endif


                                                @if(Auth()->user()->hasRole(['admin','delivery-manager', 'delivery', 'driver']))
                                                <div class="form-group">
                                                    <label>delivery_date</label>
                                                    <input type="datetime-local" class=" @error('delivery_date') is-invalid @enderror form-control"  @if(isset($order)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($order->delivery_date)) }}" @endif name="delivery_date" data-placeholder="Select a expiration date" style="width: 100%;" required>

                                                    @error('delivery_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                @endif


                                                @if(Auth()->user()->hasRole(['admin', 'delivery-manager', 'delivery']))
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                 @endif   






                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </section>

       


    @endsection




