<div class="offcanvas offcanvas-end p-4" tabindex="-1" id="kyc-offcanvas" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <h4 class="mb-0 fs-18 offcanvas-title text-white">
            @lang('KYC')
        </h4>
        <button type="button" class="text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa fa-times-circle fa-lg"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        @if( auth()->user()->kv === 0 )
            @include('components.kyc-form')
        @elseif( auth()->user()->kv === 2 )
            @include('components.kyc-info')
        @endif
    </div>
</div>