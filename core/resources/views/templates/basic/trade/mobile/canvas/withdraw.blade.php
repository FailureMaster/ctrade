<div class="offcanvas offcanvas-end" tabindex="-1" id="withdraw-offcanvas" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <h4 class="mb-0 fs-18 offcanvas-title text-white">
            @lang('Withdraw')
        </h4>
        <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa fa-times-circle fa-lg"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <form action="#" method="post" class="@if($withdrawMethods->count() <=0 ) d-none @endif" id="frmWithdrawMoney">
            @csrf
            <input type="hidden" name="currency" value="{{ $currency->symbol }}">
            <div class="form-group">
                <label class="form-label">@lang('Amount')</label>
                <div class="input-group">
                    <input type="number" step="any" name="amount" value="{{ old('amount') }}" id="amount-withdraw" class="form-control form--control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">@lang('Method')</label>
                <select class="form-control form--control form-select" name="method_code" required>
                    <option selected disabled>@lang('Select Withdraw Method')</option>
                    @foreach ($withdrawMethods as $method)
                        <option value="{{ $method->id }}" data-resource='@json($method)'>
                            {{ __($method->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="wallet_type" value="spot" for_fiat="1" for_crypto="1">
            {{-- <div class="form-group">
                <label class="form-label">@lang('Type')</label>
                <select class="form-control form--control form-select" name="wallet_type" required>
                    <option value="spot" for_fiat="1" for_crypto="1" selected>@lang('Balance')</option>
                </select>
            </div> --}}
            <div class="mt-3 preview-details d-none">
                <ul class="list-group text-center list-group-flush">
                    <li class="list-group-item d-flex flex-wrap justify-content-between">
                        <span>@lang('Limit')</span>
                        <span>
                            <span class="min fw-bold">0</span>
                            <span class="withdraw-cur-sym">{{ __(@$singleCurrency->symbol) }}</span> -
                             <span class="max fw-bold">0</span>
                             <span class="withdraw-cur-sym">{{ __(@$singleCurrency->symbol) }}</span>
                        </span>
                    </li>
                    <li class="list-group-item d-flex flex-wrap justify-content-between">
                        <span>@lang('Charge')</span>
                        <span>
                            <span class="charge fw-bold">0</span>
                            <span class="withdraw-cur-sym">{{ __(@$singleCurrency->symbol) }}</span>
                        </span>
                    </li>
                    <li class="list-group-item d-flex flex-wrap justify-content-between">
                        <span>@lang('Receivable')</span>
                        <span>
                            <span class="receivable fw-bold"> 0</span>
                            <span class="withdraw-cur-sym">{{ __(@$singleCurrency->symbol) }}</span>
                        </span>
                    </li>
                </ul>
            </div>
            <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
        </form>
        <div class="p-5 text-center empty-gateway @if($withdrawMethods->count() > 0 ) d-none @endif">
            <img src="{{ asset('assets/images/extra_images/no_money.png') }}" alt="">
            <h6 class="mt-3">
                @lang('No withdraw method available for ')
                <span class="text--base withdraw-cur-sym">{{ __(@$singleCurrency->symbol) }}</span>
                @lang('Currency')
            </h6>
        </div>

        <div class="mt-5 pending-withdraw-section">
            <div class="text-center">
                <h4 class="mb-0 fs-18 offcanvas-title text-white">@lang('Pending Withdraws')</h4>
            </div>
            <div class="table-responsive" id="tblPendingWithdraw">
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
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end p-4" tabindex="-1" id="withdraw-confirmation-canvas" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <h4 class="mb-0 fs-18 offcanvas-title text-white">
            @lang('Withdraw Confirmation')
        </h4>
        <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa fa-times-circle fa-lg"></i>
        </button>
    </div>
    <div class="offcanvas-body">
    </div>
</div>