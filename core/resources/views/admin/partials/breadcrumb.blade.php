<div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center b-crumbs">
    @if(@request()->route()->uri != 'admin/dashboard')
        {{-- <h6 class="page-title">{{ __($pageTitle) }}</h6> --}}
    @endif
    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
        @stack('breadcrumb-plugins')
    </div>
</div>
