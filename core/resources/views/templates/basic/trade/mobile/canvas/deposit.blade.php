<div class="offcanvas offcanvas-end" tabindex="-1" id="deposit-canvas" aria-labelledby="offcanvasLabel" style="padding: 10px;">
    <div class="offcanvas-header p-0">
        <h4 class="mb-0 fs-18 offcanvas-title text-white">
            @lang('Deposit Preview')
        </h4>
        <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa fa-times-circle fa-lg"></i>
        </button>
    </div>
    <div class="offcanvas-body p-0 pt-4">
        <form action="" method="post" id="depositFrm"
            class="@if ($gateways->count() <= 0) d-none @endif">
            @csrf
            <input type="hidden" name="currency" value="{{ $currency->symbol }}">
            <input type="hidden" name="wallet_type" value="spot">
            {{-- <div class="form-group position-relative" id="currency_list_wrapper">
                <x-currency-list :action="route('user.currency.all')" valueType="2" logCurrency="true" />
            </div> --}}
            <div class="form-group mb-2">
                <select class="form-control form--control form-select text-white" name="gateway" required
                style="border: 1px solid #7c666675">
                    <option value="USD" >United States Dollar-USD</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label class="form-label text-white">@lang('Amount')</label>
                <div class="input-group">
                    <input type="number" step="any" class="form--control form-control text-white" name="amount"
                        required style="border: 1px solid #7c666675">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label text-white">@lang('Gateway')</label>
                <select class="form-control form--control form-select text-white" name="gateway" required
                    style="border: 1px solid #7c666675">
                    <option selected disabled>@lang('Select Payment Gateway')</option>
                    @foreach ($gateways as $gateway)
                        <option value="{{ $gateway->method_code }}" data-gateway='@json($gateway)'>
                            {{ __($gateway->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group preview-details d-none">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex flex-wrap justify-content-between">
                        <span>@lang('Limit')</span>
                        <span>
                            <span class="min fw-bold">0</span>
                            - <span class="max fw-bold">0</span>
                            <span class="deposit-currency-symbol">{{ __(@$singleCurrency->symbol) }}</span>
                        </span>
                    </li>
                    <li class="list-group-item d-flex flex-wrap justify-content-between">
                        <span>@lang('Charge')</span>
                        <span>
                            <span class="charge fw-bold">0</span>
                            <span class="deposit-currency-symbol">{{ __(@$singleCurrency->symbol) }}</span>
                        </span>
                    </li>
                    <li class="list-group-item d-flex flex-wrap justify-content-between">
                        <span> @lang('Payable')</span>
                        <span>
                            <span class="payable fw-bold">0</span>
                            <span class="deposit-currency-symbol">{{ __(@$singleCurrency->symbol) }}</span>
                        </span>
                    </li>
                </ul>
            </div>
            <button class="deposit__button btn btn--base w-100" type="submit"> @lang('Submit') </button>
        </form>
        <div class="p-5 text-center empty-gateway @if ($gateways->count() > 0) d-none @endif">
            <img src="{{ asset('assets/images/extra_images/no_money.png') }}">
            <h6 class="mt-3">
                @lang('No payment gateway available for ')
                <span class="text--base deposit-currency-symbol">{{ __($currency->symbol) }}</span>
                @lang('Currency')
            </h6>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end p-4" tabindex="-1" id="deposit-confirmation-canvas" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <h4 class="mb-0 fs-18 offcanvas-title text-white">
            @lang('Deposit Confirmation')
        </h4>
        <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa fa-times-circle fa-lg"></i>
        </button>
    </div>
    <div class="offcanvas-body">
    </div>
</div>