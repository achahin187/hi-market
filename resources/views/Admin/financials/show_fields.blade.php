<!-- Restaurant Id Field -->
<div class="form-group">
    {!! Form::label('restaurant_id', __('models/financials.fields.restaurant_id').':') !!}
    <p>{{ $financial->restaurant_id }}</p>
</div>

<!-- Fc Commision Field -->
<div class="form-group">
    {!! Form::label('fc_commision', __('models/financials.fields.fc_commision').':') !!}
    <p>{{ $financial->fc_commision }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', __('models/financials.fields.created_at').':') !!}
    <p>{{ $financial->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', __('models/financials.fields.updated_at').':') !!}
    <p>{{ $financial->updated_at }}</p>
</div>

