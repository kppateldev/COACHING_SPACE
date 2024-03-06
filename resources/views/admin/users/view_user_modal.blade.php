<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
<table class="table table-striped">
    <thead>
        <!-- <tr>
            <th>Field Name</th>
            <th>Data</th>
        </tr> -->
    </thead>
    <tbody>
        <tr>
            <td>Id</td>
            <td>{{$data->id}}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{$data->name}}</td>
        </tr>
        <tr>
            <td>Profile Image</td>
            <td>
                @if($data->profile_image)
                    <a href="{{asset('uploads/'.$data->profile_image)}}" target="_blank">
                        <img height="70px" src="{{asset('uploads/'.$data->profile_image)}}">
                    </a>
                @else
                    <a href="{{asset('assets/admin/img/user.png')}}" target="_blank">
                        <img height="70px" src="{{asset('assets/admin/img/user.png')}}">
                    </a>
                @endif
            </td>
        </tr>
        <tr>
            <td>Email Address</td>
            <td>{{$data->email}}</td>
        </tr>
        {{--<tr>
            <td>Phone Number</td>
            <td>{{$data->phone_number}}</td>
        </tr>--}}
        <tr>
            <td>Organisation</td>
            <td>{{ $data->organization->company_name ?? '--' }}</td>
        </tr>
        <tr>
            <td>Department Name</td>
            <td>{{ _getDepartmentTitle($data->department_id) }}</td>
        </tr>
        <tr>
            <td>Last Login Time</td>
            <td>{{ nice_date_time($data->last_seen) ?? '--' }}</td>
        </tr>
        <tr>
            <td>IP Address</td>
            <td>{{ $data->ip_address ?? '--' }}</td>
        </tr>
        <tr>
            <td>Is Active</td>
            <td>
                @if ($data->is_active == 1)
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
