<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Updated By</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $data as $d )
                <tr>
                    <td>{{ $d->created_at }}</td>
                    <td>{{ $d->updatedBy->name }}</td>
                    <td>{{ $d->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if( $data->count() < 1)
 <p class="text-center">No available data</p>
@endif