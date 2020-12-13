<div class="table-responsive">
    <table class="table" id="payables-table">
        <thead>
        <tr>
            <th>@lang('models/payables.fields.restaurant_id')</th>

            <th>@lang("models/receivables.fields.restaurant_name")</th>
            <th>@lang("models/receivables.fields.total_orders")</th>
            <th>@lang('models/receivables.fields.order_id')</th>
            <th>@lang('models/payables.fields.status')</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($payables as $payable)
            <tr>
                <td>{{ $payable->restaurant_id }}</td>
                <td>{{$payable->restaurant->name}}</td>
                <td>{{$payable->restaurant->total_orders_money}}</td>
                <td>{{ $payable->restaurant->orders()->pluck("id")->first() }}</td>
                <td>{{ $payable->status }}</td>
                <td>
                    {!! Form::open(['route' => ['payables.destroy', $payable->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('payables.show', [$payable->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('payables.edit', [$payable->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => 'return confirm("'.__('crud.are_you_sure').'")']) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
