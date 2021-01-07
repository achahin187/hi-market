@extends('layouts.admin_layout')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>General Form</h1>
                        @include('includes.errors')
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('notifications.index')}}">Notifications</a></li>
                            <li class="breadcrumb-item active">General Form</li>
                        </ol>
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
                            <div class="card-header">
                                <h3 class="card-title">

                                    @if(isset($offer))
                                        resend notification
                                    @else
                                        create notification

                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="@if(isset($offer)){{route('offers.update',$offer->id) }} @else {{route('offers.store') }} @endif" method="POST">
                                @csrf

                                @if(isset($offer))

                                    @method('PUT')

                                @endif

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('offer.product_arabname')}}</label>
                                            <input type="text" value="@if(isset($product)){{$product->arab_name }} @endif" name="arab_name" class=" @error('arab_name') is-invalid @enderror form-control" required>
                                            @error('arab_name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('offer.product_engname')}}</label>
                                            <input type="text" name="eng_name" value="@if(isset($product)){{$product->eng_name }} @endif" class=" @error('eng_name') is-invalid @enderror form-control" required>
                                            @error('eng_name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    <div class="form-group">
                                        <label>{{__('offer.arab_description')}}</label>
                                        <textarea class=" @error('arab_description') is-invalid @enderror form-control" name="arab_description" rows="3" placeholder="Enter ...">

                                            @if(isset($offer))
                                                {{$offer->arab_description }}
                                            @endif
                                        </textarea>
                                        @error('arab_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('offer.eng_description')}}</label>
                                        <textarea class=" @error('eng_description') is-invalid @enderror form-control" name="eng_description" rows="3" placeholder="Enter ...">

                                            @if(isset($offer))
                                                {{$offer->eng_description }}
                                            @endif
                                        </textarea>
                                        @error('eng_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                        <div class="form-group">
                                            <label>offer supermarket </label>
                                            <select class=" @error('supermarket_id') is-invalid @enderror select2" name="supermarket_id" data-placeholder="Select a State" style="width: 100%;" required>
                                                @if(isset($offer))
                                                    @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                        <option <?php if($offer->supermarket->id == $supermarket->id) echo 'selected'; ?> value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                                    @endforeach
                                                @else
                                                    @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                        <option value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                                    @endforeach

                                                @endif
                                            </select>
                                        </div>


                                    @if(!isset($offer))


                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="@error('status') is-invalid @enderror select2" name="status" data-placeholder="Select offer status" style="width: 100%;" required>

                                                <option value="active">active</option>
                                                <option value="inactive">inactive</option>

                                            </select>

                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                    @endif

                                        <div class="form-group">
                                            <label>offer Type </label>
                                            <select class=" @error('offer_type') is-invalid @enderror select2" name="offer_type" data-placeholder="Select a State" style="width: 100%;" required @if(isset($offer) && $offer->offer_type == 'promocode') disabled @endif>

                                                @if(isset($offer))

                                                    <option <?php if($offer->offer_type == "navigable") echo 'selected'; ?> value="navigable">navigable</option>
                                                    <option <?php if($offer->offer_type == "promocode") echo 'selected'; ?> value="promocode">promocode</option>

                                                @else

                                                    <option value="promocode">promocode</option>
                                                    <option value="navigable">navigable</option>

                                                @endif
                                            </select>
                                        </div>


                                    <div class="form-group">
                                        <label>Value Type </label>
                                        <select class=" @error('value_type') is-invalid @enderror select2" name="value_type" data-placeholder="Select a State" style="width: 100%;" required>

                                            @if(isset($offer))

                                                <option <?php if($offer->value_type == "discount by value") echo 'selected'; ?> value="discount by value">discount by value</option>
                                                <option <?php if($offer->value_type == "discount by percentage") echo 'selected'; ?> value="discount by percentage">discount by percentage</option>
                                                <option <?php if($offer->value_type == "free product") echo 'selected'; ?> value="free product">free product</option>
                                                <option <?php if($offer->value_type == "free delivery") echo 'selected'; ?> value="free delivery">free delivery</option>

                                            @else

                                                <option value="discount by value">discount by value</option>
                                                <option value="discount by percentage">discount by percentage</option>
                                                <option value="free product">free product</option>
                                                <option value="free delivery">free delivery</option>

                                            @endif
                                        </select>
                                    </div>



                                    <div class="form-group">
                                        <label>start_date</label>
                                        <input type="date" class=" @error('start_date') is-invalid @enderror form-control" id="start" name="start_date" @if(isset($offer)) value="{{$offer->start_date}}" @endif data-placeholder="Select a offer start_date" style="width: 100%;" required>

                                        @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>end_date</label>
                                        <input type="date" class=" @error('end_date') is-invalid @enderror form-control"  name="end_date" @if(isset($offer)) value="{{$offer->end_date}}" @endif data-placeholder="Select a offer end_date" style="width: 100%;" required>

                                        @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection


