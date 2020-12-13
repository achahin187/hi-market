@extends('layouts.app')
@section('heading')
@lang('models/payables.singular')
@endsection
@section('content')

    <div class="content">
        @include('adminlte-templates::common.errors')
            <div class="col-sm-12 col-xs-12">
                       <div class="form-wrap">

                    {!! Form::open(['route' => 'payables.store']) !!}

                        @include('Admin.payables.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
