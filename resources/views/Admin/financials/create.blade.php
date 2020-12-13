@extends('layouts.admin_layout')
@section('heading')
    @lang('models/financials.singular')
@endsection
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>General Form</h1>
                        @include('includes.errors')
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
{{--                            @if(isset($supermarket_id))--}}

{{--                                <li class="breadcrumb-item"><a--}}
{{--                                        href="{{route('supermarket.offers',$supermarket_id)}}">{{__('admin.supermarket_offers')}}</a>--}}
{{--                                </li>--}}



{{--                            @elseif(isset($branch_id))--}}

{{--                                <li class="breadcrumb-item"><a--}}
{{--                                        href="{{route('branch.offers',$branch_id)}}">{{__('admin.branch_offers')}}</a>--}}
{{--                                </li>--}}

{{--                            @else--}}
{{--                                <li class="breadcrumb-item"><a--}}
{{--                                        href="{{route('offers.index')}}">{{__('admin.offers')}}</a></li>--}}
{{--                            @endif--}}
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
                                </h3>

                                <div class="content">
                                    @include('adminlte-templates::common.errors')
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-wrap">

                                            {!! Form::open(['route' => 'financials.store']) !!}

                                            @include('Admin.financials.fields')

                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
