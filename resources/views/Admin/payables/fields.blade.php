<!-- Restaurant Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('restaurant_id', __('models/payables.fields.restaurant_id').':') !!}
    {!! Form::select('restaurant_id', isset($payable) ? [$payable->restaurant->id=>$payable->restaurant->name] : [],  isset($payable) ? $payable->restaurant_id : null, ['class' => 'form-control select2']) !!}
</div>


<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', __('models/payables.fields.status').':') !!}
    {!! Form::select('status', __("models/payables.fields.status_options"), null, ['class' => 'form-control ']) !!}
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
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('payables.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
</div>
