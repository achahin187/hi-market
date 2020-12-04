@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">

                                @if(isset($supermarket_id))
                                      @if(auth()->user()->can('product-create')) 
                                    <li class="breadcrumb-item"><a href="{{route('products.create',['flag' => $flag , 'supermarket_id' => $supermarket_id])}}">{{__('admin.add_supermarket_product')}}</a></li>
                                    @endif
                                @elseif(isset($branch_id))
                                 @if(auth()->user()->can('branches-create')) 
                                    <li class="breadcrumb-item"><a href="{{route('products.create',['flag' => $flag , 'supermarket_id' => -1 , 'branch_id' => $branch_id])}}">{{__('admin.add_branch_product')}}</a></li>
                                 @endif    
                                @else
                                     @if(auth()->user()->can('product-create')) 
                                    <li class="breadcrumb-item"><a href="{{route('products.create',$flag)}}">{{__('admin.add_product')}}</a></li>
                                    @endif
                                @endif

                                @if(auth()->user()->can('product-export')) 
                                <li class="breadcrumb-item"><a href="{{route('products.export')}}">{{__('admin.export')}}</a></li>
                                @endif
                                @if(auth()->user()->can('product-import')) 
                                    <li class="breadcrumb-item">

                                        <a id="link" href="">{{__('admin.import')}}</a>

                                        <form role="form" action="{{route('products.import')}}" method="POST" id="import-form" enctype="multipart/form-data">
                                            @csrf
                                            <input name="file" hidden type="file" class="@error('file') is-invalid @enderror" id="import">
                                        </form>
                                    </li>
                                @endif
                                
                                @if(auth()->user()->can('product-download'))    
                                <li class="breadcrumb-item"><a href="{{route('products.downloadsample')}}">{{__('admin.download')}}</a></li>
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
                                <h3 class="card-title">{{__('admin.products')}}</h3>
                            </div>

                            <form role="form" action="@if(isset($supermarket_id)) {{route('products.show',['flag' => $flag , 'supermarket_id' => $supermarket_id]) }} @elseif(isset($branch_id)) {{route('products.show',['flag' => $flag ,'supermarket_id' => -1 , 'branch_id' => $branch_id]) }} @else {{route('products.show',$flag) }} @endif" method="GET">

                                @csrf

                                <?php $cols = [
                                    'name_ar',
                                    'name_en',
                                    'arab_description',
                                    'eng_description',
                                    'arab_spec',
                                    'eng_spec',
                                    'price',
                                    'priority',
                                    'points',
                                    'category_id',
                                    'vendor_id',
                                    'subcategory_id',
                                    'supermarket_id',
                                    'branch_id',
                                    'measure_id',
                                    'size_id',
                                    'start_date',
                                    'end_date',
                                    'production_date',
                                    'exp_date',
                                    'status',
                                    'barcode'];?>

                                <div class="row" style="margin-top: 20px;margin-left: 5px;margin-right: 10px">

                                    <div class="form-group col-md-6">
                                        <select class=" @error('columns') is-invalid @enderror select2"  name="columns[]" data-placeholder="{{__('admin.show')}}" style="width: 100%;" required multiple>

                                            @foreach($cols as $col)

                                                <option  value="{{$col}}">{{__($col)}}</option>

                                            @endforeach



                                        </select>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <button type="submit" class="btn btn-primary">{{__('admin.show')}}</button>
                                    </div>
                                </div>

                            </form>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">

                                    <thead>
                                        <tr>

                                            @if(isset($columns))

                                                @foreach($cols as $col)


                                                    @if(in_array($col,$columns))
                                                        <th>{{__($col)}}</th>
                                                    @endif

                                                @endforeach

                                            @else
                                                {{-- trans('admin.status') --}}

                                                <?php $main_cols = [trans('admin.name_ar'),trans('admin.name_en'),trans('admin.priority'),
                                                trans('admin.category'),trans('admin.supermarket'),trans('admin.branch')];?>

                                                @foreach($main_cols as $main_col)



                                                        <th>{{__($main_col)}}</th>


                                                @endforeach

                                            @endif
                                            @if(auth()->user()->hasAnyPermission(['product-delete','product-edit'])) 
                                            <th>{{ __('admin.controls') }}</th>
                                            @endif

                                        </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($products as $product)
                                        <tr>

                                            @if(isset($columns))
                                                @if(in_array('name_ar',$columns))
                                                    <td>{{$product->name_ar}}</td>
                                                @endif
                                                @if(in_array('name_en',$columns))
                                                    <td>{{$product->name_en}}</td>
                                                @endif
                                                @if(in_array('arab_description',$columns))
                                                    <td>{{$product->arab_description}}</td>
                                                @endif
                                                @if(in_array('eng_description',$columns))
                                                    <td>{{$product->eng_description}}</td>
                                                @endif
                                                @if(in_array('arab_spec',$columns))
                                                    <td>{{$product->arab_spec}}</td>
                                                @endif
                                                @if(in_array('eng_spec',$columns))
                                                    <td>{{$product->eng_spec}}</td>
                                                @endif
                                                @if(in_array('review',$columns))
                                                    <td>{{$product->review}}</td>
                                                @endif
                                                @if(in_array('priority',$columns))
                                                    <td>{{$product->priority}}</td>
                                                @endif
                                                @if(in_array('points',$columns))
                                                    <td>{{$product->points}}</td>
                                                @endif
                                                @if(in_array('price',$columns))
                                                    <td>{{$product->price}}</td>
                                                @endif
                                                @if(in_array('category_id',$columns))

                                                    @if(App::getLocale() == 'ar')
                                                        <td>{{$product->category->name_ar}}</td>
                                                    @else
                                                        <td>{{$product->category->name_en}}</td>
                                                    @endif

                                                @endif
                                                @if(in_array('vendor_id',$columns))

                                                    @if(App::getLocale() == 'ar')
                                                        <td>{{$product->vendor->arab_name}}</td>
                                                    @else
                                                        <td>{{$product->vendor->eng_name}}</td>
                                                    @endif

                                                @endif
                                                @if(in_array('supermarket_id',$columns))

                                                    @if(App::getLocale() == 'ar')
                                                        <td>{{$product->supermarket->arab_name}}</td>
                                                    @else
                                                        <td>{{$product->supermarket->eng_name}}</td>
                                                    @endif

                                                @endif
                                                @if(in_array('branch_id',$columns))

                                                    @if(App::getLocale() == 'ar')
                                                        <td>{{$product->branch->name_ar}}</td>
                                                    @else
                                                        <td>{{$product->branch->name_en}}</td>
                                                    @endif

                                                @endif
                                                @if(in_array('subcategory_id',$columns))

                                                    @if(App::getLocale() == 'ar')
                                                        <td>{{$product->subcategory->arab_name}}</td>
                                                    @else
                                                        <td>{{$product->subcategory->eng_name}}</td>
                                                    @endif

                                                @endif
                                                @if(in_array('measure_id',$columns))

                                                    @if(App::getLocale() == 'ar')
                                                        <td>{{$product->measure->arab_name}}</td>
                                                    @else
                                                        <td>{{$product->measure->eng_name}}</td>
                                                    @endif

                                                @endif
                                                @if(in_array('size_id',$columns))
                                                    <td>{{$product->size->value}}</td>
                                                @endif
                                                @if(in_array('start_date',$columns))

                                                    @if($flag == 1)
                                                        <td>{{$product->start_date}}</td>

                                                    @else
                                                        <td>doesn't have start date</td>
                                                    @endif

                                                @endif
                                                @if(in_array('end_date',$columns))
                                                    @if($flag == 1)
                                                        <td>{{$product->end_date}}</td>

                                                    @else
                                                        <td>doesn't have end date</td>
                                                    @endif
                                                @endif
                                                @if(in_array('production_date',$columns))
                                                    <td>{{$product->production_date}}</td>
                                                @endif
                                                @if(in_array('exp_date',$columns))
                                                    <td>{{$product->exp_date}}</td>
                                                @endif
                                                @if(in_array('status',$columns))
                                                    <td>

                                                        @if($product->status == 'active' )

                                                            <form id="active" onsubmit="return confirm('Do you really want to submit the form?');" action="{{ route('product.status', ['product_id' => $product->id , 'flag' => $flag]) }}"  method="POST">

                                                                @csrf
                                                                @method('put')
                                                                <button form="active" type="submit" class="btn btn-block btn-outline-success">{{__('admin.active')}}</button>
                                                            </form>

                                                        @else

                                                            <form id="in-active" onsubmit="return confirm('Do you really want to submit the form?');" action="{{ route('product.status', ['product_id' => $product->id , 'flag' => $flag]) }}" method="POST">

                                                                @csrf
                                                                @method('put')
                                                                <button type="submit" form="in-active" class="btn btn-block btn-outline-danger">{{__('admin.inactive')}}</button>
                                                            </form>

                                                        @endif


                                                    </td>
                                                @endif
                                                @if(in_array('barcode',$columns))
                                                    <td>{{$product->barcode}}</td>
                                                @endif

                                            @else

                                                <td>{{$product->name_ar}}</td>
                                                <td>{{$product->name_en}}</td>
                                                <td>{{$product->priority}}</td>
                                                @if(auth()->user()->can('product-active'))
                                                <td>

                                                    @if($product->status == 'active' )

                                                        <form id="active" onsubmit="return confirm('Do you really want to submit the form?');" action="{{ route('product.status', ['product_id' => $product->id , 'flag' => $flag]) }}"  method="POST">

                                                            @csrf
                                                            @method('put')
                                                            <button form="active" type="submit" class="btn btn-block btn-outline-success">{{__('admin.active')}}</button>
                                                        </form>

                                                    @else

                                                        <form id="in-active" onsubmit="return confirm('Do you really want to submit the form?');" action="{{ route('product.status', ['product_id' => $product->id , 'flag' => $flag]) }}" method="POST">

                                                            @csrf
                                                            @method('put')
                                                            <button type="submit" form="in-active" class="btn btn-block btn-outline-danger">{{__('admin.inactive')}}</button>
                                                        </form>

                                                    @endif
                                                </td>
                                                @endif
                                                @if(App::getLocale() == 'ar')
                                                    <td>{{$product->category->name_ar}}</td>
                                                @else
                                                    <td>{{$product->category->name_en}}</td>
                                                @endif


                                                @if(App::getLocale() == 'ar')
                                                    <td>{{$product->supermarket->arab_name}}</td>
                                                @else
                                                    <td>{{$product->supermarket->eng_name}}</td>
                                                @endif

                                                @if(App::getLocale() == 'ar')
                                                    <td>{{$product->branch->name_ar}}</td>
                                                @else
                                                    <td>{{$product->branch->name_en}}</td>
                                                @endif


                                            @endif

                                            @if(auth()->user()->hasAnyPermission(['product-delete','product-edit']))
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                          @if(auth()->user()->can('product-delete')) 
                                                        <form action="@if(isset($supermarket_id)) {{ route('products.destroy', ['id' => $product->id,'supermarket_id' => $supermarket_id]) }} @elseif(isset($branch_id)) {{ route('products.destroy', ['id' => $product->id,'supermarket_id' => -1 , 'branch_id' => $branch_id]) }} @else {{ route('products.destroy', $product->id) }} @endif" method="post">
                                                            @csrf
                                                            @method('delete')



                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this product?") }}') ? this.parentElement.submit() : ''">{{__('admin.delete')}}</button>

                                                        </form>
                                                        @endif
                                                        @if(auth()->user()->can('product-edit')) 
                                                            <a class="dropdown-item" href="@if(isset($supermarket_id)){{ route('products.edit', ['id' => $product->id,'flag' => $product->flag,'supermarket_id' => $supermarket_id]) }} @elseif(isset($branch_id)) {{ route('products.edit', ['id' => $product->id,'flag' => $product->flag,'supermarket_id' => -1 , 'branch_id' => $branch_id]) }} @else {{ route('products.edit', ['id' => $product->id,'flag' => $product->flag]) }} @endif">{{__('admin.edit')}}</a>
                                                        @endif

                                                       @if(auth()->user()->can('product-clone')) 
                                                            <a class="dropdown-item" href="@if(isset($supermarket_id)) {{ route('products.clone', ['id' => $product->id,'flag' => $product->flag ,'supermarket_id' => $supermarket_id]) }} @elseif(isset($branch_id)) {{ route('products.clone', ['id' => $product->id,'flag' => $product->flag ,'supermarket_id' => -1 , 'branch_id' => $branch_id]) }}  @else {{ route('products.clone', ['id' => $product->id,'flag' => $product->flag]) }} @endif">{{__('admin.clone')}}</a>\
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



