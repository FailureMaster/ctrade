<form action="{{ route('user.deposit.new.manual.update') }}" method="POST" enctype="multipart/form-data" id="customDepositConfirmForm">
    @csrf
    <div class="row">
        <div class="col-md-12 text-center">
            {{-- <p class="text-center mt-2">
                @lang('You have requested') <b class="text--success">
                    {{ showAmount($data['amount']) }}
                    {{ __(@$data->method_currency) }}</b> , @lang('Please pay')
                <b class="text--success">
                    {{ showAmount($data['amount']) }} +
                    <span data-bs-toggle="tooltip"  title="@lang('Charge')">{{ showAmount($data['charge']) }}</span> =
                    {{ showAmount($data['final_amo']) . ' ' . $data['method_currency'] }}
                </b> @lang('for successful payment')
            </p> --}}
            @if( $data->gateway->message == null )
                <p class="text-center mt-2">
                    @lang('You have requested') <b class="text--success">
                        {{ showAmount($data['amount']) }}
                        {{ __(@$data->method_currency) }}</b> , @lang('Please pay')
                    <b class="text--success">
                        {{ showAmount($data['amount']) }} +
                        <span data-bs-toggle="tooltip"  title="@lang('Charge')">{{ showAmount($data['charge']) }}</span> =
                        {{ showAmount($data['final_amo']) . ' ' . $data['method_currency'] }}
                    </b> @lang('for successful payment')
                </p>
            @else
                @if (App::getLocale() != 'ar')
                    <p>{{ $data->gateway->message }}</p>
                @else
                    <p>{{ $data->gateway->message_arabic }}</p>
                @endif
            @endif
            <h4 class="text-center my-4">@lang('Please follow the instruction below')</h4>
            <p class="my-4 text-center">@php echo  $data->gateway->description @endphp</p>
        </div>
        <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}" />
        <input type="hidden" name="trx" value="{{ $trx }}">
        {{-- <div class="col-md-12">
            <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
        </div> --}}
        @if( $data->gateway->allow_pay )
            <div class="col-md-12">
                <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
            </div>
        @endif
    </div>
</form>