@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.add') }}</h1>
                        @include('includes.errors')
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
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{route('delivery-companies.index')}}">{{ __('admin.delivery_companies') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('admin.add') }}</li>
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

                                    {{ __('admin.add_delivery_company') }}


                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action=" {{route('delivery-companies.store') }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf


                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name Ar</label>
                                        <input type="text" value="{{old("name_ar")}}" name="name_ar"
                                               class=" @error('name_ar') is-invalid @enderror form-control" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name En</label>
                                        <input type="text" value="{{old("name_en")}}" name="name_en"
                                               class=" @error('name_en') is-invalid @enderror form-control" required>
                                        @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.email') }}</label>
                                        <input type="email" value="{{old("email")}}" name="email"
                                               class="@error('email') is-invalid @enderror form-control"
                                               id="exampleInputEmail1" placeholder="Enter email" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{--
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input id="phone_number" name="phone_number" value="{{old("phone_number")}}" class="form-control" type="text">
                                    </div> --}}

                                    @for ($i = 0; $i < 2; $i++)
                                        <div class="form-group">
                                            <label>@lang('admin.phone')</label>
                                            <input type="text" id='phone_number' name="phone_number[]"
                                                   class="form-control" value="{{old("phone_number")}}">
                                        </div>
                                    @endfor
                                    <div class="form-group">
                                        <label for="commission">Commission</label>
                                        <input id="commission" name="commission" value="{{old("commission")}}"
                                               type="number" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="branch">Branch</label>
                                        <select name="branch_id[]" id="branch" multiple class="form-control">
                                            @foreach($branches as $branch)
                                                <option @if(old("branch_id") == $branch->id) selected
                                                        @endif value="{{$branch->id}}">{{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{__('admin.city')}} </label>
                                        <select id="city" class=" @error('city_id') is-invalid @enderror select2"
                                                name="city_id" data-placeholder="Select a State" style="width: 100%;"
                                                required>


                                            @foreach(\App\Models\City::all() as $cities)

                                                <option value="{{ $cities->id }}">{{ $cities->name_ar }}</option>

                                            @endforeach


                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>{{ __('admin.status') }}</label>

                                        <select class=" @error('status') is-invalid @enderror select2" name="status"
                                                data-placeholder="Select a State" style="width: 100%;" required>
                                            @php
                                                $statuses = [
                                                 '0'=>trans('active'),
                                                  '1'=>trans('inactive')
                                              ];
                                            @endphp
                                            @foreach($statuses  as $index=>$status)
                                                <option value={{ $index }}>
                                                    {{ $status }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group">

                                        <label for="status">Auto Approve</label>

                                        <input style="margin-left: 10px " id="status" value="{{old("status") ?? 1}}"
                                               type="checkbox" name="status">

                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


@endsection


