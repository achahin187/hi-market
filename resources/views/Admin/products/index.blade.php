@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
                    </div>


                    @if(auth()->user()->can('product-create'))
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{route('products.create',0)}}">create new product</a></li>
                                <li class="breadcrumb-item"><a href="{{route('products.export')}}">export</a></li>
                                <li class="breadcrumb-item"><a href="{{route('products.import')}}">import</a></li>
                            </ol>
                        </div>
                    @endif

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
                                <h3 class="card-title">products</h3>
                            </div>

                            <form role="form" action="{{route('products.show',$flag) }}" method="GET">

                                @csrf

                                <div class="form-group col-md-9">
                                    <label>show </label>
                                    <select class=" @error('columns') is-invalid @enderror select2"  name="columns[]" data-placeholder="Select a column" style="width: 100%;" required multiple>

                                        <option  value="arab_name">arab name</option>
                                        <option  value="eng_name">eng name</option>
                                        <option  value="arab_description">arab description</option>
                                        <option  value="eng_description">eng description</option>
                                        <option  value="arab_spec">arab spec</option>
                                        <option  value="eng_spec">eng spec</option>
                                        <option  value="quantity">quantity</option>
                                        <option  value="review">review</option>
                                        <option  value="price">price</option>
                                        <option  value="priority">priority</option>
                                        <option  value="points">points</option>
                                        <option  value="category_id">categories</option>
                                        <option  value="vendor_id">vendors</option>
                                        <option  value="subcategory_id">subcategories</option>
                                        <option  value="supermarket_id">supermarkets</option>
                                        <option  value="measure_id">measure</option>
                                        <option  value="size_id">size</option>
                                        <option  value="start_date">start date</option>
                                        <option  value="end_date">end date</option>
                                        <option  value="exp_date">expiration date</option>
                                        <option  value="status">status</option>
                                        <option  value="barcode">barcode</option>
                                    </select>
                                </div>


                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Show</button>
                                </div>

                            </form>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">

                                    <thead>
                                        <tr>

                                            @if(isset($columns))

                                                @if(in_array('arab_name',$columns))
                                                    <th>arab name</th>
                                                @endif
                                                @if(in_array('eng_name',$columns))
                                                    <th>eng name</th>
                                                @endif
                                                @if(in_array('arab_description',$columns))
                                                    <th>arab description</th>
                                                @endif
                                                @if(in_array('eng_description',$columns))
                                                    <th>arab description</th>
                                                @endif
                                                @if(in_array('arab_spec',$columns))
                                                    <th>arab spec</th>
                                                @endif
                                                @if(in_array('eng_spec',$columns))
                                                    <th>eng spec</th>
                                                @endif
                                                @if(in_array('quantity',$columns))
                                                    <th>quantity</th>
                                                @endif
                                                @if(in_array('review',$columns))
                                                    <th>review</th>
                                                @endif
                                                @if(in_array('priority',$columns))
                                                    <th>priority</th>
                                                @endif
                                                @if(in_array('points',$columns))
                                                    <th>points</th>
                                                @endif
                                                @if(in_array('price',$columns))
                                                    <th>price</th>
                                                @endif
                                                @if(in_array('category_id',$columns))
                                                    <th>category</th>
                                                @endif
                                                @if(in_array('vendor_id',$columns))
                                                    <th>vendor</th>
                                                @endif
                                                @if(in_array('supermarket_id',$columns))
                                                    <th>supermarket</th>
                                                @endif
                                                @if(in_array('subcategory_id',$columns))
                                                    <th>subcategory</th>
                                                @endif
                                                @if(in_array('measure_id',$columns))
                                                    <th>measuring unit</th>
                                                @endif
                                                @if(in_array('size_id',$columns))
                                                    <th>size</th>
                                                @endif
                                                @if(in_array('start_date',$columns))
                                                    <th>start date</th>
                                                @endif
                                                @if(in_array('end_date',$columns))
                                                    <th>end date</th>
                                                @endif
                                                @if(in_array('exp_date',$columns))
                                                    <th>expiration date</th>
                                                @endif
                                                @if(in_array('status',$columns))
                                                    <th>status</th>
                                                @endif
                                                @if(in_array('barcode',$columns))
                                                    <th>barcode</th>
                                                @endif
                                                <th>controls</th>

                                            @else

                                                <th>arab name</th>
                                                <th>eng name</th>
                                                <th>priority</th>
                                                <th>points</th>
                                                <th>price</th>
                                                <th>category</th>
                                                <th>vendor</th>
                                                <th>supermarket</th>
                                                <th>subcategory</th>
                                                <th>controls</th>
                                            @endif


                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                            <tr>

                                                @if(isset($columns))
                                                    @if(in_array('arab_name',$columns))
                                                        <td>{{$product->arab_name}}</td>
                                                    @endif
                                                    @if(in_array('eng_name',$columns))
                                                        <td>{{$product->eng_name}}</td>
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
                                                    @if(in_array('quantity',$columns))
                                                        <td>{{$product->quantity}}</td>
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
                                                            <td>{{$product->category->arab_name}}</td>
                                                        @else
                                                            <td>{{$product->category->eng_name}}</td>
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
                                                                        <button form="active" type="submit" class="btn btn-block btn-outline-success">active</button>
                                                                    </form>

                                                                @else

                                                                    <form id="in-active" onsubmit="return confirm('Do you really want to submit the form?');" action="{{ route('product.status', ['product_id' => $product->id , 'flag' => $flag]) }}" method="POST">

                                                                        @csrf
                                                                        @method('put')
                                                                        <button type="submit" form="in-active" class="btn btn-block btn-outline-danger">inactive</button>
                                                                    </form>

                                                                @endif


                                                            </td>
                                                    @endif
                                                    @if(in_array('barcode',$columns))
                                                        <td>{{$product->barcode}}</td>
                                                    @endif

                                                @else

                                                    <td>{{$product->arab_name}}</td>
                                                    <td>{{$product->eng_name}}</td>
                                                    <td>{{$product->priority}}</td>
                                                    <td>{{$product->points}}</td>
                                                    <td>{{$product->price}}</td>
                                                    @if(App::getLocale() == 'ar')
                                                        <td>{{$product->category->arab_name}}</td>
                                                    @else
                                                        <td>{{$product->category->eng_name}}</td>
                                                    @endif

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

                                                    @if(App::getLocale() == 'ar')
                                                        <td>{{$product->subcategory->arab_name}}</td>
                                                    @else
                                                        <td>{{$product->subcategory->eng_name}}</td>
                                                    @endif

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

                                                            @if(auth()->user()->can('product-edit'))

                                                                <a class="dropdown-item" href="{{ route('products.edit', ['id' => $product->id,'flag' => $product->flag]) }}">{{ __('edit') }}</a>

                                                            @endif

                                                                <a class="dropdown-item" href="{{ route('products.clone', ['id' => $product->id,'flag' => $product->flag]) }}">{{ __('clone') }}</a>


                                                            @if(auth()->user()->can('product-delete'))

                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this product?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>

                                                            @endif
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



