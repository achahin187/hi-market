<!-- Restaurant Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('restaurant_id', __('models/receivables.fields.restaurant_id').':') !!}
    {!! Form::select('restaurant_id', isset($receivable) ? [$receivable->restaurant->id=>$receivable->restaurant->name] : [],  isset($receivable) ? $receivable->restaurant_id : null, ['class' => 'form-control select2']) !!}
</div>


<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', __('models/receivables.fields.status').':') !!}
    {!! Form::select('status', __("models/receivables.fields.status_options"), null, ['class' => 'form-control ']) !!}
</div>

<!-- Delivery Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('delivery_name', __('models/receivables.fields.delivery_name').':') !!}
    {!! Form::text('delivery_name', null, ['class' => 'form-control']) !!}
</div>

@isset($receivable)
    <div class="row">
        <div class="col-md-6">
            <h6>@lang("models/receivables.total_orders")</h6>
            <label>{{$receivable->restaurant->orders()->count()}}</label>
        </div>
        <div class="col-md-6">
            <h6>@lang("models/receivables.total_money")</h6>
            <label>{{$receivable->fc_commission}}</label>
        </div>
        <div class="col-md-6">
            <h6>@lang("models/receivables.create_at")</h6>
            <label>{{$receivable->created_at->format("Y-m-d")}}</label>

        </div>


    </div>
    <button type="button"  data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-responsive">1</button>
    @component("partials.modal")
        @slot ("title",__("models/receivables.fields.order_id"))
        <div class="row">
            @foreach($receivable->restaurant->orders as $order)
            <div class="col-md-3">
                <h6>Id:{{$order->id}}</h6>
                  <h6>Price : {{$order->price}}</h6>
                  <h6>Quantity : {{$order->qty}} @lang("models/orders.fields.measure_unit_options.".$this->measure_unit)</h6>
                  <h6>taxes : {{$order->taxes}} </h6>
                  <h6>status : {{$order->status}} </h6>
                  <h6>discount amount : {{$order->discount_amount}} </h6>
                  <h6>offer : {{$order->offer}} </h6>
                  <h6>promo code : {{$order->promo_code}} </h6>
                  <h6>rate : {{$order->rate}} </h6>
                  <h6>points : {{$order->points}} </h6>
                  <h6>order type : {{$order->order_type}} </h6>
                  <h6>order date : {{$order->order_date->format("Y-m-d")}} </h6>
                  <h6>delivery date : {{$order->delivery_date->format("Y-m-d")}} </h6>


            </div>
            @endforeach
        </div>
    @endcomponent
@endisset



<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('receivables.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
</div>


@push("scripts")
    <script>
        $(".select2").select2({
            ajax: {
                url: "{{route("api.select2.restaurants")}}",
                processResults: function (data) {
                    return {
                        "results": data.items,
                        "more": data.paginate.more
                    }
                }
            }
        })
    </script>
@endpush
