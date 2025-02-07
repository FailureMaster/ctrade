@extends($activeTemplate . 'layouts.frontend')

@section('content')

<div class="summary-container pb-0">
    <h2 class="h-title p-0 mb-2 border-0">@lang('My Dashboard')</h2>
    <div class="portfolio-item">
        <div class="label p-0">@lang('Balance')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box {{ @$marketCurrencyWallet->balance < 0 ? 'text-danger' : 'text-success'}}">{{ showAmount(@$marketCurrencyWallet->balance) }} $</div>
        @else
            <div class="value-box">00000</div>
        @endauth
    </div>
    <div class="portfolio-item">
        <div class="label p-0">@lang('Open Orders')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ getAmount($widget['open_order']) }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
    <div class="portfolio-item">
        <div class="label p-0">@lang('P & L')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box {{ getAmount($widget['pl']) >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format(getAmount($widget['pl']), 2, '.', '')  }} $</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
    <div class="portfolio-item">
        <div class="label p-0">@lang('Closed Orders')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ getAmount($widget['closed_orders']) }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
    <div class="portfolio-item">
        <div class="label p-0">@lang('Total Deposit Amount')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box {{ $widget['total_deposit'] < 0 ? 'text-danger' : 'text-success'}}">{{ getAmount($widget['total_deposit']) }} $</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
    
    <div class="portfolio-item">
        <div class="label p-0">@lang('Total Deposits')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ $depositsData->count() }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
    <div class="portfolio-item">
        <div class="label p-0">@lang('Approved Deposits')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ $depositsData->where('status', 1)->count() }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
    <div class="portfolio-item">
        <div class="label p-0">@lang('Pending Deposits')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ $depositsData->where('status', 2)->count() }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
    <div class="portfolio-item">
        <div class="label p-0">@lang('Canceled Deposits')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ $depositsData->where('status', 3)->count() }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>

    <div class="portfolio-item">
        <div class="label p-0">@lang('Total withdraw Amount')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box {{ $widget['total_withdraw'] < 0 ? 'text-danger' : 'text-success'}}">{{ getAmount($widget['total_withdraw']) }} $</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>

    <div class="portfolio-item">
        <div class="label p-0">@lang('Total Withdraw')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ $withdrawsData->count() }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
    <div class="portfolio-item">
        <div class="label p-0">@lang('Approved withdraw')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ $withdrawsData->where('status', 1)->count() }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
    <div class="portfolio-item">
        <div class="label p-0">@lang('Pending withdraw')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ $withdrawsData->where('status', 2)->count() }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
    <div class="portfolio-item">
        <div class="label p-0">@lang('Canceled withdraw')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ $withdrawsData->where('status', 3)->count() }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>

    <div class="portfolio-item">
        <div class="label p-0">@lang('Pending Tickets')</div>
        <div class="dots"></div>
        @auth
            <div class="value-box">{{ getAmount($widget['open_tickets']) }}</div>
        @else
            <div class="value-box"></div>
        @endauth
    </div>
</div>


{{-- Menu --}}
@include($activeTemplate . 'partials.mobile.menu')
@endsection

@push('style')
    <style>
        .dashboard-card{
            padding: 20px 18px;
            background-color: hsl(var(--white) / 0.03);
            border-radius: 6px;
            transition: 0.2s linear;
        }

        .dashboard-fluid .dashboard-body .dashboard-card__coin-name {
            font-size: 12px !important;
            margin-bottom: 10px;
        }

        .dashboard-fluid .dashboard-body .dashboard-card__coin-title {
            font-size: 24px;
            margin-bottom: 0px;
        }

        span.dashboard-card__icon i {
            font-size: 45px;
            color: hsl(49 69% 45%) !important;
        }

        #tblPortfolio td{
            padding-right: 0 !important;
            padding-left: 0 !important;
        }

        .ch5-portfolio{
            border-bottom: 1px solid #3c4a54;
        }

        .label, .value-box, .c-icon, .portfolio-item, #tblPortfolio td, #tblPortfolio tr, #tblPortfolio{
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            font-size: 16px;
        }

        #tblPortfolio .clickable-row{
            border-bottom:1px solid #3c4a54 !important;
        }

        .portfolio-item {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 1rem;
            color: #ffffff;
        }

        .portfolio-item .label, 
        .portfolio-item .value {
            padding: 0 5px;
            position: relative;
            z-index: 1;
        } 

        .dots {
            flex-grow: 1;
            height: 8px;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.2) 1px, transparent 4px);
            background-size: 10px;
            opacity: 0.2;
            margin: 0 20px;
        }

        .label{
            font-size: 16px;
            color: white;
        }
    </style>

    @if (App::getLocale() == 'ar')
        <style>
           .portfolio-item {
                flex-flow: row-reverse;
            }
        </style>
    @endif
@endpush