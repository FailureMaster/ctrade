@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="card-title">@lang('Change Password')</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" class="cpass">
                    @csrf
                    {{-- <div class="form-group">
                        <label class="form-label">@lang('Current Password')</label>
                        <input type="password" class="form--control" name="current_password" required autocomplete="current-password">
                    </div> --}}
                    <div class="form-group">
                        <label class="form-label">@lang('Password')</label>
                        <input type="password" class="form--control @if($general->secure_password) secure-password @endif" name="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Confirm Password')</label>
                        <input type="password" class="form-control form--control" name="password_confirmation" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@if($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $(document).on('submit', '.cpass', function(e) {
                e.preventDefault();

                let frm = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    data: frm,
                    url: "{{ route('user.update.password') }}",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function(response) {
                        if( response.success == "error" ){
                            notify(response.success, response.message);
                        }
                        else{
                            Swal.fire({
                                allowOutsideClick: false,
                                target: document.getElementById('changepassword-canvas'),
                                text: response.message,
                                icon: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#d33",
                                confirmButtonText: "Ok"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('user.logout') }}";
                                }
                            });
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {},
                    complete: function(response) {}
                });
            });
        });
    </script>
@endpush
