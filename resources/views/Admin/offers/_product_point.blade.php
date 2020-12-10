                      <div class="form-group">
                        <label for="branch">Source</label>
                        <select name="source" id="type_proint"  class="form-control select2">
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



                    <div class="form-group" id="branch_point" hidden="true">
                        <label for="branch">Branch</label>
                        <select name="branch_id" id="branche_4"  class="form-control select2">
                        
                            <option  selected  disabled>Please Select branch</option>
                              @foreach( $branches as  $branch) 
                            <option  @if(old("branch_id") == $branch->id) selected
                                        @endif value="{{$branch->id}}">{{$branch->name}}</option>
                              @endforeach     
                        </select>
                    </div>


                     <div class="form-group">
                        <label for="exampleInputEmail1">Points</label>
                        <input type="number" placeholder="please write Point" value="{{old("point")}}" name="point"
                               class=" @error('point') is-invalid @enderror form-control" required>
                        @error('point')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    
                     <div class="form-group">
                        <label for="exampleInputEmail1">Total Order Money</label>
                        <input type="number" placeholder="please write Total Order Money" value="{{old("total_order_money")}}" name="total_order_money"
                               class=" @error('total_order_money') is-invalid @enderror form-control" required>
                        @error('total_order_money')
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


