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
            <div>Set Availability</div>
        </div>
        <!-- START card-->
        <div class="card card-default">
            <div class="card-header"><b>Coach Details</b></div>
            <div class="card-body">
                <table class="table table-striped mb-4" style="border: 1px solid #dde6e9;">
                    <thead>
                    </thead>
                    <tbody>
                        {{--<tr>
                            <td>Id</td>
                            <td>{{$data->id}}</td>
                        </tr>--}}
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
                            <td>Name</td>
                            <td>{{$data->name}}</td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td>{{$data->email}}</td>
                        </tr>
                        {{--<tr>
                            <td>Phone Number</td>
                            <td>{{ $data->phone_number ?? '---' }}</td>
                        </tr>
                        <tr>
                            <td>Tagline</td>
                            <td>{{$data->tagline}}</td>
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
                <div class="mb-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a href="#availability" class="nav-link active" id="availability-tab" data-toggle="tab" role="tab" aria-controls="availability" aria-selected="true">Set Availability</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="#unavailability" class="nav-link" id="unavailability-tab" data-toggle="tab" role="tab" aria-controls="unavailability" aria-selected="false">Set UnAvailability</a>
                        </li> -->
                    </ul>
                    <div class="tab-content">
                        <div id="availability" class="tab-pane fade show active" role="tabpanel" aria-labelledby="availability-tab">                        
                            <div class="card w-100">
                                <div class="card-header"><b>Set Availability</b></div>
                                <div class="card-body">
                                    <div class="dashboard-list-box-content">
                                        <form id="availability_form" action="{{route('admin.coach.store_calender')}}" method="POST" class="set-availabelity-wrap">
                                            {{csrf_field()}}
                                            <input type="hidden" name="coach_id" value="{{ $data->id }}">
                                            <div class="selection-wrap ">
                                                <div class="selection-box">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">
                                                                    Select Date
                                                                </label>
                                                                <div class="form-control-icon">
                                                                    <input type="text" name="from_date" class="form-control custom-picker" id="from_date" placeholder="Select date" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--<div class="col-lg-3 col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label">
                                                                    To Date
                                                                </label>
                                                                <div class="form-control-icon">
                                                                    <input type="text" name="to_date" class="form-control form-group" id="to_date" placeholder="Select date" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                            <label class="col-form-label">Select Day</label>
                                                            <div id="datetimepickerDate" class="form-group form-control-icon">
                                                                    <select class="form-control day_select2" name="select_day[]" id="select_day" multiple="multiple">
                                                                        <option value="All">All</option>
                                                                        <option value="Monday">Monday</option>
                                                                        <option value="Tuesday">Tuesday</option>
                                                                        <option value="Wednesday">Wednesday</option>
                                                                        <option value="Thursday">Thursday</option>
                                                                        <option value="Friday">Friday</option>
                                                                        <option value="Saturday">Saturday</option>
                                                                        <option value="Sunday">Sunday</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>--}}
                                                        <div class="col-lg-9 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Select slots</label>
                                                                <div id="datetimepickerDate" class="form-group form-control-icon">
                                                                    <div class="d-flex align-items-start">
                                                                        <?php $slots = get_custom_slot(45); ?>
                                                                        <select class="form-control timeslot_select2" name="select_timeslot[]" id="select_timeslot" multiple="multiple">
                                                                            <option value="All">All</option>
                                                                            @foreach($slots as $key =>$sval)
                                                                            <option value="{{ $sval }}">{{ $sval }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="submit" class="btn btn-primary write_btn ml-3" value="Save" name="Submit" id="unavailability_submit"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>                                                            
                                                
                    
                        {{--<div id="unavailability" class="tab-pane fade" role="tabpanel" aria-labelledby="unavailability-tab">
                            <div class="card w-100 mb-0">
                                <div class="card-header"><b>Set UnAvailability</b></div>            
                                <div class="dashboard-list-box-content">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <form id="unavailabilityform" action="{{ url('admin/coach/insert-unavailable-date') }}" method="POST" class="form-div h-100">
                                                {{csrf_field()}}
                                                <input type="hidden" name="coach_id" value="{{ $data->id }}">
                                                <div class="form-group card-availability mb-4">
                                                    <label class="col-form-label">Select Date</label>
                                                    <div>                                    
                                                        <div class="d-flex mb-4" id="dateone_error"> 
                                                            <input type="text" name="dateone" class="form-control custom-picker" placeholder="Select Date" autocomplete="off" id="from_date1"/>                                                        
                                                            <button class="btn btn-primary write_btn firstbtn addunavailibility ml-3">Save</button>
                                                        </div>
                                                        <div class="date-listing first_row">
                                                            @if(isset($firstunavailibility) && !empty($firstunavailibility))
                                                                @foreach ($firstunavailibility as $unkey => $unval)
                                                                <div class="selected-date cal_addrow">
                                                                    <div class="head">{{ nice_date($unval->date)}} <a href="javascript:void(0);" class="remove-date minus_btn" data-id="{{ $unval->id }}"><i class="fa fa-trash"></i></a></div>
                                                                </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div> 
                                            </form>
                                        </div>
                                        <div class="col-lg-8 col-md-6 col-sm-12">
                                            <form id="unavailabilityform1" action="{{ url('admin/coach/insert-unavailable-datetime') }}" method="POST" class="form-div h-100">
                                                {{csrf_field()}}
                                                <input type="hidden" name="coach_id" value="{{ $data->id }}">
                                                <div class="form-group card-availability mb-4">
                                                    <label class="col-form-label">Select Date and Slots</label>
                                                    <div>
                                                        <div class="d-flex mb-4" id="datetwo_error">
                                                            <input type="text" name="datetwo" id="datetwo" class="form-control custom-picker" placeholder="Select Date" autocomplete="off"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <div id="time_error" class="form-group form-control-icon">
                                                                <div class="d-flex align-items-start mb-4">
                                                                    <select class="form-control timeslot_select3 " name="time[]" id="time" multiple="multiple" autocomplete="off">                                                                        
                                                                    @php
                                                                        $slots = get_custom_slot(45);
                                                                        @endphp
                                                                        @if(isset($slots) AND !empty($slots))
                                                                        <option value="All">All</option>
                                                                        @foreach ($slots as $key => $sval) 
                                                                        @php
                                                                        echo "<option value='".$sval."'>".trim($sval)."</option>";
                                                                        @endphp
                                                                        @endforeach
                                                                    @endif
                                                                    </select>
                                                                    <button class="btn btn-primary write_btn secondbtn addunavailibility ml-3">Save</button>
                                                                </div>
                                                            </div>                                                            
                                                        </div>                
                                                        <div class="date-listing second_row">
                                                            @if(isset($secondunavailibility) && !empty($secondunavailibility))
                                                                @foreach ($secondunavailibility as $unkey => $unval)
                                                                <div class="selected-date cal_addrow">
                                                                    <div class="card border border-top-0">
                                                                        <div class="head">{{ nice_date($unval->date)}} <a href="javascript:void(0);" class="remove-date minus_btn" data-id="{{ $unval->id }}"><i class="fa fa-trash"></i></a></div>          
                                                                        <div class="body date_{{ $unval->date }}">
                                                                            @if(isset($unval->time_slots) AND !empty($unval->time_slots))
                                                                            @foreach ($unval->time_slots as $slotkey => $slotval)
                                                                            <span class="tags">{{ $slotval }} <a href="javascript:void(0);" class="remove slot_remove" id="{{ $slotval }}" data-id="{{ $unval->id}}" onclick="this.parentElement.style.display='none'"><i class="fa fa-times"></i></a></span>
                                                                            @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            @endif
                                                        </div>                                
                                                    </div>
                                                </div>                                
                                            </form>
                                        </div>
                                    </div>                                    
                                </div>                        
                            </div>
                        </div>--}}
                    </div>
                </div>                
                <div class="mb-4 d-flex justify-content-between">
                    <h4 class="my-2 mr-3">Availability</h4>
                    <div class="d-flex"> 
                        <div class="m-2"><span class="cal_box_span">Available</span><div class='cal_box box-available'></div></div>
                        <!-- <div class="m-2"><span class="cal_box_span">UnAvailable</span><div class='cal_box box-unavailable'></div></div> -->
                        <div class="m-2"><span class="cal_box_span">Booked</span><div class='cal_box box-booked'></div></div>
                    </div>
                </div>
                <div class="row justify-content-left">
                    <div class="col-xl-3 col-lg-4">
                        <div id="book_datepicker"></div><br>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="timeslot" id="timeslot_div">
                            <ul><li>Please select date first.</li></ul>
                        </div>
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
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('front_assets/css/jquery-ui.css') }}">
<link rel="stylesheet" type="text/css" href="{{url('assets/noty/noty.css') }}">
<link rel="stylesheet" type="text/css" href="{{url('assets/noty/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{url('assets/noty/mint.css') }}">
@stop
@section('footer_scripts')
<!-- Datatables-->
<script type="text/javascript" src="{{ asset('front_assets/js/fullcalendar/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/noty/mo.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/noty/noty.min.js') }}"></script>
<script src="{{ asset('front_assets/js/jquery-ui.js') }}"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script>
     $(document).ready(function() {
        $( "#from_date" ).datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: +1,
            onSelect: function(selectedDate) {
                $.ajax({
                    type:'GET',
                    url: "{{ url('/admin/coach/get-avail-timeslot-by-date') }}",
                    data: { _token: '<?php echo csrf_token() ?>', date: selectedDate ,coachID : {{ $data->id }} },
                    success:function(data) {
                        $('#select_timeslot').val('');
                        $('#select_timeslot').html(data.html);
                        $( "#from_date" ).datepicker();
                    }
                });
            }
        });

        var available = "{{ $available }}";
        //var unavail = '{{ $unavailable }}';
        //console.log(unavail);
        var booked = "{{ $booked }}";
        $input = $("#book_datepicker");
        $input.datepicker({
            dateFormat: 'dd-mm-yy',
            minDate:+1,
            beforeShowDay: function (date) {
                var datestring = jQuery.datepicker.formatDate('yy-mm-dd', date);
                var current_date = jQuery.datepicker.formatDate('yy-mm-dd', new Date());
                var ret = '';
                if(booked.indexOf(datestring) !=-1){
                    ret =  [true,"box-booked","Booked"];
                }else if(available.indexOf(datestring) != -1){
                    ret =  [true,"box-available","Available"];
                }else{
                    ret = '';
                }
                return ret;     
            },
            onSelect: function (selectedDate) {
                $.ajax({
                    type:'GET',
                    url: "{{ url('/admin/coach/get-timeslot-by-date') }}",
                    data: { _token: '<?php echo csrf_token() ?>', date: selectedDate ,coachID : {{ $data->id }} },
                    success:function(data) {
                        $('#timeslot_div').val('');
                        $('#timeslot_div').html(data.html);
                    }
                });
            }
        });
    });
    $(document).ready(function() {
        $('.day_select2').select2({
            placeholder: "Select day",
            width: '100%',
        });
        $('.day_select2').on("select2:select", function (e) { 
            var data = e.params.data.text;
            if(data=='All'){
                $(".day_select2 > option").prop("selected","selected");
                $('.day_select2 option[value="All"]').prop('selected', false);
                $(".day_select2").trigger("change");
            }
        });
        
        $('.timeslot_select2').select2({
            placeholder: "Select slots",
            width: '100%',
        });
        $('.timeslot_select3').select2({
            placeholder: "Select slots",
            width: '100%',
        });
        $('.timeslot_select2').on("select2:select", function (e) { 
            var data = e.params.data.text;
            if(data=='All'){
                $(".timeslot_select2 > option").prop("selected","selected");
                $('.timeslot_select2 option[value="All"]').prop('selected', false);
                $(".timeslot_select2").trigger("change");
            }
        });
        $('.timeslot_select3').on("select2:select", function (e) { 
            var data = e.params.data.text;
            if(data=='All'){
                $(".timeslot_select3 > option").prop("selected","selected");
                $('.timeslot_select3 option[value="All"]').prop('selected', false);
                $(".timeslot_select3").trigger("change");
            }
        });
    });
    

    $( "#from_date1" ).datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: +1,
    });
    $( "#datetwo" ).datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: +1,
    });
    $( "#to_date" ).datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: +1,
        onSelect: function(dateText, inst) 
        {
            var dates = [];
            var fromDateData = $('#from_date').datepicker('getDate');
            if(fromDateData != null)
            {
                var fromDate = '';
                fromDate = fromDateData.getDate()+'-'+(fromDateData.getMonth()+1)+'-'+fromDateData.getFullYear();
                dates.push(fromDate)
                dates.push(dateText);
                //getData(dates);
            }
        }
    });
    $("#availability_form").validate({
        ignore: "",
        rules: 
        {
            from_date:{
                required:true,
            },
            to_date:{
                required:true,
            },
            "select_timeslot[]": {
                required: true
            }

        },
        messages: {
            from_date:{
                required:"Please select from date.",
            },
            to_date:{
                required:"Please select to date.",
            },
            "select_timeslot[]": {
                required: "Select timeslot",
            }
        },
        errorElement: 'label',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
<script src="{{asset('vendor/datatables.net/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('public/assets/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#unavailabilityform").validate({ 
      rules: { 
        dateone: { 
          required:true,
        }
      }, 
      messages:{ 
        dateone:{ 
          required: "Please select unavailable date.", 
        }
      },
      errorPlacement: function (error, element) {
        if(element.attr('name') == 'dateone'){
            error.insertAfter('#dateone_error');
        }
        else{
            error.insertAfter($(element));
        }
    },
      submitHandler: function (form) { 
        try {
          var data = new FormData(form);
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $(form).attr("action"),
            type: 'POST',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            datatype: "application/json",
            success: function(data) {
              data = JSON.parse(data);
              if(data.result==true){
                $('#dateone').val('');
                $('.first_row').append(data.append);
                noty_alert("success",data.message,5000);
                //setTimeout(function(){ window.location.reload(); }, 5000);
              }  else {
                $('#dateone').val('');
                noty_alert("error",data.message);
              }
            },
            error: function(jqXHR, exception) {
              window.location = site_url;
            },
          });
        } catch (e) {
          console.log(e);
        }
        return false;  
      } 
    });

    $("#unavailabilityform1").validate({ 
      rules: { 
        datetwo: { 
          required:true,
        }, 
        'time[]': { 
          required:true,
        }, 
      }, 
      messages:{ 
        datetwo:{ 
          required: "Please select unavailable date.", 
        },
        'time[]':{ 
          required: "Please select time slot.", 
        },
      },
      errorPlacement: function (error, element) {
        if(element.attr('name') == 'datetwo'){
            error.insertAfter('#datetwo_error');
        }else if(element.attr('name') == 'time[]'){
            error.insertAfter('#time_error');
        }
        else{
            error.insertAfter($(element));
        }
    },
      submitHandler: function (form) { 
        try {
          var data = new FormData(form);
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $(form).attr("action"),
            type: 'POST',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            datatype: "application/json",
            success: function(data) {
              data = JSON.parse(data);
              if(data.result==true && data.li_list == '0'){
                $('#datetwo').val('');
                $("#time").val("");
                $("#time").trigger("change");
                $('.second_row').append(data.append);
                noty_alert("success",data.message,5000);
                //setTimeout(function(){ window.location.reload(); }, 5000);
              }else if(data.result== true && data.li_list == '1'){
                $('#datetwo').val('');
                $("#time").val("");
                $("#time").trigger("change");
                $('.'+data.class).html(data.append);
                noty_alert("success",data.message,5000);
                //setTimeout(function(){ window.location.reload(); }, 5000);
              } else {
                $('#datetwo').val('');
                $("#time").val("");
                $("#time").trigger("change");
                noty_alert("error",data.message);
                //setTimeout(function(){ window.location.reload(); }, 5000);
              }
            },
            error: function(jqXHR, exception) {
              window.location = site_url;
            },
          });
        } catch (e) {
          console.log(e);
        }
        return false;  
      }
    });

    $(document).on("click",".minus_btn",function(){
      var thisbtn = $(this);
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType:"json",
        url: '{{ url("admin/coach/remove-unavailable-date") }}',
        data: {id:$(this).data('id')},
        beforeSend: function(){
            $('.main-loader').css('opacity','0.5').show();
        },
        success: function(data){
            if(data.result==true){
                thisbtn.parents('.cal_addrow').remove();
                noty_alert("success",data.message,5000);
                //setTimeout(function(){ window.location.reload(); }, 5000); 
            }else{
                noty_alert("error",data.message);
            }
            $('.main-loader').fadeOut("slow");
        }
      });
      return false;
    });

    $(document).on("click",".slot_remove",function(){
      var thisbtn = $(this);
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType:"json",
        url: '{{ url("admin/coach/remove-unavailable-datetime") }}',
        data: {id:$(this).data('id'), slotval : $(this).attr('id')},
        beforeSend: function(){
            $('.main-loader').css('opacity','0.5').show();
        },
        success: function(data){
            if(data.result==true){
                noty_alert("success",data.message,5000);
                var lilen = thisbtn.parent('li').parent('ul').children('li').length;
                if(lilen==1){
                    thisbtn.parents('.cal_addrow').remove();
                    $('.first_row').append(data.append);
                }
                thisbtn.parent('li').remove();
                if(data.remove==true){
                    thisbtn.parents('.cal_addrow').remove();
                }
                //setTimeout(function(){ window.location.reload(); }, 5000);
            }else{
             noty_alert("error",data.message);
         }
            // $('.main-loader').fadeOut("slow");
        }
      });
      return false;
    });
});
//default 5000 
function noty_alert(type="success", text="Success!", duration=4000){
    new Noty({
        text: text,
        type: type,
        timeout: duration,
        animation: {
            open: function (promise) {
                var n = this;
                var Timeline = new mojs.Timeline();
                var body = new mojs.Html({
                    el        : n.barDom,
                    x         : {500: 0, delay: 0, duration: 500, easing: 'elastic.out'},
                    isForce3d : true,
                    onComplete: function () {
                        promise(function(resolve) {
                            resolve();
                        })
                    }
                });

                var parent = new mojs.Shape({
                    parent: n.barDom,
                    width      : 200,
                    height     : n.barDom.getBoundingClientRect().height,
                    radius     : 0,
                    x          : {[150]: -150},
                    duration   : 1.2 * 500,
                    isShowStart: true
                });

                n.barDom.style['overflow'] = 'visible';
                parent.el.style['overflow'] = 'hidden';

                var burst = new mojs.Burst({
                    parent  : parent.el,
                    count   : 10,
                    top     : n.barDom.getBoundingClientRect().height + 75,
                    degree  : 90,
                    radius  : 75,
                    angle   : {[-90]: 40},
                    children: {
                        fill     : '#EBD761',
                        delay    : 'stagger(500, -50)',
                        radius   : 'rand(8, 25)',
                        direction: -1,
                        isSwirl  : true
                    }
                });

                var fadeBurst = new mojs.Burst({
                    parent  : parent.el,
                    count   : 2,
                    degree  : 0,
                    angle   : 75,
                    radius  : {0: 100},
                    top     : '90%',
                    children: {
                        fill     : '#EBD761',
                        pathScale: [.65, 1],
                        radius   : 'rand(12, 15)',
                        direction: [-1, 1],
                        delay    : .8 * 500,
                        isSwirl  : true
                    }
                });

                Timeline.add(body, burst, fadeBurst, parent);
                Timeline.play();
            },
            close: function (promise) {
                var n = this;
                new mojs.Html({
                    el        : n.barDom,
                    x         : {0: 500, delay: 10, duration: 500, easing: 'cubic.out'},
                    skewY     : {0: 10, delay: 10, duration: 500, easing: 'cubic.out'},
                    isForce3d : true,
                    onComplete: function () {
                        promise(function(resolve) {
                            resolve();
                        })
                    }
                }).play();
            }
        }
    }).show();  
}
</script>
@stop
