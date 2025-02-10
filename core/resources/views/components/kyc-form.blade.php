<form action="{{route('user.kyc.submit')}}" method="post" enctype="multipart/form-data" class="frmKYC">
    @csrf

    <x-viser-form identifier="act" identifierValue="kyc" />

    <div class="form-group">
        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
    </div>
</form>
@push('style')
 <style>
     [data-theme=light] .frmKYC .form--control{
        color: #000000 !important;
        border: 1px solid #7c666675 !important;
      }
      [data-theme=dark] .frmKYC .form--control{
        color: #ffffff !important;
        border: 1px solid #7c666675 !important;
      }
 </style>
@endpush