@extends('layouts.app')
@section('heading')
@lang('models/financials.singular')
@endsection
@section('content')

    <div class="content">
        @include('adminlte-templates::common.errors')
            <div class="col-sm-12 col-xs-12">
                       <div class="form-wrap">

                    {!! Form::open(['route' => 'financials.store']) !!}

                        @include('financials.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
