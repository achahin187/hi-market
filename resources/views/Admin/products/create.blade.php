@extends('layouts.admin_layout')

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
                            @if(($flag == 1))

                                <li class="breadcrumb-item"><a href="{{route('products.index',$flag)}}">offers</a></li>
                                <li class="breadcrumb-item active">Offer Form</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{route('products.index',$flag)}}">products</a></li>
                                <li class="breadcrumb-item active">product Form</li>
                            @endif
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

                                @if(isset($product) && !isset($clone))

                                    @if($product->flag == 0)

                                        edit product

                                    @else

                                        edit offer

                                    @endif

                                @elseif(isset($product) && isset($clone))

                                    @if($flag == 0)

                                        clone product

                                    @else

                                        clone offer

                                    @endif

                                @else
                                    @if($flag == 0)

                                        create product

                                    @else

                                        create offer

                                    @endif


                                @endif
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="@if(isset($product) && !isset($clone)){{route('products.update',['id' => $product->id,'flag' => $product->flag]) }} @elseif(isset($clone) && isset($product)) {{route('productsadd',$flag) }} @else {{route('productsadd',$flag) }}  @endif" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if(isset($product) && !isset($clone))

                                @method('PUT')

                            @endif

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('admin.product_arabname')}}</label>
                                    <input type="text" value="@if(isset($product)){{$product->name_ar }} @endif" name="name_ar" class=" @error('name_ar') is-invalid @enderror form-control" required>
                                    @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('admin.product_engname')}}</label>
                                    <input type="text" name="name_en" value="@if(isset($product)){{$product->name_en }} @endif" class=" @error('name_en') is-invalid @enderror form-control" required>
                                    @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{__('admin.arab_description')}}</label>
                                    <textarea class=" @error('arab_description') is-invalid @enderror form-control" name="arab_description" rows="3" placeholder="Enter ...">

                                        @if(isset($product))
                                            {{$product->arab_description }}
                                        @endif
                                    </textarea>
                                    @error('arab_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{__('admin.eng_description')}}</label>
                                    <textarea class=" @error('eng_description') is-invalid @enderror form-control" name="eng_description" rows="3" placeholder="Enter ...">

                                        @if(isset($product))
                                            {{$product->eng_description }}
                                        @endif
                                    </textarea>
                                    @error('eng_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{__('admin.arab_spec')}}</label>
                                    <textarea class=" @error('arab_spec') is-invalid @enderror form-control" name="arab_spec" rows="3" placeholder="Enter ...">

                                        @if(isset($product))
                                            {{$product->arab_spec }}
                                        @endif
                                    </textarea>
                                    @error('arab_spec')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{__('admin.eng_spec')}}</label>
                                    <textarea class=" @error('eng_spec') is-invalid @enderror form-control" name="eng_spec" rows="3" placeholder="Enter ...">

                                        @if(isset($product))
                                            {{$product->eng_spec }}
                                        @endif
                                    </textarea>
                                    @error('eng_spec')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('admin.product_barcode')}}</label>
                                    <input type="text" value="@if(isset($product)){{$product->barcode }} @endif" name="barcode" class=" @error('barcode') is-invalid @enderror form-control" required>
                                    @error('barcode')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.product_price')}}</label>
                                    <input type="number" name="price" min="0" max="99999.99" step="0.01" @if(isset($product)) value="{{$product->price}}" @else value="0" @endif class=" @error('price') is-invalid @enderror form-control">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.product_points')}}</label>
                                    <input type="number" name="points" min="0" @if(isset($product)) value="{{$product->points}}" @else value="0" @endif class=" @error('points') is-invalid @enderror form-control">
                                    @error('points')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.product_priority')}}</label>
                                    <input type="number" name="priority" min="0" @if(isset($product)) value="{{$product->priority}}" @else value="0" @endif class=" @error('priority') is-invalid @enderror form-control" >
                                    @error('priority')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                @if(!isset($client))

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="@error('status') is-invalid @enderror select2" name="status" data-placeholder="Select a State" style="width: 100%;" required>


                                            <option value="active">active</option>
                                            <option value="inactive">inactive</option>

                                        </select>

                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                @endif

                                <div class="form-group">
                                    <label>product category</label>
                                    <select class=" @error('category_id') is-invalid @enderror select2"  name="category_id" data-placeholder="Select a State" style="width: 100%;" required>

                                        @if(isset($product))
                                            @foreach(\App\Models\Category::all() as $category)

                                                <option <?php if($product->category->id == $category->id) echo 'selected'; ?> value="{{ $category->id }}">{{ $category->name_en }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Category::all() as $category)

                                                <option value="{{ $category->id }}">{{ $category->name_en }}</option>

                                            @endforeach

                                        @endif

                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>product subcategory </label>
                                    <select class=" @error('subcategory_id') is-invalid @enderror select2" name="subcategory_id" data-placeholder="Select a State" style="width: 100%;" required>
                                        @if(isset($product))
                                            @foreach(\App\Models\SubCategory::all() as $subcategory)

                                                <option <?php if($product->subcategory->id == $subcategory->id) echo 'selected'; ?> value="{{ $subcategory->id }}">{{ $subcategory->eng_name }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\SubCategory::all() as $subcategory)

                                                <option value="{{ $subcategory->id }}">{{ $subcategory->eng_name }}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>product supermarket </label>
                                    <select id="supermarket" class=" @error('supermarket_id') is-invalid @enderror select2" name="supermarket_id" data-placeholder="Select a State" style="width: 100%;" required>
                                        @if(isset($product))
                                            @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                <option <?php if($product->supermarket->id == $supermarket->id) echo 'selected'; ?> value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                <option value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>supermarket branch </label>
                                    <select id="branch" class=" @error('branch_id') is-invalid @enderror select2" name="supermarket_id" data-placeholder="Select a State" style="width: 100%;" required>
                                        @if(isset($product))
                                            @foreach(\App\Models\Branch::all() as $branch)

                                                <option <?php if($product->branch->id == $branch->id) echo 'selected'; ?> value="{{ $branch->id }}">{{ $branch->name_en }}</option>

                                            @endforeach
                                        @else

                                            @foreach(\App\Models\Branch::all() as $branch)

                                                <option value="{{ $branch->id }}">{{ $branch->name_en }}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>product vendor </label>
                                    <select class=" @error('vendor_id') is-invalid @enderror select2" name="vendor_id" data-placeholder="Select a State" style="width: 100%;" required>
                                        @if(isset($product))
                                            @foreach(\App\Models\Vendor::all() as $vendor)

                                                <option <?php if($product->vendor->id == $vendor->id) echo 'selected'; ?> value="{{ $vendor->id }}">{{ $vendor->eng_name }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Vendor::all() as $vendor)

                                                <option value="{{ $vendor->id }}">{{ $vendor->eng_name }}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>product measuring unit </label>
                                    <select class=" @error('measuring_unit') is-invalid @enderror select2" name="measure_id" data-placeholder="Select a State" style="width: 100%;" required>
                                        @if(isset($product))
                                            @foreach(\App\Models\Measures::all() as $measure)

                                                <option <?php if($product->measure->id == $measure->id) echo 'selected'; ?> value="{{ $measure->id }}">{{ $measure->eng_name }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Measures::all() as $measure)

                                                <option value="{{ $measure->id }}">{{ $measure->eng_name }}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>product size </label>
                                    <select class=" @error('size') is-invalid @enderror select2" name="size_id" data-placeholder="Select a Size" style="width: 100%;" required>
                                        @if(isset($product))
                                            @foreach(\App\Models\Size::all() as $size)

                                                <option <?php if($product->size->id == $size->id) echo 'selected'; ?> value="{{ $size->id }}">{{ $size->value }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Size::all() as $size)

                                                <option value="{{ $size->id }}">{{ $size->value }}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>start_date</label>
                                    <input type="datetime-local" class=" @error('start_date') is-invalid @enderror form-control" @if(isset($product)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($product->start_date)) }}" @endif id="start" name="start_date" data-placeholder="Select a offer start_date" style="width: 100%;" required>

                                    @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>end_date</label>
                                    <input type="datetime-local" class=" @error('end_date') is-invalid @enderror form-control"  @if(isset($product)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($product->end_date)) }}" @endif name="end_date" data-placeholder="Select a offer end_date" style="width: 100%;" required>

                                    @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>exp_date</label>
                                    <input type="datetime-local" class=" @error('exp_date') is-invalid @enderror form-control"  @if(isset($product)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($product->exp_date)) }}" @endif name="exp_date" data-placeholder="Select a expiration date" style="width: 100%;" required>

                                    @error('exp_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                @if(isset($product) && !isset($clone))

                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">

                                                @if($product->images != null)

                                                    @foreach($productimages as $image)

                                                        <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('product_images') }}/{{$image}}" class="card-img-top" alt="Course Photo">

                                                        <input type="checkbox" checked style="margin-right:10px;" name="image[]" value="{{$image}}">

                                                    @endforeach

                                                @endif

                                                <input name="images[]" multiple type="file">

                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                    </div>


                                @elseif(isset($product) && isset($clone))

                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="images[]" multiple type="file" class="custom-file-input @error('images') is-invalid @enderror" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                @else

                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="images[]" multiple type="file" class="custom-file-input @error('images') is-invalid @enderror" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>


@endsection


