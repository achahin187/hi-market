<!-- Restaurant Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('restaurant_id', __('models/financials.fields.restaurant_id').':') !!}
    {!! Form::select('restaurant_id',isset($financial) ? [$financial->restaurant->id =>$financial->restaurant->name]:[], isset($financial) ? $financial->restaurant_id:null, ['class' => 'form-control select2']) !!}
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
<!-- Fc Commision Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fc_commision', __('models/financials.fields.fc_commision').':') !!}
    {!! Form::number('fc_commision', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('financials.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
</div>
@isset($financial)
    <div class="row">
        <div class="col-md-6">
            <h6>@lang("models/financials.total_orders")</h6>
            <label>{{$financial->restaurant->orders()->count()}}</label>
        </div>
        <div class="col-md-6">
            <h6>@lang("models/financials.total_money")</h6>
            <label>{{$financial->restaurant->total_orders_money}}</label>
        </div>
        <div class="col-md-6">
            <h6>@lang("models/financials.fc_money_commission")</h6>
            <label>{{$financial->restaurant->fc_money_from_commission}}</label>

        </div>
        <div class="col-md-6">
            <h6>@lang("models/financials.received_money_rest")</h6>
            <label>{{$financial->restaurant->received_money_res}}</label>

        </div>
        <div class="col-md-6">
            <h6>@lang("models/financials.remain_money_rest")</h6>
            <label>{{$financial->restaurant->remain_res_money}}</label>

        </div>

        <div class="col-md-6">
            <h6>@lang("models/financials.money_res_from_commission")</h6>
            <label>{{$financial->restaurant->money_res_from_commission}}</label>
        </div>
    </div>
@endisset
