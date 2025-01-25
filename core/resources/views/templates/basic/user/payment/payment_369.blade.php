@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card custom--card">
                <div class="card-header card-header-bg">
                    <h5 class="card-title">{{ __($pageTitle) }}</h5>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('user.deposit.custom.confirm') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @if( $data->gateway->message == null )
                                <p class="text-center mt-2">
                                    @lang('You have requested') <b class="text--success">
                                        {{ showAmount($data['amount']) }}
                                        {{ __(@$data->method_currency) }}</b> , @lang('Please pay')
                                    <b class="text--success">
                                        {{ showAmount($data['amount']) }} +
                                        <span data-bs-toggle="tooltip"  title="@lang('Charge')">{{ showAmount($data['charge']) }}</span> =
                                        {{ showAmount($data['final_amo']) . ' ' . $data['method_currency'] }}
                                    </b> @lang('for successful payment')
                                </p>
                                @else
                                    @if (App::getLocale() != 'ar')
                                        <p>{{ $data->gateway->message }}</p>
                                    @else
                                        <p>{{ $data->gateway->message_arabic }}</p>
                                    @endif
                                @endif
                                <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>
                                <p class="my-4 text-center">@php echo  $data->gateway->description @endphp</p>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-label">@lang('Country')</label>
                                    <select name="country" id="country" class="form--control register-select">
                                        @foreach($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}"
                                            value="{{ $key }}" data-code="{{ $key }}"
                                            {{ $user->country_code === $key ? "selected" : "" }}>{{__($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label required" for="city">City*</label>
                                    <input type="text" class="form-control form--control" name="city" value="{{ old('city') ?? $user->address->city }}" required id="city">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label required" for="zip_code">Zip Code*</label>
                                    <input type="text" class="form-control form--control" name="zip_code" value="{{ old('zip_code') ?? $user->address->zip }}" required id="zip_code">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="form-label required" for="address">Address*</label>
                                <input type="text" class="form-control form--control" name="address" value="{{ old('address') ?? $user->address->address }}" required id="address">
                            </div>
                            <div class="form-group">
                                <label class="form-label required" for="first_name">First Name*</label>
                                <input type="text" class="form-control form--control" name="first_name" value="{{ old('first_name') ?? $user->firstname }}" required id="first_name">
                            </div>
                            <div class="form-group">
                                <label class="form-label required" for="last_name">Last Name*</label>
                                <input type="text" class="form-control form--control" name="last_name" value="{{ old('last_name') ?? $user->lastname }}" required id="last_name">
                            </div>
                            <div class="form-group">
                                <label class="form-label required" for="email">Email*</label>
                                <input type="text" class="form-control form--control" name="email" value="{{ old('email') ?? $user->email }}" required id="email">
                            </div>
                            <div class="form-group">
                                <label class="form--label required">@lang('Mobile')*</label>
                                <div class="input-group">
                                    <div class="input-group-text mobile-code"></div>
                                    <input type="number" placeholder="@lang('Your mobile')" name="mobile" value="{{ old('mobile') ?? $user->mobile }}" required  class="form-control form--control checkUser" required>
                                </div>
                                <small class="text--danger mobileExist"></small>
                            </div>
                            {{-- <div class="form-group">
                                <label class="form-label" for="cell_phone">Cell Phone</label>
                                <input type="text" class="form-control form--control" name="cell_phone" value="" id="cell_phone">
                            </div> --}}
                            <div class="form-group">
                                <label class="form-label" for="state">State</label>
                                <input type="text" class="form-control form--control" name="state" value="{{ old('state') }}" id="state">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="ssn">SSN</label>
                                <input type="text" class="form-control form--control" name="ssn" value="{{ old('ssn') }}" id="ssn">
                            </div>
                          
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="credit_card_number">Credit Card Number*</label>
                                    <input type="text" class="form-control form--control" name="credit_card_number" value="{{ old('credit_card_number') }}" id="credit_card_number">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="card_printed_name">Card Printed Name*</label>
                                    <input type="text" class="form-control form--control" name="card_printed_name" value="{{ old('card_printed_name') }}" id="card_printed_name">
                                </div>
                            </div> 

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="form-label required" for="cvv2">CVV2*</label>
                                    <input type="text" class="form-control form--control" name="cvv2" value="{{ old('cvv2') }}" required id="cvv2">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label required" for="expire_month">Expire Month*</label>
                                    <input type="text" class="form-control form--control" name="expire_month" value="{{ old('expire_month') }}" required id="expire_month">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label required" for="expire_year">Expire Year*</label>
                                    <input type="text" class="form-control form--control" name="expire_year" value="{{ old('expire_year') }}" required id="expire_year">
                                </div>
                            </div>
                            <input type="hidden" name="trx" value=" {{ Crypt::encrypt($track)}}">
                            @if( $data->gateway->allow_pay )
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function(){
            $('select[name=country]').change(function () {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
        })
    </script>
@endpush
