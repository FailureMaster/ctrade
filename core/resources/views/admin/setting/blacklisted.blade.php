@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card bl--5-primary">
                <div class="card-body">
                    <p class="text--primary">
                        Countries listed here will be restricted to access the site.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($blacklistCountries as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ __($item->name) }}</strong>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-outline--danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#actionMessageModal{{ $item->id }}"
                                            >
                                                <i class="la la-trash"></i> @lang('Remove')
                                            </button>
                                        </td>
                                        <div id="actionMessageModal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete Country #{{ $item->id }}</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="las la-times"></i>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="{{ route('admin.blacklist.countries.delete', $item->id) }}"
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
            </div><!-- card end -->
        </div>
    </div>
    
    {{-- BLACKLIST COUNTRY MODAL --}}
    <div class="modal fade" id="addBlacklistCountryModal" tabindex="-1" role="dialog" aria-labelledby="addBlacklistCountryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Blacklist Country</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.blacklist.countries.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <label>Country Code (Kindly use country code e.g. "AR")</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="country" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45" id="btn-save" value="add">
                            @lang('Submit')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button
        type="button"
        class="btn btn-sm btn-outline--primary"
        data-bs-toggle="modal"
        data-bs-target="#addBlacklistCountryModal"
        >
            <i class="las la-plus"></i>
            @lang('Add Country')
    </button>
@endpush
