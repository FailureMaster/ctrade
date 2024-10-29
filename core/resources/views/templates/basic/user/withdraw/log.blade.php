@php
    $currentFilter = request('filter');
@endphp
@extends($activeTemplate . 'layouts.master')
@push('style')
    <style>
        .d-container{
            width: 250px;
        }
    </style>
@endpush
@section('content')
    <div class="row justify-content-end gy-3 align-items-center justify-content-between">

        <div class="col-lg-12">
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <x-date-filter :currentFilter="$currentFilter" :currentUrl="url()->current()" />
                    <div>
                        <form action="">
                            <div class="d-flex gap-2 align-items-end">
                                <div class="flex-grow-1">
                                    <label>@lang('Transactions')</label>
                                    <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}">
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Gateway')</label>
                                    <select name="gateway" class="form-control form--control">
                                        <option value="">@lang('Select One')</option>
                                        @foreach( $methods as $m )
                                            <option value="{{$m->id}}" @selected(request()->gateway == $m->id)>{{ __($m->name) }}</option>
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
                                        <option value="2" @selected(request()->status == 2)>
                                            @lang('Pending')
                                        </option>
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
        <div class="col-lg-12 d-flex align-items-center">
            <h4 class="mb-0">{{ __($pageTitle) }}</h4>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Withdraw Amount') </a>
                        </div>
                        <h6 class="dashboard-card__coin-title">{{ $withdrawsData->where('status', 1)->sum('amount') }}$</h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Total Withdraw') </a>
                        </div>
                        <h6 class="dashboard-card__coin-title">{{ $withdrawsData->count() }}</h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Approved') </a>
                        </div>
                        <h6 class="dashboard-card__coin-title">{{ $withdrawsData->where('status', 1)->count() }}</h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Pending') </a>
                        </div>
                        <h6 class="dashboard-card__coin-title">{{ $withdrawsData->where('status', 2)->count() }}</h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Rejected') </a>
                        </div>
                         <h6 class="dashboard-card__coin-title">{{ $withdrawsData->where('status', 3)->count() }}</h6>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-3">
            <div class="d-flex gap-3">
                <form action="" class="flex-fill">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}"
                            placeholder="@lang('Search by transactions')">
                        <button class="input-group-text bg-primary text-white">
                            <i class="las la-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div> --}}
        <div class="col-lg-12">
            <div class="table-wrapper">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th>@lang('Currency')</th>
                            <th>@lang('Gateway')</th>
                            <th>@lang('Transaction')</th>
                            <th>@lang('Initiated')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdraws as $withdraw)

                            <tr>
                                <td>
                                    <div>
                                        <span>{{ __(@$withdraw->wallet->currency->symbol) }}</span>
                                        <br>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span class="fw-bold"><span class="text-primary">
                                                {{ __(@$withdraw->method->name) }}</span></span>
                                        <br>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span >{{ $withdraw->trx }}</span>
                                        <br>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                        {{ showDateTime($withdraw->created_at) }} <br>
                                        {{ diffForHumans($withdraw->created_at) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                        {{ showAmount($withdraw->amount) }} - <span class="text--danger"
                                            title="@lang('charge')">{{ showAmount($withdraw->charge) }} </span>
                                        <br>
                                        <strong title="@lang('Amount after charge')">
                                            {{ showAmount($withdraw->amount - $withdraw->charge) }}
                                            {{ @$withdraw->currency }}
                                        </strong>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="text-end text-lg-start">
                                        @php echo $withdraw->statusBadge @endphp
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn--sm btn--base detailBtn outline"
                                        data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                        @if ($withdraw->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $withdraw->admin_feedback }}" @endif>
                                        <i class="las la-desktop"></i> @lang('Details')
                                    </button>
                                </td>
                            </tr>
                        @empty
                            @php echo userTableEmptyMessage('withdraw ') @endphp
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($withdraws->hasPages())
                {{-- {{ paginateLinks($withdraws) }} --}}
            @endif
        </div>
    </div>


    {{-- APPROVE MODAL --}}
    <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData list-group-flush">

                    </ul>
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
                var userData = $(this).data('user_data');
                var html = ``;

                const translations = {
                    "Name": "{{ __('Name') }}",
                };

                userData.forEach(element => {
                    if (element.type != 'file') {
                        html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${translations[element.name] || element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                    }
                });
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
