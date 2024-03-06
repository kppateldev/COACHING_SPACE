<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Organisation Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
<table class="table table-striped">
    <thead>
        <!-- <tr>
            <th>Field Name</th>
            <th>Value</th>
        </tr> -->
    </thead>
    <tbody>
        <tr>
            <td>Organisation ID</td>
            <td>{{$data->id ?? ''}}</td>
        </tr>
        <tr>
            <td>First Name</td>
            <td>{{$data->first_name ?? ''}}</td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td>{{$data->last_name ?? ''}}</td>
        </tr> 
        <tr>
            <td>Organisation Name</td>
            <td>{{$data->company_name ?? ''}}</td>
        </tr>
        <tr>
            <td>Organisation Email Address</td>
            <td>{{$data->email ?? ''}}</td>
        </tr>
        <tr>
            <td>Department Name</td>
            <td>{{ _getDepartmentTitle($data->department_id) }}</td>
        </tr>
        {{--<tr>
            <td>Phone Number</td>
            <td>{{$data->phone_number ?? ''}}</td>
        </tr>--}}
        <tr>
            <td>Sessions Limit</td>
            <td>{{$data->sessions_limit ?? ''}}</td>
        </tr>
        <tr>
            <td>Is Active</td>
            <td>
                @if ($data->status == 1)
                    Yes
                @else
                    No
                @endif
            </td>
        </tr>
    </tbody>
</table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
