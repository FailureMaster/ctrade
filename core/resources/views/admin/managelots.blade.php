@extends('admin.layouts.app')

@section('panel')

    <div class="container my-5">
        <div class="card box--shadow2 b-radius--5 bg--white">
            <form id="lot-form" action="{{ route('admin.savelots') }}" method="POST">
                @csrf   
                <div class="card-header">
                    <h4 class="card-title py-3">Lot Volume Management</h4>
                </div>
                <div class="card-body px-3">
                    <div id="lots-container">
                        @foreach($lots as $index => $lot)
                            <div class="row mb-3 align-items-end lot-row" data-id="{{ $lot->id }}">
                                <div class="col-md-5">
                                    <label for="lot-volume" class="form-label">Lot Volume</label>
                                    <input type="text" class="form-control" name="lot_volume[]" value="{{ $lot->lot_volume }}" placeholder="Enter lot volume">
                                </div>
                                <div class="col-md-5">
                                    <label for="lot-value" class="form-label">Lot Value</label>
                                    <input type="text" class="form-control" name="lot_value[]" value="{{ $lot->lot_value }}" placeholder="Enter lot value">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">Selected</label>
                                    <input type="radio" class="form-check-input" name="selected_lot" value="{{ $index }}" {{ $lot->selected ? 'checked' : '' }}>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-danger remove-lot-btn" data-id="{{ $lot->id }}" type="button">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Button to Add More Lots -->
                    <div class="d-flex justify-content-between mb-3">
                        <button id="add-lot-btn" class="btn btn-primary" type="button">Add Lots</button>
                    </div>
                </div>

                <!-- Card Footer with Save Button -->
                <div class="card-footer d-flex justify-content-end">
                    <button id="save-lots-btn" class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .box--shadow2 {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        .b-radius--5 {
            border-radius: 5px;
        }
        .bg--white {
            background-color: #fff;
        }
    </style>
@endpush

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

@push('script')
    <script>
        $(document).ready(function () {
            let lotCount = {{ count($lots) }};  // Track the number of lots
            const csrfToken = '{{ csrf_token() }}'; // Grab the CSRF token

            // Function to show iziToast notifications
            function showToast(type, message) {
                iziToast[type]({
                    title: type === 'success' ? 'Success' : 'Error',
                    message: message,
                    position: 'topRight',
                    timeout: 3000
                });
            }

            // Add new lot row
            $('#add-lot-btn').on('click', function () {
                let lotRow = `
                    <div class="row mb-3 align-items-end lot-row" data-id="new">
                        <div class="col-md-5">
                            <label class="form-label">Lot Volume</label>
                            <input type="text" class="form-control" name="lot_volume[]" placeholder="Enter lot volume">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Lot Value</label>
                            <input type="text" class="form-control" name="lot_value[]" placeholder="Enter lot value">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Selected</label>
                            <input type="radio" class="form-check-input" name="selected_lot" value="${lotCount}">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger remove-lot-btn" type="button">Remove</button>
                        </div>
                    </div>
                `;
                $('#lots-container').append(lotRow);
                lotCount++;
                
            });

            // Remove lot row
            $(document).on('click', '.remove-lot-btn', function () {
                let row = $(this).closest('.lot-row');
                let lotId = row.data('id');
                console.log('to delete', lotId);

                // If the lot exists in the database, send a delete request
                if (lotId !== 'new') {
                    $.ajax({
                        url: `/admin/lot/${lotId}/delete`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (data) {
                            showToast('success', 'Lot deleted successfully!');
                            row.remove();  // Remove the row from the view
                        },
                        error: function (xhr, status, error) {
                            showToast('error', 'Error deleting lot');
                            console.error('Error:', error);
                        }
                    });
                } else {
                    row.remove();  // Just remove the row from the DOM if it's not saved
                    showToast('success', 'Lot removed successfully!');
                }
            });

            // Save lots using AJAX
            $('#lot-form').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.savelots') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        showToast('success', 'Lots saved successfully!');
                        setTimeout(function() {
                            location.reload();  // Reload the page to update the view
                        }, 1500); // Delay the reload to allow the user to see the notification
                    },
                    error: function (xhr, status, error) {
                        showToast('error', 'Error saving lots');
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endpush

