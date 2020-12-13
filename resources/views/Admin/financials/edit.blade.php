@extends('layouts.admin_layout')

@section('content')
    @lang('models/financials.singular')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($financial, ['route' => ['financials.update', $financial->id], 'method' => 'patch']) !!}

                        @include('financials.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
