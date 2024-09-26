@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="p-3">
                    <small>
                        @if ($salesStatuses->firstItem())
                            <strong>{{ $salesStatuses->firstItem() }} - {{ $salesStatuses->lastItem() }} of {{ $salesStatuses->total() }}</strong>
                            
                        @endif
                    </small>
                </div>
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two highlighted-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th style="text-align: left;  padding-left: 0">Name</th>
                                <th class="text-center">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salesStatuses as $status)
                                <tr>
                                    <td style="text-indent: 25px;">
                                        {{ $status->id }}
                                    </td>
                                    <td style="text-align: left;">
                                        {{ $status->name }}
                                    </td>
                                    <td class="text-center">
                                        
                                            <button
                                                type="button"
                                                class="btn btn-outline--primary"
                                                data-bs-target="#actionMessageModal{{ $status->id }}"
                                                data-bs-toggle="modal"
                                                >
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        
                                    </td>
                                    <div id="actionMessageModal{{ $status->id }}" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete User {{ $status->name }}</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <i class="las la-times"></i>
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ route('admin.users.sales.status.delete', $status->id) }}"
                                                    method="POST"
                                                    >
                                                    @csrf
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                                                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
            @if ($salesStatuses->hasPages())
            <div class="card-footer py-4">
                <div>
                    <small>
                        @if ($salesStatuses->firstItem())
                            <strong>{{ $salesStatuses->firstItem() }} - {{ $salesStatuses->lastItem() }} of {{ $salesStatuses->total() }}</strong>
                            
                        @endif
                    </small>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    {{ paginateLinks($salesStatuses) }}
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
@push('breadcrumb-plugins')
<a href="{{ route('admin.users.sales.status.create') }}" class="btn btn-outline--primary addBtn h-45">
    <i class="las la-plus"></i>@lang('Add New Status')
</a>
@endpush
@push('script')
<script>
</script>
@endpush