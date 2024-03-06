@extends('front.app.index')
@section('content')
@include('front.app.sidebar')
<link rel="stylesheet" type="text/css" href="{{ url('front_assets/css/jquery.rateyo.css') }}">
<section class="main-body-wrapper">
  <div class="topbar-main py-4">
    <div class="row align-items-center">
      <div class="col-md-12">
        <div class="topbar-col-left me-md-4">
          <h1 class="title-main-md mb-md-0"><a href="{{ url('my-sessions')}}"><i class="fa-solid fa-arrow-left"></i></a> Booking Details</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="content-inner-wrapper">
    @include('front.includes.flash-message')
    <div class="session-booking-details">
      <div class="session-tbl p-sm-4 p-2 pb-2 d-flex align-items-center justify-content-between flex-wrap mb-30">
        <div class="modal-profile-wrap d-flex align-items-center me-3 mb-3">
          <div class="modal-profile me-3"><img src="{{ (isset($session->coachData->profile_image)) ? url('uploads/'.$session->coachData->profile_image) : url('assets/admin/img/user.png') }}"></div>
          <div>
            <h1 class="mb-1 fs-16">{{ $session->coachData->name ?? '' }}</h1>
            <p class="mb-0 fw-bold"><i class="icon-price-tag"></i> {{ $session->coachData->tagline ?? '' }}</p>
          </div>
        </div>
        <ul class="list-inline coaching-details me-3 mb-3">
          <li class="d-flex align-items-center me-2">
            <span class="d-flex align-items-center justify-content-center me-2"><i class="fa-regular fa-calendar-plus"></i></span>
            <div>
              <p class="mb-0">Coaching Date</p>
              <h6 class="mb-0">{{ nice_date($session->date)}}</h6>
            </div>
          </li>
        </ul>
        <ul class="list-inline coaching-details me-3 mb-3">
          <li class="d-flex align-items-center">
            <span class="d-flex align-items-center justify-content-center me-2"><i class="fa-regular fa-clock"></i></span>
            <div>
              <p class="mb-0">Coaching Time</p>
              <h6 class="mb-0">{{ $session->time ?? '' }}</h6>
            </div>
          </li>
        </ul>
        @if($session->status == 'upcoming')
        <label class="lbl-upcoming me-lg-4 mb-3">Upcoming</label>
        @elseif($session->status == 'canceled')
        <label class="lbl-canceled me-lg-4 mb-3">Canceled</label>
        @else
        <label class="lbl-completed me-lg-4 mb-3">Completed</label>
        @endif
      </div>
      <div>
        <h5>What would you like to discuss during your coaching session?</h5>
        <p>{{ $session->like_to_discuss ?? '' }}</p>
      </div>
      @if(isset($session->status) && $session->status == 'canceled')
      <div>
        <h5>Cancel Reason</h5>
        <p>{{ $session->cancel_reason ?? '' }}</p>
      </div>
      @endif
      @if(isset($session->status) && $session->status == 'upcoming')
      <div>
        <h5>MS Teams Link</h5>
        <p><a href="{{ $session->ms_join_web_url ?? '' }}" target="_blank" class=""><button class="btn btn-main-primary card-btn w-25">MS Teams Link</button></a></p>
      </div>
      @endif
      <!-- User review - start -->
      @if(!isset($session->ReviewData) && ($session->status == 'completed' && $session->session_end_time < \Carbon\Carbon::now()))
      <div class="col-md-12 user_review_form">
        <h5 class="mb-3 text-start">Give a Review</h5>
        <p>We hope you found your coaching session useful!</p>
        <p>To make sure that we continue to provide the support you need, we would like to ask you to review your coach.</p>
        {!! Form::open(['url'=>url('give-review-submit'), 'id'=>'giveReview']) !!}
        <input type="hidden" name="sessionID" value="{{ $session->id }}">
        <div class="form-group inline-reviews">
          <label class="form-label">Overall Experience</label>
          <div class="position-relative pass-view-box">
            <p class="overall_rating"></p>
            <input type="hidden" id="overall_rating_val" name="overall_rating_val" class="form-control">
          </div>
        </div>

        <div class="form-group inline-reviews">
          <label class="form-label">Attentiveness</label>
          <div class="position-relative pass-view-box">
            <p class="attentiveness"></p>
            <input type="hidden" id="attentiveness_val" name="attentiveness_val" class="form-control">
          </div>
        </div>

        <div class="form-group inline-reviews">
          <label class="form-label">Communication</label>
          <div class="position-relative pass-view-box">
            <p class="communication"></p>
            <input type="hidden" id="communication_val" name="communication_val" class="form-control">
          </div>
        </div>

        <div class="form-group inline-reviews">
          <label class="form-label">Active Listening and Questioning</label>
          <div class="position-relative pass-view-box">
            <p class="active_listening"></p>
            <input type="hidden" id="active_listening_val" name="active_listening_val" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Please provide any other feedback:</label>
          <div class="position-relative pass-view-box">
            <textarea cols="80" rows="4" name="review" class="form-control"></textarea>
          </div>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-main-primary mw-btn-185">Submit</button>
        </div>
        {!! Form::close() !!}
      </div>
      @endif
      <!-- User review - end -->


      <!-- User Reviewed - start -->
      @if(isset($session->ReviewData))
      <h5>User Reviews:</h5>
      
        <div class="form-group inline-reviews">
          <label class="form-label">Overall Experience</label>
          <div class="position-relative">{!! reviewImages($session->ReviewData->overall_rating) !!}</div>
        </div>
      
      
        <div class="form-group inline-reviews">
          <label class="form-label">Attentiveness</label>
          <div class="position-relative">{!! reviewImages($session->ReviewData->attentiveness) !!}</div>
        </div>
      
      
        <div class="form-group inline-reviews">
          <label class="form-label">Communication</label>
          <div class="position-relative">{!! reviewImages($session->ReviewData->communication) !!}</div>
        </div>
      
      
        <div class="form-group inline-reviews">
          <label class="form-label">Active Listening and Questioning</label>
          <div class="position-relative">{!! reviewImages($session->ReviewData->active_listening) !!}</div>
        </div>
      
      <div class="row">
        <div class="form-group form-text-border">
          <h5 class="">Feedback:</h5>
          <div class="position-relative">{{ $session->ReviewData->review ?? '---' }}</div>
        </div>
      </div>
      @endif
      <!-- User Reviewed - end -->

      <!-- Session Report - start -->
      @if(isset($session->ReviewData))
      @if(isset($session->session_report) && !empty($session->session_report))
      <div>
        <h5>Session report by coach:</h5>
        <p>{{ $session->session_report ?? '' }}</p>
      </div>
      @endif
      @endif
      <!-- Session Report - end -->

    </div>
  </div>
</section>
@stop

@section('js')
<script src="{{ url('front_assets/js/jquery.rateyo.min.js') }}"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
  $(function() {
    jQuery.validator.addMethod("customRegex", function(value, element) {
        return this.optional(element) || /^[^\s]+(\s+[^\s]+)*$/.test(value);
    });
    jQuery.validator.addMethod("noHTML", function(value, element) {
      return this.optional(element) || /^([a-zA-Z0-9_ ]+)$/.test(value);
    }, "No HTML tags are allowed!");
    $("#giveReview").validate({
      ignore: ':hidden:not(.hiddenRecaptcha,#overall_rating_val,#attentiveness_val,#communication_val,#active_listening_val)',
      rules: {
        overall_rating_val: {
          required: true,
        },
        attentiveness_val: {
          required: true,
        },
        communication_val: {
          required: true,
        },
        active_listening_val: {
          required: true,
        },
        review: {
          required: true,
          customRegex: true,
          noHTML: true,
        }
      },
      messages: {
        overall_rating_val: {
          required: "Please select a rating.",
        },
        attentiveness_val: {
          required: "Please select a rating.",
        },
        communication_val: {
          required: "Please select a rating.",
        },
        active_listening_val: {
          required: "Please select a rating.",
        },
        review: {
          required: "Please enter feedback.",
          customRegex: "Space not allowed for starting and ending.",
        }
      },
      submitHandler: function(form) {
        form.submit();
        $('.sub-loader').show();
      }
    });
  });

  $(".overall_rating").rateYo({
    rating : 0,
    spacing   : "5px",
    starWidth : "20px",
    fullStar : true,
    onSet: function (rating, rateYoInstance) {
      $(this).siblings("input[name=overall_rating_val]").val(rating);
    }
  });

  $(".attentiveness").rateYo({
    rating : 0,
    spacing   : "5px",
    starWidth : "20px",
    fullStar : true,
    onSet: function (rating, rateYoInstance) {
      $(this).siblings("input[name=attentiveness_val]").val(rating);
    }
  });

  $(".communication").rateYo({
    rating : 0,
    spacing   : "5px",
    starWidth : "20px",
    fullStar : true,
    onSet: function (rating, rateYoInstance) {
      $(this).siblings("input[name=communication_val]").val(rating);
    }
  });

  $(".active_listening").rateYo({
    rating : 0,
    spacing   : "5px",
    starWidth : "20px",
    fullStar : true,
    onSet: function (rating, rateYoInstance) {
      $(this).siblings("input[name=active_listening_val]").val(rating);
    }
  });
</script>
@stop