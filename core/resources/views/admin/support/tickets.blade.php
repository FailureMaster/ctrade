@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="p-3">
                        <small>
                            @if ($items->firstItem())
                                <strong>{{ $items->firstItem() }} - {{ $items->lastItem() }} of {{ $items->total() }}</strong>
                                
                            @endif
                        </small>
                    </div>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Submitted By')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.ticket.view', $item->id) }}" class="fw-bold"> [@lang('Ticket')#{{ $item->ticket }}] {{ strLimit($item->subject,30) }} </a>
                                    </td>

                                    <td>
                                        @if($item->user_id)
                                        <a href="{{ route('admin.users.detail', $item->user_id)}}"> {{@$item->user->fullname}}</a>
                                        @else
                                            <p class="fw-bold"> {{$item->name}}</p>
                                        @endif
                                    </td>
                                    <td>
                                        @php echo $item->statusBadge; @endphp
                                    </td>
                                    <td>
                                        @if($item->priority == Status::PRIORITY_LOW)
                                            <span class="badge badge--dark">@lang('Low')</span>
                                        @elseif($item->priority == Status::PRIORITY_MEDIUM)
                                            <span class="badge  badge--warning">@lang('Medium')</span>
                                        @elseif($item->priority == Status::PRIORITY_HIGH)
                                            <span class="badge badge--danger">@lang('High')</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ diffForHumans($item->last_reply) }}
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.ticket.view', $item->id) }}" class="btn btn-sm btn-outline--primary ms-1">
                                            <i class="las la-desktop"></i> @lang('Details')
                                        </a>
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
                @if ($items->hasPages())
                <div class="card-footer py-4">
                    <div>
                        <small>
                            @if ($items->firstItem())
                                <strong>{{ $items->firstItem() }} - {{ $items->lastItem() }} of {{ $items->total() }}</strong>
                                
                            @endif
                        </small>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        {{ paginateLinks($items) }}
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


