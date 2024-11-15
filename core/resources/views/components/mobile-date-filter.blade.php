<div class="dropdown">
    <label class="ellipsis-menu" class="btn btn-secondary dropdown-toggle text-white btn-sm" type="button"
    id="dateFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">•••</label>
    <ul class="dropdown-menu" aria-labelledby="dateFilterDropdown" id="mobileDateFilterDropdown">
        <li>
            <a class="dropdown-item @if(App::getLocale() == 'ar') justify-content-end @endif" href="#" data-value="today">
                <div class="d-flex">
                    <div>
                        @lang('Today')
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="dropdown-item @if(App::getLocale() == 'ar') justify-content-end @endif" href="#" data-value="last_week">
                <div class="d-flex">
                    <div>
                        @lang('Last week')
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="dropdown-item @if(App::getLocale() == 'ar') justify-content-end @endif" href="#" data-value="last_month">
                <div class="d-flex">
                    <div>
                        @lang('Last Month')
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="dropdown-item @if(App::getLocale() == 'ar') justify-content-end @endif" href="#" data-value="last_3_month">
                <div class="d-flex">
                    <div>
                        @lang('Last 3 months')
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="dropdown-item @if(App::getLocale() == 'ar') justify-content-end @endif customFilterButton" href="#" data-value="custom" data-bs-toggle="modal" data-bs-target="#mobileCustomDateFilterModal">
                <div class="d-flex">
                    <div>
                        @lang('Custom Period')
                        <span class="date-range d-block custom-period"></span>
                    </div>
                </div>
            </a>
        </li>
    </ul>
</div>