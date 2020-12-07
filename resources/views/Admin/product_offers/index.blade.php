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
                                <li class="breadcrumb-item"><a href="{{route('products.create',['flag' => 1 , 'supermarket_id' => $supermarket_id])}}">{{__('admin.add_supermarket_product')}}</a></li>
                            @elseif(isset($branch))
                                <li class="breadcrumb-item"><a href="{{route('branchproducts.create',['flag' => $flag , 'branch_id' => $branch->id])}}">{{__('admin.add_branch_product')}}</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="{{route('products.create',1)}}">{{__('admin.add_product_offer')}}</a></li>
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

                            <form role="form" action="{{route('products.show',$flag) }}" method="GET">

                                @csrf

                                <div class="row" style="margin-top: 20px;margin-left: 5px;margin-right: 10px">

                                    <div class="form-group col-md-6">
                                        <select class=" @error('columns') is-invalid @enderror select2"  name="columns[]" data-placeholder="{{__('admin.show')}}" style="width: 100%;" required multiple>

                                            <option  value="name_ar">{{__('admin.name_ar')}}</option>
                                            <option  value="name_en">{{__('admin.name_en')}}</option>
                                            <option  value="arab_description">{{__('admin.description_ar')}}</option>
                                            <option  value="eng_description">{{__('admin.description_en')}}</option>
                                            <option  value="arab_spec">{{__('admin.spec_ar')}}</option>
                                            <option  value="eng_spec">{{__('admin.spec_en')}}</option>
                                            <option  value="review">{{__('admin.review')}}</option>
                                            <option  value="price">{{__('admin.price')}}</option>
                                            <option  value="priority">{{__('admin.priority')}}</option>
                                            <option  value="points">{{__('admin.points')}}</option>
                                           {{--  <option  value="category_id">{{__('admin.category')}}</option> --}}
                                            <option  value="vendor_id">{{__('admin.vendor')}}</option>
                                           {{--  <option  value="subcategory_id">{{__('admin.subcategory')}}</option> --}}
                                            <option  value="supermarket_id">{{__('admin.supermarket')}}</option>
                                            <option  value="branch_id">{{__('admin.branch')}}</option>
                                            <option  value="measure_id">{{__('admin.measure')}}</option>
                                            <option  value="size_id">{{__('admin.size')}}</option>
                                            <option  value="start_date">{{__('admin.start_date')}}</option>
                                            <option  value="end_date">{{__('admin.end_date')}}</option>
                                            <option  value="exp_date">{{__('admin.exp_date')}}</option>
                                             @if(auth()->user()->can('product-active')) 
                                            <option  value="status">{{__('admin.status')}}</option>
                                            @endif
                                            <option  value="barcode">{{__('admin.barcode')}}</option>
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

                                            @if(in_array('name_ar',$columns))
                                                <th>{{__('admin.name_ar')}}</th>
                                            @endif
                                            @if(in_array('name_en',$columns))
                                                <th>{{__('admin.name_en')}}</th>
                                            @endif
                                            @if(in_array('arab_description',$columns))
                                                <th>{{__('admin.description_ar')}}</th>
                                            @endif
                                            @if(in_array('eng_description',$columns))
                                                <th>{{__('admin.description_en')}}</th>
                                            @endif
                                            @if(in_array('arab_spec',$columns))
                                                <th>{{__('admin.spec_ar')}}</th>
                                            @endif
                                            @if(in_array('eng_spec',$columns))
                                                <th>{{__('admin.spec_en')}}</th>
                                            @endif
                                            @if(in_array('review',$columns))
                                                <th>{{__('admin.review')}}</th>
                                            @endif
                                            @if(in_array('priority',$columns))
                                                <th>{{__('admin.priority')}}</th>
                                            @endif
                                            @if(in_array('points',$columns))
                                                <th>{{__('admin.points')}}</th>
                                            @endif
                                            @if(in_array('price',$columns))
                                                <th>{{__('admin.price')}}</th>
                                            @endif
                                           {{--  @if(in_array('category_id',$columns))
                                                <th>{{__('admin.category')}}</th>
                                            @endif --}}
                                            @if(in_array('vendor_id',$columns))
                                                <th>{{__('admin.vendor')}}</th>
                                            @endif
                                            @if(in_array('supermarket_id',$columns))
                                                <th>{{__('admin.supermarket')}}</th>
                                            @endif

                                            @if(in_array('branch_id',$columns))
                                                <th>{{__('admin.branch')}}</th>
                                            @endif
                                           {{--  @if(in_array('subcategory_id',$columns))
                                                <th>{{__('admin.subcategory')}}</th>
                                            @endif --}}
                                            @if(in_array('measure_id',$columns))
                                                <th>{{__('admin.measure')}}</th>
                                            @endif
                                            @if(in_array('size_id',$columns))
                                                <th>{{__('admin.size')}}</th>
                                            @endif
                                            @if(in_array('start_date',$columns))
                                                <th>{{__('admin.start_date')}}</th>
                                            @endif
                                            @if(in_array('end_date',$columns))
                                                <th>{{__('admin.end_date')}}</th>
                                            @endif
                                            @if(in_array('exp_date',$columns))
                                                <th>{{__('admin.exp_date')}}</th>
                                            @endif
                                            @if(in_array('status',$columns))
                                                <th>{{__('admin.status')}}</th>
                                            @endif
                                            @if(in_array('barcode',$columns))
                                                <th>{{__('admin.barcode')}}</th>
                                            @endif
                                              @if(auth()->user()->hasAnyPermission(['product-edit','product-delete','product-clone']))
                                            <th>{{__('admin.controls')}}</th>
                                            @endif

                                        @else

                                            <th>{{__('admin.name_ar')}}</th>
                                            <th>{{__('admin.name_en')}}</th>
                                            <th>{{__('admin.priority')}}</th>
                                                @if(auth()->user()->can('product-active'))
                                            <th>{{__('admin.status')}}</th>
                                            @endif
                                           {{--  <th>{{__('admin.category')}}</th> --}}
                                            <th>{{__('admin.vendor')}}</th>
                                            <th>{{__('admin.supermarket')}}</th>
                                            {{-- <th>{{__('admin.branch')}}</th> --}}
                                         {{--    <th>{{__('admin.subcategory')}}</th> --}}
                                             @if(auth()->user()->hasAnyPermission(['product-edit','product-delete','product-clone']))
                                            <th>{{__('admin.controls')}}</th>
                                            @endif
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
                                               {{--  @if(in_array('category_id',$columns))

                                                    @if(App::getLocale() == 'ar')
                                                        <td>{{$product->category->arab_name}}</td>
                                                    @else
                                                        <td>{{$product->category->eng_name}}</td>
                                                    @endif

                                                @endif --}}
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
                                                {{-- @if(in_array('subcategory_id',$columns))

                                                    @if(App::getLocale() == 'ar')
                                                        <td>{{$product->subcategory->arab_name}}</td>
                                                    @else
                                                        <td>{{$product->subcategory->eng_name}}</td>
                                                    @endif

                                                @endif --}}
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
                                                    <td>{{$product->start_date}}</td>
                                                @endif
                                                @if(in_array('end_date',$columns))
                                                    <td>{{$product->end_date}}</td>
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
                                           {{--      @if(App::getLocale() == 'ar')
                                                    <td>{{$product->category->name_ar}}</td>
                                                @else
                                                    <td>{{$product->category->name_en}}</td>
                                                @endif --}}

                                                @if(App::getLocale() == 'ar')
                                                    <td>{{$product->vendor->arab_name}}</td>
                                                @else
                                                    <td>{{$product->vendor->eng_name}}</td>
                                                @endif

                                                @if(App::getLocale() == 'ar')
                                                    <td>{{$product->supermarket->arab_name}}</td>
                                                @else
                                                    <td>{{$product->supermarket->eng_name}}</td>
                                                @endif

                                               {{--  @if(App::getLocale() == 'ar')
                                                    <td>{{$product->branches->name_ar}}</td>
                                                @else
                                                    <td>{{$product->branches->name_en}}</td>
                                                @endif --}}

                                               {{--  @if(App::getLocale() == 'ar')
                                                    <td>{{$product->subcategory->arab_name}}</td>
                                                @else
                                                    <td>{{$product->subcategory->eng_name}}</td>
                                                @endif --}}

                                            @endif


                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')


                                                            <a class="dropdown-item" href="{{ route('products.edit', ['id' => $product->id,'flag' => $product->flag]) }}">{{__('admin.edit')}}</a>


                                                            <a class="dropdown-item" href="{{ route('products.clone', ['id' => $product->id,'flag' => $product->flag]) }}">{{__('admin.clone')}}</a>


                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this product?") }}') ? this.parentElement.submit() : ''">{{__('admin.delete')}}</button>

                                                        </form>

                                                    </div>
                                                </div>
                                            </td>
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
