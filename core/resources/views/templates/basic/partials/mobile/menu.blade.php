@php    
    $uri = collect(request()->segments())->last();
@endphp
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/templates/basic/css/mobile.css') }}">
@endpush
<div class="mobile-navigator">
    <div class="bg-dark">
        <div>
            <ul class="d-flex justify-content-around nav nav-pills" id="pills-sm-tab-list" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="/trade/markets" class="nav-link m-markets d-flex flex-column {{ $uri === "markets" ? 'active' : '' }}" data-type="m-markets" >
                        <i class="fas fa-chart-line" id="m-markets"></i>
                        <label>@lang('Markets')</label>
                    </a>
                </li>
                <li class="nav-item" role="presentation" data-status="0">
                    <a class="nav-link m-portfolio d-flex flex-column" data-type="trade-btn-pill" data-bs-toggle="pill"
                        data-bs-target="#portfolio-sm" role="tab" aria-controls="pills-chartthree"
                        aria-selected="true">
                        <i class="fas fa-briefcase" id="trade-btn-pill"></i>
                        @lang('Trade')
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link m-closed d-flex flex-column {{ $uri === "closed_orders" ? 'active' : '' }}" data-type="m-closed" href="/trade/closed_orders">
                        <i class="fas fa-history" id="m-closed"></i>
                        @lang('Closed Orders')
                    </a>
                </li>
                <li class="nav-item" role="presentation" data-status="0">
                    <a class="nav-link m-portfolio d-flex flex-column {{ $uri === "dashboard" ? 'active' : '' }}" data-type="m-portfolio" href="/trade/dashboard">
                        <i class="fas fa-briefcase" id="m-portfolio"></i>
                        @lang('Dashboard')
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="/trade/menu" class="nav-link d-flex flex-column {{ $uri === "menu" ? 'active' : '' }}" data-type="m-menu">
                        <i class="fas fa-bars" id="m-menu"></i>
                        @lang('Menu')
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@push('style')
    <style>
        .mobile-navigator {
            position: fixed;
            bottom: 0;
            width: 100%;
            right: 0;
            z-index: 999;
        }

        .nav-pills .nav-link {
            padding: 20px 10px !important;
            border-radius: 0 !important;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            border-top: 4px solid yellow !important;
            background: transparent !important;
        }
    </style>
@endpush

@push('script')
 <script>
     function countDecimalPlaces(num) {
            // Convert the number to a string
            const numStr = num.toString();

            // Check if there is a decimal point
            const decimalIndex = numStr.indexOf('.');

            // If there's no decimal point, return 0
            if (decimalIndex === -1) {
                return 0;
            }

            // Calculate the number of decimal places
            const decimalPlaces = numStr.length - decimalIndex - 1;

            return decimalPlaces;
        }
 </script>
@endpush