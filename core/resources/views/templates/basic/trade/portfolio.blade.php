@php
    $meta           = (object) $meta;
    $widget         = @$meta->widget;
@endphp

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
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.2) 1px, transparent 4px); /* Tiny 1px circles with 4px padding */
            background-size: 10px; /* 5px horizontal spacing between circles */
            opacity: 0.2;
            margin: 0 20px; /* Space around the entire .dots element */
        }
    </style>
@endpush

<div class="trading-table__mobile" style="margin-top: 0px;margin-bottom:80px;">
    {{-- <div class="summary-container">
        <div class="d-flex justify-content-between">
            <h2 class="h-title p-0 mb-0 border-0">My Dashboard</h2>
        </div>

        <h2 class="p-0 ch5 ch5-portfolio"></h2>

        <table id="tblPortfolio" style="display: inline-table;">
            <tbody class="portf-body">
                <tr class="clickable-row">
                    <td>@lang('Open Orders')</td>
                    <td>{{ getAmount($widget['open_order']) }}</td>
                </tr>
                <tr class="clickable-row">
                    <td>@lang('Closed Orders')</td>
                    <td>{{ getAmount($widget['closed_orders']) }}</td>
                </tr>
                <tr class="clickable-row">
                    <td>@lang('P & L')</td>
                    <td class="{{ getAmount($widget['pl']) >= 0 ? 'text-success' : 'text-danger' }}">{{ getAmount($widget['pl']) }} $ </td>
                </tr>
                <tr class="clickable-row">
                    <td>@lang('Total Deposit')</td>
                    <td>{{ getAmount($widget['total_deposit']) }}</td>
                </tr>
                <tr class="clickable-row">
                    <td>@lang('Total withdraw')</td>
                    <td>{{ getAmount($widget['total_withdraw']) }}</td>
                </tr>
                <tr class="clickable-row">
                    <td>@lang('Pending Tickets')</td>
                    <td>{{ getAmount($widget['open_tickets']) }}</td>
                </tr>
            </tbody>
        </table>
    </div> --}}

    <div class="summary-container pb-0">
        <h2 class="h-title p-0 mb-0 border-0">@lang('My Dashboard')</h2>
        <h2 class="p-0 ch5"></h2>
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
            <div class="label p-0">@lang('Total Deposit')</div>
            <div class="dots"></div>
            @auth
                <div class="value-box">{{ getAmount($widget['total_deposit']) }} $</div>
            @else
                <div class="value-box"></div>
            @endauth
        </div>
        <div class="portfolio-item">
            <div class="label p-0">@lang('Total withdraw')</div>
            <div class="dots"></div>
            @auth
                <div class="value-box">{{ getAmount($widget['total_withdraw']) }} $</div>
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
</div>


