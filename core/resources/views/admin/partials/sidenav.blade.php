<div class="sidebar bg--dark">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('admin.dashboard') }}" class="sidebar__main-logo"><img
                    src="{{ siteLogo() }}?v={{ time() }}"></a>
        </div>
        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">

                @if(can_access('dashboard'))
                    <li class="sidebar-menu-item {{ menuActive('admin.dashboard') }}">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link ">
                            <i class="menu-icon las la-home"></i>
                            <span class="menu-title">@lang('Dashboard')</span>
                        </a>
                    </li>
                @endif

                @if(can_access('all-workers'))
                    <li class="sidebar-menu-item {{ menuActive('admin.manage_admins.admins') }}">
                        <a href="{{ route('admin.manage_admins.admins') }}" class="nav-link">
                            <i class="menu-icon las la-users"></i>
                            <span class="menu-title">@lang('All Workers')</span>
                        </a>
                    </li>
                @endif

                @php
                    $leads_settings = [
                        'admin.users.sales.status',
                        'admin.users.import.view',
                        'admin.users.create',
                        'admin.setting.system.configuration',
                        'admin.kyc.setting',
                        'admin.users.notification.all'
                    ];
                @endphp

                @if(can_access('leads-status|import-leads|add-new-lead|system-configuration|kyc-setting|notification-to-all'))
                    <li class="sidebar-menu-item sidebar-dropdown">
                            <a href="javascript:void(0)"
                                class="{{ menuActive(
                                    $leads_settings,
                                    3,
                                ) }}">
                                <i class="menu-icon las la-users"></i>
                                <span class="menu-title">@lang('Leads Settings')</span>
                            </a>
                        <div
                            class="sidebar-submenu {{ menuActive(
                                $leads_settings,
                                2,
                            ) }} ">
                            <ul>
                                @if (can_access('leads-status'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.sales.status') }} ">
                                        <a href="{{ route('admin.users.sales.status') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Leads Status')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('import-leads'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.import.view') }} ">
                                        <a href="{{ route('admin.users.import.view') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Import Leads')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('add-new-lead'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.create') }} ">
                                        <a href="{{ route('admin.users.create') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Add New Lead')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('system-configuration'))
                                    <li
                                        class="sidebar-menu-item {{ menuActive('admin.setting.system.configuration') }}">
                                        <a href="{{ route('admin.setting.system.configuration') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('System Configuration')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('kyc-setting'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.kyc.setting') }}">
                                        <a href="{{ route('admin.kyc.setting') }}" class="nav-link">
                                            <i class="menu-icon las la-user-check"></i>
                                            <span class="menu-title">@lang('KYC Setting')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('notification-to-all'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.notification.all') }}">
                                        <a href="{{ route('admin.users.notification.all') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Notification to All')</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                {{-- Manager Groups --}}
                @if (can_access('permission-groups|banned-clients|email-unverified|mobile-unverified'))
                    @php
                        $mworkers = [
                            'admin.manage_admins.permission_groups',
                            'admin.users.banned',
                            'admin.users.email.unverified',
                            'admin.users.mobile.unverified',
                        ];
                    @endphp
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive($mworkers, 3) }}">
                            <i class="menu-icon las la-file-invoice-dollar"></i>
                            <span class="menu-title">@lang('Manager Groups')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive($mworkers, 2) }}">
                            <ul>
                                @if(can_access('permission-groups'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.manage_admins.permission_groups') }}">
                                        <a href="{{ route('admin.manage_admins.permission_groups') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Permission Groups')</span>
                                        </a>
                                    </li>
                                @endif

                                @if(can_access('banned-clients'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.banned') }} ">
                                        <a href="{{ route('admin.users.banned', ['filter' => 'all_time']) }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Banned Clients')</span>
                                            @if ($bannedUsersCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ $bannedUsersCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                @if(can_access('email-unverified'))
                                    <li class="sidebar-menu-item  {{ menuActive('admin.users.email.unverified') }}">
                                        <a href="{{ route('admin.users.email.unverified', ['filter' => 'all_time']) }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Email Unverified')</span>

                                            @if ($emailUnverifiedUsersCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ $emailUnverifiedUsersCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                @if(can_access('mobile-unverified'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.mobile.unverified') }}">
                                        <a href="{{ route('admin.users.mobile.unverified', ['filter' => 'all_time']) }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Mobile Unverified')</span>
                                            @if ($mobileUnverifiedUsersCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ $mobileUnverifiedUsersCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                {{-- Finance --}}
                @if (can_access('pending-deposits|approved-deposits|successful-deposits|rejected-deposits|initiated-deposits|all-deposits|withdrawal-methods|pending-withdrawal|approved-withdrawal|rejected-withdrawal|all-withdrawal|automatic-gateways|manual-gateways|kyc-unverified|kyc-pending|transaction-log'))
                    @php
                        $financeActive = [
                            'admin.deposit*',
                            'admin.withdraw',
                            'admin.gateway*',
                            'admin.users.kyc.unverified',
                            'admin.users.kyc.pending',
                            'admin.report.transaction'
                        ];
                    @endphp
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive($financeActive, 3) }}">
                            <i class="menu-icon las la-file-invoice-dollar"></i>
                            <span class="menu-title">@lang('Finance')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive($financeActive, 2) }}">
                            <ul>
                                @if (can_access('pending-deposits|approved-deposits|successful-deposits|rejected-deposits|initiated-deposits|all-deposits'))
                                    <li class="sidebar-menu-item sidebar-dropdown">
                                        <a href="javascript:void(0)" class="{{ menuActive('admin.deposit*', 3) }}">
                                            <i class="menu-icon las la-file-invoice-dollar"></i>
                                            <span class="menu-title">@lang('Deposits')</span>
                                            @if (0 < $pendingDepositsCount)
                                                <span class="menu-badge pill bg--danger ms-auto">
                                                    <i class="fa fa-exclamation"></i>
                                                </span>
                                            @endif
                                        </a>
                                        <div class="sidebar-submenu {{ menuActive('admin.deposit*', 2) }} ">
                                            <ul>
                                                @if(can_access('pending-deposits'))
                                                    <li class="sidebar-menu-item {{ menuActive('admin.deposit.pending') }} ">
                                                        <a href="{{ route('admin.deposit.pending', ['filter' => 'all_time']) }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Pending Deposits')</span>
                                                            @if ($pendingDepositsCount)
                                                                <span
                                                                    class="menu-badge pill bg--danger ms-auto">{{ $pendingDepositsCount }}</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(can_access('approved-deposits'))
                                                    <li class="sidebar-menu-item {{ menuActive('admin.deposit.approved') }} ">
                                                        <a href="{{ route('admin.deposit.approved', ['filter' => 'this_month']) }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Approved Deposits')</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(can_access('successful-deposits'))
                                                    <li
                                                        class="sidebar-menu-item {{ menuActive('admin.deposit.successful') }} ">
                                                        <a href="{{ route('admin.deposit.successful', ['filter' => 'this_month']) }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Successful Deposits')</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(can_access('rejected-deposits'))
                                                    <li class="sidebar-menu-item {{ menuActive('admin.deposit.rejected') }} ">
                                                        <a href="{{ route('admin.deposit.rejected', ['filter' => 'this_month']) }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Rejected Deposits')</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(can_access('initiated-deposits'))
                                                    <li
                                                        class="sidebar-menu-item {{ menuActive('admin.deposit.initiated') }} ">
                                                        <a href="{{ route('admin.deposit.initiated', ['filter' => 'this_month']) }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Initiated Deposits')</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(can_access('all-deposits'))
                                                    <li class="sidebar-menu-item {{ menuActive('admin.deposit.list') }} ">
                                                        <a href="{{ route('admin.deposit.list', ['filter' => 'this_month']) }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('All Deposits')</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if (can_access('withdrawal-methods|pending-withdrawal|approved-withdrawal|rejected-withdrawal|all-withdrawal'))
                                    <li class="sidebar-menu-item sidebar-dropdown">
                                        <a href="javascript:void(0)" class="{{ menuActive('admin.withdraw*', 3) }}">
                                            <i class="menu-icon la la-bank"></i>
                                            <span class="menu-title">@lang('Withdrawals') </span>
                                            @if (0 < $pendingWithdrawCount)
                                                <span class="menu-badge pill bg--danger ms-auto">
                                                    <i class="fa fa-exclamation"></i>
                                                </span>
                                            @endif
                                        </a>
                                        <div class="sidebar-submenu {{ menuActive('admin.withdraw*', 2) }} ">
                                            <ul>
                                                @if(can_access('withdrawal-methods'))
                                                    <li class="sidebar-menu-item {{ menuActive('admin.withdraw.method.*') }}">
                                                        <a href="{{ route('admin.withdraw.method.index') }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Withdrawal Methods')</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(can_access('pending-withdrawal'))
                                                    <li class="sidebar-menu-item {{ menuActive('admin.withdraw.pending') }} ">
                                                        <a href="{{ route('admin.withdraw.pending', ['filter' => 'all_time']) }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Pending Withdrawals')</span>

                                                            @if ($pendingWithdrawCount)
                                                                <span
                                                                    class="menu-badge pill bg--danger ms-auto">{{ $pendingWithdrawCount }}</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(can_access('approved-withdrawal'))
                                                    <li
                                                        class="sidebar-menu-item {{ menuActive('admin.withdraw.approved') }} ">
                                                        <a href="{{ route('admin.withdraw.approved', ['filter' => 'this_month']) }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Approved Withdrawals')</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(can_access('rejected-withdrawal'))
                                                    <li
                                                        class="sidebar-menu-item {{ menuActive('admin.withdraw.rejected') }} ">
                                                        <a href="{{ route('admin.withdraw.rejected', ['filter' => 'this_month']) }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Rejected Withdrawals')</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(can_access('all-withdrawal'))
                                                    <li class="sidebar-menu-item {{ menuActive('admin.withdraw.log') }} ">
                                                        <a href="{{ route('admin.withdraw.log', ['filter' => 'this_month']) }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('All Withdrawals')</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if (can_access('automatic-gateways|manual-gateways'))
                                    <li class="sidebar-menu-item sidebar-dropdown">
                                        <a href="javascript:void(0)" class="{{ menuActive('admin.gateway*', 3) }}">
                                            <i class="menu-icon las la-credit-card"></i>
                                            <span class="menu-title">@lang('Payment Gateways')</span>
                                        </a>
                                        <div class="sidebar-submenu {{ menuActive('admin.gateway*', 2) }} ">
                                            <ul>
                                                @if (can_access('automatic-gateways'))
                                                    <li
                                                        class="sidebar-menu-item {{ menuActive('admin.gateway.automatic.*') }} ">
                                                        <a href="{{ route('admin.gateway.automatic.index') }}"
                                                            class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Automatic Gateways')</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if (can_access('manual-gateways'))
                                                    <li class="sidebar-menu-item {{ menuActive('admin.gateway.manual.*') }} ">
                                                        <a href="{{ route('admin.gateway.manual.index') }}" class="nav-link">
                                                            <i class="menu-icon las la-dot-circle"></i>
                                                            <span class="menu-title">@lang('Manual Gateways')</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if(can_access('kyc-unverified'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.kyc.unverified') }}">
                                        <a href="{{ route('admin.users.kyc.unverified', ['filter' => 'all_time']) }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('KYC Unverified')</span>
                                            @if ($kycUnverifiedUsersCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ $kycUnverifiedUsersCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                @if(can_access('kyc-pending'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.kyc.pending') }}">
                                        <a href="{{ route('admin.users.kyc.pending', ['filter' => 'all_time']) }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('KYC Pending')</span>
                                            @if ($kycPendingUsersCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ $kycPendingUsersCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                                
                                @if (can_access('transaction-log'))
                                    <li class="sidebar-menu-item {{ menuActive(['admin.report.transaction', 'admin.report.transaction.search']) }}">
                                        <a href="{{ route('admin.report.transaction', ['filter' => 'this_month']) }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Transaction Log')</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if(can_access('open-orders|closed-orders|margin-level|manage-symbols|vip-groups|lots-volume|orders-fee'))
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)"
                            class="{{ menuActive(['admin.order*', 'admin.coin.pair.*', 'admin.groups.index', 'admin.managelots*', 'admin.togleFee*'], 3) }}">
                            <i class="menu-icon las la-file-invoice-dollar"></i>
                            <span class="menu-title">@lang('Manager Trading')</span>
                        </a>
                        <div
                            class="sidebar-submenu {{ menuActive(['admin.order*', 'admin.coin.pair.*', 'admin.groups.index', 'admin.managelots*', 'admin.togleFee*'], 2) }}">
                            <ul>
                                @if (can_access('open-orders'))
                                    <li class="sidebar-menu-item {{ menuActive(['admin.order.open']) }}">
                                        <a href="{{ route('admin.order.open', ['filter' => 'this_month']) }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Open Orders')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('closed-orders'))
                                    <li class="sidebar-menu-item {{ menuActive(['admin.order.close']) }}">
                                        <a href="{{ route('admin.order.close', ['filter' => 'this_month']) }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Closed Orders')</span>
                                        </a>
                                    </li>
                                @endif
                                @if (can_access('margin-level'))
                                    <li class="sidebar-menu-item {{ menuActive(['admin.order.manageLevel']) }}">
                                        <a href="{{ route('admin.order.manageLevel', ['filter' => 'all_time']) }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Margin Level')</span>
                                        </a>
                                    </li>
                                @endif
                                @if (can_access('manage-symbols'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.coin.pair.*') }}">
                                        <a href="{{ route('admin.coin.pair.list') }}" class="nav-link ">
                                            <i class="menu-icon las la-list"></i>
                                            <span class="menu-title">@lang('Manage Symbols')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('vip-groups'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.groups.index') }}">
                                        <a href="{{ route('admin.groups.index') }}" class="nav-link ">
                                            <i class="menu-icon las la-users"></i>
                                            <span class="menu-title">@lang('VIP Groups')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('lots-volume'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.managelots*') }}">
                                        <a href="{{ route('admin.managelots') }}" class="nav-link ">
                                            <i class="menu-icon fas fa-exchange-alt"></i>
                                            <span class="menu-title">@lang('Lots volume')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('orders-fee'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.togleFee*') }}">
                                        <a href="{{ route('admin.togleFee') }}" class="nav-link ">
                                            <i class="menu-icon fas fa-calculator"></i>
                                            <span class="menu-title">@lang('Orders fee')</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif

                @if (can_access('all-leads'))
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)"
                            class="{{ menuActive(['admin.users.all'], 3) }}">
                            <i class="menu-icon las la-dot-circle"></i>
                            <span class="menu-title">@lang('Sales')</span>
                        </a>
                        <div
                            class="sidebar-submenu {{ menuActive(['admin.users.all'], 2) }} ">
                            <ul>
                                <li class="sidebar-menu-item {{ menuActive('admin.users.all') }} ">
                                    <a href="{{ route('admin.users.all', ['filter' => 'this_month']) }}"
                                        class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('All Leads')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (can_access('active-clients'))
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)"
                            class="{{ menuActive(
                                [
                                    'admin.users.active',
                                ],
                                3,
                            ) }}">
                            <i class="menu-icon las la-users"></i>
                            <span class="menu-title">@lang('Retention')</span>
                        </a>
                        <div
                            class="sidebar-submenu {{ menuActive(
                                [
                                    'admin.users.active',
                                ],
                                2,
                            ) }} ">
                            <ul>
                                <li class="sidebar-menu-item {{ menuActive('admin.users.active') }} ">
                                    <a href="{{ route('admin.users.active', ['filter' => 'this_month']) }}"
                                        class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Active Clients')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (can_access('notifications|logins'))
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive(['admin.report.notification.history', 'admin.report.login.ipHistory', 'admin.report.login.history', 'admin.notifications'], 3) }}">
                            <i class="menu-icon la la-list"></i>
                            <span class="menu-title">@lang('Reports') </span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive(['admin.report.notification.history', 'admin.report.login.ipHistory', 'admin.report.login.history', 'admin.notifications'], 2) }} ">
                            <ul>
                                @if (can_access('notifications'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.report.notification.history') }}">
                                        <a href="{{ route('admin.report.notification.history') }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Email Notifications')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('notifications'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.notifications') }}">
                                        <a href="{{ route('admin.notifications') }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Notifications')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('logins'))
                                    <li class="sidebar-menu-item {{ menuActive(['admin.report.login.history', 'admin.report.login.ipHistory']) }}">
                                        <a href="{{ route('admin.report.login.history', ['filter' => 'this_month']) }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Logins')</span>
                                        </a>
                                    </li>
                                @endif

                                {{-- @if (can_access('logins')) --}}
                                    <li class="sidebar-menu-item {{ menuActive(['']) }}">
                                        <a href="{{ route('admin.users.online.leads') }}"
                                            class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Online Leads')</span>
                                        </a>
                                    </li>
                                {{-- @endif --}}
                            </ul>
                        </div>
                    </li>
                @endif

                @if (can_access('pending-ticket|closed-ticket|answered-ticket|all-ticket'))
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.ticket*', 3) }}">
                            <i class="menu-icon la la-ticket"></i>
                            <span class="menu-title">@lang('Support Ticket') </span>
                            @if (0 < $pendingTicketCount)
                                <span class="menu-badge pill bg--danger ms-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.ticket*', 2) }} ">
                            <ul>
                                @if(can_access('pending-ticket'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.ticket.pending') }} ">
                                        <a href="{{ route('admin.ticket.pending') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Pending Ticket')</span>
                                            @if ($pendingTicketCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ $pendingTicketCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                @if(can_access('closed-ticket'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.ticket.closed') }} ">
                                        <a href="{{ route('admin.ticket.closed') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Closed Ticket')</span>
                                        </a>
                                    </li>
                                @endif

                                @if(can_access('answered-ticket'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.ticket.answered') }} ">
                                        <a href="{{ route('admin.ticket.answered') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Answered Ticket')</span>
                                        </a>
                                    </li>
                                @endif

                                @if(can_access('all-ticket'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.ticket.index') }} ">
                                        <a href="{{ route('admin.ticket.index') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('All Ticket')</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (can_access(
                        'general-setting|logo-favicon|language|global-template|email-setting|sms-setting|notification-templates|application|server|cache'))
                    <li class="sidebar__menu-header">@lang('Settings')</li>
                @endif

                @if (can_access('general-setting'))
                    <li class="sidebar-menu-item {{ menuActive('admin.setting.index') }}">
                        <a href="{{ route('admin.setting.index') }}" class="nav-link">
                            <i class="menu-icon las la-life-ring"></i>
                            <span class="menu-title">@lang('General Setting')</span>
                        </a>
                    </li>
                @endif

                @if (can_access('seo-manager'))
                    <li class="sidebar-menu-item {{ menuActive('admin.seo') }}">
                        <a href="{{ route('admin.seo') }}" class="nav-link">
                            <i class="menu-icon las la-tachometer-alt"></i>
                            <span class="menu-title">@lang('SEO')</span>
                        </a>
                    </li>
                @endif

                @if (can_access('logo-favicon'))
                    <li class="sidebar-menu-item {{ menuActive('admin.setting.logo.icon') }}">
                        <a href="{{ route('admin.setting.logo.icon') }}" class="nav-link">
                            <i class="menu-icon las la-images"></i>
                            <span class="menu-title">@lang('Logo & Favicon')</span>
                        </a>
                    </li>
                @endif

                @if (can_access('language'))
                    <li class="sidebar-menu-item  {{ menuActive(['admin.language.manage', 'admin.language.key']) }}">
                        <a href="{{ route('admin.language.manage') }}" class="nav-link"
                            data-default-url="{{ route('admin.language.manage') }}">
                            <i class="menu-icon las la-language"></i>
                            <span class="menu-title">@lang('Language') </span>
                        </a>
                    </li>
                @endif

         
                @if (can_access('global-template|email-setting|sms-setting|notification-templates'))
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.setting.notification*', 3) }}">
                            <i class="menu-icon las la-bell"></i>
                            <span class="menu-title">@lang('Notification Setting')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.setting.notification*', 2) }} ">
                            <ul>
                                @if (can_access('global-template'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.setting.notification.global') }} ">
                                        <a href="{{ route('admin.setting.notification.global') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Global Template')</span>
                                        </a>
                                    </li>
                                @endif
                                @if (can_access('email-setting'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.setting.notification.email') }} ">
                                        <a href="{{ route('admin.setting.notification.email') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Email Setting')</span>
                                        </a>
                                    </li>
                                @endif
                                @if (can_access('sms-setting'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.setting.notification.sms') }} ">
                                        <a href="{{ route('admin.setting.notification.sms') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('SMS Setting')</span>
                                        </a>
                                    </li>
                                @endif
                                @if (can_access('notification-templates'))
                                    <li
                                        class="sidebar-menu-item {{ menuActive('admin.setting.notification.templates') }} ">
                                        <a href="{{ route('admin.setting.notification.templates') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Notification Templates')</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif


                @if (can_access('manage-section'))
                    <li class="sidebar-menu-item sidebar-dropdown" style="display: none">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.frontend.sections*', 3) }}">
                            <i class="menu-icon la la-puzzle-piece"></i>
                            <span class="menu-title">@lang('Manage Section')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.frontend.sections*', 2) }} ">
                            <ul>
                                @php
                                    $lastSegment = collect(request()->segments())->last();
                                @endphp
                                @foreach (getPageSections(true) as $k => $secs)
                                    @if ($secs['builder'])
                                        <li class="sidebar-menu-item {{ $lastSegment == $k ? 'active' : '' }} ">
                                            <a href="{{ route('admin.frontend.sections', $k) }}" class="nav-link">
                                                <i class="menu-icon las la-dot-circle"></i>
                                                <span class="menu-title">{{ __($secs['name']) }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif

                @if (can_access('application|server|cache'))
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.system*', 3) }}">
                            <i class="menu-icon la la-server"></i>
                            <span class="menu-title">@lang('System')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.system*', 2) }} ">
                            <ul>
                                @if (can_access('application'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.system.info') }} ">
                                        <a href="{{ route('admin.system.info') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Application')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('server'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.system.server.info') }} ">
                                        <a href="{{ route('admin.system.server.info') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Server')</span>
                                        </a>
                                    </li>
                                @endif

                                @if (can_access('cache'))
                                    <li class="sidebar-menu-item {{ menuActive('admin.system.optimize') }} ">
                                        <a href="{{ route('admin.system.optimize') }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Cache')</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

            </ul>
            <div class="text-center mb-5 text-uppercase">
                <span class="text--primary">Sputnik22</span>
                <span class="text--success">@lang('V'){{ systemDetails()['version'] }} </span>
            </div>
        </div>
    </div>
</div>
<!-- sidebar end -->

@push('script')
    <script>
        if ($('li').hasClass('active')) {
            $('#sidebar__menuWrapper').animate({
                scrollTop: eval($(".active").offset().top - 320)
            }, 500);
        }
    </script>
@endpush
