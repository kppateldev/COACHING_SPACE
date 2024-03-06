@extends('admin.layouts.default')
@section('content')
<!-- Main section-->
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
    <div class="content-heading">
      <div>Organisations</div>
    </div>
    <!-- START card-->
    <div class="card card-default">
     <div class="card-header">
       Organisations List
       <span class="f-right">Total Organisations: {{$count}}</span>
       <a href="{{ url('/admin/organizations/create') }}" class="btn btn-info">Add New</a>
     </div>

    <div class="card-body">
     <table class="table table-striped my-4 w-100" id="organizationsTbl">
      <thead>
        <tr role="row" class="filter">
          <td></td>
          <td><input type="text" class="form-control" name="company_name" id="company_name" autocomplete="off" placeholder="Search by Organization Name"></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th>Organisation ID</th>
          <th>Organisation Name</th>
          <th>Department Name</th>
          <th>Email Address</th>
          <th>No. Of Users</th>
          <th>Sessions Limit</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        {{-- organization list --}}
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
        <h5 class="modal-title" id="exampleModalLabel">Delete organisation <span id="perment"></span></h5>
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
        <h5 class="modal-title" id="exampleModalLabel">Restore organisation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure to restore <span id="org_name_temp"></span>?
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
  .organization_img {
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

    var oTable = $('#organizationsTbl').DataTable({
      ordering: false,
      processing: true,
      serverSide: true,
      stateSave: true,
      searching: false,
      "order": [[0, "desc"]],
      ajax: {
        url: "{!! route('admin.organizations.data') !!}",
        data: function (d) {
          d.company_name = $('input[name=company_name]').val();
        }
      },
      columns: [
      {data: 'id', name: 'id'},
      {data: 'company_name', name: 'company_name'},
      {data: 'department', name: 'department'},
      {data: 'email', name: 'email'},
      {data: 'no_of_users', name: 'no_of_users'},
      {data: 'sessions_limit', name: 'sessions_limit'},
      {data: 'statusHTML', name: 'statusHTML'},
      {data: 'action', name: 'action'},
      ]

    });

    $('#company_name').on('keyup', function (e) {
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
    var modal = $(this);
    var title = button.data('title');
    $('#name').html(name);
    $('#perment').html(title);
    modal.find('.modal-footer #delete-url').attr('href',url);
  });

  $('#restoreModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var url = button.data('url');
    var name = button.data('name');
    var modal = $(this);
    $('#org_name_temp').html(name);
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
