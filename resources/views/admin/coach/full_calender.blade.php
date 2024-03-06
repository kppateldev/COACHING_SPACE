@extends('admin.layouts.default')
@section('content')
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
    border: 1px solid #000;
    clear: both;
    margin: 0px 5px;
}
.box-available {    
    background-color: #ffff007a;
}
.box-unavailable {    
    background-color: #ff3333a3;
}
.box-booked {    
    background-color: #006600a1;
}
.cal_box_blocked{
    padding: 0px 5px;
    background: linear-gradient(to right top, rgba(158, 154, 154, 0.38) calc(50% - 1px), rgb(0, 0, 0), rgba(158, 154, 154, 0.38) calc(50% + 1px));
    opacity: var(--fc-bg-event-opacity,.3);
}
/*.fc-day-past{
    padding: 0px 5px;
    background: #6d706d85 !important;
    opacity: var(--fc-bg-event-opacity,.3);
}*/
.select2-container input:placeholder-shown {
  width: 100% !important;
}
</style>
<!-- Main section-->
<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div>All Coaches Availability</div>
        </div>
        <!-- START card-->
        <div class="card card-default">
            <div class="card-body">
                <div class="row justify-content-left">
                     <div class="col-xl-12 col-lg-12">
                        <div id="calendar"></div><br>
                    </div>
                </div>
            </div>
        </div>
        <!-- END card-->
    </div>
</section>
@stop
@section('header_styles')
<!-- Datatables-->
<link rel="stylesheet" href="{{ asset('front_assets/css/font-awesome-all.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('front_assets/css/fullcalendar/main.css') }}">
@stop
@section('footer_scripts')
<!-- Modal -->
<div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nameDiv"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span id="timeslotsDiv"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<!-- Datatables-->
<script type="text/javascript" src="{{ asset('front_assets/js/fullcalendar/main.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            displayEventTime: true,
            events: "{{ url('admin/coach/getEvents')}}",
            dayMaxEvents:5,
            eventClick:  function(info) {
                if (info.event.extendedProps.gradient) 
                {
                    info.el.style.background = info.event.extendedProps.gradient;
                }
                //$("#timeslotsDiv").html(info.event.extendedProps.time);
                //$("#nameDiv").html(info.event.title);
                //$('#calendarModal').modal();
            },
        });
        calendar.render();
    });
</script>
@stop
