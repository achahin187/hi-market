@extends('layouts.app')
@section('heading')
 @lang('models/payables.singular')
@endsection
@section('content')

   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($payable, ['route' => ['payables.update', $payable->id], 'method' => 'patch']) !!}

                        @include('Admin.payables.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
