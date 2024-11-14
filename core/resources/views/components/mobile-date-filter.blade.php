<div class="dropdown">
    <label class="ellipsis-menu" class="btn btn-secondary dropdown-toggle text-white btn-sm" type="button"
    id="dateFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">•••</label>
    <ul class="dropdown-menu" aria-labelledby="dateFilterDropdown" id="mobileDateFilterDropdown">
        <li>
            <a class="dropdown-item" href="#" data-value="today">
                <div class="d-flex">
                    <div>
                        Today
                        {{-- <span
                            class="date-range d-block">{{ \Carbon\Carbon::today()->format('m/d/y') }}</span> --}}
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#" data-value="last_week">
                <div class="d-flex">
                    <div>
                        Last Week
                        {{-- <span class="date-range d-block">{{ \Carbon\Carbon::now()->subWeek()->startOfWeek()->format('m/d/y') }} - {{ \Carbon\Carbon::now()->startOfWeek()->format('m/d/y') }}</span> --}}
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#" data-value="last_month">
                <div class="d-flex">
                    <div>
                        Last Month
                        {{-- <span class="date-range d-block">{{ \Carbon\Carbon::now()->subMonth()->startOfMonth()->format('m/d/y') }} - {{ \Carbon\Carbon::now()->startOfMonth()->format('m/d/y') }}</span> --}}
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#" data-value="last_3_month">
                <div class="d-flex">
                    <div>
                        Last 3 months
                        {{-- <span class="date-range d-block">{{ \Carbon\Carbon::now()->subMonth(3)->startOfMonth()->format('m/d/y') }} - {{ \Carbon\Carbon::now()->startOfMonth()->format('m/d/y') }}</span> --}}
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="dropdown-item customFilterButton" href="#" data-value="custom" data-bs-toggle="modal" data-bs-target="#mobileCustomDateFilterModal">
                <div class="d-flex">
                    <div>
                        Custom Period
                        <span class="date-range d-block custom-period"></span>
                    </div>
                </div>
            </a>
        </li>
      {{-- <li>
        <a class="dropdown-item active" href="#" data-value="all_time">
            <div class="d-flex">
                <div>
                    All Time
                    <span class="date-range d-block"></span>
                </div>
            </div>
        </a>
      </li> --}}
    </ul>
</div>