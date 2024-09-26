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
                    <div class="position-relative">
                        <form action="">
                            <div class="d-flex gap-2">
                                <div class="flex-grow-1">
                                    <label>@lang('ID')</label>
                                    <input type="text" name="lead_code" value="{{ request()->lead_code }}" class="form-control">
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Name')</label>
                                    <input type="text" name="user_name" value="{{ request()->user_name }}" class="form-control">
                                </div>
                                <div class="flex-grow-1">
                                    <label>IP</label>
                                    <input type="text" name="ip" value="{{ request()->ip }}" class="form-control">
                                </div>
                                <div class="flex-grow-1">
                                    <label>Browser</label>
                                    <input type="text" name="browser" value="{{ request()->browser }}" class="form-control">
                                </div>
                                <div class="flex-grow-1 align-self-end">
                                    <button class="btn btn--primary w-100 h-45">
                                        <i class="la la-search"></i>
                                    </button>
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
                    <div class="p-3">
                        <small>
                            @if ($loginLogs->firstItem())
                                <strong>{{ $loginLogs->firstItem() }} - {{ $loginLogs->lastItem() }} of {{ $loginLogs->total() }}</strong>
                                
                            @endif
                        </small>
                    </div>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Login at')</th>
                                    <th>@lang('IP')</th>
                                    <th>@lang('Location')</th>
                                    <th class="text-center">@lang('Browser | OS')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($loginLogs as $log)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('admin.users.detail', $log->user_id) }}">{{ @$log?->user?->lead_code }}</a>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ @$log->user->fullname }}</span>
                                        </td>
                                        <td>
                                            {{showDateTime($log->created_at) }} <br> {{diffForHumans($log->created_at, true) }}
                                        </td>
                                        <td>
                                            <span class="fw-bold">
                                                <a href="{{route('admin.report.login.ipHistory',[$log->user_ip])}}">{{ $log->user_ip }}</a>
                                            </span>
                                        </td>
    
                                        <td>
                                            {{ __($log->city) }} <br> {{ __($log->country) }}
                                        </td>
                                        <td class="text-center">
                                            {{ __($log->browser) }} <br> {{ __($log->os) }}
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
                @if ($loginLogs->hasPages())
                <div class="card-footer py-4">
                    <div>
                        <small>
                            @if ($loginLogs->firstItem())
                                <strong>{{ $loginLogs->firstItem() }} - {{ $loginLogs->lastItem() }} of {{ $loginLogs->total() }}</strong>
                                
                            @endif
                        </small>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        {{ paginateLinks($loginLogs) }}
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
            </div><!-- card end -->
        </div>
    </div>
@endsection

@if(request()->routeIs('admin.report.login.ipHistory'))
    @push('breadcrumb-plugins')
        <a href="https://www.ip2location.com/{{ $ip }}" target="_blank" class="btn btn--primary">@lang('Lookup IP') {{ $ip }}</a>
    @endpush
@endif