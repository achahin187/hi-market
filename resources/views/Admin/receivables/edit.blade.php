@extends('layouts.app')
@section('heading')
 @lang('models/receivables.singular')
@endsection
@section('content')

   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($receivable, ['route' => ['receivables.update', $receivable->id], 'method' => 'patch']) !!}

                        @include('receivables.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
