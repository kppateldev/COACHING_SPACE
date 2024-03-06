<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Coach Details</h5>
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
            <td>{{ $data->phone_number ?? '---' }}</td>
        </tr>--}}
        <tr>
            <td>Tagline</td>
            <td>{{$data->tagline}}</td>
        </tr>
        <tr>
            <td>About</td>
            <td>{{$data->about}}</td>
        </tr>
        <tr>
            <td>Career Levels</td>
            <td>{{ $data->coachCoachingLevelStr() }}</td>
        </tr>
        <tr>
            <td>Strengths</td>
            <td>{{ $data->coachStrengthsStr() }}</td>
        </tr>
        {{--<tr>
            <td>Calendly Link</td>
            <td>{{ $data->calendly_link ?? '---' }}</td>
        </tr>--}}
        <?php 
        $admin = \App\Models\Admin::where('id',$data->created_by)->first();
        if($data->created_by == '1'){
            $role = 'Super Admin';
        }else{
            $role = 'Coach Admin';
        }
        ?>
        <tr>
            <td>Added By</td>
            <td>{{ $admin->email ?? '---' }} ({{ $role }})</td>
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
