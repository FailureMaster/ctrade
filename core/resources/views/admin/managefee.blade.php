@extends('admin.layouts.app')

@section('panel')

    <div class="container my-5">
        <div class="card box--shadow2 b-radius--5 bg--white">
            <form id="fee-form" action="{{ route('admin.fee.save') }}" method="POST">
                @csrf
                <div class="card-header">
                    <h4 class="card-title py-3">Fee Management</h4>
                </div>
                <div class="card-body px-3">
                    <div>
                        <label for="fee-status">Turn On/Off Fee</label>
                    </div>   

                    <label class="custom-radio">
                        <input type="radio" name="status" value="1" {{ isset($fee) && $fee->status ? 'checked' : '' }}>
                        <span class="custom-radio-btn"></span> Enable Fee
                    </label>
                    
                    <label class="custom-radio">
                        <input type="radio" name="status" value="0" {{ isset($fee) && !$fee->status ? 'checked' : '' }}>
                        <span class="custom-radio-btn"></span> Disable Fee
                    </label>
                </div>

                <!-- Card Footer with Save Button -->
                <div class="card-footer d-flex justify-content-end">
                    <button id="save-fee-btn" class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .custom-radio {
            display: inline-block;
            position: relative;
            padding-left: 35px;
            margin-right: 20px;
            cursor: pointer;
            font-size: 16px;
            user-select: none;
        }

        /* Hide the browser's default radio button */
        .custom-radio input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom radio button */
        .custom-radio-btn {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #fff;
            border: 2px solid #071251;
            border-radius: 50%;
        }

        /* When the radio button is checked, add a background color */
        .custom-radio input:checked ~ .custom-radio-btn {
            background-color: #071251;
        }

        /* Create the indicator (the dot inside the radio button) */
        .custom-radio-btn:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the dot when the radio button is checked */
        .custom-radio input:checked ~ .custom-radio-btn:after {
            display: block;
        }

        /* Style the dot inside the radio button */
        .custom-radio .custom-radio-btn:after {
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: white;
            transform: translate(-50%, -50%);
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function () {
            $('#fee-form').on('submit', function (e) {
                e.preventDefault();

                let formData = $(this).serialize();
                console.log(formData);
                

                $.ajax({
                    url: '{{ route('admin.fee.save') }}',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        iziToast.success({
                            title: 'Success',
                            message: 'Fee status updated successfully!',
                            position: 'topRight'
                        });
                    },
                    error: function (xhr, status, error) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Error updating fee status!',
                            position: 'topRight'
                        });
                    }
                });
            });
        });
    </script>
@endpush
