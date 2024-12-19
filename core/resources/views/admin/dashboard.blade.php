@extends('admin.layouts.app')
@section('panel')


@if(can_access('manage-users'))
<div class="row mb-none-30 mb-3 align-items-center gy-4">
    <div class="col-xxl-{{ auth('admin')->user()->group->id != 37 ? 3 : 6 }} col-sm-6">
        <x-widget style="2" link="{{ route('admin.users.all', ['filter' => 'this_month']) }}" icon="las la-users " icon_style="false"
            title="Total Lead" value="{{$widget['total_users']}}" color="primary" />
    </div><!-- dashboard-w1 end -->
    <div class="col-xxl-{{ auth('admin')->user()->group->id != 37 ? 3 : 6 }} col-sm-6">
        <x-widget style="2" link="{{route('admin.users.active', ['filter' => 'this_month'])}}" icon="las la-user-check "
            title="Active Users" icon_style="false" value="{{$widget['verified_users']}}" color="success" />
    </div>
    @if(auth('admin')->user()->group->id != 37)
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" link="{{route('admin.users.email.unverified', ['filter' => 'this_month'])}}" icon="lar la-envelope "
                icon_style="false" title="Email Unverified Users" value="{{$widget['email_unverified_users']}}"
                color="danger" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" icon_style="false" link="{{route('admin.users.mobile.unverified', ['filter' => 'this_month'])}}"
                icon="las la-comment-slash " title="Mobile Unverified Users"
                value="{{$widget['mobile_unverified_users']}}" color="red" />
        </div>
    @endif
</div>
@endif

@if(can_access('manage-order|manage-currency'))
<div class="row mb-none-30 mb-3 align-items-center gy-4">
  
    @if(can_access('manage-currency'))
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.deposit.list', ['filter' => 'this_month'])}}" icon="las la-list-alt" icon_style="false"
            title="Total Deposits" value="${{ showAmount($widget['deposit']['total_deposits']) ?? 0 }}" color="primary" />
    </div><!-- dashboard-w1 end -->
    @endif
    @if(can_access('manage-currency'))
    <div class="col-xxl-3 col-sm-6">
        <x-widget style="2" link="{{route('admin.order.open', ['filter' => 'this_month'])}}" icon="fa  fa-spinner" icon_style="false"
            title="Open Orders" value="{{$widget['order_count']['open']}}" color="info" />
    </div>
    <!-- dashboard-w1 end -->
    @endif
    @if(can_access('manage-currency'))
    <div class="col-xxl-3 col-sm-6">
       <x-widget style="2" link="{{route('admin.order.close', ['filter' => 'this_month'])}}&status={{Status::ORDER_CANCELED}}"
                icon="las la-times-circle" icon_style="false" title="Close Orders"
                value="{{$widget['order_count']['canceled']}}" color="danger" />
    </div>
    <!-- dashboard-w1 end -->
    @endif

    <div class="col-xxl-3 col-sm-6">
       <x-widget style="2" link="{{ route('admin.notifications') }}"
                icon="las la-bell" icon_style="false" title="Notifications"
                value="{{$notification_count}}" color="warning" />

    </div>
</div>
@endif

@if(can_access('deposits|withdraw'))
<div class="row mb-none-30 align-items-center my-4">
    @if(can_access('deposits'))
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <span>@lang('Deposit Summary')</span>
                    <br>
                </div>
                <div class="cadr-body table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">@lang('Currency')</th>
                                <th class="text-center">@lang('Name')</th>
                                <th class="text-center">@lang('Lead id')</th>
                                <th class="text-center">@lang('Date ')| <small>@lang('MM/DD/YY (time)')</small></th>
                                <th class="text-center">@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deposits as $deposit)
                            
                                <tr>
                                    <td class="text-center">{{@$deposit->symbol}}</td>
                                    <td class="text-center">{{ucfirst( $deposit->firstname) ." ". ucfirst($deposit->lastname)}}</td>
                                    <td class="text-center">{{@$deposit->lead_code}}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($deposit->created_at)->format('M j, Y (g:ia)') }}</td>
                                    <td class="text-center">{{ showAmount($deposit->amount)}}</td>
                                </tr>
                            @empty
                                <td class="list-group-item text-center text-muted">
                                    {{ __($emptyMessage) }}
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                
                </div>
            </div>
        </div>
    @endif
    @if(can_access('withdraw'))
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <span>@lang('Withdraw Summary')</span>
                </div>
                <div class="cadr-body table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">@lang('Currency')</th>
                                <th class="text-center">@lang('Name')</th>
                                <th class="text-center">@lang('Lead id')</th>
                                <th class="text-center">@lang('Date ')| <small>@lang('MM/DD/YY (time)')</small></th>
                                <th class="text-center">@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($withdrawals as $withdraw)
                            {{-- @dd($withdraw) --}}
                                <tr>
                                    <td class="text-center">{{@$withdraw->symbol}}</td>
                                    <td class="text-center">{{ucfirst( $withdraw->firstname) ." ". ucfirst($withdraw->lastname)}}</td>
                                    <td class="text-center">{{@$withdraw->lead_code}}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($withdraw->created_at)->format('M j, Y (g:ia)') }}</td>
                                    <td class="text-center">{{ showAmount($withdraw->amount)}}</td>
                                </tr>
                            @empty
                                <td class="list-group-item text-center text-muted">
                                    {{ __($emptyMessage) }}
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endif

@if(can_access('manage-order'))
<div class="row mb-none-30 mb-4 gy-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <span>@lang('Order Summary')</span>
                <br>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="order-list">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex flex-wrap gap-2 align-items-center justify-content-between pt-0">
                                    <span>@lang('Symbol')</span>
                                    <span class="text-start">@lang('Amount')</span>
                                </li>
                                @forelse ($widget['order']['list'] as $order)
                                <li
                                    class="list-group-item d-flex flex-wrap gap-2 align-items-center mb-2 justify-content-between">
                                    <span>{{ @$order->pair->symbol }}</span>
                                    <span class="text-start">
                                        {{ showAmount($order->total_amount)}} {{ @$order->pair->coin->symbol }}
                                    </span>
                                </li>
                                @empty
                                <li class="list-group-item text-center text-muted">
                                    {{ __($emptyMessage) }}
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex ">
                            <div class="w-100">
                                <canvas id="pair-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(can_access('report'))
<div class="row mb-none-30">
    <div class="col-xl-4 col-lg-6 mb-30">
        <div class="card d-flex flex-column align-items-center justify-content-center pt-4">
            {{-- <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5> --}}
            <h5 class="card-title">@lang('Login By Browser') (@lang('Current Month'))</h5>
            <div class="card-body">
                <canvas id="userBrowserChart" class="" style="font-size: 50px !important"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 mb-30">
        <div class="card d-flex flex-column align-items-center justify-content-center pt-4">
            {{-- <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5> --}}
            <h5 class="card-title">@lang('Login By Browser') (@lang('Current Month'))</h5>
            <div class="card-body">
                <canvas id="userOsChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 mb-30">
        <div class="card d-flex flex-column align-items-center justify-content-center pt-4">
            {{-- <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5> --}}
            <h5 class="card-title">@lang('Login By Browser') (@lang('Current Month'))</h5>
            <div class="card-body">
                <canvas id="userCountryChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endif

@php
$lastCron = Carbon\Carbon::parse($general->last_cron)->diffInSeconds();
@endphp

@if ($lastCron >= 900)
<!-- @include('admin.partials.cron_instruction') -->
@endif

@endsection

@push('script')
{{-- <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script> --}}
<script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>

<script>
    "use strict";

    $(".order-list").scroll(function () {
        if ((parseInt($(this)[0].scrollHeight) - parseInt(this.clientHeight)) == parseInt($(this).scrollTop())) {
            loadOrderList();
        }
    });

    let orderSkip = 6;
    let take = 20;
    function loadOrderList() {
        $.ajax({
            url: "{{ route('admin.load.data') }}",
            type: "GET",
            dataType: 'json',
            cache: false,
            data: {
                model_name: "Order",
                skip: orderSkip,
                take: take
            },
            success: function (resp) {
                if (!resp.success) {
                    return false;
                }
                orderSkip += parseInt(take);
                let html = "";
                $.each(resp.data, function (i, order) {
                    html += `
                    <li class="list-group-item d-flex flex-wrap gap-2 align-items-center mb-2 justify-content-between">
                        <span>${order.pair.symbol}</span>
                            <span class="text-start">
                            ${getAmount(order.total_amount)} ${order.pair.coin.symbol}
                        </span>
                    </li>
                    `;
                });
                $('.order-list ul').append(html);
            }
        });
    };

    $(".deposit-list").scroll(function () {
        if ((parseInt($(this)[0].scrollHeight) - parseInt(this.clientHeight)) == parseInt($(this).scrollTop())) {
            loadDepositList();
        }
    });

    let depositSkip = 6;
    function loadDepositList() {
        $.ajax({
            url: "{{ route('admin.load.data') }}",
            type: "GET",
            dataType: 'json',
            cache: false,
            data: {
                model_name: "Deposit",
                skip: depositSkip,
                take: take
            },
            success: function (resp) {
                if (!resp.success) {
                    return false;
                }
                depositSkip += parseInt(take);
                let html = "";
                $.each(resp.data, function (i, deposit) {
                    html += `
                    <li class="list-group-item d-flex flex-wrap gap-2 align-items-center mb-2 justify-content-between">
                        <div class="flex-fill text-start">
                            <div class="user">
                                <div class="thumb">
                                    <img src="${deposit.currency.image_url}">
                                </div>
                                <div class="text-start ms-1">
                                    <small>${deposit.currency.symbol}</small> <br>
                                    <small>${deposit.currency.name}</small>
                                </div>
                            </div>
                        </div>
                        <span class="flex-fill text-center">${getAmount(deposit.total_amount)}</span>
                        <span class="flex-fill text-center">${getAmount(parseFloat(deposit.total_amount) * parseFloat(deposit.currency.rate))}</span>
                    </li>
                    `;
                });
                $('.deposit-list').append(html);
            }
        });
    };

    $(".withdraw-list").scroll(function () {
        if ((parseInt($(this)[0].scrollHeight) - parseInt(this.clientHeight)) == parseInt($(this).scrollTop())) {
            loadWithdrawList();
        }
    });

    let withdrawSkip = 6;
    function loadWithdrawList() {
        $.ajax({
            url: "{{ route('admin.load.data') }}",
            type: "GET",
            dataType: 'json',
            cache: false,
            data: {
                model_name: "Withdrawal",
                skip: withdrawSkip,
                take: take
            },
            success: function (resp) {
                if (!resp.success) {
                    return false;
                }
                withdrawSkip += parseInt(take);
                let html = "";
                $.each(resp.data, function (i, withdraw) {
                    html += `
                    <li class="list-group-item d-flex flex-wrap gap-2 align-items-center mb-2 justify-content-between">
                        <div class="flex-fill text-start">
                            <div class="user">
                                <div class="thumb">
                                    <img src="${withdraw.withdraw_currency.image_url}">
                                </div>
                                <div class="text-start ms-1">
                                    <small>${withdraw.withdraw_currency.symbol}</small> <br>
                                    <small>${withdraw.withdraw_currency.name}</small>
                                </div>
                            </div>
                        </div>
                        <span class="flex-fill text-center">${getAmount(withdraw.total_amount)}</span>
                        <span class="flex-fill text-center">${getAmount(parseFloat(withdraw.total_amount) * parseFloat(withdraw.withdraw_currency.rate))}</span>
                    </li>
                    `;
                });
                $('.withdraw-list').append(html);
            }
        });
    };
    // var ctx = document.getElementById('deposit-chart');
    // var myChart = new Chart(ctx, {
    //     type: 'bar',
    //     data: {
    //         labels: @json($widget['deposit']['currency_symbol']),
    //         datasets: [{
    //             data: @json($widget['deposit']['currency_count']),
    //             backgroundColor: [
    //                 '#ff7675',
    //                 '#6c5ce7',
    //                 '#ffa62b',
    //                 '#ffeaa7',
    //                 '#D980FA',
    //                 '#fccbcb',
    //                 '#45aaf2',
    //                 '#05dfd7',
    //                 '#FF00F6',
    //                 '#1e90ff',
    //                 '#2ed573',
    //                 '#eccc68',
    //                 '#ff5200',
    //                 '#cd84f1',
    //                 '#7efff5',
    //                 '#7158e2',
    //                 '#fff200',
    //                 '#ff9ff3',
    //                 '#08ffc8',
    //                 '#3742fa',
    //                 '#1089ff',
    //                 '#70FF61',
    //                 '#bf9fee',
    //                 '#574b90'
    //             ],
    //             borderColor: [
    //                 'rgba(231, 80, 90, 0.75)'
    //             ],
    //             borderWidth: 0,
    //         }]
    //     },
    //     options: {
    //         aspectRatio: 1.3,
    //         responsive: true,
    //         elements: {
    //             line: {
    //                 tension: 0 // disables bezier curves
    //             }
    //         },
    //         scales: {
    //             xAxes: [{
    //                 display: false
    //             }],
    //             yAxes: [{
    //                 display: false
    //             }]
    //         },
    //         legend: {
    //             display: false,
    //         }
    //     }
    // });

    // var ctx = document.getElementById('withdraw');
    // var myChart = new Chart(ctx, {
    //     type: 'bar',
    //     data: {
    //         labels: @json(@$widget['withdraw']['currency_symbol']),
    //         datasets: [{
    //             data: @json(@$widget['withdraw']['currency_count']),
    //             backgroundColor: [
    //                 '#ff7675',
    //                 '#6c5ce7',
    //                 '#ffa62b',
    //                 '#ffeaa7',
    //                 '#D980FA',
    //                 '#fccbcb',
    //                 '#45aaf2',
    //                 '#05dfd7',
    //                 '#FF00F6',
    //                 '#1e90ff',
    //                 '#2ed573',
    //                 '#eccc68',
    //                 '#ff5200',
    //                 '#cd84f1',
    //                 '#7efff5',
    //                 '#7158e2',
    //                 '#fff200',
    //                 '#ff9ff3',
    //                 '#08ffc8',
    //                 '#3742fa',
    //                 '#1089ff',
    //                 '#70FF61',
    //                 '#bf9fee',
    //                 '#574b90'
    //             ],
    //             borderColor: [
    //                 'rgba(231, 80, 90, 0.75)'
    //             ],
    //             borderWidth: 0,
    //         }]
    //     },
    //     options: {
    //         aspectRatio: 1.3,
    //         responsive: true,
    //         elements: {
    //             line: {
    //                 tension: 0 // disables bezier curves
    //             }
    //         },
    //         scales: {
    //             xAxes: [{
    //                 display: false
    //             }],
    //             yAxes: [{
    //                 display: false
    //             }]
    //         },
    //         legend: {
    //             display: false,
    //         }
    //     }
    // });

    var ctx = document.getElementById('pair-chart');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($widget['order']['symbol']),
            datasets: [{
                data: @json($widget['order']['count']),
                backgroundColor: [
                    '#ff7675',
                    '#6c5ce7',
                    '#ffa62b',
                    '#ffeaa7',
                    '#D980FA',
                    '#fccbcb',
                    '#45aaf2',
                    '#05dfd7',
                    '#FF00F6',
                    '#1e90ff',
                    '#2ed573',
                    '#eccc68',
                    '#ff5200',
                    '#cd84f1',
                    '#7efff5',
                    '#7158e2',
                    '#fff200',
                    '#ff9ff3',
                    '#08ffc8',
                    '#3742fa',
                    '#1089ff',
                    '#70FF61',
                    '#bf9fee',
                    '#574b90'
                ],
                borderColor: [
                    'rgba(231, 80, 90, 0.75)'
                ],
                borderWidth: 0,
            }]
        },
        options: {
            aspectRatio: 1.2,
            responsive: true,
            elements: {
                line: {
                    tension: 0 // disables bezier curves
                }
            },
            scales: {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }]
            },
            legend: {
                display: false,
            }
        }
    });


    var ctx = document.getElementById('userBrowserChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chart['user_browser_counter'] -> keys()),
            datasets: [{
                data: {{ $chart['user_browser_counter']-> flatten() }},
                backgroundColor: [
                    '#ff7675',
                    '#6c5ce7',
                    '#ffa62b',
                    '#ffeaa7',
                    '#D980FA',
                    '#fccbcb',
                    '#45aaf2',
                    '#05dfd7',
                    '#FF00F6',
                    '#1e90ff',
                    '#2ed573',
                    '#eccc68',
                    '#ff5200',
                    '#cd84f1',
                    '#7efff5',
                    '#7158e2',
                    '#fff200',
                    '#ff9ff3',
                    '#08ffc8',
                    '#3742fa',
                    '#1089ff',
                    '#70FF61',
                    '#bf9fee',
                    '#574b90'
                ],
                borderColor: [
                    'rgba(231, 80, 90, 0.75)'
                ],
                borderWidth: 0,

            }]
        },
        options: {
            aspectRatio: 1.3,
                responsive: true,
                    maintainAspectRatio: true,
                        elements: {
                line: {
                    tension: 0 // disables bezier curves
                }
            },
            scales: {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }]
            },
            legend: {
                display: false,
            }
        }
    });

    var ctx = document.getElementById('userOsChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chart['user_os_counter'] -> keys()),
            datasets: [{
                data: {{ $chart['user_os_counter']-> flatten() }},
                backgroundColor: [
                    '#ff7675',
                    '#6c5ce7',
                    '#ffa62b',
                    '#ffeaa7',
                    '#D980FA',
                    '#fccbcb',
                    '#45aaf2',
                    '#05dfd7',
                    '#FF00F6',
                    '#1e90ff',
                    '#2ed573',
                    '#eccc68',
                    '#ff5200',
                    '#cd84f1',
                    '#7efff5',
                    '#7158e2',
                    '#fff200',
                    '#ff9ff3',
                    '#08ffc8',
                    '#3742fa',
                    '#1089ff',
                    '#70FF61',
                    '#bf9fee',
                    '#574b90'
                ],
                borderColor: [
                    'rgba(0, 0, 0, 0.05)'
                ],
                borderWidth: 0,

            }]
        },
        options: {
            aspectRatio: 1.3,
                responsive: true,
                    elements: {
                line: {
                    tension: 0 // disables bezier curves
                }
            },
            scales: {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }]
            },
            legend: {
                display: false,
                }
        },
    });

    // Donut chart
    var ctx = document.getElementById('userCountryChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chart['user_country_counter'] -> keys()),
            datasets: [{
                data: {{ $chart['user_country_counter']-> flatten() }},
                backgroundColor: [
                    '#ff7675',
                    '#6c5ce7',
                    '#ffa62b',
                    '#ffeaa7',
                    '#D980FA',
                    '#fccbcb',
                    '#45aaf2',
                    '#05dfd7',
                    '#FF00F6',
                    '#1e90ff',
                    '#2ed573',
                    '#eccc68',
                    '#ff5200',
                    '#cd84f1',
                    '#7efff5',
                    '#7158e2',
                    '#fff200',
                    '#ff9ff3',
                    '#08ffc8',
                    '#3742fa',
                    '#1089ff',
                    '#70FF61',
                    '#bf9fee',
                    '#574b90'
                ],
                borderColor: [
                    'rgba(231, 80, 90, 0.75)'
                ],
                borderWidth: 0,

            }]
        },
        options: {
            aspectRatio: 1.3,
                responsive: true,
                    elements: {
                line: {
                    tension: 0 // disables bezier curves
                }
            },
            scales: {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }]
            },
            legend: {
                display: false,
            }
        }
    });

</script>
@endpush


@push('style')
<style>
    .user .thumb {
        width: 35px;
        height: 35px;
    }

    .list-group-item {

        border: 1px solid rgba(0, 0, 0, .045);
    }

    #deposit-chart {
        margin-left: -20px;
    }

    .order-list,
    .deposit-list,
    .withdraw-list {
        max-height: 300px;
        overflow-y: auto;
        margin-bottom: 1.5rem;
    }

    canvas{
        width: auto !important ;
        height: 250px !important
    }

    .table-container {
    height: 300px; /* Adjust height as needed */
    overflow-y: auto; /* For vertical scrolling */
    overflow-x: auto; /* For horizontal scrolling */
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
}

.table {
    width: 100%; /* Make sure the table takes the full width of the container */
    border-collapse: collapse; /* Optional: improves the appearance of table borders */
}

.table td, .table th {
    font-size: 0.8125rem;
    color: #5b6e88;
    text-align: center;
    font-weight: 500;
    padding: 10px;
    vertical-align: middle;
    white-space: nowrap; /* Prevents wrapping in cells */
}

.table td {
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;
}

.table th, .table td {
    max-width: 200px; /* Adjust as necessary */
    overflow: hidden; /* Hide overflowed text */
    text-overflow: ellipsis; /* Show ellipsis for overflowed text */
}

@media (max-width: 768px) {
    .table-container {
        height: auto; /* Adjust height for smaller screens if needed */
    }
}

.widget-two__icon {
    width: unset;
    height: unset;
}

.widget-two__content{
    display:flex;
    align-items: center;
}

.widget-two__icon i {
    font-size: 25px;
}

.widget-two{
    padding:10px;
}

.widget-two__btn{
    z-index: 999;
}
</style>
@endpush