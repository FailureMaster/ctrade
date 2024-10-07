@php
    $currentFilter = request('filter');
@endphp
@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card responsive-filter-card mb-4">
            <div class="card-body">
                <x-date-filter :currentFilter="$currentFilter" :currentUrl="url()->current()" />
                <div>
                    <form action="{{ url()->current() }}">
                        @foreach (request()->query() as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <div class="d-flex gap-2">
                            <div class="flex-grow-1">
                                <label>@lang('ID')</label>
                                <input type="number" name="lead_code" value="{{ request()->lead_code }}" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Name')</label>
                                <input type="text" name="name" value="{{ request()->name }}" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('email')</label>
                                <input type="text" name="email" value="{{ request()->email }}" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('mobile')</label>
                                <input type="number" name="mobile" value="{{ request()->mobile }}" class="form-control">
                            </div>

                            <div class="flex-grow-1">
                                <label>@lang('Country')</label>
                                <select name="country_code" class="form-control">
                                    <option value="">@lang('Select One')</option>
                                    @foreach ($filteredCountries as $code => $country)
                                        <option value="{{ $code }}" @selected(request()->country_code == $code)>
                                            {{ __(keyToTitle($country['country']))}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45" data-bs-placement="top" title="Search">
                                    <i class="la la-search"></i>
                                </button>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <a href="{{route('admin.users.active', ['filter' => 'this_month'])}}" class="btn btn--secondary w-100 h-45 d-flex align-items-center" data-bs-placement="top" title="Clear Search">
                                    <i class="la la-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <div class="d-flex align-items-center p-3">
                        <small>
                            @if ($users->firstItem())
                                <strong>{{ $users->firstItem() }} - {{ $users->lastItem() }} of {{ $users->total() }}</strong>
                                
                            @endif
                        </small>
                        @if (can_access('bulk-update-leads'))
                            <div class="dropdown mx-2 bulk-action">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Selected Leads: 
                                    <span class="selected-leads-count text-white"></span>
                                </button>
                                <ul class="dropdown-menu px-2" style="width: 220px">
                                    <li>
                                        <div>
                                            <label>@lang('Owner')</label>
                                            <select class="owner_id w-100">
                                                <option value="">@lang('Select One')</option>
                                                @foreach ($admins as $admin)
                                                    <option value="{{ $admin->id }}">
                                                        {{ __(keyToTitle($admin->name)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <label>@lang('Status')</label>
                                            <select class="sales_status w-100">
                                                <option value="">@lang('Select One')</option>
                                                @foreach ($salesStatuses as $status)
                                                    <option value="{{ $status->name }}">
                                                        {{ __(keyToTitle($status->name)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </li>
                                    @if (can_access('change-user-type'))
                                        <li>
                                            <div>
                                                <label>@lang('Account Type')</label>
                                                <select class="account_type w-100">
                                                    <option value="">@lang('Select One')</option>
                                                    <option value="demo">
                                                        Demo
                                                    </option>
                                                    <option value="real">
                                                        Real
                                                    </option>
                                                </select>
                                            </div>
                                        </li>
                                    @endif
                                    <li>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-primary w-100" id="submitBtn">Submit</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endif

                        

                        @if (can_access('delete-user'))
                            <button class="btn btn-danger btn-md ms-2 delete-action">
                                Delete: 
                                <span class="selected-leads-count text-white"></span>
                            </button>
                        @endif
                    </div>
                    <table class="table table--light style--two highlighted-table">
                        <thead>
                            <tr>
                                <!--<th>Star</th>-->
                                <th class="text-center">ID</th>
                        
                                <th>@lang('First Name')</th>
                                <th>@lang('Last Name')</th>
                                <th>@lang('Phone')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Country')</th>
                                <th>@lang('Registered')</th>
                                <th class="text-center">@lang('Margin Level')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="hidden" name="user_id" id="userIds" value="{{json_encode($users->pluck('id')->toArray())}}">
                            @forelse($users as $user)
                                <tr>
                                    <td class="text-center">
                                        <span class="fw-bold">
                                            @php
                                                $parsed_url = parse_url(url()->full());
                                                $pathParts = explode('/', $parsed_url['path']);
                                                $lastPathPart = end($pathParts);

                                                $filters = isset(parse_url(url()->full())['query']) ? parse_url(url()->full())['query'] : '';
                                            

                                            @endphp
                                            <a href="{{ route('admin.users.detail', $user->id).'?'. $filters."&account_type=".$lastPathPart}}">
                                                {{ $user->lead_code ?? $user->id }}
                                            </a>
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <span class="fw-bold">{{$user->firstname}}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{$user->lastname}}</span>
                                    </td>
                                    <td>
                                        <span class="d-block"></span>
                                        {{ $user->mobile }}
                                    </td>
                                    <td>
                                        <span class="d-block">
                                            {{ $user->email }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold" title="{{ @$user->address->country }}">
                                            {{ $user->country_code }}
                                        </span>
                                        <img src="https://flagcdn.com/24x18/{{ Illuminate\Support\Str::lower($user->country_code) }}.png" width="12" height="12">
                                    </td>
                            
                                    <td>
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d-m-y - H:i')}}

                                            {{-- showDateTime($user->created_at, 'd-m-y - H:i') }}  --}}
                                    </td>
    
                                    <td class="text-center margin-level{{$user->id}}" >
                                        0.0000
                                    </td>
                                
                                </tr>
                              
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($users->hasPages())
                <div class="card-footer py-4">
                    <div>
                        <small>
                            @if ($users->firstItem())
                                <strong>{{ $users->firstItem() }} - {{ $users->lastItem() }} of {{ $users->total() }}</strong>
                                
                            @endif
                        </small>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        {{ paginateLinks($users) }}
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center gap-2">
                           {{-- {{dd(parse_url(url()->full()));}} --}}
                            @foreach (request()->query() as $key => $value)
                                @if ($key !== 'per_page')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <span for="per_page" class="per_page_span" style="font-size: 12px">View</span>
                            <select name="per_page" id="per_page" onchange="this.form.submit()" style="font-size: 14px !important; padding: 0">
                                <option value="5" {{ $perPage == 5 ? 'selected' : '' }} style="font-size: 14px !important; padding: 0">5</option>
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }} style="font-size: 14px important; padding: 0">10</option>
                                <option value="25" {{ $perPage == 25 ? 'selected' : '' }} style="font-size: 14px important; padding: 0">25</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }} style="font-size: 14px important; padding: 0">50</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }} style="font-size: 14px important; padding: 0">100</option>
                            </select>
                            <span for="per_page" class="me-2 per_page_span" style="font-size: 12px">Per Page</span>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            let equity = 0;
            let pl = 0;
            let total_open_order_profit = 0;
            let free_margin = 0;
            let total_amount = 0;
            let total_used_margin = 0;
            let margin_level = 0;
        
            $('.bal-btn').click(function () {
                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);
                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });

            let mobileElement = $('.mobile-code');

            $('select[name=country]').change(function () {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

            $('select[name=country]').val('{{@$user->country_code}}');

            let dialCode = $('select[name=country] :selected').data('mobile_code');
            let mobileNumber = `{{ $user->mobile }}`;

            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);

            $('select[name=wallet]').on('change', function (e) {
                let symbol = $(this).find('option:selected').data('symbol');
                $(`.wallet-cur-symbol`).text(symbol);
            });

            $('.select2').select2({
                dropdownParent: $(`.position-relative`)
            });

            function generateOrderRow(order, jsonData) {
                // let current_price = jsonData[order.pair.symbol]
                let current_price = jsonData[order.pair.symbol].replace(/,/g, '')
            
                current_price = parseFloat(current_price);
                if (order.pair.symbol === 'GOLD') {
                    if (parseInt(order.order_side) === 2) {
                        current_price = (current_price * order.pair.spread) + current_price;
                    }
                    current_price = current_price.toFixed(2);
                } else {
                    if (parseInt(order.order_side) === 2) {
                        current_price = (current_price * order.pair.spread) + current_price;
                    }
                    current_price = formatWithPrecision(current_price); 
                }
                let lotValue = order.pair.percent_charge_for_buy;

                
                let lotEquivalent = parseFloat(lotValue) * parseFloat(order.no_of_lot);
                let total_price = parseInt(order.order_side) === 2
                    ? formatWithPrecision(((parseFloat(order.rate) - parseFloat(current_price)) * lotEquivalent))
                    : formatWithPrecision(((parseFloat(current_price) - parseFloat(order.rate)) * lotEquivalent));
                total_open_order_profit = parseFloat(total_open_order_profit) + parseFloat(total_price);
                total_amount = parseFloat(total_amount) + parseFloat(formatWithPrecision1(order.amount));
            }

            function fetchOrderHistory() {
                let actionUrl = "{{ route('trade.order.marginlevel', ['pairSym' => @$pair->symbol ?? 'default_symbol', 'status' => 0 ]) }}";
                $.ajax({
                    url: actionUrl,
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    data: {user_ids:$('#userIds').val()},
                    success: function(resp) {
                        
                        resp.users.forEach(user => {
                            let html = '';
                            let initial_equity = Number(user.custom_wallets.balance) + Number(user.custom_wallets.bonus) + Number(user.custom_wallets.credit);
                            equity = 0;
                            pl = 0;
                            total_open_order_profit = 0;
                            total_amount = 0;
                            let jsonMarketData = resp.marketData;

                            if (user.orders && user.orders.length > 0) {
                            
                                user.orders.forEach(order => {
                                    html += generateOrderRow(order, jsonMarketData[order.pair.type]);
                                });

                                pl      = total_open_order_profit;
                                equity  = initial_equity + pl;
                                
                            }else {
                                pl      = 0;
                                equity  = initial_equity;
                            }

                            if (equity < 0) equity = 0;

                            if (user.totalRequiredMargin === 0) {
                                margin_level = 0;
                            } else {
                                margin_level = (equity / user.totalRequiredMargin) * 100;
                            }

                            $(`.margin-level${user.id}`).html(`${formatWithPrecision1(margin_level)} %`);

                        });
                    },

                    error: function(xhr, status, error) {
                        console.error("Error fetching order history: ", error);
                    }
                });
            }

            function formatWithPrecision(value, precision = 5) {
                return Number(value).toFixed(precision);
            }
            function formatWithPrecision1(value, precision = 2) {
                return Number(value).toFixed(precision);
            }

            setInterval(function func() { 
                fetchOrderHistory()
                return func; 
            }(), 3000); 
        })(jQuery);
    </script>
@endpush

@push('style')
<style>
    #checkAll {
        border: 1px solid white;
    }
    
    .bulk-action, .delete-action {
        display: none;
    }

    
    tbody tr:nth-child(even) {
      background-color: #ebecee;
    }
    
    table.table--light.style--two thead th {
        border-top: none;
        padding-left: 10px;
        padding-right: 10px;
    }
    
    table.table--light.style--two tbody td {
        padding: 4px 0px;
    }
</style>
@endpush

