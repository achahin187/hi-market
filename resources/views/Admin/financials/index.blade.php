@extends('layouts.app')
@section("heading")
    @lang('models/financials.plural')
@endsection
@section('content')

    {!! Form::open(["route"=>"financials.index","method"=>"get"]) !!}

    <div class="form-group col-md-3">
        {!! Form::label("name",__("models/resturants.fields.name")) !!}
        {!! Form::text("name",request("name")) !!}
    </div>
    <div class="form-group col-md-3">
        {!! Form::label("status",__("models/resturants.fields.status")) !!}
        {!! Form::select("status",__("models/resturants.fields.status_options"),request("status")) !!}
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
                @include('financials.table')
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
                @include('receivables.table')
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
                @include('payables.table')
            </div>
        </div>
        <div class="text-center">

            @include('adminlte-templates::common.paginate', ['records' => $payables])

        </div>
    </div>
@endsection

