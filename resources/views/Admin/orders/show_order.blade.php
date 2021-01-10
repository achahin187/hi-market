@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.order_details') }}</h1>
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
                                <h3 class="card-title">{{ __('admin.order_details') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                               <!-- Image Field -->
                                <div class="form-group">
                                  <label>Order num</label>
                                  <p>{{ $order->num }}</p>
                                </div>


                                <div class="form-group">
                                  <label>Products </label>
                                  @php
                                   $products = DB::table('order_product')->where('order_id', $order->id)->get();

                                  @endphp
                              @foreach( $products as $product)
                            
                                  <p>{{ \App\Models\Product::Where('id', $product->product_id)->first()->name }} <span style="color: red;font-weight: bold;"> Quantity :</span> {{ $product->quantity }} <span style="color: red; font-weight: bold;"> price : </span> {{ $product->price}} </p>
                              @endforeach
                                </div> 


                                <div class="form-group">
                                  <label>Status</label>
                                   <?php $status = 
                                      [
                                       'new'      => 0,
                                       'approved' => 1,
                                       'prepared' => 2,
                                       'shipping' => 3,
                                       'deliverd' => 4,
                                       'received' => 5,
                                       'Canceled' => 6,
                                      ];?>

                           @foreach ($status as $index => $state)

                                @if($order->status == $state )

                                    <p>{{ $index }}</p>

                                @endif
                       
                            @endforeach
                                </div>


                                <div class="form-group">
                                  <label>Client Name</label>
                                  <p>{{ $order->client->name }}</p>
                                </div>

                               <div class="form-group">
                                  <label>Client Address</label>
                                  <p>{{ $order->address }}</p>
                               </div>

                               <div class="form-group">
                                  <label>Client Phone</label>
                                  <p>{{ $order->phone }}</p>
                               </div>

                                <div class="form-group">
                                  <label>company Name</label>
                                  <p>{{ $order->companies->name ??'' }}</p>
                                </div>


                                <div class="form-group">
                                  <label>Branch</label>
                                  <p>{{ $order->branch->name }}</p>
                                </div>
                                
                              @if($order->point_redeem)
                                <div class="form-group">
                                  <label>Point Redeem</label>
                                  <p>{{ $order->point_redeem  }}</p>
                                </div> 
                              @endif  

                              @if($order->promocode)
                                <div class="form-group">
                                  <label>Promocode</label>
                                  <p>{{ $order->promocode  }}</p>
                                </div>
                             @endif   

                               
                                {{-- total_before --}}
                                <div class="form-group">
                                  <label>Total Money</label>
                                  <p>{{ $order->total_before  }}</p>
                                   @php
                                    $FinalOrder =  $order->total_before ;
                                  @endphp
                                </div>

                                {{-- total_money --}}
                               @if( $order->total_before != $order->total_money  )
                                <div class="form-group">
                                  <label>Total Money</label>
                                  <p> <span style="color: green;  font-weight: bold;">After Disount</span>  {{ $order->total_money }}</p>
                                  @php
                                    $FinalOrder =  $order->total_money ;
                                  @endphp
                                </div>

                               @endif

                               {{-- shipping_fee --}}
                              @if( $order->shipping_fee == 0)
                                 <div class="form-group">
                                  <label>Shipping Fee</label>
                                  <p> <span style="color: green;  font-weight: bold;">Free Shipping</span> {{ $order->shipping_fee }}</p>
                                  @php
                                    $Final = 0;
                                  @endphp
                                  
                                </div> 

                              {{-- Shipping Fee --}}
                               @elseif( $order->shipping_fee != $order->shipping_before)
                                 <div class="form-group">
                                  <label>Shipping Fee</label>
                                  <p>  <span style="color: green;  font-weight: bold;">After Dicount</span> {{ $order->shipping_fee }}</p>
                                   @php
                                    $Final = $order->shipping_fee;
                                  @endphp
                                  
                                   
                                </div> 

                              @else

                               <div class="form-group">
                                  <label>Shipping Fee</label>
                                  <p>{{ $order->shipping_before }}</p>

                                   @php
                                    $Final = $order->shipping_before;
                                  @endphp
                                   
                                </div> 
                              @endif  

                                <div class="form-group">
                                  <label>Final Total Money</label>
                                  <p> {{ $Final + $FinalOrder}}</p>
                                   
                                </div> 


                                @if($order->rate)
                                <div class="form-group">
                                  <label>Rate</label>
                                  <p>{{ $order->rate }}</p>
                                </div>
                                @endif

                              @if($order->delivery_rate)
                                <div class="form-group">
                                  <label>Delivery Rate</label>
                                  <p>{{ $order->delivery_rate }}</p>
                                </div> 
                              @endif

                              @if($order->seller_rate)
                                <div class="form-group">
                                  <label>Seller Rate</label>
                                  <p>{{ $order->seller_rate }}</p>
                                </div>
                              @endif

                              @if($order->pickup_rate)
                                <div class="form-group">
                                  <label>PickUp Rate</label>
                                  <p>{{ $order->pickup_rate }}</p>
                                </div>
                              @endif
                                
                              @if($order->time_rate)
                                <div class="form-group">
                                  <label>Time Rate</label>
                                  <p>{{ $order->time_rate }}</p>
                                </div>
                              @endif
                                
                              @if($order->comment)
                                <div class="form-group">
                                  <label>Comment</label>
                                  <p>{{ $order->comment }}</p>
                                </div>
                              @endif  
                               @if($order->comment)
                                <div class="form-group">
                                  <label>Delivery Date</label>
                                  <p>{{ $order->delivery_date }}</p>
                                </div>
                                @endif
                             
                           
                           



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

