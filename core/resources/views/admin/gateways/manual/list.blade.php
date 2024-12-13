@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
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
                                <th>@lang('Currency')</th>
                                <th>@lang('Status')</th>
                                <th class="text-center">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($gateways as $gateway)
                                <tr>
                                    <td style="text-indent: 20px;">{{__($gateway->name)}}</td>
                                    <td >
                                        <span>{{ __(@$gateway->singleCurrency->currency) }}</span>
                                    </td>
                                    <td>
                                        @php
                                            echo $gateway->statusBadge
                                        @endphp
                                    </td>
                                    <td>
                                        @if (can_access('remove-manual-gateway'))
                                            <button class="btn btn-sm btn-outline--danger btnDelete" data-id="{{ $gateway->id }}">
                                                <i class="la la-eraser"></i> @lang('Delete')
                                            </button>
                                        @endif
                                        <a href="{{ route('admin.gateway.manual.edit', $gateway->alias) }}" class="btn btn-sm btn-outline--primary editGatewayBtn mx-1">
                                            <i class="la la-pencil"></i> @lang('Edit')
                                        </a>
                                       <div>
                                            <form action="{{ route('admin.gateway.manual.status',$gateway->id) }}" method="POST">
                                                @csrf
                                                @if($gateway->status == Status::DISABLE)
                                                    <button type="button" class="btn btn-sm btn-outline--success btnConfirmation" data-id="{{$gateway->id}}" data-question="@lang('Are you sure to enable this gateway?')" data-action="{{ route('admin.gateway.manual.status',$gateway->id) }}">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline--danger btnConfirmation" data-id="{{$gateway->id}}" data-question="@lang('Are you sure to disable this gateway?')" data-action="{{ route('admin.gateway.manual.status',$gateway->id) }}">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </form>
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
    <div class="input-group w-auto search-form">
        <input type="text" name="search_table" class="form-control bg--white" placeholder="@lang('Search')...">
        <button class="btn btn--primary input-group-text"><i class="fa fa-search"></i></button>
    </div>
    <a class="btn btn-outline--primary" href="{{ route('admin.gateway.manual.create') }}"><i class="las la-plus"></i>@lang('Add New')</a>
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '.btnDelete', function() {
              
              let id = $(this).attr('data-id');
       
              Swal.fire({
                  target: document.getElementById('withdraw-offcanvas'),
                  text: "Are you sure you want to remove this gateway?",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Yes"
              }).then((result) => {
                  if (result.isConfirmed) {
                      $.ajax({
                          method: 'POST',
                          data: { id : id },
                          dataType: 'json',
                          url: "{{ route('admin.gateway.manual.remove') }}",
                          headers: {
                              "X-CSRF-TOKEN": "{{ csrf_token() }}",
                          },
                          success: function(response) {
                              if( response.success == 1 ){
                                  notify('success', response.message);

                                  setTimeout(() => {
                                      location.reload();
                                  }, 1000);
                              }
                          },
                          error: function(XMLHttpRequest, textStatus, errorThrown) {
                              notify('error', 'Failed!');
                          },
                          complete: function(response) {}
                      });
                  }
              });
          });

          $(document).on('click', '.btnConfirmation', function() {
              
              let url       = $(this).attr('data-action');
              let question  = $(this).attr('data-question');
              let parent    = $(this).parent('form');

              Swal.fire({
                  text: question,
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "Yes"
              }).then((result) => {
                  if (result.isConfirmed) {
                    $(parent).submit();
                  }
              });
          });
        });
    </script>
@endpush
