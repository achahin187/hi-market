<!-- Restaurant Id Field -->
<div class="form-group">
    {!! Form::label('restaurant_id', __('models/payables.fields.restaurant_id').':') !!}
    <p>{{ $payable->restaurant_id }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', __('models/payables.fields.status').':') !!}
    <p>{{ $payable->status }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', __('models/payables.fields.created_at').':') !!}
    <p>{{ $payable->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', __('models/payables.fields.updated_at').':') !!}
    <p>{{ $payable->updated_at }}</p>
</div>

