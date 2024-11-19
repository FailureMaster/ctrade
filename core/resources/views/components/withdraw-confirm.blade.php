<div class="confirm-withdraw-content">
    <h5 class="mb-2">@lang('Withdraw Via') {{ $withdraw->method->name }}</h5>
    <form action="#" method="post" enctype="multipart/form-data" id="frmConfirmWithdraw">
        @csrf
        <div class="mb-2">
            @php echo $withdraw->method->description; @endphp
        </div>
        <x-viser-form identifier="id" identifierValue="{{ $withdraw->method->form_id }}" />
        <input type="hidden" value="{{ $trx }}" name="trx">
        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
    </form>
</div>