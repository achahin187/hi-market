@extends('layouts.app')
@section("heading")
 @lang('models/receivables.plural')
@endsection
@section('content')
    <section class="content-header">

        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('receivables.create') }}">@lang('crud.add_new')</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('receivables.table')
            </div>
        </div>
        <div class="text-center">
        
        @include('adminlte-templates::common.paginate', ['records' => $receivables])

        </div>
    </div>
@endsection

