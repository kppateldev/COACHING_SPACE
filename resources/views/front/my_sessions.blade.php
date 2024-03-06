@extends('front.app.index')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ url('front_assets/css/jquery.rateyo.css') }}">
@include('front.app.sidebar')
<section class="main-body-wrapper">
  <div class="topbar-main">
    <div class="row align-items-center">
      <div class="col-md-4">
        <div class="topbar-col-left me-md-4">
          <h1 class="title-main-md mb-md-0">My Sessions</h1>
        </div>
      </div>
      <div class="col-md-8">
        <div class="topbar-col-right d-flex align-items-center justify-content-md-end flex-wrap">
          <form action="{{ url('my-sessions')}}" name="sessions_listings_search" id="sessions_listings_search" method="GET" class="searchbar me-sm-2 me-lg-3 me-0 mb-2 mb-sm-0">
            <input type='hidden' name='sort_by_val' id='sort_by_val' value={{isset($_GET['sort_by_val'])? $_GET['sort_by_val'] : ''}}>
            <div class="form-outline position-relative">
              <input value="{{ ($_GET['keyword']) ?? '' }}" type="search" id="form1" class="form-control" placeholder="Search by coach name" name="keyword"/>
              <span class="search-icons"><button class="btn p-0"><i class="icon-search-interface-symbol"></i></button></span>
            </div>
          </form>
          <div class="form-select-icon position-relative me-2 me-lg-3 flex-shrink-0">
            <select class="form-select" aria-label="Default select example" name="sort_by" id="sort_by">
              <option value="">Filter By : All </option>
              <option value="upcoming" {{ (isset($_GET['sort_by_val']) && $_GET['sort_by_val'] == 'upcoming') ? "selected" : ""  }}>Upcoming</option>
              <option value="completed" {{ (isset($_GET['sort_by_val']) && $_GET['sort_by_val'] == 'completed') ? "selected" : ""  }}>Completed </option>
              <option value="canceled" {{ (isset($_GET['sort_by_val']) && $_GET['sort_by_val'] == 'canceled') ? "selected" : ""  }}>Canceled </option>
            </select>
            <i class="fa-solid fa-caret-down"></i>
          </div>
          @if(isset($_GET['keyword']) || isset($_GET['sort_by_val']))
          <a href="{{ url('my-sessions') }}"><button type="submit" class="btn btn-main-primary p-0 d-flex align-items-center justify-content-center filter-btns reset_btn" style="width: 50px;" data-toggle="tooltip" data-placement="top" title="Reset"><i class="fa fa-undo" aria-hidden="true"></i></button></a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="container my-3">
      @include('front.includes.flash-message')
    </div>
  </div>
  
  @if(isset($sessions) && count($sessions) > 0)
  <div class="content-inner-wrapper">
    <div class="session-tbl overflow-auto">
      <table class="table">
        <thead>
          <tr>
            <th>Session Id</th>
            <th>Coach Name</th>
            <th>Date / Time</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($sessions as $key => $session)
          <tr>
            <td>#{{ $session->id }}</td>
            <td>{{ $session->CoachData->name }}</td>
            <?php 
            $expl = explode('-',$session->time);
            $time = $expl[0];
            ?>
            <td>{{ nice_date($session->date)}} {{ $session->time }}</td>
            <td>
              @if($session->status == 'upcoming')
              <label class="lbl-upcoming">Upcoming</label>
              @elseif($session->status == 'canceled')
              <label class="lbl-canceled">Canceled</label>
              @else
              <label class="lbl-completed">Completed</label>
              @endif
            </td>
            <td class="action-btns"><div class="d-flex align-items-center"><a href="{{ route('mySessionDetails',$session->id)}}" class="me-3" data-toggle="tooltip" data-placement="top" title="View Session Details"><i class="fa-regular fa-eye"></i></a>@if($session->status == 'upcoming')<span id="cancel_session_btn" class="fs-20" data-toggle="tooltip" data-placement="top" title="Cancel Session" data-id="{{ $session->id }}" style="cursor: pointer;"><i class="fa fa-times" aria-hidden="true"></i></span>@elseif($session->status == 'completed')<span id="user_notes_btn" class="fs-20" data-toggle="tooltip" data-placement="top" title="View User Notes" data-id="{{ $session->id }}" style="cursor: pointer;"><i class="icon-question fs-20"></i></span>@endif</div></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="col-lg-12 d-flex justify-content-center general_pagination">
      {!! $sessions->withQueryString()->links() !!}
    </div>
  </div>
  @else
  <div class="col-md-12">
    <div class="container"><div class="alert alert-info text-center my-3" role="alert"> No session found. </div></div>
  </div>
  @endif
</section>
<!-- Modal -->
<div class="modal fade" id="userNotesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modal-before-bg position-relative">
      <div class="modal-header text-center flex-column p-0 border-0">
        <h5 class="modal-title title-main-lg fs-28" id="exampleModalLabel">User Notes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body p-0">
        <div class="modal-profile-wrap text-center">
          <div class="modal-profile mx-auto">
            <img src="{{ url('assets/admin/img/user.png') }}">
          </div>
          <h1 class="mb-0 mt-3">Grace Waites</h1>
          <p class="mb-0 fw-bold"><i class="icon-price-tag"></i> Leadership Coaching</p>
        </div>
        <ul class="list-inline coaching-details d-flex align-items-center justify-content-evenly mt-3 mb-4">
          <li class="d-flex align-items-center me-2">
            <span class="d-flex align-items-center justify-content-center me-2"><i class="fa-regular fa-calendar-plus"></i></span>
            <div>
              <p class="mb-0">Coaching Date</p>
              <h6 id="confirm_coach_date" class="mb-0">23 mar, 2022</h6>
            </div>
          </li>
          <li class="d-flex align-items-center">
            <span class="d-flex align-items-center justify-content-center me-2"><i class="fa-regular fa-clock"></i></span>
            <div>
              <p class="mb-0">Coaching Time</p>
              <h6 id="confirm_coach_time" class="mb-0">02:00 - 02:45</h6>
            </div>
          </li>
        </ul>
        <div class="form-group">
          <label class="form-label mb-1">User Notes</label>
          <textarea class="form-control h-auto" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer p-0 border-0 justify-content-center">
        <button type="button" class="btn btn-main-primary mw-btn-185">Update</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="cancelSessionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modal-before-bg position-relative">
      <div class="modal-header text-center flex-column p-0 border-0">
        <h5 class="modal-title title-main-lg fs-28" id="exampleModalLabel">Cancel Session</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body p-0">
        <div class="modal-profile-wrap text-center">
          <div class="modal-profile mx-auto">
            <img src="{{ url('assets/admin/img/user.png') }}">
          </div>
          <h1 class="mb-0 mt-3">Grace Waites</h1>
          <p class="mb-0 fw-bold"><i class="icon-price-tag"></i> Leadership Coaching</p>
        </div>
        <ul class="list-inline coaching-details d-flex align-items-center justify-content-evenly mt-3 mb-4">
          <li class="d-flex align-items-center me-2">
            <span class="d-flex align-items-center justify-content-center me-2"><i class="fa-regular fa-calendar-plus"></i></span>
            <div>
              <p class="mb-0">Coaching Date</p>
              <h6 id="confirm_coach_date" class="mb-0">23 mar, 2022</h6>
            </div>
          </li>
          <li class="d-flex align-items-center">
            <span class="d-flex align-items-center justify-content-center me-2"><i class="fa-regular fa-clock"></i></span>
            <div>
              <p class="mb-0">Coaching Time</p>
              <h6 id="confirm_coach_time" class="mb-0">02:00 - 02:45</h6>
            </div>
          </li>
        </ul>
        <div class="form-group">
          <label class="form-label mb-1">Reason</label>
          <textarea class="form-control h-auto" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer p-0 border-0 justify-content-center">
        <button type="button" class="btn btn-main-primary mw-btn-185">Update</button>
      </div>
    </div>
  </div>
</div>
@stop
@section('js')
<script src="{{ url('front_assets/js/jquery.rateyo.min.js') }}"></script>
<script src="{{ url('front_assets/js/jquery-ui.js') }}"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script>
  $(document).on('change','#sort_by',function(){
    sortBy = $(this).val();
    $('#sort_by_val').val(sortBy);
    $('#sessions_listings_search')[0].submit();
  });
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    $(".rateYo").rateYo({
      //rating: 3.6,
      stsarWidth: "16px",
      normalFill: "#D2D2D2",
      ratedFill: "#FED509"
    });
  });

  $(document).ready(function() {
    jQuery.validator.addMethod("noHTML", function(value, element) {
      return this.optional(element) || /^([a-zA-Z0-9_ ]+)$/.test(value);
    }, "No HTML tags are allowed!");
    $(document).on("click","#user_notes_btn",function() {
      var idValue = $(this).attr('data-id');
      $.ajax({
       type:'GET',
       url: "{{ url('/user-notes-popup') }}",
       data: { _token: '<?php echo csrf_token() ?>', id: idValue },
       success:function(data) {
        $("#userNotesModal").replaceWith(data);
        $('#userNotesModal').modal('show');
            //Validation start
            $("#user-notes-submit").validate({
              rules: {
                user_notes: {
                  required: true,
                  noHTML: true,
                },
              },
              messages: {
                user_notes: {
                  required: "Please enter user notes.",
                },
              },
              submitHandler: function(form) {
                form.submit();
                $('.sub-loader').show();
              }
            });
            //Validation end
          }
        });
    });
  });

  $(document).ready(function() {
    jQuery.validator.addMethod("noHTML", function(value, element) {
      return this.optional(element) || /^([a-zA-Z0-9_ ]+)$/.test(value);
    }, "No HTML tags are allowed!");
    $(document).on("click","#cancel_session_btn",function() {
      var idValue = $(this).attr('data-id');
      $.ajax({
       type:'GET',
       url: "{{ url('/cancel-session-popup') }}",
       data: { _token: '<?php echo csrf_token() ?>', id: idValue },
       success:function(data) {
        $("#cancelSessionModal").replaceWith(data);
        $('#cancelSessionModal').modal('show');
            //Validation start
            $("#cancel-session-submit").validate({
              rules: {
                cancel_reason: {
                  required: true,
                  noHTML: true,
                },
              },
              messages: {
                cancel_reason: {
                  required: "Please enter cancel reason.",
                },
              },
              submitHandler: function(form) {
                form.submit();
                $('.sub-loader').show();
              }
            });
            //Validation end
          }
        });
    });
  });
</script>
@stop
