@extends('layouts.app')
@section('heading')
@lang('models/receivables.singular')
@endsection
@section('content')

    <div class="content">
        @include('adminlte-templates::common.errors')
            <div class="col-sm-12 col-xs-12">
                       <div class="form-wrap">

                    {!! Form::open(['route' => 'receivables.store']) !!}

                        @include('receivables.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
