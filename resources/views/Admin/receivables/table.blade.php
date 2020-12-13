<div class="table-responsive">
    <table class="table" id="receivables-table">
        <thead>
        <tr>
            <th>@lang('models/receivables.fields.restaurant_id')</th>
            <th>@lang("models/receivables.fields.restaurant_name")</th>
            <th>@lang("models/receivables.fields.total_orders")</th>
            <th>@lang('models/receivables.fields.order_id')</th>
            <th>@lang("models/receivables.fields.total_orders")</th>

            <th>@lang('models/receivables.fields.status')</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($receivables as $receivable)
            <tr>
                <td>{{ $receivable->restaurant_id }}</td>
                <td>{{$receivable->restaurant->name}}</td>
                <td>{{$receivable->restaurant->total_orders_money}}</td>
                <td>{{ $receivable->restaurant->orders()->pluck("id")->first() }}</td>
                <td>{{$receivable->restaurant->orders->count()}}</td>

                <td>{{ $receivable->status }}</td>

                <td>
                    {!! Form::open(['route' => ['receivables.destroy', $receivable->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('receivables.show', [$receivable->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('receivables.edit', [$receivable->id]) }}" class='btn btn-default btn-xs'><i
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
