@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.points') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                            @if(!isset($point))
                              @if(auth()->user()->can('point-create'))
                                <li class="breadcrumb-item"><a href="{{route('points.create')}}">add new points</a></li>
                              @endif  
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
                                <form action="{{ route('point.photo') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group" style="margin-bottom: 10px">
                                            <label for="exampleInputFile">{{__('admin.image')}}</label>
                                       
                                             <div class="form-group">
                                             
                                                <input type="file"   name="image" class="form-control-file" id="exampleFormControlFile1">
                                              </div>
                                                 <button class="btn btn-primary">Upload </button>
                                               <p style="color: red">Width: 400 px -- length: 800 px </p>
                                          
                                        </div>
                                </form>
                            </div>
                              
                            
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example30" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>points</th>
                                       {{--  <th>type</th>
                                        <th>offer_type</th> --}}
                                        <th>EGP Discount value</th>
                                        @if(auth()->user()->can('point-active'))
                                        <th>status</th>
                                        @endif
                                        <th>start date</th>
                                        <th>end date</th>
                                      @if(auth()->user()->hasAnyPermission(['point-delete','point-edit']))  <th>{{ __('admin.controls') }}</th>
                                      @endif  
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($points as $point)
                                        <tr>
                                            <td>{{$point->points}}</td>
                                            {{-- <td>
                                                @if($point->type == 0)

                                                    discount

                                                @elseif($point->type == 1)

                                                    value
                                                @else

                                                    offer

                                                @endif


                                            </td> --}}
                                            {{-- <td>

                                                @if($point->offer_type == 'value')

                                                    value
                                                @elseif($point->offer_type == 'percentage')

                                                    percentage

                                                @else

                                                    not an offer

                                                @endif


                                            </td> --}}
                                            <td>{{$point->value ."  EGP"}}</td>
                                            @if(auth()->user()->can('point-active'))
                                            <td>

                                                @if($point->status == 'active' )

                                                    <form action="{{ route('points.status', $point->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this range ?") }}') ? this.parentElement.submit() : ''" href="{{ route('points.status', $point->id) }}" class="btn btn-block btn-outline-success">active</button>
                                                    </form>

                                                @else

                                                    <form action="{{ route('points.status', $point->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this range ?") }}') ? this.parentElement.submit() : ''" href="{{ route('points.status', $point->id) }}" class="btn btn-block btn-outline-danger">inactive</button>
                                                    </form>

                                                @endif
                                            </td>
                                            @endif
                                            <td>{{$point->start_date}}</td>
                                            <td>{{$point->end_date}}</td>
                                              @if(auth()->user()->hasAnyPermission(['point-delete','point-edit']))
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                    @if(auth()->user()->can('point-delete'))    
                                                        <form action="{{ route('points.destroy', $point->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this range?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                        </form>
                                                    @endif
                                                    
                                                    @if(auth()->user()->can('point-edit'))    

                                                            <a class="dropdown-item" href="{{ route('points.edit',$point->id) }}">{{ __('edit') }}</a>
                                                    @endif        

                                                    </div>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection



