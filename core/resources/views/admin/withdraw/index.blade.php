@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="p-3">
                        <small>
                            @if ($methods->firstItem())
                                <strong>{{ $methods->firstItem() }} - {{ $methods->lastItem() }} of {{ $methods->total() }}</strong>
                                
                            @endif
                        </small>
                    </div>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('Method')</th>
                                    <th>@lang('Currency')</th>
                                    <th>@lang('Charge')</th>
                                    <th>@lang('Withdraw Limit')</th>
                                    <th>@lang('Status')</th>
                                    <th class="text-center">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($methods as $method)
                                <tr>
                                    <td class="text-center">{{__($method->name)}}</td>

                                    <td class="fw-bold">{{ __($method->currency) }}</td>
                                    <td class="fw-bold">{{ showAmount($method->fixed_charge)}} {{ __($method->currency) }} {{ (0 < $method->percent_charge) ? ' + '. getAmount($method->percent_charge) .' %' : '' }} </td>
                                    <td class="fw-bold">{{ $method->min_limit + 0 }}
                                        - {{ $method->max_limit + 0 }}  {{ __($method->currency) }}</td>
                                    <td>
                                        @php
                                            echo $method->statusBadge
                                        @endphp
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <div class="button--group">
                                            <a href="{{ route('admin.withdraw.method.edit', $method->id)}}"
                                               class="btn btn-sm btn-outline--primary ms-1"><i class="las la-pen"></i> @lang('Edit')</a>
                                            @if($method->status == Status::ENABLE)
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn" data-question="@lang('Are you sure to disable this method?')" data-action="{{ route('admin.withdraw.method.status',$method->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn" data-question="@lang('Are you sure to enable this method?')" data-action="{{ route('admin.withdraw.method.status',$method->id) }}">
                                                    <i class="la la-eye"></i> @lang('Enable')
                                                </button>
                                            @endif
                                        </div>
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
                @if ($methods->hasPages())
                <div class="card-footer py-4">
                    <div>
                        <small>
                            @if ($methods->firstItem())
                                <strong>{{ $methods->firstItem() }} - {{ $methods->lastItem() }} of {{ $methods->total() }}</strong>
                                
                            @endif
                        </small>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        {{ paginateLinks($methods) }}
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
    <x-confirmation-modal />
@endsection



@push('breadcrumb-plugins')
    <div class="input-group w-auto search-form">
        <input type="text" name="search_table" class="form-control bg--white" placeholder="@lang('Search')...">
        <button class="btn btn--primary input-group-text"><i class="fa fa-search"></i></button>
    </div>
    <a class="btn btn-outline--primary" href="{{ route('admin.withdraw.method.create') }}"><i class="las la-plus"></i>@lang('Add New')</a>
@endpush
