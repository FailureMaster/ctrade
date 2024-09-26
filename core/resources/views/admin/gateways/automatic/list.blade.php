@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">

                <div class="card-body p-0">
                    <div class="p-3">
                        <small>
                            @if ($gateways->firstItem())
                                <strong>{{ $gateways->firstItem() }} - {{ $gateways->lastItem() }} of {{ $gateways->total() }}</strong>
                                
                            @endif
                        </small>
                    </div>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                            <tr>
                                <th class="text-center">@lang('Gateway')</th>
                                <th>@lang('Supported Currency')</th>
                                <th>@lang('Enabled Currency')</th>
                                <th>@lang('Status')</th>
                                <th id="action">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($gateways->sortBy('alias') as $k=>$gateway)
                                <tr>
                                    <td style="text-indent: 20px;">{{__($gateway->name)}}</td>

                                    <td>
                                        {{ collect($gateway->supported_currencies)->count() }}
                                    </td>
                                    <td>
                                        {{ $gateway->currencies->count() }}
                                    </td>


                                    <td>
                                        @php
                                            echo $gateway->statusBadge
                                        @endphp
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.gateway.automatic.edit', $gateway->alias) }}" class="btn btn-sm btn-outline--primary editGatewayBtn">
                                            <i class="la la-pencil"></i> @lang('Edit')
                                        </a>


                                        @if($gateway->status == Status::DISABLE)
                                            <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn" data-question="@lang('Are you sure to enable this gateway?')" data-action="{{ route('admin.gateway.automatic.status',$gateway->id) }}">
                                                <i class="la la-eye"></i> @lang('Enable')
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn" data-question="@lang('Are you sure to disable this gateway?')" data-action="{{ route('admin.gateway.automatic.status',$gateway->id) }}">
                                                <i class="la la-eye-slash"></i> @lang('Disable')
                                            </button>
                                        @endif
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
                @if ($gateways->hasPages())
                    <div class="card-footer py-4">
                        <div>
                            <small>
                                @if ($gateways->firstItem())
                                    <strong>{{ $gateways->firstItem() }} - {{ $gateways->lastItem() }} of {{ $gateways->total() }}</strong>
                                    
                                @endif
                            </small>
                        </div>
                        <div class="d-flex justify-content-center mb-3">
                            {{ paginateLinks($gateways) }}
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

@push('style')
    <style>
      #action{
        text-align: center
      }

      td[data-label="Action"] {
            justify-content: center;
            display: flex;
        }
    </style>
@endpush
@push('breadcrumb-plugins')
    <div class="d-inline">
        <div class="input-group justify-content-end">
            <input type="text" name="search_table" class="form-control bg--white" placeholder="@lang('Search')...">
            <button class="btn btn--primary input-group-text"><i class="fa fa-search"></i></button>
        </div>
    </div>
@endpush
