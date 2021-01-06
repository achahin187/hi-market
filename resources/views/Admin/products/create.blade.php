@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @include('includes.errors')
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                            @if(isset($supermarket_id))

                                <li class="breadcrumb-item"><a href="{{route('supermarket.products',['flag' => $flag , 'supermarket_id' => $supermarket_id])}}">{{__('admin.supermarket_products')}}</a></li>
                                <li class="breadcrumb-item active">{{__('admin.supermarket_products')}}</li>


                            @elseif(isset($branch_id))

                                <li class="breadcrumb-item"><a href="{{route('branch.products',['flag' => $flag , 'branch_id' => $branch_id])}}">{{__('admin.branch_products')}}</a></li>
                                <li class="breadcrumb-item active">{{__('admin.branch_products')}}</li>

                            @else
                                <li class="breadcrumb-item"><a href="{{route('products.index',$flag)}}">{{__('admin.products')}}</a></li>
                                <li class="breadcrumb-item active">{{__('admin.products')}}</li>
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

                                @if(isset($supermarket_id) && !isset($product))

                                    {{__('admin.add_supermarket_product')}}


                                @elseif(isset($product) && isset($supermarket_id))

                                    {{__('admin.edit_supermarket_product')}}

                                @elseif(isset($branch_id) && !isset($product))

                                    {{__('admin.add_branch_product')}}


                                @elseif(isset($product) && isset($branch_id))

                                    {{__('admin.edit_branch_product')}}

                                @elseif(isset($product) && !isset($clone))

                                    @if($product->flag == 0)

                                        {{__('admin.edit_product')}}

                                    @else

                                        {{__('admin.edit_product')}} {{--edit offer--}}

                                    @endif

                                @elseif(isset($product) && isset($clone))

                                    @if($flag == 0)

                                        {{__('admin.clone_product')}} {{--clone product--}}

                                    @else

                                        {{__('admin.clone_product')}} {{--clone offer--}}

                                    @endif

                                @else
                                    @if($flag == 0)

                                        {{__('admin.add_product')}} {{--add product--}}

                                    @else

                                        {{__('admin.add_product')}} {{--add offer--}}

                                    @endif


                                @endif
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="


                        @if(isset($supermarket_id) && !isset($product))

                            {{route('productsadd',['flag' => $flag , 'supermarket_id' => $supermarket_id]) }}

                        @elseif(isset($supermarket_id) && isset($product) && !isset($clone))

                            {{route('products.update',['id' => $product->id,'flag' => $product->flag,'supermarket_id' => $supermarket_id]) }}

                        @elseif(isset($branch_id) && !isset($product))

                            {{route('productsadd',['flag' => $flag ,'supermarket_id' => -1 , 'branch_id' => $branch_id]) }}

                        @elseif(isset($branch_id) && isset($product) && !isset($clone))

                            {{route('products.update',['id' => $product->id,'flag' => $product->flag,'supermarket_id' => -1 ,'branch_id' => $branch_id]) }}

                        @elseif(isset($product) && !isset($clone))

                            {{route('products.update',['id' => $product->id,'flag' => $product->flag]) }}

                        @elseif(isset($clone) && !isset($supermarket_id) && !isset($branch_id) )

                            {{route('productsadd',$flag) }}

                        @elseif(isset($clone) && isset($supermarket_id))

                            {{route('productsadd',['id' => $product->id,'flag' => $product->flag,'supermarket_id' => $supermarket_id]) }}

                        @elseif(isset($clone) && isset($branch_id))

                            {{route('productsadd',['id' => $product->id,'flag' => $product->flag,'supermarket_id' => -1 ,'branch_id' => $branch_id]) }}

                        @else

                            {{route('productsadd',$flag) }}

                        @endif"


                              method="POST" enctype="multipart/form-data">


                            @csrf

                            @if(isset($product) && !isset($clone))

                                @method('PUT')

                            @endif


                            <div class="card-body">

                            @if(isset($product))

                                  <div class="form-group">
                                        <label>{{ __('admin.supermarket') }}</label>

                                        <select class=" @error('supermarket_id') is-invalid @enderror select2" name="supermarket_id" id="supermarket_1" data-placeholder="Select a State" style="width: 100%;" required>


                                            @foreach($superMarkets  as $supermarket)
                                                <option <?php if($product->supermarket_id == $supermarket->id)  'selected'; ?> value={{ $supermarket->id }}>
                                               {{ $supermarket->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                @else

                                  <div class="form-group">
                                        <label>{{ __('admin.supermarket') }}</label>
                                        <select class=" @error('supermarket_id') is-invalid @enderror select2" id="supermarket_1" name="supermarket_id" style="width: 100%;" required>

                                            @foreach($superMarkets  as $supermarket)
                                                <option  <?php if($supermarket->id == $supermarket->id) echo 'selected'; ?> value={{ $supermarket->id }}>{{ $supermarket->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>


                                @endif





                            <div class="form-group">
                                <label>{{__('admin.branch')}} </label>

                                <select id="branches" class=" @error('branch_id') is-invalid @enderror select2" name="branch_id[]"  style="width: 100%;"  multiple>

                                    @if(isset($product))

                                        @foreach(\App\Models\Branch::all() as $branch)

                                            <option  {{ $product->branches->where('id', $branch->id)->count() != 0 ?  'selected' : ""  }} value="{{ $branch->id }}">{{ $branch->name_en }}</option>

                                        @endforeach

                                    @elseif(isset($branch_id))
                                        @foreach(\App\Models\Branch::all() as $branch)
{{--
                                            <option <?php if($branch->id == $branch->id) echo 'selected'; ?> value="{{ $branch->id }}">{{ $branch->name_en }}</option> --}}

                                        @endforeach

                                    @else

                                   {{--  @foreach(\App\Models\Branch::all() as $branch)

                                            <option></option>

                                        @endforeach --}}

                                    @endif

                                </select>
                            </div>

                                <div class="form-group">
                                    <label>{{__('admin.category')}}</label>
                                    <select class=" @error('category_id') is-invalid @enderror select2"  id="vendor_1"  name="category_id" data-placeholder="Select a State" style="width: 100%;" required >

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
                                    <label>{{__('admin.vendor')}} </label>
                                    <select class=" @error('vendor_id') is-invalid @enderror select2"  name="vendor_id" id='categories' data-placeholder="Select a State" style="width: 100%;" required>
                                        @if(isset($product))
                                            @foreach(\App\Models\Vendor::all() as $vendor)

                                                <option <?php if($product->vendor->id ?? "" == $vendor->id) echo 'selected'; ?> value="{{ $vendor->id }}">{{ $vendor->eng_name }}</option>

                                            @endforeach
                                        @else

                                        @endif
                                    </select>
                                </div>




                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('admin.name_ar')}}</label>
                                    <input type="text" value="@if(isset($product)){{$product->name_ar }} @endif" name="name_ar" class=" @error('name_ar') is-invalid @enderror form-control" required>
                                    @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('admin.name_en')}}</label>
                                    <input type="text" name="name_en" value="@if(isset($product)){{$product->name_en }} @endif" class=" @error('name_en') is-invalid @enderror form-control" required>
                                    @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{__('admin.description_ar')}}</label>
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
                                    <label>{{__('admin.description_en')}}</label>
                                    <textarea class=" @error('eng_description') is-invalid @enderror form-control" name="eng_description" rows="3" placeholder="Enter ...">
                                        {{ isset($product) ? $product->eng_description : '' }}
                                        {{-- @if(isset($product))
                                            {{$product->eng_description }}
                                        @endif --}}
                                    </textarea>
                                    @error('eng_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{__('admin.spec_ar')}}</label>
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
                                    <label>{{__('admin.spec_en')}}</label>
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
                                    <label for="exampleInputEmail1">{{__('admin.barcode')}}</label>
                                    <input type="text" value="@if(isset($product)){{$product->barcode }} @endif" name="barcode" class=" @error('barcode') is-invalid @enderror form-control" required>
                                    @error('barcode')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.price')}}</label>
                                    <input type="number" name="price" min="0" max="99999.99" step="0.01" @if(isset($product)) value="{{$product->price}}" @else value="0" @endif class=" @error('price') is-invalid @enderror form-control">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('admin.offer_price')}}</label>
                                        <input type="number" name="offer_price" min="0" max="99999.99" step="0.01" @if(isset($product)) value="{{$product->offer_price}}" @else value="0" @endif class=" @error('offer_price') is-invalid @enderror form-control">
                                        @error('offer_price')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>



                                 <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('admin.rate')}}</label>
                                    <input type="text" @if(isset($product)) value="{{$product->rate}}" @else value="" @endif  name="rate" class=" @error('rate') is-invalid @enderror form-control" required>
                                    @error('rate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">{{__('admin.rate')}}</label>
                                    <input type="text" @if(isset($product)) value="{{$product->ratings}}" @else value="" @endif  name="ratings" class=" @error('ratings') is-invalid @enderror form-control" required>
                                    @error('ratings')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.points')}}</label>
                                    <input type="number" name="points" min="0" @if(isset($product)) value="{{$product->points}}" @else value="0" @endif class=" @error('points') is-invalid @enderror form-control">
                                    @error('points')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{__('admin.priority')}}</label>
                                    <input type="number" name="priority" min="0" @if(isset($product)) value="{{$product->priority}}" @else value="0" @endif class=" @error('priority') is-invalid @enderror form-control" >
                                    @error('priority')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


{{--
                                @if(!isset($client))

                                    <div class="form-group">
                                        <label>
                                        </label>
                                        <select class="@error('status') is-invalid @enderror select2" name="status" data-placeholder="Select a State" style="width: 100%;" required>


                                            <option value="active">{{__('admin.active')}}</option>
                                            <option value="inactive">{{__('admin.inactive')}}</option>

                                        </select>

                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                @endif
 --}}


                            {{--     <div class="form-group">
                                    <label>{{__('admin.subcategory')}} </label>
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
                                </div> --}}


                              {{--   <div class="form-group">
                                    <label>{{__('admin.supermarket')}} </label>
                                    <select id="supermarket" class=" @error('supermarket_id') is-invalid @enderror select2" name="supermarket_id" data-placeholder="Select a State" style="width: 100%;" @if(isset($supermarket_id)) disabled @endif required>
                                        @if(isset($product))
                                            @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                <option <?php if($product->supermarket->id == $supermarket->id) echo 'selected'; ?> value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                            @endforeach

                                        @elseif(isset($supermarket_id))

                                            @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                <option <?php if($supermarket_id == $supermarket->id) echo 'selected'; ?> value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Supermarket::all() as $supermarket)

                                                <option value="{{ $supermarket->id }}">{{ $supermarket->eng_name }}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>
 --}}
                                @if(isset($supermarket_id))

                                    <input type="hidden" name="supermarket_id" value="{{$supermarket_id}}">
                                @endif




                                                     {{--
                                              @foreach(\App\Models\Branch::all() as $branch)

                                                <option value="{{ $branch->id }}">
                                                    {{ $branch->name_en }}
                                                </option> --}}



                                          {{--   @endforeach --}}





                               {{--  @if(isset($branch_id))

                                    <input type="hidden" name="branch_id" value="{{$branch_id}}">
                                @endif
 --}}

                                <div class="form-group">
                                    <label>{{__('admin.measure')}} </label>
                                    <select class=" @error('measuring_unit') is-invalid @enderror select2" name="measure_id" data-placeholder="Select a State" style="width: 100%;" required>
                                        @if(isset($product))
                                            @foreach(\App\Models\Measures::all() as $measure)

                                                <option <?php if($product->measure->id ?? false == $measure->id) echo 'selected'; ?> value="{{ $measure->id }}">{{ $measure->eng_name }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Measures::all() as $measure)

                                                <option value="{{ $measure->id }}">{{ $measure->eng_name }}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>{{__('admin.size')}} </label>
                                    <select class=" @error('size') is-invalid @enderror select2" name="size_id" data-placeholder="Select a Size" style="width: 100%;" required>
                                        @if(isset($product))
                                            @foreach(\App\Models\Size::all() as $size)

                                                <option <?php if($product->size->id ?? false == $size->id) echo 'selected'; ?> value="{{ $size->id }}">{{ $size->value }}</option>

                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Size::all() as $size)

                                                <option value="{{ $size->id }}">{{ $size->value }}</option>

                                            @endforeach

                                        @endif
                                    </select>
                                </div>


                                @if($flag == 1)


                                    <div class="form-group">
                                        <label>{{__('admin.start_date')}}</label>
                                        <input type="datetime-local" class=" @error('start_date') is-invalid @enderror form-control" @if(isset($product)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($product->start_date)) }}" @endif id="start" name="start_date" data-placeholder="Select a offer start_date" style="width: 100%;" required>

                                        @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>{{__('admin.end_date')}}</label>
                                        <input type="datetime-local" class=" @error('end_date') is-invalid @enderror form-control"  @if(isset($product)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($product->end_date)) }}" @endif name="end_date" data-placeholder="Select a offer end_date" style="width: 100%;" required>

                                        @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                @endif


                                <div class="form-group">
                                    <label>{{__('admin.production_date')}}</label>
                                    <input type="datetime-local" class=" @error('production_date') is-invalid @enderror form-control"  @if(isset($product)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($product->production_date)) }}" @endif name="production_date" data-placeholder="Select a expiration date" style="width: 100%;" required>

                                    @error('production_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>{{__('admin.exp_date')}}</label>
                                    <input type="datetime-local" class=" @error('exp_date') is-invalid @enderror form-control"  @if(isset($product)) value="{{old('time')?? date('Y-m-d\TH:i', strtotime($product->exp_date)) }}" @endif name="exp_date" data-placeholder="Select a expiration date" style="width: 100%;" required>

                                    @error('exp_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                @if(isset($product) && !isset($clone))

                                    <div class="form-group">
                                        <label for="exampleInputFile">{{__('admin.image')}}</label>
                                        <div class="input-group">
                                            <div class="custom-file">

                                                @if($product->images != null)

                                                    @foreach($productimages as $image)

                                                        <img style="width:80px;height:80px;margin-right:10px;margin-top: 30px;" src="{{ asset('product_images') }}/{{$image}}" class="card-img-top" alt="Course Photo">

                                                        <input type="checkbox" checked style="margin-right:10px;" name="image" value="{{$image}}">

                                                    @endforeach

                                                @endif

                                                <input  type="file"  name="image">

                                            </div>

                                        </div>
                                    </div>
                                         <p style="color: red">Width: 80 px</p>
                                          <p style="color: red"> length: 80 px </p>


                                @elseif(isset($product) && isset($clone))

                                    <div class="form-group">
                                        <label for="exampleInputFile">{{ __('admin.image') }}</label>
                                        <div class="input-group">

                                                <input name="image"  type="file" class=" @error('image') is-invalid @enderror" id="exampleInputFile">



                                        </div>
                                    </div>
                                            <p style="color: red">Width: 80 px</p>
                                             <p style="color: red"> length: 80 px </p>
                                @else

                                    <div class="form-group">
                                        <label for="exampleInputFile">{{ __('admin.image') }}</label>
                                        <div class="input-group">

                                                <input name="image"  type="file" class=" @error('image') is-invalid @enderror" >



                                        </div>
                                    </div>
                                                <p style="color: red">Width: 80 px</p>
                                                <p style="color: red"> length: 80 px </p>
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

@push('scripts')
<script type="text/javascript">
        $("#supermarket_1").change(function(){
            $.ajax({
                url: "{{ route('get_supermarket_branches') }}?supermarket_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#branches').html('');
                    data.forEach(function(x){

                    $('#branches').append(new Option(x.name_ar,x.id,true,true)).trigger("change");
                    })
                }
            });
        });
    </script>

    <script type="text/javascript">
        $("#vendor_1").change(function(){
            $.ajax({
                url: "{{ route('vendor.categories') }}?vendor_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#categories').html('');
                    data.forEach(function(x){
                    @if (app()->getLocale() == 'ar')
                    $('#categories').append(new Option(x.eng_name,x.id,false,false)).trigger("change");

                    @else
                     $('#categories').append(new Option(x.eng_name,x.id,false,false)).trigger("change");
                    @endif

                    })

                }
            });
        });
    </script>
@endpush
