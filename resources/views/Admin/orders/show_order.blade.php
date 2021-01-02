@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.client') }}</h1>
                    </div>

                    @if(auth()->user()->can('client-create'))
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('clients.create')}}">{{ __('admin.add_client') }}</a></li>
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
                                <h3 class="card-title">{{ __('admin.client') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                               <!-- Image Field -->
                                <div class="form-group">
                                  <label>num</label>
                                  <p>{{ $order->num }}</p>
                                </div>

                                <div class="form-group">
                                  <label>Status</label>
                                   <?php $status = 
                                     [
                                       'new' => 0,
                                       'approved' => 1,
                                       'prepared' => 2,
                                       'shipping' => 3,
                                       'deliverd' => 4,
                                       'received' => 5,
                                        ];?>

                           @foreach ($status as $index => $state)

                                @if($order->status == $state )

                                              <p>{{ $index }}</p>

                                @endif
                       
                            @endforeach
                                </div>


                                <div class="form-group">
                                  <label>Client Name</label>
                                  <p>{{ $order->client->name_en }}</p>
                                </div>

                                <div class="form-group">
                                  <label>company Name</label>
                                  <p>{{ $order->companies->name_en }}</p>
                                </div>

                                <div class="form-group">
                                  <label>Rate</label>
                                  <p>{{ $order->rate }}</p>
                                </div>

                                <div class="form-group">
                                  <label>Delivery Rate</label>
                                  <p>{{ $order->delivery_rate }}</p>
                                </div>

                                 <div class="form-group">
                                  <label>Delivery Date</label>
                                  <p>{{ $order->delivery_date }}</p>
                                </div>

                                 <div class="form-group">
                                  <label>Delivery Client Review</label>
                                  <p>{{ $order->client_review }}</p>
                                </div>

                                <div class="form-group">
                                  <label>Total Money</label>
                                  <p>{{ $order->total_money }}</p>
                                </div>

                                <div class="form-group">
                                  <label>Total Money Befor</label>
                                  <p>{{ $order->total_before }}</p>
                                </div>

                                 <div class="form-group">
                                  <label>Shipping Fee</label>
                                  <p>{{ $order->shipping_fee }}</p>
                                </div> 

                                <div class="form-group">
                                  <label>Shipping Fee before</label>
                                  <p>{{ $order->shipping_before }}</p>
                                </div>

                                <div class="form-group">
                                  <label>Branch</label>
                                  <p>{{ $order->branch->name }}</p>
                                </div>



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

