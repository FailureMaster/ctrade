@php
    $currentFilter = request('filter');
@endphp
@extends($activeTemplate . 'layouts.master')
@push('style')
    <style>
       .table thead tr th:last-child {
            text-align: left !important;
        }

        .d-container{
            width: 220px;
        }

        .d-container:first-child{
            margin-right: .5rem !important;
        }
    </style>
@endpush
@section('content')
    <div class="row justify-content-center gy-2">
        <div class="col-lg-12">
            {{-- <div class="show-filter mb-3 text-end">
                <button type="button" class="btn btn--base showFilterBtn btn--sm"><i class="las la-filter"></i>
                    @lang('Filter')</button>
            </div> --}}
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <x-date-filter :currentFilter="$currentFilter" :currentUrl="url()->current()" />
                    <div>
                        <form action="">
                            <div class="d-flex flex-wrap gap-4">
                                <div class="flex-grow-1">
                                    <label class="form-label">@lang('Order ID')</label>
                                    <input type="text" name="search" value="{{ request()->search }}"
                                        class="form-control form--control">
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label">@lang('Symbol')</label>
                                    <select name="symbol" class="form-select form--control">
                                        <option value="">@lang('All')</option>
                                        @foreach($currency as $c)
                                            <option value="{{ $c->id }}" @selected( $c->id == request()->symbol )>{{ $c->symbol }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label">@lang('Type')</label>
                                    <select name="trx_type" class="form-select form--control">
                                        <option value="">@lang('All')</option>
                                        <option value="{{Status::BUY_SIDE_ORDER}}" @selected(request()->trx_type == Status::BUY_SIDE_ORDER)>@lang('Buy')</option>
                                        <option value="{{Status::SELL_SIDE_ORDER}}" @selected(request()->trx_type == Status::SELL_SIDE_ORDER)>@lang('Sell')</option>
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
        <h4 class="mb-0">{{ __($pageTitle) }}</h4>
        <div class="col-lg-12 d-flex flex-wrap align-items-center">
           
            <div class="d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Total Orders') </a>
                        </div>
                        <h6 class="dashboard-card__coin-title">{{ $closed_orders->count()}}</h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('PL') </a>
                        </div>
                        <h6 class="dashboard-card__coin-title {{ getAmount($pl) >= 0 ? 'text-success' : 'text-danger' }}">  {{ number_format(getAmount($pl), 2, '.', '') }}$ </h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Sell') </a>
                        </div>
                        <h6 class="dashboard-card__coin-title {{ getAmount($closed_orders->where('order_side', Status::SELL_SIDE_ORDER)->sum('profit')) >= 0 ? 'text-success' : 'text-danger' }}"> {{ getAmount($closed_orders->where('order_side', Status::SELL_SIDE_ORDER)->sum('profit')) }}$ </h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Buy') </a>
                        </div>
                          <h6 class="dashboard-card__coin-title {{ getAmount($closed_orders->where('order_side', Status::BUY_SIDE_ORDER)->sum('profit')) >= 0 ? 'text-success' : 'text-danger' }}"> {{ getAmount($closed_orders->where('order_side', Status::BUY_SIDE_ORDER)->sum('profit')) }}$ </h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Profit') </a>
                        </div>
                        <h6 class="dashboard-card__coin-title {{ getAmount($total_profit) >= 0 ? 'text-success' : 'text-danger' }}"> {{ getAmount($total_profit) }}$ </h6>
                    </div>
                </div>
            </div>
            <div class="mx-2 d-container">
                <div class="dashboard-card skeleton">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dashboard-card__content">
                            <a class="dashboard-card__coin-name mb-0 ">
                                @lang('Lose') </a>
                        </div>
                        
                        <h6 class="dashboard-card__coin-title {{ getAmount($total_loss) >= 0 ? 'text-success' : 'text-danger' }}"> {{ getAmount($total_loss) }}$ </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="table-wrapper">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th>@lang('Order ID')</th>
                            <th>@lang('Open Date')</th>
                            <th>@lang('Close Date')</th>
                            <th>@lang('Symbol')</th>
                            <th>@lang('Type')</th>
                            <th>@lang('Volume')</th>
                            <th>@lang('Open Price')</th>
                            <th>@lang('Closed Price')</th>
                            <th>@lang('Stop Loss')</th>
                            <th>@lang('Take Profit')</th>
                            <th class="text-left">@lang('Profit')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                            @php
                                $decimalPlaces = countDecimal($trx->rate);
                            @endphp
                            <tr>
                                <td>
                                    <div class="text-end text-lg-start">
                                        <span>#{{ $trx->id }}</span>
                                        <br>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                        {{ $trx->formatted_date }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                        {{ $trx->close_date }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                        {{ $trx->pair->symbol }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                        {!! $trx->order_side_badge !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                        {{ $trx->no_of_lot }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                        {{ number_format((float) $trx->rate, 2, '.', '') }}
                                        {{-- @if( $decimalPlaces > 0 )
                                            {{ number_format((float) $trx->rate, $decimalPlaces, '.', '') }}
                                        @else
                                            {{ $trx->rate }}
                                        @endif --}}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                        {{ number_format((float) $trx->closed_price, 2, '.', '') }}
                                        {{-- @if( $decimalPlaces > 0 )
                                            {{ number_format((float) $trx->closed_price, $decimalPlaces, '.', '') }}
                                        @else
                                            {{ $trx->closed_price }}
                                        @endif --}}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                        {{ $trx->stop_loss ? number_format((float) $trx->stop_loss, 2, '.', '') ?: 0 : '-'; }}
                                        {{-- @if( $decimalPlaces > 0 )
                                            {{ number_format((float) $trx->stop_loss, $decimalPlaces, '.', '') }}
                                        @else
                                            {{ $trx->stop_loss }}
                                        @endif --}}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start" style="font-size: 0.8125rem">
                                        {{ $trx->take_profit ? number_format((float) $trx->take_profit, 2, '.', '') ?: 0 : '-'; }}
                                        {{-- @if( $decimalPlaces > 0 )
                                            {{ number_format((float) $trx->take_profit, $decimalPlaces, '.', '') }}
                                        @else
                                            {{ $trx->take_profit }}
                                        @endif --}}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end text-lg-start">
                                    <div class="text-end text-lg-start {{ $trx->profit < 1 ? 'text-danger' : 'text-success'}}">
                                        {{  number_format($trx->profit, 2) }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @php echo userTableEmptyMessage('transactions') @endphp
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                @if ($transactions->hasPages())
                    {{ paginateLinks($transactions) }}
                @endif 
            </div>
        </div>
    </div>
@endsection

