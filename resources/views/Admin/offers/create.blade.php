@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.add') }}</h1>
                        @include('includes.errors')
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
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{route('offer.index')}}">{{ __('admin.delivery_companies') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('admin.add') }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
           
      
    <div class="col-12 col-sm-6 col-lg-12">
                <div class="card card-primary card-outline card-outline-tabs">
                  <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="false">Promo Code</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Product offer</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Free Delivery</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link " id="custom-tabs-three-settings-tab" data-toggle="pill" href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="true">Points</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                      <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                         @include('Admin.offers._promocode') 
                      </div>
                      <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                          @include('Admin.offers._product_offers') 
                      </div>
                      <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                           @include('Admin.offers._product_free') 
                      </div>
                      <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                           @include('Admin.offers._product_point') 
                      </div>
                    </div>
                  </div>
                
                  <!-- /.card -->
                </div>
    </div>



                      
        </section>
    </div>


@endsection

{{-- 
@push('scripts')

<script type="text/javascript">

    function setInput(selectedType){
        selectedType.forEach(function(x){
        $('#type').append(new Option(x,true,true)).trigger("change");
        })
    }


        $("#offer_type").change(function(){

            var offer_type      = $('#offer_type').val(); 
            var promoCodeSource = ['Delivertto','Branches'];
            var productOffer    = ['Delivertto','Branches'];

               $('#type').html('');

               switch(offer_type) {

                      case "PromoCode":
                          setInput(promoCodeSource);
                        break;
                      case 'Product Offer':
                          setInput(promoCodeSource);
                        break;
                      default:
                        // code block
                }

             
        });
    </script>
@endpush --}}


@push('scripts')
<script type="text/javascript">
        $("#supermarket_2").change(function(){
            $.ajax({
                url: "{{ route('get_supermarket_branches') }}?supermarket_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#branche_2').html('');
                    data.forEach(function(x){
                        
                    $('#branche_2').append(new Option(x.name_ar,x.id,true,true)).trigger("change");
                    })
                }
            });
        });
    </script>

    <script type="text/javascript">
        $("#supermarket_4").change(function(){
            $.ajax({
                url: "{{ route('get_supermarket_branches') }}?supermarket_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#branche_5').html('');
                    data.forEach(function(x){
                        
                    $('#branche_5').append(new Option(x.name_ar,x.id,false,false)).trigger("change");
                    })
                }
            });
        });
    </script>

    <script type="text/javascript">
        $("#branche_2").change(function(){
            $.ajax({
                url: "{{ route('get_branch_product') }}?branch_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#product_2').html('');
                    data.forEach(function(x){
                        
                    $('#product_2').append(new Option(x.name_ar,x.id,true,true)).trigger("change");
                    })
                }
            });
        });
    </script>

      <script type="text/javascript">
        $("#branche_3").change(function(){
            $.ajax({
                url: "{{ route('get_branch_product') }}?branch_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#product_3').html('');
                    data.forEach(function(x){
                        
                    $('#product_3').append(new Option(x.name_ar,x.id,true,true)).trigger("change");
                    })
                }
            });
        });
    </script>

    <script>
    $("#type_proint").change(function(){
         var type = $('#type_proint').val();
         
            if (type === 'Branch') {
       

                 $('#branch_point').removeAttr('hidden');
            }else{
                 $('#branch_point').attr("hidden",true);
            }
    });

     $("#type").change(function(){
         var type = $('#type').val();
            console.log(type);
            if (type === 'Branch') {
       

                 $('.supermarket_4').removeAttr('hidden');
                 $('#branch').removeAttr('hidden');
            }else{
                 $('.supermarket_4').attr("hidden",true);
                 $('#branch').attr("hidden",true);
            }
    });

     $("#type").change(function(){
         var type = $('#type').val();
            console.log(type);
            if (type === 'Branch') {
       

                 $('.supermarket_4').removeAttr('hidden');
                 $('#branch').removeAttr('hidden');
            }else{
                 $('.supermarket_4').attr("hidden",true);
                 $('#branch').attr("hidden",true);
            }
    });
</script>
@endpush
