  @extends('front.app.index')
  @section('css') @stop
  @section('content')
  <link rel="stylesheet" type="text/css" href="{{ url('front_assets/css/jquery.rateyo.css') }}">
  <div class="main-body-content position-relative pb-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 col-left">
          <div class="body-col-left text-center">
            <img src="{{ url('front_assets/images/login.png') }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="body-col-right mt-5 mt-lg-0">
            <div class="form-body">
              <h1 class="title-main-lg mb-4 text-center">Session Report</h1>
              @include('front.includes.flash-message')
              <div class="content-inner-wrapper1">
                <div class="session-booking-details">
                  <div class="session-tbl p-sm-4 p-2 pb-2 d-flex align-items-center justify-content-between flex-wrap mb-30">
                    <div class="modal-profile-wrap d-flex align-items-center me-3 mb-3">
                      <div class="modal-profile me-3"><img src="{{ ($sessionData->UserData->profile_image) ? url('uploads/'.$sessionData->UserData->profile_image) : url('assets/admin/img/user.png') }}"></div>
                      <div>
                        <h1 class="mb-1 fs-16">{{ character_limit($sessionData->UserData->name,30) ?? '' }}</h1>
                      </div>
                    </div>
                    <ul class="list-inline coaching-details me-3 mb-3">
                      <li class="d-flex align-items-center me-2">
                        <span class="d-flex align-items-center justify-content-center me-2"><i class="fa-regular fa-calendar-plus"></i></span>
                        <div>
                          <p class="mb-0">Coaching Date</p>
                          <h6 class="mb-0">{{ nice_date($sessionData->date)}}</h6>
                        </div>
                      </li>
                    </ul>
                    <ul class="list-inline coaching-details me-3 mb-3">
                      <li class="d-flex align-items-center">
                        <span class="d-flex align-items-center justify-content-center me-2"><i class="fa-regular fa-clock"></i></span>
                        <div>
                          <p class="mb-0">Coaching Time</p>
                          <h6 class="mb-0">{{ $sessionData->time ?? '' }}</h6>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="session_report_form">
                <p>Thank you for your coaching session with <strong>{{ $sessionData->UserData->name }}</strong>.</p>
                
                {!! Form::open(['url'=>url('add-session-report/'.$sessionData->id), 'id'=>'sessionreportform']) !!}
                <input type="hidden" name="sessionID" value="{{ $sessionData->id }}">
                <div class="row">
                  <div class="form-group">
                    <label class="form-label">For our records, we would like you to know what the theme of session was?</label>
                    <div class="position-relative">
                      <textarea cols="80" rows="2" name="session_report" class="form-control"></textarea>
                    </div>  
                  </div>
                  <div class="">
                    <button type="submit" class="btn btn-main-primary mw-btn-185">Add Session Report</button>
                  </div>
                </div>
                {!! Form::close() !!}
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @stop
  @section('js')
  <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
  <script type="text/javascript">
    $(function() {
      jQuery.validator.addMethod("customRegex", function(value, element) {
        return this.optional(element) || /^[^\s]+(\s+[^\s]+)*$/.test(value);
      });
      jQuery.validator.addMethod("noHTML", function(value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_ ]+)$/.test(value);
      }, "No HTML tags are allowed!");
      $("#sessionreportform").validate({
        rules: {
          session_report: {
            required: true,
            customRegex: true,
            noHTML: true,
          },
        },
        messages: {
          session_report: {
            required: "Please enter session report.",
            customRegex: "Space not allowed for starting and ending.",
          },
        },
        submitHandler: function(form) {
          form.submit();
          $('.sub-loader').show();
        }
      });
    });
  </script>
  @stop