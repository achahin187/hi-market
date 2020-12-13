@extends('layouts.admin_layout')
@section("heading")
    @lang('models/financials.plural')
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                            @if(isset($supermarket_id))
                                <li class="breadcrumb-item"><a
                                        href="{{route('offers.create',$supermarket_id)}}">{{__('admin.add_supermarket_offer')}}</a>
                                </li>
                            @elseif(isset($branch_id))
                                <li class="breadcrumb-item"><a
                                        href="{{route('offers.create',['supermarket_id' => -1 , 'branch_id' => $branch_id])}}">{{__('admin.add_branch_offer')}}</a>
                                </li>
                            @else
                                <li class="breadcrumb-item"><a
                                        href="{{route('offers.create')}}">{{__('admin.add_offer')}}</a></li>
                            @endif
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
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('admin.financials')}}</h3>
                            </div>

                            {!! Form::open(["route"=>"financials.index","method"=>"get"]) !!}

                            <div class="form-group col-md-3">
                                {!! Form::label("name",__("models/resturants.fields.name")) !!}
                                {!! Form::text("name",request("name")) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label("status",__("models/resturants.fields.status")) !!}
                                {!! Form::select("status",[],request("status")) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label("created_at",__("models/resturants.fields.created_at")) !!}
                                {!! Form::date("created_at",request("created_at")) !!}
                            </div>

                            <div class="form-group col-md-3">
                                {!! Form::submit("Search") !!}
                            </div>
                            {!! Form::close() !!}
                            <section class="content-header">

                                <h1 class="pull-right">
                                    <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px"
                                       href="{{ route('financials.create') }}">@lang('crud.add_new')</a>
                                </h1>
                            </section>
                            <div class="content">
                                <div class="clearfix"></div>

                                @include('flash::message')

                                <div class="clearfix"></div>
                                <div class="box box-primary">
                                    <div class="box-header"><h3>Financial</h3></div>
                                    <div class="box-body">
                                        @include('Admin.financials.table')
                                    </div>
                                </div>
                                <div class="text-center">


                                </div>
                            </div>
                            <div class="content">
                                <div class="clearfix"></div>

                                @include('flash::message')

                                <div class="clearfix"></div>
                                <div class="box box-primary">
                                    <div class="box-header"><h3>Receivable</h3></div>
                                    <div class="box-body">
                                        @include('Admin.receivables.table')
                                    </div>
                                </div>
                                <div class="text-center">


                                </div>
                            </div>
                            <div class="content">
                                <div class="clearfix"></div>

                                @include('flash::message')

                                <div class="clearfix"></div>
                                <div class="box box-primary">
                                    <div class="box-header"><h3>Payable</h3></div>
                                    <div class="box-body">
                                        @include('Admin.payables.table')
                                    </div>
                                </div>
                                <div class="text-center">

                                    @include('adminlte-templates::common.paginate', ['records' => $payables])

                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>


@endsection

