<form action="{{ route('offer.update', $offer->id) }}" method="POST"  enctype="multipart/form-data">
    
@csrf  
@method('PUT')
                 <input type="hidden" value="product Offer" name="type">
                    <div class="form-group">
                        <label for="branch">SuperMarket</label>
                        <select name="supermarket_id" id='supermarket_2'  class="form-control select2">
                        
                            <option  selected  disabled>Please Select Source</option>
                        @foreach( $supermarkets as  $supermarket) 
                            <option  @if(old("supermarket_id") == $supermarket->id) selected
                                        @endif value="{{$supermarket->id}}"{{ $offer->supermarket_id ==  $supermarket->id ? 'selected' : ''}}>{{$supermarket->name}}</option>
                        @endforeach             
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="branch">Branch</label>
                        <select name="branch_id" id="branche_2"  class="form-control select2">
                        
                            <option  selected  disabled>Please Select branch</option>
                             @foreach($branches  as $branch)
                                 <option value="{{$branch->id}}" {{$offer->branch_id == $branch->id ? 'selected' :'' }}>{{ $branch->name }}</option>
                              @endforeach     
                        </select>
                    </div>


                     <div class="form-group">
                        <label for="branch">Product </label>
                        <select name="product_id" id="product_2"   class="@error('product_link') is-invalid @enderror form-control select2">
                        
                            <option  selected  disabled>Please Select product</option>
                            @foreach($products  as $product)
                                 <option value="{{$product->id}}" {{ $offer->product_id ==  $product->id ? 'selected' : ''}}>{{ $product->name }}</option>
                              @endforeach 
                        </select>
                        @error('product_id')
                         <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1">Priority</label>
                        <input type="text" placeholder="please Choose Priority" value="{{$offer->priority}}" name="priority"
                               class=" @error('priority') is-invalid @enderror form-control" >
                        @error('priority')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>




                    <div class="form-group">
                        <label>{{__('admin.start_date')}}</label>
                        <input type="datetime-local" class=" @error('start_date') is-invalid @enderror form-control"   name="start_date" value="{{old('start_date')?? date('Y-m-d\TH:i', strtotime($offer->start_date)) }}" data-placeholder="Select a offer start_date" style="width: 100%;" >

                        @error('start_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>{{__('admin.end_date')}}</label>
                        <input type="datetime-local" class=" @error('end_date') is-invalid @enderror form-control"  name="end_date" value="{{old('end_date')?? date('Y-m-d\TH:i', strtotime($offer->start_date)) }}" data-placeholder="Select a offer end_date" style="width: 100%;" >

                        @error('end_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>{{__('admin.banner')}}</label>
                        <br>
                        <input type="file" name="banner">
                        @error('banner')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <p style="color: red">Width: 400 px</p>
                       <p style="color: red"> length: 130 px </p>
                    </div>
                    
                        <img  style="width: 100px;height: 100px;" src="{{ asset('offer_images/'.$offer->banner) }}">

                     <div class="card-footer">
                      <button type="submit" class="btn btn-primary">{{ __('admin.add_offer') }}</button>
                  </div>
</form>

