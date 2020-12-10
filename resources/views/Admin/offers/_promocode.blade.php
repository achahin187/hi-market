
                    <div class="form-group">
                        <label for="branch">Source</label>
                        <select name="source" id="type"  class="form-control select2">
                            @php
                            $sources = ['Delivertto','Branch'];
                            @endphp
                              <option  selected  disabled>Please Select Source</option>
                             @foreach($sources as  $source) 
                               <option  @if(old("source") == $source) selected
                                        @endif value="{{$source}}">{{$source}}</option>
                             @endforeach             
                        </select>
                    </div>


                    <div class="form-group supermarket_4" hidden="true">
                        <label for="branch">SuperMarket</label>
                        <select name="supermarket_id" id='supermarket_4'  class="form-control select2">
                        
                            <option  selected  disabled>Please Select Source</option>
                        @foreach( $supermarkets as  $supermarket) 
                            <option  @if(old("source") == $supermarket) selected
                                        @endif value="{{$supermarket->id}}">{{$supermarket->name}}</option>
                        @endforeach             
                        </select>
                    </div>

                     <div class="form-group" id="branch_promo" hidden="true">
                        <label for="branch">Branch</label>
                        <select name="branch_id" id="branche_4"  class="form-control select2">
                        
                            <option  selected  disabled>Please Select branch</option>
                               
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Promo Code Name</label>
                        <input type="text" placeholder="please Choose PromoCode Name" value="{{old("promocode_name")}}" name="promocode_name"
                               class=" @error('promocode_name') is-invalid @enderror form-control" required>
                        @error('promocode_name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                     <div class="form-group">
                        <label for="branch">Promo Code Type</label>
                        <select name="promocode_type"  class="form-control select2">

                                @php $promocode_types = ['Dicount','Value'];@endphp

                            <option  selected  disabled>Please Select Source</option>

                             @foreach($promocode_types as  $promocode_type) 

                               <option  @if(old("promocode_type") == $promocode_type) selected
                                @endif value="{{$promocode_type}}">{{$promocode_type}}</option>

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
                                @endif value="{{$discount}}">{{$discount}}</option>

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
                        <input type="text" placeholder="please Choose Value" value="{{old("Value")}}" name="value"
                               class=" @error('Value') is-invalid @enderror form-control" required>
                        @error('Value')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>{{__('admin.start_date')}}</label>
                        <input type="datetime-local" class=" @error('start_date') is-invalid @enderror form-control"  id="start" name="start_date" data-placeholder="Select a offer start_date" style="width: 100%;" required>

                        @error('start_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>{{__('admin.end_date')}}</label>
                        <input type="datetime-local" class=" @error('end_date') is-invalid @enderror form-control"  name="end_date" data-placeholder="Select a offer end_date" style="width: 100%;" required>

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