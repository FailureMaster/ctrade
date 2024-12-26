@php
    $currentFilter = request('filter');
@endphp
@extends($activeTemplate . 'layouts.master')
@push('style')
    <style>
        .d-container{
            width: 250px;
        }

        .text-right{
            text-align:right !important;
        }
    </style>

    @if(App::getLocale() == 'ar')
        <style>
            .dashboard-card > div{
                flex-direction: row-reverse !important;
            }
            input,select{
                text-align:right;
            }

            form label{
                text-align:right;
            }

            .form--control{
                line-height: unset !important;
            }

            #detailModal .modal-header, #detailModal .modal-body ul li{
                flex-direction: row-reverse;
            }

            #dh-table{
                text-align:right !important;
            }
        </style>
    @endif
@endpush
@section('content')
    <div class="row justify-content-between align-items-center gy-4">
        {{-- <x-date-filter :currentFilter="$currentFilter" :currentUrl="url()->current()" /> --}}
        <div class="col-lg-12">
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <x-date-filter :currentFilter="$currentFilter" :currentUrl="url()->current()" />
                    <div>
                        <form action="">
                            <div class="d-flex gap-2 align-items-end @if(App::getLocale() == 'ar')text-end flex-row-reverse @endif">
                                <div class="flex-grow-1">
                                    <label>@lang('Transactions')</label>
                                    <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}">
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Gateway')</label>
                                    <select name="gateway" class="form-control form--control">
                                        <option value="">@lang('Select One')</option>
                                        @foreach ($gateway as $g)
                                            <option value="{{ $g->method_code }}">
                                                {{ __($g->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Status')</label>
                                    <select name="status" class="form-control form--control">
                                        <option value="">@lang('Select One')</option>
                                        <option value="1" @selected(request()->status == 1)>
                                            @lang('Approved')
                                        </option>
                                        {{-- <option value="2" @selected(request()->status == 2)>
                                            @lang('Pending')
                                        </option> --}}
                                        <option value="3" @selected(request()->status == 3)>
                                            @lang('Rejected')
                                        </option>
                                    </select>
                                </div>
                                <div class="flex-grow-1 align-self-end">
                                    <button class="btn btn--base w-100"><i class="las la-filter"></i> @lang('Filter')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 d-flex align-items-center @if(App::getLocale() == 'ar') flex-row-reverse @endif">
            <h4 class="mb-0">{{ __($pageTitle) }}</h4>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Deposit Amount') </a>
                        </div>
                        <h6 class="dashboard-card__coin-title">{{ $depositsData->where('status', 1)->sum('amount') }}$</h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Total Deposits') </a>
                        </div>
                        <h6 class="dashboard-card__coin-title">{{ $depositsData->count() }}</h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @if(App::getLocale() == 'ar')
                                    @lang('Approved Deposits') 
                                @else
                                    @lang('Approved') 
                                @endif
                            </a>
                        </div>
                        <h6 class="dashboard-card__coin-title">{{ $depositsData->where('status', 1)->count() }}</h6>
                    </div>
                </div>
            </div>
            {{-- <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @if(App::getLocale() == 'ar')
                                    @lang('Pending Deposit') 
                                @else
                                    @lang('Pending') 
                                @endif
                            </a>
                        </div>
                        <h6 class="dashboard-card__coin-title">{{ $depositsData->where('status', 2)->count() }}</h6>
                    </div>
                </div>
            </div> --}}
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @if(App::getLocale() == 'ar')
                                    @lang('Rejected Deposits') 
                                @else
                                    @lang('Rejected') 
                                @endif
                            </a>
                        </div>
                         <h6 class="dashboard-card__coin-title">{{ $depositsData->where('status', 3)->count() }}</h6>
                    </div>
                </div>
            </div>
        </div>
 
        <div class="col-md-12">
            <div class="table-wrapper">
                <table class="table table--responsive--lg" id="dh-table">
                    <thead>
                        @if(App::getLocale() != 'ar')
                            <tr>
                                <th>@lang('Currency')</th>
                                <th>@lang('Gateway')</th>
                                <th>@lang('Transaction')</th>
                                <th>@lang('Initiated')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        @else
                            <tr>
                                <th>@lang('Details')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Initiated')</th>
                                <th>@lang('Transaction')</th>
                                <th>@lang('Gateway')</th>
                                <th>@lang('Currency')</th>
                            </tr>
                        @endif
                    </thead>
                    <tbody>
                        @forelse($deposits as $deposit)
                            @php
                                $symbol = @$deposit->wallet->currency->symbol;
                            @endphp
                            @if(App::getLocale() != 'ar')
                                <tr>
                                    <td>
                                        <div class="text-end text-lg-start">
                                            <span>{{ __($symbol) }}</span>
                                            <br>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-end text-lg-start">
                                            <span class="text-primary fw-bold">{{ __($deposit->gateway?->name) }}</span>
                                            <br>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-end text-lg-start">
                                            <span>{{ $deposit->trx }} </span>
                                            <br>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-end text-lg-start fw-normal">
                                            <span>{{ showDateTime($deposit->created_at) }}</span> <br>
                                            <small>{{ diffForHumans($deposit->created_at) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-end text-lg-start fw-normal">
                                            {{ showAmount($deposit->amount) }} +
                                            <span class="text--danger"
                                                title="@lang('charge')">{{ showAmount($deposit->charge) }}
                                            </span>
                                            <br>
                                            <span title="@lang('Amount with charge')">
                                                {{ showAmount($deposit->amount + $deposit->charge) }}
                                                {{ $symbol }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="text-end text-lg-start">
                                            @php echo $deposit->statusBadge @endphp
                                        </div>
                                    </td>
                                    @php
                                        $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                    @endphp
                                    <td>
                                        <button type="button"
                                            class="btn btn--base btn--sm outline @if ($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                            @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif
                                            @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                            <i class="las la-desktop"></i> @lang('Details')
                                        </button>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    @php
                                        $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                    @endphp
                                    <td>
                                        <button type="button"
                                            class="btn btn--base btn--sm outline @if ($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                            @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif
                                            @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                            <i class="las la-desktop"></i> @lang('Details')
                                        </button>
                                    </td>
                                    <td class="">
                                        <div class="">
                                            @php echo $deposit->statusBadge @endphp
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-normal">
                                            {{ showAmount($deposit->amount) }} +
                                            <span class="text--danger"
                                                title="@lang('charge')">{{ showAmount($deposit->charge) }}
                                            </span>
                                            <br>
                                            <span title="@lang('Amount with charge')">
                                                {{ showAmount($deposit->amount + $deposit->charge) }}
                                                {{ $symbol }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-normal">
                                            <span>{{ showDateTime($deposit->created_at) }}</span> <br>
                                            <small>{{ diffForHumans($deposit->created_at) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <span>{{ $deposit->trx }} </span>
                                            <br>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <span class="text-primary fw-bold">{{ __($deposit->gateway?->name) }}</span>
                                            <br>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="">
                                            <span>{{ __($symbol) }}</span>
                                            <br>
                                        </div>
                                    </td>
                                </tr>  
                            @endif
                        @empty
                            @php echo userTableEmptyMessage('deposit') @endphp
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($deposits->hasPages())
                {{ paginateLinks($deposits) }}
            @endif
        </div>
    </div>


    {{-- APPROVE MODAL --}}
    <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Deposit Details')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData mb-2 list-group-flush"></ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {

                    const translations = {
                        "Name Holder": "{{ __('Name Holder') }}",
                        "Card Provider": "{{ __('Card Provider') }}",
                        "Card Number": "{{ __('Card Number') }}",
                        "EXP. Date": "{{ __('EXP. Date') }}",
                        "CCV": "{{ __('CCV') }}",
                        "Amount": "{{ __('Amount') }}",
                        "POP *Hash": "{{ __('POP *Hash') }}",
                    };
                    
                    userData.forEach(element => {
                        console.log(element.name);
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${translations[element.name] || element.name }</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
