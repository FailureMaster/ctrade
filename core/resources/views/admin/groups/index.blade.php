@extends('admin.layouts.app')
@section('panel')
    <div class="bodywrapper__inner">
        <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
            <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins"></div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="p-3">
                    <small><strong>{{ $groups->count() }} Groups</strong></small>
                </div>
                <h4>
                    <a id="btn_add" href="#" data-bs-toggle="modal" data-bs-target="#createGroupModal" class="btn btn-success btn-sm float-end">
                        <i class="fa fa-plus"></i> Add New Group
                    </a>
                </h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name of Group</th>
                            <th>Users</th>
                            <th>Symbols</th>
                            <th>Spread</th>
                            <th>Lots</th>
                            <th>Leverage</th>
                            <th>Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td>{{ $group->name }}</td>
                                
                                <!-- List all users in the group -->
                                <td>
                                    
                                    @foreach($group->groupUsers as $groupUser)
                                        {{ $groupUser->user->firstname }}@if (!$loop->last), @endif
                                    @endforeach
                                </td>

                                <!-- List all symbols and display their settings -->
                                <td>
                                   @php
                                        $arr = [];
                                        $groupSettings = $group->settings->pluck('symbol')->toArray();
                                        // var_dump($groupSettings);

                                        foreach ($symbols as $symbol){
                                            if (in_array($symbol->id,$groupSettings )) {
                                                array_push($arr, $symbol->symbol);
                                            }
                                        }
                                   @endphp
                                    {{ implode(', ', $arr) }}
                                </td>

                                <td>{{ rtrim(rtrim(number_format($group->settings->first()->spread ?? 0, 10), '0'), '.') }}</td>
                                <td>{{ $group->settings->first()->lots ?? 0 }}</td>
                                <td>{{ $group->settings->first()->leverage ?? 0 }}</td>
                                <td>{{ $group->settings->first()->level ?? 0 }}</td>

                                
                                <td>
                                    <a 
                                        class               ="btn btn-primary btn-sm btn-edit" 
                                        data-id             ="{{ $group->id }}" 
                                        data-group-name     ="{{ $group->name }}"
                                        data-users          ="{{ implode(',', $group->groupUsers->pluck('user_id')->toArray()) }}" 
                                        data-symbols        ="{{ implode(',', $group->settings->pluck('symbol')->toArray()) }}" 
                                        data-spread         ="{{ $group->settings->first()->spread ?? '' }}"
                                        data-lots           ="{{ $group->settings->first()->lots ?? '' }}"
                                        data-leverage       ="{{ $group->settings->first()->leverage ?? '' }}"
                                        data-level          ="{{ $group->settings->first()->level ?? '' }}"
                                          
                                    >
                                        Edit
                                    </a>

                                    <a href="#" 
                                        class="btn btn-danger btn-sm btn-delete" 
                                        data-id="{{ $group->id }}" 
                                        data-name="{{ $group->name }}"
                                    >
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal for Creating a Group -->
    <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupModalLabel">Create New Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createGroupForm" action="{{route('admin.groups.create')}}" method="post">
                        @csrf
                        <!-- Group Name -->
                        <div class="mb-3">
                            <label for="groupName" class="form-label">Name of the Group</label>
                            <input type="text" class="form-control" id="groupName" name="groupName" placeholder="Enter group name" required>
                        </div>

                        <!-- Users Field with Select2 -->
                        <div class="mb-3" id="addContainer">
                            <label for="users" class="form-label">Users</label>
                            <select id="users" class="form-control" multiple="multiple" name="users[]">
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->firstname}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3" id="editContainer">
                            <div id="editContainerClone">
                                <label for="usersm" class="form-label">Users</label>
                                <select class="form-control usersm" multiple="multiple" name="users[]">
                                </select>
                            </div>
                        </div>

                        

                        <!-- Symbols Field with Select2 -->
                        <div class="mb-3">
                            <label for="symbols" class="form-label">Symbols</label>
                            <select id="symbols" class="form-control" multiple="multiple" name="symbols[]">
                                @foreach ($symbols as $symbol)
                                    <option value="{{$symbol->id}}">{{$symbol->symbol}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Spread -->
                        <div class="mb-3">
                            <label for="spread" class="form-label" >Spread</label>
                            <input type="number" step="0.000000001" class="form-control" id="spread" name="spread" placeholder="Enter spread" required>
                        </div>
                        
                        <!-- Lots -->
                        <div class="mb-3">
                            <label for="lots" class="form-label" >Lots</label>
                            <input type="number" step="0.01" class="form-control" id="lots" name="lots" placeholder="Enter lots" required>
                        </div>
                        
                        <!-- Leverage -->
                        <div class="mb-3">
                            <label for="leverage" class="form-label" >Leverage</label>
                            <input type="text" class="form-control" id="leverage" placeholder="Enter leverage" name="leverage" required>
                        </div>
                        
                        <!-- Level -->
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <input type="text" class="form-control" id="level" name="level" placeholder="Enter level" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="createGroupForm" class="btn btn-primary">Create Group</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="usersInGroups" id="usersInGroups" value="{{ implode(',', $usersInGroups) }}">

@endsection

@push('script')
    <!-- Include jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 CSS & JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for users and symbols fields when the modal is opened
            let userAll = "{{ json_encode($userAllArrJson) }}";
            let editSelect2 = $('#editContainerClone').clone();
    
            // Initialize Select2 for creating group
            $('#users').select2({
                dropdownParent: $('#createGroupModal'),
                placeholder: "Select users",
                allowClear: true
            });
    
            // Handle modal show event for editing
            $('#createGroupModal').on('shown.bs.modal', function() {
                // Initialize Select2 for editing users
                $('.usersm').select2({
                    dropdownParent: $('#createGroupModal'),
                    placeholder: "Select users",
                    allowClear: true
                });
    
                // Initialize Select2 for symbols
                $('#symbols').select2({
                    dropdownParent: $('#createGroupModal'),
                    placeholder: "Select symbols",
                    allowClear: true
                });
            });
    
            // Handle modal hidden event
            $('#createGroupModal').on('hidden.bs.modal', function() {
                // Show create group container
                $('#addContainer').removeClass('d-none');
    
                // Clear users for edit
                $('.usersm').find('option').remove();
    
                // Show edit container
                $('#editContainer').removeClass('d-none');
            });
    
            // Handle add button click event
            $(document).on('click', '#btn_add', function() {
                let addurl = "{{ route('admin.groups.create') }}";
                let modal = $('#createGroupModal');
    
                modal.find('form').attr('action', addurl);
    
                $('#editContainer').addClass('d-none');
                $('#createGroupForm')[0].reset();
                $('.modal-footer button[type="submit"]').text('Create Group');
            });
    
            // Handle edit button click event
            $(document).on('click', '.btn-edit', function() {
                let modal = $('#createGroupModal');
                userAll = userAll.replace(/&quot;/g, '"');
    
                // Parse the JSON string into a JavaScript array
                let array = JSON.parse(userAll);
    
                // Hide create group container
                $('#addContainer').addClass('d-none');
    
                // Get data from the clicked button
                let id          = $(this).attr('data-id');
                let groupName   = $(this).attr('data-group-name');
                let users       = $(this).attr('data-users').split(',');
                let symbols     = $(this).attr('data-symbols').split(',');
                let spread      = parseFloat($(this).attr('data-spread')).toString(); // Remove trailing zeros
                let lots        = $(this).attr('data-lots');
                let leverage    = $(this).attr('data-leverage');
                let level       = $(this).attr('data-level');
    
                // Set form action URL for updating the group
                let updateUrl = "{{ route('admin.groups.update', ':id') }}".replace(':id', id);
                modal.find('form').attr('action', updateUrl);
    
                // Populate the form fields with the data
                modal.find('#groupName').val(groupName);
                modal.find('#spread').val(spread);
                modal.find('#lots').val(lots);
                modal.find('#leverage').val(leverage);
                modal.find('#level').val(level);
    
                let usersInGroups   = $('#usersInGroups').val().split(',');
                usersInGroups       = usersInGroups.filter(item => !users.includes(item));
    
                array.forEach(option => {
                    let newOption = new Option(option.name, option.id, false, false);
                    $('.usersm').append(newOption);
                });
    
                usersInGroups.forEach(id => {
                    modal.find('.usersm').find('option[value="' + id + '"]').remove();
                });
    
                // Set selected values for users and symbols
                $('.usersm').val(users).trigger('change');
                $('#symbols').val(symbols).trigger('change');
    
                $('.modal-footer button[type="submit"]').text('Update Group');
    
                // Show the modal
                modal.modal('show');
            });
    
            // Check if the group was deleted
            if (localStorage.getItem('groupDeleted') === 'true') {
                // Show the success notification
                notify('success', 'Group deleted successfully!');
                // Remove the flag from localStorage
                localStorage.removeItem('groupDeleted');
            }


            // Handle delete button click event
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();

                let id = $(this).attr('data-id');
                let groupName = $(this).attr('data-name');
                let url = "{{ route('admin.groups.delete', ':id') }}".replace(':id', id); // Use the correct route

                // Confirm deletion
                if (confirm(`Are you sure you want to delete the group "${groupName}"?`)) {
                    $.ajax({
                        url: url, // Use the generated URL
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}' // CSRF token for security
                        },
                        success: function(response) {
                            // Set a flag in localStorage indicating a successful deletion
                            localStorage.setItem('groupDeleted', 'true');
                            // Reload the page to update the list
                            location.reload();
                        },
                        error: function(xhr) {
                            // Use iziToast to show an error notification
                            notify('error', 'An error occurred while deleting the group. Please try again.');
                        }
                    });
                }
            });


        });
    </script>
    
@endpush

