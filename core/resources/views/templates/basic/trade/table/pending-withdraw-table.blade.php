<table class="tbl-pw">
    <thead>
        @if (App::getLocale() != 'ar')
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Amount')</th>
                <th></th>
            </tr>
        @else
            <tr>
                <th></th>
                <th>@lang('Amount')</th>
                <th>@lang('Date')</th>
            </tr>
        @endif
    </thead>
    <tbody>
        @foreach( $pendingWithdraw as $pw )
            @if (App::getLocale() != 'ar')
                <tr>
                    <td>
                        {{ showDateTime($pw->created_at) }} <br>
                        {{ diffForHumans($pw->created_at) }}
                    </td>
                    <td>
                        {{ showAmount($pw->amount) }} - <span class="text--danger"
                            title="@lang('charge')">{{ showAmount($pw->charge) }} </span>
                        <br>
                        <strong title="@lang('Amount after charge')">
                            {{ showAmount($pw->amount - $pw->charge) }}
                            {{ @$pw->currency }}
                        </strong>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-cancelw" data-id="{{ Crypt::encrypt($pw->id) }}">@lang('Cancel')</button>
                    </td>
                </tr>
            @else
                <tr>
                    <td>
                        <button class="btn btn-sm btn-warning btn-cancelw" data-id="{{ Crypt::encrypt($pw->id) }}">@lang('Cancel')</button>
                    </td>
                    <td>
                        {{ showAmount($pw->amount) }} - <span class="text--danger"
                            title="@lang('charge')">{{ showAmount($pw->charge) }} </span>
                        <br>
                        <strong title="@lang('Amount after charge')">
                            {{ showAmount($pw->amount - $pw->charge) }}
                            {{ @$pw->currency }}
                        </strong>
                    </td>
                    <td>
                        {{ showDateTime($pw->created_at) }} <br>
                        {{ diffForHumans($pw->created_at) }}
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>