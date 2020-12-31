<form action="{{ route('offer.update',$offer->id) }}" method="POST"  enctype="multipart/form-data">
    
    @csrf 
    @method('PUT')        
                    <input type="hidden" value="promocode" name="type">

                    <div class="form-group">
                        <label for="branch">Source</label>
                        <select name="source" id="type"  class="form-control select2">
                            @php
                            $sources = ['Delivertto','Branch'];
                            @endphp
                              <option  selected  disabled>Please Select Source</option>
                             @foreach($sources as  $source) 
                               <option  @if(old("source") == $source) selected
                                        @endif value="{{$source}}"{{ $offer->source == $source ?'selected':'' }}>{{$source}}</option>
                             @endforeach             
                        </select>
                    </div>


                    <div class="form-group supermarket_4"  {{ $offer->source == 'Delivertto'?'hidden':"" }}>
                        <label for="branch">SuperMarket</label>
                        <select name="supermarket_id" id='supermarket_4'  class="form-control select2">
                        
                            <option  selected  disabled>Please Select Source</option>
                        @foreach( $supermarkets as  $supermarket) 
                            <option  @if(old("supermarket_id") == $supermarket->id) selected
                                        @endif value="{{$supermarket->id}}"{{ $offer->supermarket_id ==  $supermarket->id ? 'selected' : ''}}>{{$supermarket->name}}</option>
                        @endforeach             
                        </select>
                    </div>

                     <div class="form-group" id="branch" hidden="true">
                        <label for="branch">Branch</label>
                        <select name="branch_id[]" id="branche_5" multiple class="form-control select2">
                        
                            <option  selected  disabled>Please Select branch</option>

                            
                               @foreach($branches  as $branch)
                                 <option value="{{$branch->id}}" {{ in_array($branch->id, $offer->branches->pluck('id')->toArray())?'selected' :'' }}>{{ $branch->name }}</option>
                              @endforeach    
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Promo Code Name</label>
                        <input type="text" placeholder="please Choose PromoCode Name" value="{{$offer->promocode_name}}" name="promocode_name"
                               class=" @error('promocode_name') is-invalid @enderror form-control" >
                        @error('promocode_name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                     <div class="form-group">
                        <label for="branch">Promo Code Type</label>
                        <select name="promocode_type"  class="form-control select2">

                                @php $promocode_types = ['Percentage','Value'];@endphp

                            <option  selected  disabled>Please Select Source</option>

                             @foreach($promocode_types as  $promocode_type) 

                               <option  @if(old("promocode_type") == $promocode_type) selected
                                @endif value="{{$promocode_type}}" {{ $offer->promocode_type == $promocode_type ? 'selected' :'' }}>{{$promocode_type}}</option>

                             @endforeach  

                        </select>
                    </div>

                     <div class="form-group">
                        <label for="branch">Discount On</label>
                        <select name="discount_on"  class=" @error('discount_on') is-invalid @enderror form-control select2">

                                @php $discount_on = ['Delivery','Order'];@endphp

                            <option  selected  disabled>Please Select discount</option>

                             @foreach($discount_on as  $discount) 

                               <option  @if(old("discount_on") == $discount) selected
                                @endif value="{{$discount}}" {{ $offer->discount_on == $discount ? 'selected' :''}}>{{$discount}}</option>

                             @endforeach  

                        </select>
                         @error('discount_on')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                     <div class="form-group">
                        <label for="exampleInputEmail1">Value</label>
                        <input type="text" placeholder="please Choose Value" value="{{ $offer->value }}" name="value"
                               class=" @error('Value') is-invalid @enderror form-control" >
                        @error('Value')
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
                        <input type="datetime-local" class=" @error('end_date') is-invalid @enderror form-control"  name="end_date" value="{{old('end_date')?? date('Y-m-d\TH:i', strtotime($offer->end_date)) }}" data-placeholder="Select a offer end_date" style="width: 100%;" >

                        @error('end_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- banner 1 --}}
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
                        <br>
                        <br>
                        <br>
                             {{-- banner 1 --}}
                    <div class="form-group">
                        <label>{{__('admin.banner')}}</label>
                        <br>
                        <input type="file" name="banner2">
                        @error('banner')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <p style="color: red">Width: 400 px</p>
                        <p style="color: red"> length: 130 px </p>
                    </div>

                        <img  style="width: 100px;height: 100px;" src="{{ asset('offer_images/'.$offer->banner2) }}">

                        <br>
                        <br>
                        <br>
                        <br>
                      <div class="card-footer">
                      <button type="submit" class="btn btn-primary">{{ __('admin.edit_offer') }}</button>
                  </div>

</form>