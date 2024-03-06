    @extends('front.app.index')
    @section('css') 
    <style type="text/css">
      .agreementform {
        padding: 30px;
        border-radius:15px;
        background-color: #FFF;
        box-shadow: 0px 0px 15px rgba(0,0,0,0.1);

      }
      .title-main-sm {font-size: 18px;}
      .subtitle-main {font-size: 16px;}
      .customScroll {
        max-height: 480px;
        min-height: 480px;
        overflow-y: scroll;
        padding:0  30px;
      }
      .customScroll::-webkit-scrollbar {        
        width: 8px;
        border-radius: 8px;
      }
       
      .customScroll::-webkit-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
      }
       
      .customScroll::-webkit-scrollbar-thumb {
        background-color: #00aee8;
        border-radius: 8px;
      }
    </style>
    @stop
    @section('content')
    <header class="header-main-two header-before position-relative">
      <div class="container">
        <div class="site-logo"><a href="#"><img src="{{ url('front_assets/images/logo.png') }}"></a></div>
      </div>
    </header>
    <div class="main-body-content position-relative pb-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-9 m-auto">
            <form id="agreementform" class="agreementform" action="{{ url('update-agreement')}}" method="GET"> 
              <h1 class="title-main-lg mb-4 text-center">Coaching Agreement</h1>              
              <div class="customScroll">                
                @include('front.includes.flash-message')
                <p class="subtitle-main mb-3">This agreement is between the ‘Coachee’) and the ‘Coach’, and by the Coachee making a booking, and the Coach providing their availability, both parties agree with the terms set out in this Coaching Agreement. </p>
                
                <h2 class="title-main-sm mb-1 mt-4">The coaching relationship</h2>
                <p class="subtitle-main mb-3">The purpose of the coaching relationship is to support the Coachee to achieve their goals. Coaching is intended to enhance the Coachee’s performance or improve their work or personal situation.</p>
                <p class="subtitle-main mb-3">The services to be provided by the Coach to the Coachee will take place through live online two-way video sessions via our platform Coaching Space.</p>
                
                <h2 class="title-main-sm mb-1 mt-4">Coachee’s responsibilities</h2>
                <ul>
                  <li class="subtitle-main mb-2">To attend coaching sessions as agreed.</li>
                  <li class="subtitle-main mb-2">To select topics for discussion.</li>
                  <li class="subtitle-main mb-2">Coach’s responsibilities</li>
                  <li class="subtitle-main mb-2">To manage the coaching process (including timekeeping).</li>
                  <li class="subtitle-main mb-2">To undertake regular professional coaching supervision.</li>
                  <li class="subtitle-main mb-2">
                    To maintain confidentiality (subject to certain exemptions):
                    <ol>
                      <li>A person being at risk to themselves or others </li>
                      <li>Illegal or unethical actions</li>
                    </ol>
                  </li>
                  <li class="subtitle-main mb-2">To store and dispose of any records created during coaching in a manner that promotes confidentiality, security, and privacy, and complies with any applicable laws and agreements. As a Coachee you can request access to your records, should you wish to.</li>
                  <li class="subtitle-main mb-2">The Coach will work within the professional ethics and guidelines as outlined in the Global Code of Ethics, which is available upon request.</li>
                </ul>

                <h2 class="title-main-sm mb-1 mt-4">Sessions</h2>
                <p class="subtitle-main mb-3">The Coachee and Coach will meet for a set number sessions, each lasting for no longer than 45 minutes.</p>
                
                <h2 class="title-main-sm mb-1 mt-4">Rescheduling/ cancelling a coaching session</h2>
                <p class="subtitle-main mb-3">Coaching sessions can be rescheduled or cancelled by either the Coachee or the Coach with at least 24 hours notice.</p>
              </div>              
              <div class="form-check p-0 d-block my-3">
                <input type="checkbox" name="agree" id="agree" value="1" class="form-check-input m-0 me-2" />
                <label class="form-check-label" for="agree">I agree with Terms & Conditions.</label><br>
                <label style="display: none;" id="agreeerror" class="error mt-2">Please agree to the Terms & Conditions.</label>
              </div>                
              <button type="submit" class="btn btn-main-primary btn-sm save_btn" style="width: 150px" data-bs-dismiss="modal" aria-label="Close">I AGREE</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@stop
@section('js')
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
  $(document).on('click','.save_btn',function(){
    if($("input[name='agree']").is(":checked")) {
      $('#agreeerror').hide();
      return true;
    }else{
      $('#agreeerror').show();
      return false;
    }
  });
</script>
@stop