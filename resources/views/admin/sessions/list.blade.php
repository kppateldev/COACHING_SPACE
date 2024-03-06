@extends('admin.layouts.default')
@section('content')
<!-- Main section-->
<link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
    <div class="content-heading">
      <div>Sessions</div>
    </div>
    <!-- START card-->
    <div class="card card-default">
     <div class="card-header">
       Sessions List
       <span class="f-right">Total Sessions: {{$count}}</span>
       <!-- <a href="{{ url('/admin/sessions/create') }}" class="btn btn-info">Add New</a> -->
     </div>

     <div class="card-body">
       <table class="table table-striped my-4 w-100" id="sessionsTbl" style="width:100%">
        <thead>
          <tr role="row" class="filter">
            <td></td>
            <td></td>
            <td><div class="form-group row mb-2"><input type="text" id="date_picker1" class="form-control custom-picker" name="session_start_date" placeholder="Session Start Date" value="{{ isset($_GET['session_start_date']) ? $_GET['session_start_date'] : '' }}"></div></td>
            <td><div class="form-group row mb-2"><input type="text" id="date_picker2" class="form-control custom-picker" name="session_end_date" placeholder="Session End Date" value="{{ isset($_GET['session_end_date']) ? $_GET['session_end_date'] : '' }}"></div></td>
            <td><select class="form-control" name="session_status" id="session_status">
              <option value="">Session Status</option>
              <option value="upcoming">Upcoming</option>
              <option value="completed">Completed</option>
              <option value="canceled">Canceled</option>
            </select></td>
            <td></td>
          </tr>
          <tr>
            <th>ID</th>
            <th>Coach</th>
            <th>User</th>
            <th>Date/Time</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {{-- Session list --}}
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
        <h5 class="modal-title" id="exampleModalLabel">Delete session</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure to delete this session?
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
        <h5 class="modal-title" id="exampleModalLabel">Restore session</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure to restore this session?
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
<link rel="stylesheet" href="{{ asset('front_assets/css/font-awesome-all.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{ asset('front_assets/css/datatable/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('front_assets/css/datatable/buttons.dataTables.min.css')}}">
<style>
  .session_img {
    height: 50px;
    width: 50px;
    border-radius: 50%;
  }
</style>
<style>
.fc-event-title {
    display: none;
}
.ui-datepicker-prev:before {
    content: "\f053";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    font-size: 16px;
}
.ui-datepicker-next:before {
    content: "\f054";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    font-size: 16px;
}
.status_available{
    background: #00800085 !important;
}
.cal_box {
    float: left;
    height: 20px;
    width: 20px;
    margin-bottom: 15px;
    margin-left: 10px;
    border: 1px solid black;
    clear: both;
}
.cal_box_span{
    margin: 0px 5px;
}
.cal_box_green {
    padding: 0px 5px;
    background-color: #b2d8b2;
}
.cal_box_blocked{
    padding: 0px 5px;
    background: linear-gradient(to right top, rgba(158, 154, 154, 0.38) calc(50% - 1px), rgb(0, 0, 0), rgba(158, 154, 154, 0.38) calc(50% + 1px));
    opacity: var(--fc-bg-event-opacity,.3);
}
.fc-day-past{
    padding: 0px 5px;
    background: #6d706d85 !important;
    opacity: var(--fc-bg-event-opacity,.3);
}
</style>
@stop
@section('footer_scripts')
<!-- Datatables-->
<script src="{{asset('vendor/datatables.net/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{ asset('front_assets/js/datatable/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('front_assets/js/datatable/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('front_assets/js/datatable/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('front_assets/js/datatable/vfs_fonts.js')}}"></script>
<script>
  $(function () {

    var oTable = $('#sessionsTbl').DataTable({

      ordering: false,
      processing: true,
      serverSide: true,
      stateSave: true,
      searching: false,
      "order": [[0, "desc"]],
      ajax: {
        url: "{!! route('admin.sessions.data') !!}",
        data: function (d) {
          d.session_start_date = $('input[name=session_start_date]').val();
          d.session_end_date = $('input[name=session_end_date]').val();
          d.session_status = $('select[name=session_status]').val();
        }
      },
      columns: [
      {data: 'id', name: 'id'},
      {data: 'coach_name', name: 'coach_name'},
      {data: 'user_name', name: 'user_name'},
      {data: 'dateTime', name: 'dateTime'},
      {data: 'statusHTML', name: 'statusHTML'},
      {data: 'action', name: 'action'},
      ],
      dom: 'lBfrtip',
      buttons: [
      {
        extend: 'pdf',
        title: 'Export Sessions PDF',
        customize: function (doc) {
               doc.defaultStyle.fontSize = 10; //2, 3, 4,etc
               doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
               doc.defaultStyle.alignment = 'left';
               doc.styles.tableHeader.alignment = 'left';
               doc.styles.tableHeader.padding = 10;
               doc.content[1].table.widths = [ '10% ',  '20%', '20%', '30%', 
               '20%'];
             },
             exportOptions: {
              columns: [0,1,2,3,4]
            }
          }],
        });

    $('#date_picker1').change(function(e) {
      oTable.draw();
      e.preventDefault();
    });

    $('#date_picker2').change(function(e) {
      oTable.draw();
      e.preventDefault();
    });

    $('#session_status').on('change', function (e) {
      oTable.draw();
      e.preventDefault();
    });


  });
</script>
<script type="text/javascript">

  $('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var url = button.data('url');
    var modal = $(this);
    modal.find('.modal-footer #delete-url').attr('href',url);
  });

  $('#restoreModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var url = button.data('url');
    var modal = $(this);
    modal.find('.modal-footer #restore-url').attr('href',url);
  });

  $('#viewModal').on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget);
    var dataURL = button.data('url');

    $('.modal-content').load(dataURL,function(){
     $('#viewModal').modal('show');
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

<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>
  $(document).ready(function() {
    var startDate;
    var endDate;
    $( "#date_picker1" ).datepicker({
      dateFormat: 'dd-mm-yy'
    })
    $( "#date_picker2" ).datepicker({
      dateFormat: 'dd-mm-yy'
    });
    $('#date_picker1').change(function() {
      startDate = $(this).datepicker('getDate');
      console.log(startDate);
      $("#date_picker2").datepicker("option", "minDate", startDate );
    })
    $('#date_picker2').change(function() {
      endDate = $(this).datepicker('getDate');
      $("#date_picker1").datepicker("option", "maxDate", endDate );
    })
  })
</script>
@stop
