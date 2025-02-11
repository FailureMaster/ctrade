<div class="mb-4">
    <form method="GET" action="{{ $currentUrl }}">
        @foreach (request()->query() as $key => $value)
            @if( $key != "filter" && $key != "customfilter" )
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach
        <div class="btn-group d-flex w-100 mb-2 @if(App::getLocale() == 'ar') flex-row-reverse @endif" role="group" aria-label="Basic example">
            <button
                type="submit"
                name="filter"
                value="today"
                class="btn btn-lg btn-custom-border {{ $currentFilter == 'today' ? 'btn-primary' : 'btn-outline-primary' }}"
                >
                @lang('Today')
            </button>
            <button
                type="submit"
                name="filter"
                value="yesterday"
                class="btn btn-lg btn-custom-border {{ $currentFilter == 'yesterday' ? 'btn-primary' : 'btn-outline-primary' }}"
                >
                @lang('Yesterday')
            </button>
            <button
                type="submit"
                name="filter"
                value="this_week"
                class="btn btn-lg btn-custom-border {{ $currentFilter == 'this_week' ? 'btn-primary' : 'btn-outline-primary' }}"
                >
                @lang('This week')
            </button>
            <button
                type="submit"
                name="filter"
                value="last_week"
                class="btn btn-lg btn-custom-border {{ $currentFilter == 'last_week' ? 'btn-primary' : 'btn-outline-primary' }}"
                >
                @lang('Last week')
            </button>
            <button
                type="submit"
                name="filter"
                value="this_month"
                class="btn btn-lg btn-custom-border {{ $currentFilter == 'this_month' ? 'btn-primary' : 'btn-outline-primary' }}"
                >
                @lang('This Month')
            </button>
            <button
                type="submit"
                name="filter"
                value="last_month"
                class="btn btn-lg btn-custom-border {{ $currentFilter == 'last_month' ? 'btn-primary' : 'btn-outline-primary' }}"
                >
                @lang('Last Month')
            </button>
            <button
                type="submit"
                name="filter"
                value="all_time"
                class="btn btn-lg btn-custom-border {{ $currentFilter == 'all_time' ? 'btn-primary' : 'btn-outline-primary' }}"
                >
                @lang('All Time')
            </button>
            <a
                id="customFilterButton"
                class="btn btn-lg btn-custom-border {{ $currentFilter == 'custom' ? 'btn-primary' : 'btn-outline-primary' }}"
                data-bs-toggle="modal"
                data-bs-target="#customDateFilterModal"
                >
                @lang('By Date')
            </a>
        </div>
    </form>
</div>
<div class="modal fade" id="customDateFilterModal" tabindex="-1" role="dialog" aria-labelledby="customDateFilterLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header @if(App::getLocale() == 'ar') flex-row-reverse @endif" >
                <h5 class="modal-title" id="customDateFilterLabel">
                    @lang('By Date')
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="customDateFilterForm" action="{{ url()->current() }}" method="GET">
                    <div class="flex-grow-1 @if(App::getLocale() == 'ar') text-right @endif">
                        <label>@lang('Start date - End date')</label>
                        <input
                            name="customfilter"
                            data-range="true"
                            data-multiple-dates-separator=" - "
                            data-language="en"
                            class="customDateFilterInput form-control"
                            data-position='bottom right'
                            placeholder="@lang('Start date - End date')"
                            autocomplete="off"
                            value="{{ request()->date }}"
                            >
                    </div>
                    @foreach (request()->query() as $key => $value)
                        @if( $key != "filter" && $key != "customfilter" )
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <div class="my-3">
                        <button type="submit" class="btn-lg btn-primary w-100">@lang('Start Filter')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('style')
    <style>
        .btn-custom-border {
            border: none;
            border-bottom: 1px solid;
        }

        .btn-outline-primary.btn-custom-border {
            border-bottom: 1px solid #007bff; /* match the border color to the outline-primary color */
        }

        .btn-primary.btn-custom-border {
            border-bottom: 1px solid #007bff; /* match the border color to the primary color */
        }

        .datepickers-container {
            z-index: 10000 !important;
        }
    </style>
@endpush

@push('style-lib')
    {{-- <link rel="stylesheet" href="{{asset('assets/admin/css/vendor/datepicker.min.css')}}"> --}}
    {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('script-lib')
  {{-- <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script> --}}
  {{-- <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script> --}}
  {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";
            if(!$('.customDateFilterInput').val()){
                // $('.customDateFilterInput').datepicker();

                flatpickr(".customDateFilterInput", {
                    mode: "range", // For single date selection
                    inline: false,   // Display inline calendar
                    showMonths: 2,  // Show two months side by side
                    dateFormat: 'm/d/Y',
                    locale: {
                        rangeSeparator: " - ",  // Replace "to" with " - "
                    }
                });
            }
        })(jQuery)
    
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            
            const customFilter = urlParams.get('customfilter');
    
            if (customFilter) {
                const decodedCustomFilter = decodeURIComponent(customFilter);
    
                const dateRange = decodedCustomFilter.split(' - ');
    
                const formattedStartDate = formatDate(dateRange[0]);
                const formattedEndDate = formatDate(dateRange[1]);
    
                if (formattedStartDate && formattedEndDate) {
                    const button = document.getElementById("customFilterButton");
                    button.innerHTML = `<i class="far fa-calendar"></i> ${formattedStartDate} - <i class="far fa-calendar"></i> ${formattedEndDate}`;
                    button.classList.add('btn-primary');
                    button.classList.add('text-white');
                } else {
                    console.error('Invalid date range format in customfilter parameter.');
                }
            }
        });
    
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = String(date.getFullYear()).slice(-2);
            return `${month}-${day}-${year}`;
        }
    </script>
@endpush