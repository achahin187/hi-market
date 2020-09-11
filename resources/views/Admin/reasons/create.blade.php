@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>General Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('reasons.index')}}">Reasons</a></li>
                            <li class="breadcrumb-item active">Reason Form</li>
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

                                @if(isset($reason))

                                    edit reason

                                @else

                                    create reason

                                @endif
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="@if(isset($reason)){{route('reasons.update',$reason->id) }} @else {{route('reasons.store') }} @endif" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if(isset($reason))

                                @method('PUT')

                            @endif

                            <div class="card-body">

                                <div class="form-group">
                                    <label>{{__('admin.arab_reason')}}</label>
                                    <textarea class=" @error('arab_reason') is-invalid @enderror form-control" name="arab_reason" rows="3" placeholder="Enter ...">

                                        @if(isset($reason))
                                            {{$reason->arab_reason }}
                                        @endif
                                    </textarea>
                                    @error('arab_reason')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{__('admin.eng_reason')}}</label>
                                    <textarea class=" @error('eng_reason') is-invalid @enderror form-control" name="eng_reason" rows="3" placeholder="Enter ...">

                                        @if(isset($reason))
                                            {{$reason->eng_reason }}
                                        @endif
                                    </textarea>
                                    @error('eng_reason')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>reason status</label>
                                    <select class=" @error('status') is-invalid @enderror select2"  name="status" data-placeholder="Select a State" style="width: 100%;" required>

                                        @if(isset($reason))

                                            <option  <?php if($reason->status == 'active') echo 'selected'; ?> value="active">active</option>
                                            <option <?php if($reason->status == 'inactive') echo 'selected'; ?> value="inactive">inactive</option>

                                        @else

                                            <option value="active">active</option>
                                            <option value="inactive">inactive</option>

                                        @endif

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


