<h2 class="h-title p-0 mb-0 border-0">@lang('Transactions Logs')</h2>
<h2 class="p-0 ch5"></h2>
<div class="portfolio-item">
    <div class="label p-0">@lang('Total Orders')</div>
    <div class="dots"></div>
    @auth
        @if ($closed_orders != null)
            <div class="value-box">{{ $closed_orders->count() }}</div>
        @else
            <div class="value-box">0</div>
        @endif
    @else
        <div class="value-box">00000</div>
    @endauth
</div>

<div class="portfolio-item">
    <div class="label">@lang('P/L')</div>
    <div class="dots"></div>
    @auth
        @if ($pl != null)
            <div class="value-box {{ getAmount($pl) >= 0 ? 'text-success' : 'text-danger' }}" id="">
                {{ number_format(getAmount($pl), 2, '.', '') }}$</div>
        @else
            <div class="value-box">-</div>
        @endif
    @else
        <div class="value-box" id="">00000</div>
    @endauth
</div>

<div class="portfolio-item">
    <div class="label">@lang('Sell')</div>
    <div class="dots"></div>
    @auth
        @if ( $closed_orders->count() > 0 )
            <div class="value-box {{ getAmount($closed_orders->where('order_side', Status::SELL_SIDE_ORDER)->sum('profit')) >= 0 ? 'text-success' : 'text-danger' }}"
                id="">
                {{ getAmount($closed_orders->where('order_side', Status::SELL_SIDE_ORDER)->sum('profit')) }}$</div>
        @else
            <div class="value-box">-</div>
        @endif
    @else
        <div class="value-box">00000</div>
    @endauth
</div>

<div class="portfolio-item">
    <div class="label">@lang('Buy')</div>
    <div class="dots"></div>
    @auth
        @if ( $closed_orders->count() > 0 )
            <div class="value-box {{ getAmount($closed_orders->where('order_side', Status::BUY_SIDE_ORDER)->sum('profit')) >= 0 ? 'text-success' : 'text-danger' }}"
                id="">
                {{ getAmount($closed_orders->where('order_side', Status::BUY_SIDE_ORDER)->sum('profit')) }}$</div>
        @else
            <div class="value-box">-</div>
        @endif
    @else
        <div class="value-box">00000</div>
    @endauth
</div>

<div class="portfolio-item">
    <div class="label">@lang('Profit')</div>
    <div class="dots"></div>
    @auth
        @if( $total_profit !== 0 )
            <div class="value-box {{ getAmount($total_profit) >= 0 ? 'text-success' : 'text-danger' }}" id="">{{ getAmount($total_profit) }}$</div>
        @else
            <div class="value-box">-</div>
    @endif
    @else
        <div class="value-box">00000</div>
    @endauth
</div>

<div class="portfolio-item">
    <div class="label">@lang('Lose')</div>
    <div class="dots"></div>
    @auth
        @if( $total_loss !== 0 )
            <div class="value-box {{ getAmount($total_loss) >= 0 ? 'text-success' : 'text-danger' }}" id="">{{ getAmount($total_loss) }}$</div>
        @else
            <div class="value-box">-</div>
        @endif
    @else
        <div class="value-box">00000</div>
    @endauth
</div>
<h2 class="mb-1 p-0 ch1"></h2>