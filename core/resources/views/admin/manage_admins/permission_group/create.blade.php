@extends('admin.layouts.app')
@section('panel')
<div class="card">
    <!-- extends('admin.layouts.master')
section('title',__('group-create'))
section('content')
 -->
    <div class="card-body">
        <form action="{{route('admin.manage_admins.permission_group.store')}}" method="POST">
            @csrf
            <div class="row mb-2 justify-content-center">
                <div class="col-md-6">
                    <div class="form-group mb-2">
                        <label class="form-label">{{__('Group Name')}}</label>
                        <input class="form-control" name="name" placeholder="Group Name">
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customChec" name="status">
                            <label class="form-label custom-control-label" for="customChec">{{__('Status')}}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <h3>{{__('Permission')}}</h3>
                <hr />
                @php
                    $count       = 0;
                    $offsetCol   = auth()->guard('admin')->user()->id == 1 ? 6 : 5;
                    $new_offset  = 1;
                    $offsetCount = 3;
                    $startKey    = "dashboard";
                @endphp
                <div class="row">
                    @for( $i = 0; $i < $offsetCount; $i++ )
                        @php
                            $filteredItems = $newPermission->skipUntil(function ($value, $key) use ( $startKey ){
                                return $key === $startKey;
                            });
                        @endphp
                        <div class="col-md-4 mb-2">
                            @foreach($filteredItems as $key => $data)
                                <div class="row mb-2">
                                    <div class="col-md-12 p-2">
                                        <div class="group-box mb-0">
                                            <span class="group-box-label">{{ ucwords($key) }}</span>
                                            @foreach($data as $per )
                                                <div class="form-group mb-0">
                                                    <div class="custom-control custom-checkbox mb-0">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck{{$count+1}}" name="permission[{{$per['name']}}]" {{$per['value']?'checked':''}} value="true">
                                                        <label class="form-label custom-control-label" for="customCheck{{$count+1}}">{{$per['label']}}</label>
                                                    </div>
                                                </div>
                                                @php
                                                    $count++; 
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $new_offset++;
                                    if( $new_offset > $offsetCol ){
                                        $keys = $newPermission->keys();

                                        // Get the key
                                        $getKey = $keys[$offsetCol];

                                        $offsetCol += ( auth()->guard('admin')->user()->id == 1 ? 6 : 5 );

                                        $startKey = $getKey;
                                        break;
                                    }
                                @endphp
                            @endforeach
                        </div>
                    @endfor
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn btn--primary mt-2 w-100 h-45">@lang('Submit')</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('style')
    <style>
        .group-box {
            border: 1px solid #ddd; /* Border for the panel */
            padding: 15px; /* Inner spacing */
            border-radius: 5px; /* Rounded corners */
            background-color: #f9f9f9; /* Light gray background */
            position: relative; /* For label positioning */
        }
        .group-box-label {
            position: absolute;
            top: -12px;
            left: 15px;
            background: #f9f9f9; /* Match the background color */
            padding: 0 5px;
            font-size: 14px;
            color: #555; /* Text color */
        }
    </style>
@endpush