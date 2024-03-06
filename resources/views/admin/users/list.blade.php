@extends('admin.layouts.default')
@section('content')
<!-- Main section-->
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
    <div class="content-heading">
      <div>Users</div>
    </div>
    <!-- START card-->
    <div class="card card-default">
     <div class="card-header">
       Users List
       <span class="f-right">Total Users: {{$count}}</span>
       <a href="{{ url('/admin/users/create') }}" class="btn btn-info">Add New</a>
       <a href="{{ url('/admin/users/create-bulk-user') }}" class="btn btn-info">Add Multiple Users</a>
     </div>

    <div class="card-body">
     <table class="table table-striped my-4 w-100" id="usersTbl">
      <thead>
        <tr role="row" class="filter">
          <td></td>
          <td><input type="text" class="form-control" name="user_name" id="user_name" autocomplete="off" placeholder="Search by Name"></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Profile Image</th>
          <th>Email Address</th>
          <th>Organisation</th>
          <th>Registration Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        {{-- User list --}}
      </tbody>
    </table>
  </div>
</div>
<!-- END card-->
</div>
</section>

@stop

@section('before_scripts')
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete User <span id="perment"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure to delete <span id="name"></span>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <a class="btn btn-danger" id="delete-url">Yes</a>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Restore User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure to restore <span id="user_name_temp"></span>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <a class="btn btn-danger" id="restore-url">Yes</a>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      {{-- Modal content --}}
    </div>
  </div>
</div>
@stop

@section('header_styles')
<!-- Datatables-->
<link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
<style>
  .user_img {
    height: 50px;
    width: 50px;
    border-radius: 50%;
  }
</style>
@stop
@section('footer_scripts')
<!-- Datatables-->
<script src="{{asset('vendor/datatables.net/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
  $(function () {

    var oTable = $('#usersTbl').DataTable({
      ordering: false,
      processing: true,
      serverSide: true,
      stateSave: true,
      searching: false,
      "order": [[0, "desc"]],
      ajax: {
        url: "{!! route('admin.users.data') !!}",
        data: function (d) {
          d.user_name = $('input[name=user_name]').val();
        }
      },
      columns: [
      {data: 'id', name: 'id'},
      {data: 'name', name: 'name'},
      {data: 'profile_image', name: 'profile_image'},
      {data: 'email', name: 'email'},
      {data: 'organization', name: 'organization'},
      {data: 'registration_date', name: 'registration_date'},
      {data: 'is_active', name: 'is_active'},
      {data: 'action', name: 'action'},
      ]

    });

    $('#user_name').on('keyup', function (e) {
      oTable.draw();
      e.preventDefault();
    });
  });
</script>
<script type="text/javascript">

  $('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var url = button.data('url');
    var name = button.data('name');
    var title = button.data('title');
    var modal = $(this);
    $('#name').html(name);
    $('#perment').html(title);
    modal.find('.modal-footer #delete-url').attr('href',url);
  });

  $('#restoreModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var url = button.data('url');
    var name = button.data('name');
    var modal = $(this);
    $('#user_name_temp').html(name);
    modal.find('.modal-footer #restore-url').attr('href',url);
  });

  $('#viewModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var dataURL = button.data('url');
    $('#viewModal .modal-content').load(dataURL,function(){
    });

  });

</script>

<script type="text/javascript">
  $(document).on('click','.change_status',function(){
    var url = $(this).data('url');
    $.ajax({
      type: 'GET',
      url: url,
      data: '',
      success: function(response){
        toastr[response.msgType](response.msg, response.msgHead);
      }
    });
  });
</script>
@stop
