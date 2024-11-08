<div class="modal fade" id="mobileCustomDateFilterModal" tabindex="-1" role="dialog" aria-labelledby="customDateFilterLabel" aria-hidden="true">
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
                <form id="mobileCustomDateFilterForm" action="{{ url()->current() }}" method="GET">
                    <div class="flex-grow-1 @if(App::getLocale() == 'ar') text-right @endif">
                        <label class="text-dark">@lang('Start date')</label>
                        <input
                            type="date"
                            name="customfilterFrom"
                            class="customDateFilterInput form-control"
                            data-position='bottom right'
                            placeholder="@lang('Start date - End date')"
                            autocomplete="off"
                            value="{{ request()->customfilterFrom }}"
                            required
                            >
                    </div>
                    <div class="flex-grow-1 mt-2 @if(App::getLocale() == 'ar') text-right @endif">
                        <label class="text-dark">@lang('End date')</label>
                        <input
                            type="date"
                            name="customfilterTo"
                            class="customDateFilterInput form-control"
                            data-position='bottom right'
                            placeholder="@lang('End date')"
                            autocomplete="off"
                            value="{{ request()->customfilterTo }}"
                            required
                            >
                    </div>
                    <div class="my-3">
                        <button type="submit" class="btn-lg w-100 btn-filter">@lang('Start Filter')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        $(document).ready(function(){
            // For custom date filtering
            $(document).on('submit', '#mobileCustomDateFilterForm', function(e){
                e.preventDefault();
                let from_date = $('input[name="customfilterFrom"]').val();
                let to_date   = $('input[name="customfilterTo"]').val();

                $('.custom-period').text(from_date+ ' - '+to_date);

                $('#mobileCustomDateFilterModal').modal('hide');
            })
        })
    </script>
@endpush