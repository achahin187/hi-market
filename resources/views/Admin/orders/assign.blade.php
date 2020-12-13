
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

                                    <div class="card card-primary">

                                        <div class="card-header">
                                            Assign Order
                                        </div>

            <form role="form" action="{{route('orders.update',$order->id) }} " method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')


                                            <div class="card-body">

                                    
                                                <div class="form-group">
                                                    <label>assign driver</label>
                                                  <select class="@error('driver') is-invalid @enderror select2" name="driver" data-placeholder="Select a State" style="width: 100%;" required>
     
                                                            @foreach(\App\User::role(['driver'])->get() as $driver)

                                                                <option <?php if($order->user->id == $driver->id) echo 'selected'; ?> value="{{ $driver->id }}">

                                                                        {{ $driver->name }}

                                                                </option>
                                                            @endforeach

                                                    </select>
                                                    @error('driver')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                @if(Auth()->user()->hasRole(['super_admin', 'delivery-admin']))
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                              






                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </section>

       


    @endsection




