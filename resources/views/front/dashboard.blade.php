      @extends('front.app.index')
      @section('css') @stop
      @section('content')
      <style type="text/css">
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
      </style>
      <link rel="stylesheet" type="text/css" href="{{ url('front_assets/css/jquery.rateyo.css') }}">
      <link rel="stylesheet" href="{{ url('assets/css/select2.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ url('front_assets/css/jquery-ui.css') }}">
      @include('front.app.sidebar')
      <section class="main-body-wrapper">
        <div class="topbar-main topbar-home">
          <div class="row align-items-center">
            <div class="col-md-4">
              <div class="topbar-col-left me-md-4">
                <h1 class="title-main-md mb-md-0">Dashboard</h1>
              </div>
            </div>
            <div class="col-md-8">
              <div class="topbar-col-right d-flex align-items-center justify-content-md-end">
                <div class="mobile-filter-menu"><i class="fa fa-filter mobile-fillter-toggle" aria-hidden="true"></i></div>
                <div class="mobile-filter">
                  <form action="{{ url('dashboard')}}" name="coach_listings_search" id="coach_listings_search" method="GET" class="searchbar me-sm-2 me-lg-3 me-0 mb-2 mb-sm-0 coach_listings_search">
                    <input type='hidden' name='sort_by_val' id='sort_by_val' value={{isset($_GET['sort_by_val'])? $_GET['sort_by_val'] : ''}}>
                    <div class="form-outline position-relative">
                    @if(isset($all_coaches) && count($all_coaches) > 0)
                    <select class="form-select coaches_select2" name="keyword" id="keyword">
                      <option value="">Select Coach</option>
                      @foreach($all_coaches as $key => $coach)
                      <option value="{{ $coach->name }}" {{ (isset($_GET['keyword']) && $_GET['keyword'] == $coach->name) ? "selected" : "" }}>{{ $coach->name }}</option>
                      @endforeach
                    </select>
                    @endif
                    </div>
                    <div class="form-outline position-relative datepicker-cal-icon">
                      <input type="text" name="select_date" value="{{isset($_GET['select_date'])? $_GET['select_date'] : ''}}" id="datepicker" class="form-control" autocomplete="off" placeholder="Select date">
                      <i class="fa-regular fa-calendar-days"></i>
                    </div>
                    <div class="form-outline position-relative">
                      <?php $slots = get_custom_slot(45); ?>
                      <select class="form-control timeslot_select2" name="select_timeslot" id="select_timeslot">
                        <option value=""></option>
                        @foreach($slots as $key =>$sval)
                        <option value="{{ $sval }}" {{ (isset($_GET['select_timeslot']) && $_GET['select_timeslot'] == $sval) ? "selected" : ""  }}>{{ $sval }}</option>
                        @endforeach
                      </select>
                    </div>
                    <button type="submit" class="btn btn-main-primary p-0 d-flex align-items-center justify-content-center filter-btns reset_btn" style="width: 50px;" data-toggle="tooltip" data-placement="top" title="Search"><i class="icon-search-interface-symbol"></i></button>
                  </form>
                </div>
                <div class="form-select-icon position-relative me-2 me-lg-3 flex-shrink-0">
                  <select class="form-select" aria-label="Default select example" name="sort_by" id="sort_by">
                    <option value="relevance" {{ (isset($_GET['sort_by_val']) && $_GET['sort_by_val'] == 'relevance') ? "selected" : "" }}>Sort By : All </option>
                    <option value="avg_review_low_high" {{ (isset($_GET['sort_by_val']) && $_GET['sort_by_val'] == 'avg_review_low_high') ? "selected" : ""  }}>Reviews: Low to high </option>
                    <option value="avg_review_high_low" {{ (isset($_GET['sort_by_val']) && $_GET['sort_by_val'] == 'avg_review_high_low') ? "selected" : ""  }}>Reviews: High to Low </option>
                    <option value="rating_count_low_high" {{ (isset($_GET['sort_by_val']) && $_GET['sort_by_val'] == 'rating_count_low_high') ? "selected" : ""  }}>Ratings: Low to high </option>
                    <option value="rating_count_high_low" {{ (isset($_GET['sort_by_val']) && $_GET['sort_by_val'] == 'rating_count_high_low') ? "selected" : ""  }}>Ratings: High to Low </option>
                  </select>
                  <i class="fa-solid fa-caret-down"></i>
                </div>
                @if(isset($_GET['keyword']) || isset($_GET['sort_by_val']) || isset($_GET['select_date']) || isset($_GET['select_timeslot']))
                  <a href="{{ url('dashboard') }}"><button type="submit" class="btn btn-main-primary p-0 d-flex align-items-center justify-content-center filter-btns reset_btn" style="width: 50px;" data-toggle="tooltip" data-placement="top" title="Reset"><i class="fa fa-undo" aria-hidden="true"></i></button></a>
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
        <div class="content-inner-wrapper">
          <div class="row">
            @if(isset($coaches) && count($coaches) > 0)
            <div class="col-lg-8 col-md-8 order-2 order-md-1">
              <div class="row">
                @foreach($coaches as $key => $coach)
                <div class="col-lg-4 col-md-6 mb-30">
                  <div class="card text-center" style="cursor: default;">
                    <div class="card-img">
                      <img src="{{ ($coach->profile_image) ? url('uploads/'.$coach->profile_image) : url('assets/admin/img/user.png') }}">
                    </div>
                    <h5 class="card-title mb-0">{{ character_limit($coach->name,35) }}</h5>
                    {{--<div class="rating-star d-flex align-items-center justify-content-center mb-2">
                      <div class="rateYo" data-rateyo-read-only="true" data-rateyo-rating="{{ $coach->avg_rating }}" data-rateyo-star-width="18px" data-rateyo-spacing="1px"></div>
                      <div class="rating_number mt-1">({{ $coach->rating_count }} <span>Reviews</span>)</div>
                    </div>--}}
                    @if(isset($coach->tagline))
                    <h6 class="card-subtitle" data-toggle="tooltip" data-placement="top" title="{{ $coach->tagline ?? '' }}"><i class="icon-price-tag"></i> {{ character_limit($coach->tagline,35) }}</h6>
                    @endif
                    <div>
                      {{--<p>{{ character_limit($coach->short_description,105) }}</p>--}}
                      <form action="{{ route('coachprofile',$coach->slug)}}" name="coach_detail" id="coach_detail" method="GET" class="coach_detail">
                          <input type="hidden" name="coach_date" value="{{isset($_GET['select_date'])? $_GET['select_date'] : ''}}">
                          <input type="hidden" name="coach_timeslot" value="{{isset($_GET['select_timeslot'])? $_GET['select_timeslot'] : ''}}">
                          <button class="btn btn-main-primary card-btn w-100">Book Session</button>
                      </form>
                    </div>
                  </div>
                </div>
                @endforeach    
              </div>
            </div>
            @else
            <div class="col-md-8">
              <div class="container"><div class="alert alert-info text-center my-3" role="alert"> No coach found. </div></div>
            </div>
            @endif
            <div class="col-lg-4 col-md-4 order-1 order-md-2 mb-30">
              <div class="text-center box-container calender-wrapper calender-wrapper-sticky">
                <h3 class="mb-5">Select Date and Time</h3>
                <div id="book_datepicker"></div><br>
                <input type="hidden" name="select_date" value="{{isset($_GET['select_date'])? $_GET['select_date'] : ''}}" id="date" >
                <?php //$slot = get_custom_slot(45); ?>
                <div class="timeslot topbar-col-right" id="">
                  <div class="coach_listings_search"> 
                      <?php $slots = get_custom_slot(45); ?>
                      <select class="form-control timeslot_select2" name="select_timeslot" id="timeslot">
                        <option value=""></option>
                        @foreach($slots as $key =>$sval)
                        <option value="{{ $sval }}" {{ (isset($_GET['select_timeslot']) && $_GET['select_timeslot'] == $sval) ? "selected" : ""  }}>{{ $sval }}</option>
                        @endforeach
                      </select>
                  </div>
                  {{--<div class="btn-dv"><button id="find_session_btn" class="btn btn-main-primary card-btn">Find</button></div>--}}
                </div>
              </div>
            </div>
            <div class="col-lg-8 d-flex justify-content-center general_pagination order-3 order-md-3">
              {!! $coaches->withQueryString()->links() !!}
            </div>
          </div>
        </div>
      </section>
      @stop
      @section('js')
      <script src="{{ url('front_assets/js/jquery.rateyo.min.js') }}"></script>
      <script src="{{ url('front_assets/js/jquery-ui.js') }}"></script>
      <script src="{{ url('front_assets/js/common.js') }}"></script>
      <script src="{{ url('assets/js/select2.full.min.js')}}"></script>
      <script>
        $('.coaches_select2').select2({
            placeholder: "Select coach",
        });
        $('.day_select2').select2({
            placeholder: "Select day",
        });
        $('.timeslot_select2').select2({
            placeholder: "Select timeslot",
        });
        $('#datepicker').datepicker({
          dateFormat: 'dd-mm-yy',
          minDate: +1,
        });
        $(document).on('change','#sort_by,#keyword,#timeslot',function(){
          sortBy = $('#sort_by').val();
          $('#sort_by_val').val(sortBy);
          keyword = $('#keyword').val();
          $('#keyword').val(keyword);
          date_val = $('#date').val();
          $('#datepicker').val(date_val);
          timeslot_val = $('#timeslot').val();
          $('#select_timeslot').val(timeslot_val);
          $('#coach_listings_search')[0].submit();
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
        $(function () {
          $input = $("#book_datepicker");
          $input.datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: +1,
            onSelect: function (selectedDate) {
              $('#date').val(selectedDate);
              date_val = $('#date').val();
              $('#datepicker').val(date_val);
              timeslot_val = $('#timeslot').val();
              $('#select_timeslot').val(timeslot_val);
              $('#coach_listings_search')[0].submit();
            }
          });
          var selectedDate = $('#date').val();
          $("#book_datepicker").datepicker("setDate",selectedDate);
        });
      </script>
      @stop