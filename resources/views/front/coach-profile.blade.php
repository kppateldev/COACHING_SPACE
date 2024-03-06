      @extends('front.app.index')
      @section('css') @stop
      <style type="text/css">
        td.unavailable {
          /*background: linear-gradient(to right top, rgba(158, 154, 154, 0.38) calc(50% - 1px), rgb(0, 0, 0), rgba(158, 154, 154, 0.38) calc(50% + 1px));
          pointer-events: none;*/
        }
      </style>
      @section('content')
      <link rel="stylesheet" type="text/css" href="{{ url('front_assets/css/jquery.rateyo.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ url('front_assets/css/jquery-ui.css') }}">
      @include('front.app.sidebar')
      <section class="main-body-wrapper">
        <div class="topbar-dark">
          <div class="coach-profile d-sm-flex align-items-center justify-content-between flex-wrap">
            <div class="left-profile d-sm-flex align-items-center me-sm-3 mb-3">
              <a href="{{ url('/dashboard') }}" class="icon-back me-2"><i class="fa-solid fa-arrow-left"></i></a>
              <div class="d-flex align-items-center flex-wrap">
                <div class="coach-img me-md-4 me-2">
                  <img src="{{ ($coach->profile_image) ? url('uploads/'.$coach->profile_image) : url('assets/admin/img/user.png') }}">
                </div>
                <div class="coach-name">
                  <h1 class="title-main-white mb-1">{{ $coach->name }}</h1>
                  <p class="mb-0"><i class="icon-price-tag"></i> {{ $coach->tagline}}</p>
                </div>
              </div>
            </div>
            {{--<div class="right-profile mb-3">
              <h4>Customer Reviews</h4>
              <div class="d-flex align-items-center">
                <div class="rateYo ps-0" data-rateyo-read-only="true" data-rateyo-rating="{{ $coach->avg_rating }}" data-rateyo-star-width="18px" data-rateyo-spacing="1px"></div>
                <div class="rating_number mt-1">({{ $coach->rating_count}} Reviews)</div>
              </div>
            </div>--}}
          </div>
        </div>
        <div class="content-inner-wrapper">
          <div class="row">
            <div class="col-lg-7">
              <div class="box-container mb-30">
                <h3 class="title-main-sm">About Coach</h3>
                <p>{{ $coach->about ?? '----' }}</p>
              </div>

              @if(isset($coach->strengths))
              <div class="box-container mb-30 pb-2">
                <h3 class="title-main-sm">Strengths</h3>
                <?php $explStrengths = explode(',',$coach->coachStrengthsStr()); ?>
                <div class="coach-strengths">
                  <ul class="list-inline d-flex align-items-center flex-wrap">
                    @foreach($explStrengths as $value)
                    <li>{{ $value }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
              @endif

              @if(isset($coach->coaching_level))
              <div class="box-container mb-30">
                <h3 class="title-main-sm">Coaching Level</h3>
                <ul class="list-inline coaching-level d-flex align-items-center mb-0">
                  <?php $explLevels = explode(',',$coach->coachCoachingLevelStr()); ?>
                  @foreach($explLevels as $leval_value)
                  <li class="me-4 mb-1"><i class="fa-regular fa-circle-check me-2"></i> {{ $leval_value }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
            </div>
            <div class="col-lg-5">
              @include('front.includes.flash-message')
              <div class="text-center box-container calender-wrapper">
                <h3 class="mb-5">Select Date and Time</h3>
                <div id="book_datepicker"></div><br>
                <input type="hidden" name="date" value="<?php echo $coach_date;?>" id="date">
                <?php 
                if(isset($coach_date) && !empty($coach_date) || !empty($coach_timeslot)){
                  $date = date("Y-m-d", strtotime($coach_date));
                  $AvailabilityDates = \App\Models\AvailabilityDate::where('date',$date)->first();
                  $slot = $AvailabilityDates['time_slots'];
                }else{
                  $slot = get_custom_slot(45); 
                }
                ?>
                @if(isset($coach_date) && !empty($coach_date) || !empty($coach_timeslot))
                  <div class="timeslot" id="timeslot_div">
                    <select name="timeslot" id="timeslot_select" class="form-select">
                      @foreach($slot as $key => $timeslot)
                      <option value="{{ $timeslot }}" {{ (isset($coach_timeslot) && $coach_timeslot == $timeslot) ? "selected" : ""  }}> {{ $timeslot}}</option>
                      @endforeach
                    </select>
                  </div>
                @else
                  <div class="timeslot" id="timeslot_div">
                    <select name="timeslot" id="timeslot_select" class="form-select">
                      <option value=""> Select timeslot</option>
                    </select>
                  </div>
                @endif
                <div><button id="book_session_btn" class="btn btn-main-primary card-btn mw-btn-185 mt-3">Book Session</button></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Modal -->
      <div class="modal fade" id="sessionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content modal-before-bg position-relative">
            <div class="modal-header text-center flex-column p-0 border-0">
              <h5 class="modal-title title-main-lg fs-28" id="exampleModalLabel">Confirm Your Session</h5>
              <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body p-0">
              <div class="modal-profile-wrap text-center">
                <div class="modal-profile mx-auto">
                  <img src="{{ ($coach->profile_image) ? url('uploads/'.$coach->profile_image) : url('assets/admin/img/user.png') }}">
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
                <label class="form-label mb-1">What would you like to discuss during your coaching session? </label>
                <textarea class="form-control h-auto" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer p-0 border-0 justify-content-center">
              <button type="button" class="btn btn-main-primary mw-btn-185">Confirm</button>
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
        //Remove query strings from url
        @if(isset($coach_date) || isset($coach_timeslot))
        $(document).ready(function(){
          var uri = window.location.toString();
          if (uri.indexOf("?") > 0) {
          var clean_uri = uri.substring(0, uri.indexOf("?"));
          window.history.replaceState({}, document.title, clean_uri);
        }
        });
        @endif
        $(function () {
          var unavail = "{{ $unavailable }}";
          var available = '{{ $available }}';
          $input = $("#book_datepicker");
          $input.datepicker({
            dateFormat: 'dd-mm-yy',
            minDate:+1,
            beforeShowDay: function (date) {
              var datestring = jQuery.datepicker.formatDate('yy-mm-dd', date);
              var current_date = jQuery.datepicker.formatDate('yy-mm-dd', new Date());
              var ret = '';
              
              if(unavail.indexOf(datestring) !=-1){
                ret = [true,"ui-datepicker-unselectable ui-state-disabled undefined","Unavailable"];
              }else if(available.indexOf(datestring) != -1){
                ret = [true,"available","Available"];
              }else{
                if(current_date > datestring){
                 ret = ''; 
                }
              } 
              return ret;     
            },
            onSelect: function (selectedDate) {
              $("#timeslot_div").show();
              $('#date').val(selectedDate);
              $.ajax({
                 type:'GET',
                 url: "{{ url('/get-timeslot-by-day') }}",
                 data: { _token: '<?php echo csrf_token() ?>', date: selectedDate ,coachID : {{ $coach->id }} },
                 success:function(data) {
                  $('#timeslot_div').html(data.html);
                 }
             });
            }
          });
          $(".rateYo").rateYo({
            rating: 3.6,
            starWidth: "16px",
            normalFill: "#D2D2D2",
            ratedFill: "#FED509"
          });
          $(".rateYo-lg").rateYo({
            rating: 3.6,
            starWidth: "22px",
            normalFill: "#D2D2D2",
            ratedFill: "#FED509"
          });
        });
        jQuery.validator.addMethod("noHTML", function(value, element) {
          return this.optional(element) || /^([a-zA-Z0-9_ ]+)$/.test(value);
        }, "No HTML tags are allowed!");
        $(document).ready(function() {
          $("#book_datepicker").find(".ui-state-default").removeClass("ui-state-active");
          var sDate = $('#date').val();
          $("#book_datepicker").datepicker("setDate",sDate);
          $(document).on("click","#book_session_btn",function() {
            $('.error_datetime').remove();
            var dateValue = $('#date').val();
            var timeslotValue = $('#timeslot_select').find(":selected").val();
            if (!timeslotValue) {
              $('#book_session_btn').before('<label class="error_datetime error">Please select date and timeslot.</label>');
            }
            else
            {
              $('.error_datetime').remove();
              $.ajax({
               type:'GET',
               url: "{{ url('/confirm-session-popup') }}",
               data: { _token: '<?php echo csrf_token() ?>', date: dateValue, time: timeslotValue,coachID : {{ $coach->id }} },
               success:function(data) {
                $("#sessionModal").replaceWith(data);
                $('#sessionModal').modal('show');
                //Validation start
                $("#confirm-session-submit").validate({
                  rules: {
                    like_to_discuss: {
                      required: true,
                      noHTML:true,
                    },
                  },
                  messages: {
                    like_to_discuss: {
                      required: "Please enter description.",
                    },
                  },
                  submitHandler: function(form) {
                    $('.sub-loader').show();
                    form.submit();
                  }
                });
                //Validation end
              }
            });

            }
          });
        });
      </script>
      @stop