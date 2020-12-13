<div class="table-responsive">
    <table class="table" id="financials-table">
        <thead>
        <tr>
            <th>@lang('models/financials.fields.restaurant_id')</th>
            <th>@lang('models/financials.fields.fc_commision')</th>

            <th>@lang("models/financials.fields.total_money")</th>
            <th>@lang("models/financials.fields.fc_money_commission")</th>
            <th>@lang("models/financials.fields.money_res_from_commission")</th>
            <th>@lang("models/financials.fields.received_money_rest")</th>
            <th>@lang("models/financials.fields.remain_money_rest")</th>

            <th colspan="3">@lang('crud.action')</th>
        </tr>


        </thead>
        <tbody>

        @foreach($financials as $financial)
            <tr>
                <td>{{ $financial->id }}</td>
                <td>{{ $financial->restaurant ? $financial->restaurant->fc_commision : null }}</td>
                <td>{{$financial->total_orders_money}}</td>
                <td>{{$financial->fc_money_from_commission}}</td>
                <td>{{$financial->money_res_from_commission}}</td>
                <td>{{$financial->received_money_res}}</td>
                <td>{{$financial->remain_res_money}}</td>

                <td>

                    <div class='btn-group'>
                        <a href="{{ route('financials.show', [$financial->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('financials.edit', [$financial->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>

                    </div>

                </td>
            </tr>
        @endforeach


        </tbody>
    </table>
</div>
