@extends('admin.layouts.app')
@push('style')
<style>
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .accordion-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .accordion-header {
        background: #f8f8f8;
        padding: 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        user-select: none;
    }

    .accordion-header:hover {
        background: #f0f0f0;
    }

    .accordion-content {
        padding: 15px;
        display: none;
        border-top: 1px solid #ddd;
    }

    .accordion-content.active {
        display: block;
    }

    .symbol-list {
        margin-bottom: 15px;
        padding-left: 25px;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 5px;
    }

    .settings-row {
        display: flex;
        gap: 15px;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 4px;
        margin-top: 15px;
    }

    .input-group {
        flex: 1;
    }

    .input-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 0.9em;
        color: #666;
    }

    .input-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #eee;
        text-align: right;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        margin-left: 10px;
    }

    .btn-close {
        background: #f5f5f5;
        color: #333;
    }

    .btn-create {
        background: #007bff;
        color: white;
    }

    input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .main-category {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: bold;
    }
</style>
@endpush
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
            <div class="card-body p-0 ">
                <div class="table-responsive"> 
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
                                            @if( $groupUser->user == null ) @continue @endif
                                            {{ $groupUser->user->firstname }}@if (!$loop->last), @endif
                                        @endforeach
                                    </td>

                                    <!-- List all symbols and display their settings -->
                                    <td style="white-space: wrap;">
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
    </div>


    <!-- Modal for Creating a Group -->
    {{-- <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel" aria-hidden="true">
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
    </div> --}}
    <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Create New Group</h2>
                    <button class="btn btn-close" onclick="closeModal()">×</button>
                </div>
                
                <div class="modal-body">
                    <form id="createGroupForm" action="{{route('admin.groups.create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Name of the Group</label>
                            <input type="text" name="groupName" class="form-control" placeholder="Enter group name">
                        </div>

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

                        <!-- GCC Stocks -->
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion('gcc-stocks')">
                                <div class="main-category">
                                    <input type="checkbox" onchange="toggleCategory(this, 'gcc-symbols')" onclick="event.stopPropagation()"> 
                                    GCC Stocks
                                </div>
                            </div>
                            <div class="accordion-content" id="gcc-stocks">
                                <div class="symbol-list" id="gcc-symbols">
                                
                                    @foreach ($symbols->where('type', 'Stocks') as $symbol)
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" class="chksymbol" id="symbol-{{ $symbol->id }}" name="symbols[]" value="{{$symbol->id}}"> 
                                            <label for="symbol-{{ $symbol->id }}">{{$symbol->symbol}}</label>
                                        </div>
                                    @endforeach
                            
                                </div>
                            </div>
                        </div>

                        <!-- Forex -->
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion('forex')">
                                <div class="main-category">
                                    <input type="checkbox" onchange="toggleCategory(this, 'forex-symbols')" onclick="event.stopPropagation()"> 
                                    Forex
                                </div>
                            </div>
                            <div class="accordion-content" id="forex">
                                <div class="symbol-list" id="forex-symbols">
                                    @foreach ($symbols->where('type', 'FOREX') as $symbol)
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" class="chksymbol" id="symbol-{{ $symbol->id }}" name="symbols[]" value="{{$symbol->id}}"> 
                                            <label for="symbol-{{ $symbol->id }}">{{$symbol->symbol}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Index -->
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion('index')">
                                <div class="main-category">
                                    <input type="checkbox" onchange="toggleCategory(this, 'index-symbols')" onclick="event.stopPropagation()"> 
                                    Index
                                </div>
                            </div>
                            <div class="accordion-content" id="index">
                                <div class="symbol-list" id="index-symbols">
                                    @foreach ($symbols->where('type', 'INDEX') as $symbol)
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" class="chksymbol" id="symbol-{{ $symbol->id }}" name="symbols[]" value="{{$symbol->id}}"> 
                                            <label for="symbol-{{ $symbol->id }}">{{$symbol->symbol}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Crypto -->
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion('crypto')">
                                <div class="main-category">
                                    <input type="checkbox" onchange="toggleCategory(this, 'crypto-symbols')" onclick="event.stopPropagation()"> 
                                    Crypto
                                </div>
                            </div>
                            <div class="accordion-content" id="crypto">
                                <div class="symbol-list" id="crypto-symbols">
                                    @foreach ($symbols->where('type', 'Crypto') as $symbol)
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" class="chksymbol" id="symbol-{{ $symbol->id }}" name="symbols[]" value="{{$symbol->id}}"> 
                                            <label for="symbol-{{ $symbol->id }}">{{$symbol->symbol}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Commodity -->
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion('commodity')">
                                <div class="main-category">
                                    <input type="checkbox" onchange="toggleCategory(this, 'commodity-symbols')" onclick="event.stopPropagation()"> 
                                    Commodity
                                </div>
                            </div>
                            <div class="accordion-content" id="commodity">
                                <div class="symbol-list" id="commodity-symbols">
                                    @foreach ($symbols->where('type', 'COMMODITY') as $symbol)
                                        <div class="checkbox-wrapper">
                                            <input type="checkbox" class="chksymbol" id="symbol-{{ $symbol->id }}" name="symbols[]" value="{{$symbol->id}}"> 
                                            <label for="symbol-{{ $symbol->id }}">{{$symbol->symbol}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                
                        <div class="d-flex">
                            <!-- Spread -->
                            <div class="mb-3">
                                <label for="spread" class="form-label" >Spread</label>
                                <input type="number" step="0.000000001" class="form-control" id="spread" name="spread" placeholder="Enter spread" required>
                            </div>
                        
                            <!-- Lots -->
                            <div class="mb-3 mx-2">
                                <label for="lots" class="form-label" >Lots</label>
                                <input type="number" step="0.01" class="form-control" id="lots" name="lots" placeholder="Enter lots" required>
                            </div>
                        
                            <!-- Leverage -->
                            <div class="mb-3">
                                <label for="leverage" class="form-label" >Leverage</label>
                                <input type="text" class="form-control" id="leverage" placeholder="Enter leverage" name="leverage" required>
                            </div>
                        
                            <!-- Level -->
                            <div class="mb-3 mx-2">
                                <label for="level" class="form-label">Level</label>
                                <input type="text" class="form-control" id="level" name="level" placeholder="Enter level" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" onclick="closeModal()">Close</button>
                    <button type="submit" form="createGroupForm" class="btn btn-create">Create Group</button>
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
        function toggleAccordion(id) {
            const content = document.getElementById(id);
            const allContents = document.querySelectorAll('.accordion-content');
            
            // Close all other accordions
            allContents.forEach(item => {
                if (item.id !== id) {
                    item.classList.remove('active');
                }
            });

            // Toggle the clicked accordion
            content.classList.toggle('active');
        }

        function toggleCategory(checkbox, categoryId) {
            const category = document.getElementById(categoryId);
            const checkboxes = category.getElementsByTagName('input');
            for (let box of checkboxes) {
                box.checked = checkbox.checked;
            }
        }

        function closeModal() {
            const modal = document.querySelector('.modal');
            if (modal) {
                $(modal).modal('hide');
            }
        }

        function createGroup() {
            // Collect all form data
            const formData = {
                name: document.querySelector('input[placeholder="Enter group name"]').value,
                users: document.querySelector('input[placeholder="Select users"]').value,
                categories: {}
            };

            // Collect data for each category
            const categories = ['gcc-stocks', 'forex', 'index', 'crypto', 'commodity'];
            categories.forEach(category => {
                const categoryContent = document.getElementById(category);
                if (categoryContent) {
                    const symbols = [];
                    categoryContent.querySelectorAll('.checkbox-wrapper input:checked').forEach(checkbox => {
                        symbols.push(checkbox.parentElement.textContent.trim());
                    });

                    const settings = {};
                    categoryContent.querySelectorAll('.settings-row input').forEach(input => {
                        settings[input.previousElementSibling.textContent.toLowerCase()] = input.value;
                    });

                    if (symbols.length > 0) {
                        formData.categories[category] = {
                            symbols,
                            settings
                        };
                    }
                }
            });

            console.log('Form Data:', formData);
            // Add your form submission logic here
            alert('Group created successfully!');
        }
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

                // Clear symbol for edit
                $('.chksymbol').prop('checked', false);
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
                // $('#symbols').val(symbols).trigger('change');

                symbols.forEach(s => {
                    $('.chksymbol[value="'+s+'"]').prop('checked', true);
                });
    
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

