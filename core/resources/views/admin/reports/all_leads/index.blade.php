@php
    $currentFilter = request('filter');
@endphp
@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two highlighted-table">
                            <thead>
                                <tr>
                                    <th>@lang('Online Status')</th>
                                    <th>@lang('ID')</th>
                                    <th>@lang('First Name')</th>
                                    <th>@lang('Last Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Last Login')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $users as $u )
                                    <tr>
                                        <td>

                                        </td>
                                        <td>
                                            {{ $u->lead_code }}
                                        </td>
                                        <td>
                                            {{ $u->firstname }}
                                        </td>
                                        <td>
                                             {{ $u->lastname }}
                                        </td>
                                        <td>
                                             {{ $u->email }}
                                        </td>
                                        <td>
                                             {{-- {{ $u->lead_code }} --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer py-4">
                        <div>
                            <small>
                                @if ($users->firstItem())
                                    <strong>{{ $users->firstItem() }} - {{ $users->lastItem() }} of
                                        {{ $users->total() }}</strong>
                                @endif
                            </small>
                        </div>
                        <div class="d-flex justify-content-center mb-3">
                            {{ paginateLinks($users) }}
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <form action="{{ url()->current() }}" method="GET"
                                class="d-flex align-items-center gap-2">
                                {{-- {{dd(parse_url(url()->full()));}} --}}
                                @foreach (request()->query() as $key => $value)
                                    @if ($key !== 'per_page')
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                                <span for="per_page" class="per_page_span" style="font-size: 12px">View</span>
                                <select name="per_page" id="per_page" onchange="this.form.submit()"
                                    style="font-size: 14px !important; padding: 0">
                                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}
                                        style="font-size: 14px !important; padding: 0">5</option>
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}
                                        style="font-size: 14px important; padding: 0">10</option>
                                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}
                                        style="font-size: 14px important; padding: 0">25</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}
                                        style="font-size: 14px important; padding: 0">50</option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}
                                        style="font-size: 14px important; padding: 0">100</option>
                                </select>
                                <span for="per_page" class="me-2 per_page_span" style="font-size: 12px">Per Page</span>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script>
        // // Add event listeners to all edit buttons
        // (function ($) {
        //     "use strict";
        try {
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.edit-comment-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const comment = button.getAttribute('data-comment');
                        const userId = button.getAttribute('data-userid');

                        document.getElementById('userComment').value = comment;
                        document.getElementById('commentUserId').value = userId;

                        if (document.getElementById('userComment').value == "") {
                            document.getElementById('userComment').value = 'No comments';
                        }

                        const form = document.getElementById('editCommentForm');
                        form.action = '/admin/users/update-comment/' + userId;
                        const modal = new bootstrap.Modal(document.getElementById(
                            'commentModal'), {});
                        modal.show();
                    });
                });
                document.querySelectorAll('.edit-owner-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const gotOwner = button.getAttribute('data-owner');
                        const owner = gotOwner ? JSON.parse(gotOwner) : undefined;
                        const userId = button.getAttribute('data-userid');
                        const ownerSelect = document.getElementById('userOwner');
                        ownerSelect.value = String(owner ? owner.id : 0);
                        // // Iterate over the options and select the matching one
                        // let someSelected = false;
                        // Array.from(ownerSelect.options).forEach(function (option) {
                        //     console.log('inside closure');
                        //     console.log(owner, typeof owner);
                        //     console.log(option.value, typeof option.value, owner.id, typeof owner.id);
                        //     if (Number(option.value) === Number(owner.id)) {
                        //         option.selected = true;
                        //         someSelected = true;
                        //     }
                        // });
                        // if (!someSelected) {
                        //     Array.from(ownerSelect.options).forEach(function (option) {
                        //         if (Number(option.value) === 0) {
                        //             option.selected = true;
                        //         }
                        //     });
                        // }
                        document.getElementById('ownerUserId').value = userId;
                        const form = document.getElementById('editOwnerForm');
                        form.action = '/admin/users/update-owner/' + userId;
                        const modal = new bootstrap.Modal(document.getElementById(
                        'ownerModal'), {});
                        modal.show();
                    });
                });
                document.querySelectorAll('.edit-status-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const status = button.getAttribute('data-status');
                        const userId = button.getAttribute('data-userid');
                        const statusSelect = document.getElementById('userStatus');
                        statusSelect.value = String(status ? status : 'NEW');
                        document.getElementById('statusUserId').value = userId;
                        const form = document.getElementById('editStatusForm');
                        form.action = '/admin/users/update-status/' + userId;
                        const modal = new bootstrap.Modal(document.getElementById(
                            'statusModal'), {});
                        modal.show();
                    });
                });
            });
        } catch (e) {
            console.error(e);
        }
        // })(jQuery);
    </script>
@endpush
@push('script')
    <script src="{{ asset('assets/global/js/iziToast.min.js') }}"></script>
    <script>
        "use strict";
        (function($) {
            $(document).ready(function() {
                const checkAll = $('#checkAll');
                const checkboxes = $('.selectUser');
                const selectedCountSpan = $('.selected-leads-count');

                function updateSelectedCount() {
                    let selectedCount = checkboxes.filter(':checked').length;
                    selectedCountSpan.text(selectedCount);

                    $('.bulk-action').toggle(selectedCount > 0);
                    $('.delete-action').toggle(selectedCount > 0);
                }

                updateSelectedCount();

                checkAll.on('change', function() {
                    let isChecked = this.checked;

                    $('.bulk-action').toggle(isChecked);

                    checkboxes.prop('checked', isChecked);

                    updateSelectedCount();
                });

                checkboxes.on('change', function() {
                    if (!this.checked) {
                        checkAll.prop('checked', false);
                    }
                    if (checkboxes.filter(':checked').length === checkboxes.length) {
                        checkAll.prop('checked', true);
                    }

                    updateSelectedCount();
                });

                $('#submitBtn').on('click', function() {
                    // Collect the IDs of the selected checkboxes
                    let selectedIds = [];
                    checkboxes.filter(':checked').each(function() {
                        selectedIds.push(parseInt($(this).val()));
                    });

                    // Collect the form data
                    const formData = {
                        owner_id: parseInt($('.owner_id').val()),
                        sales_status: $('.sales_status').val(),
                        account_type: $('.account_type').val(),
                        selected_ids: selectedIds,
                        _token: "{{ csrf_token() }}"
                    };

                    console.log('Form Data:', formData);

                    Swal.fire({
                        target: document.getElementById('withdraw-offcanvas'),
                        text: "Are you sure you want to update the selected user?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let url = "{{ route('admin.users.bulk.record.update') }}";
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: formData,
                                success: function(response) {
                                    iziToast.success({
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1500);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error);
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.delete-action', function() {
                    // Collect the IDs of the selected checkboxes
                    let selectedIds = [];
                    checkboxes.filter(':checked').each(function() {
                        selectedIds.push(parseInt($(this).val()));
                    });

                    $.ajax({
                        url: "{{ route('admin.users.bulk.record.delete') }}",
                        type: 'POST',
                        data: {
                            ids: selectedIds,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            window.location.reload();

                            iziToast['success']({
                                message: 'deleted successful',
                                position: 'topRight',
                                displayMode: 1
                            });

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                });

                $(document).on('click', '.btn-ac', function(e) {
                    e.preventDefault();
                    let form = $(this).parent('form');
                    Swal.fire({
                        target: document.getElementById('withdraw-offcanvas'),
                        text: "Are you sure?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(form).submit();
                        }
                    });

                })


            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        #checkAll {
            border: 1px solid white;
        }

        .bulk-action,
        .delete-action {
            display: none;
        }


        tbody tr:nth-child(even) {
            background-color: #ebecee;
        }

        table.table--light.style--two thead th {
            border-top: none;
            padding-left: 10px;
            padding-right: 10px;
        }

        table.table--light.style--two tbody td {
            padding: 4px 0px;
        }
    </style>
@endpush
