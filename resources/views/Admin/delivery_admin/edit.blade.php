@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>edit </h1>
                        @include('includes.errors')
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('delivery-admins.index')}}">delivery admin</a></li>
                            <li class="breadcrumb-item active">edit </li>
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

                                    
                                        edit delivery

                                    
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{route('delivery-admins.update',$delivery->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                            
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.name')}}</label>
                                        <input type="text" value="{{$delivery->name }}" name="name" class=" @error('name') is-invalid @enderror form-control" required>

                                        @error('name')

                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.email')}}</label>
                                        <input type="text" name="email" value="{{$delivery->email }} " class=" @error('email') is-invalid @enderror form-control" required>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                     <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('admin.password')}}</label>
                                        <input type="password" name="password"  class=" @error('password') is-invalid @enderror form-control" >

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>



                                       
                                <div class="form-group">
                                    <label>{{__('admin.company')}} </label>
                                    <select id="company" class=" @error('company_id') is-invalid @enderror select2" name="company_id" data-placeholder="Select a State" style="width: 100%;" required>
                                      

                                            @foreach(\App\Models\DeliveryCompany::all() as $companies)

<option value="{{ $companies->id }}" {{ $companies->id == $delivery->company_id ?'selected' :'' }} >{{ $companies->name }}</option>

                                            @endforeach

                                 
                                    </select>
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



