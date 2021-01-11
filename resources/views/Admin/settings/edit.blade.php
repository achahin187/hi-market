@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.setting') }}</h1>
                        @include('includes.errors')
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item active">{{ __('admin.setting') }}</li>
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
                            <div class="card-header">
                                <h3 class="card-title">

                                   {{ __('admin.order_setting') }}
                                </h3>

                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{route('settings.update',$setting->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')


                                <div class="card-body">
                                   

                                    <div class="form-group">
                                        <label>{{ __('admin.delivery_money') }}</label>
                                        <input type="number" min="0" step="0.01" name="delivery" value="{{$setting->delivery}}" class=" @error('delivery') is-invalid @enderror form-control" >
                                        @error('delivery')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                     <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('admin.redeem_point')}}</label>
                                        <input type="text"  name="reedem_point" value="{{$setting->reedem_point}}" class=" @error('reedem_point') is-invalid @enderror form-control" >
                                        @error('reedem_point')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


{{-- 
                                    <div class="form-group">
                                        <label>{{ __('admin.Cancellation_disabled_when_order') }}</label>
                                        <select class=" @error('tax') is-invalid @enderror select2"  name="cancellation" data-placeholder="Select a State" style="width: 100%;" required>

                                            <option <?php if($setting->cancellation == 0) echo 'selected'; ?> value="0">new</option>
                                            <option <?php if($setting->cancellation == 1) echo 'selected'; ?> value="1">approved</option>
                                            <option <?php if($setting->cancellation == 2) echo 'selected'; ?> value="2">prepared</option>
                                            <option <?php if($setting->cancellation == 3) echo 'selected'; ?> value="3">shipping</option>
                                            <option <?php if($setting->cancellation == 4) echo 'selected'; ?> value="4">shipped</option>
                                            <option <?php if($setting->cancellation == 6) echo 'selected'; ?> value="6">received</option>

                                        </select>
                                    </div>
 --}}
                                   
                                </div>


                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">{{ __('admin.edit') }}</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection




