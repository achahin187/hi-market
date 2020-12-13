<!-- Restaurant Id Field -->
<div class="form-group">
    {!! Form::label('restaurant_id', __('models/receivables.fields.restaurant_id').':') !!}
    <p>{{ $receivable->restaurant_id }}</p>
</div>

<!-- Order Id Field -->
<div class="form-group">
    {!! Form::label('order_id', __('models/receivables.fields.order_id').':') !!}
    <p>{{ $receivable->order_id }}</p>
</div>

<!-- Delivery Name Field -->
<div class="form-group">
    {!! Form::label('delivery_name', __('models/receivables.fields.delivery_name').':') !!}
    <p>{{ $receivable->delivery_name }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', __('models/receivables.fields.status').':') !!}
    <p>{{ $receivable->status }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', __('models/receivables.fields.created_at').':') !!}
    <p>{{ $receivable->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', __('models/receivables.fields.updated_at').':') !!}
    <p>{{ $receivable->updated_at }}</p>
</div>

