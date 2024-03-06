@extends('admin.layouts.default')
@section('content')
<!-- Main section-->
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
    <div class="content-heading">
      <div>Organization - {{ $organization->company_name }}</div>
    </div>
    <!-- START card-->
    <div class="card card-default">
     <div class="card-header">
       Users List
       <span class="f-right"></span>
     </div>

    <div class="card-body">
     <table class="table table-striped my-4 w-100" id="organizationsTbl">
      <thead>
        <tr role="row" class="filter">
          <td></td>
          <td></td>
          <td></td>
          <td><input type="text" class="form-control" name="user_name" id="user_name" autocomplete="off" placeholder="Search by Name"></td>
        </tr>
        <tr>
          <th>User ID</th>
          <th>Name</th>
          <th>Email Address</th>
          <th>Phone Number</th>
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


@section('header_styles')
<!-- Datatables-->
<link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
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
        url: "{!! route('admin.organizations.users.data',$organization->id) !!}",
        data: function (d) {
          d.user_name = $('input[name=user_name]').val();
        }
      },
      columns: [
      {data: 'id', name: 'id'},
      {data: 'name', name: 'name'},
      {data: 'email', name: 'email'},
      {data: 'phone_number', name: 'phone_number'},
      ]

    });

    $('#user_name').on('keyup', function (e) {
      oTable.draw();
      e.preventDefault();
    });
  });
</script>
@stop
