<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Session Details</h5>
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
            <td>Id</td>
            <td>{{$data->id ?? ''}}</td>
        </tr>
        <tr>
            <td>Coach</td>
            <td>{{$data->CoachData->name ?? ''}} ({{$data->CoachData->email ?? ''}})</td>
        </tr>
        <tr>
            <td>User</td>
            <td>{{$data->UserData->name ?? ''}} ({{$data->UserData->email ?? ''}})</td>
        </tr> 
        <tr>
            <td>Date / Time</td>
            <td>{{ date("d-M-Y",strtotime($data->date))." ".$data->time }}</td>
        </tr>
        <tr>
            <td>User like to discuss</td>
            <td>{{ $data->like_to_discuss }}</td>
        </tr>
        @if(isset($data->status) && $data->status == 'canceled')
        <tr>
            <td>Cancel Reason</td>
            <td>{{ $data->cancel_reason }}</td>
        </tr>
        @endif
        @if(isset($data->status) && $data->status == 'upcoming')
        <tr>
            <td>MS Teams Link</td>
            <td><a href="{{ $data->ms_join_web_url ?? '' }}" class=""><button class="btn btn btn-info w-25">MS Teams Link</button></a></td>
        </tr>
        @endif
        <tr>
            <td>User notes</td>
            <td>{{ $data->user_notes ?? 'Not added' }}</td>
        </tr>
        <tr>
            <td>Session Report(Coach)</td>
            <td>{{ $data->session_report ?? 'Not added' }}</td>
        </tr>   
        <tr>
            <td>Status</td>
            <td>{{ ucwords($data->status) }}</td>
        </tr>
    </tbody>
</table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
