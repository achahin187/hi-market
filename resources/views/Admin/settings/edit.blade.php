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
                                        <label>{{ __('admin.tax') }}</label>
                                        <select class=" @error('tax') is-invalid @enderror select2"  name="tax" data-placeholder="Select a State" style="width: 100%;" required>

                                                <option <?php if($setting->tax == 1) echo 'selected'; ?> value="1">{{ __('admin.percentage') }}</option>
                                                <option <?php if($setting->tax == 0) echo 'selected'; ?> value="0">{{ __('admin.value') }}</option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('admin.tax_value')}}</label>
                                        <input type="number" min="0" step="0.01" name="tax_value" value="{{$setting->tax_value}}" class=" @error('tax_value') is-invalid @enderror form-control" >
                                        @error('tax_value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('admin.tax_on_product') }}</label>
                                        <select class=" @error('tax_on_product') is-invalid @enderror select2"  name="tax_on_product" data-placeholder="Select a State" style="width: 100%;" required>

                                                <option <?php if($setting->tax_on_product == 1) echo 'selected'; ?> value="1">
                                                    {{ __('admin.product_price_contain_tax') }}
                                                </option>
                                                <option <?php if($setting->tax_on_product == 0) echo 'selected'; ?> value="0">
                                                       {{ __('admin.product_price_doesnt_contain_tax') }}
                                                </option>
                                        </select>
                                    </div>

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

                                    @if($setting->splash != null)

                                        <div class="form-group">
                                            <label for="exampleInputFile">{{__('admin.image')  }}</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                    <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('splash') }}/{{$setting->splash}}" class="card-img-top" alt="Course Photo">

                                                    <input type="checkbox" checked style="margin-right:10px;" name="checkedimage" value="{{$setting->splash}}">

                                                    <input name="splash" type="file">

                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else

                                        <div class="form-group">
                                            <label for="exampleInputFile">{{__('admin.image')  }}</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="splash" type="file" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>


                                    @endif

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




