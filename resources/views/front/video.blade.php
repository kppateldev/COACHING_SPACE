    @extends('front.app.index')
    @section('css') @stop
    @section('content')
    <div class="video-wrap pb-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <div class="video-col-left">
              <div class="site-logo mb-5 pb-lg-5"><a href="#"><img src="{{ url('front_assets/images/logo.png') }}"></a></div>
              <p>The video is mandatory and after it has played in full, you can click next and will be redirect to the Dashboard.</p>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="video-col-right">
              <div class="video-box-wrapper position-relative">
                <style type="text/css">
                  .video-box-wrapper:before{
                    content: none;
                  }
                </style>
                <video id="video_display" poster="{{ url('front_assets/images/woman-attending-online-class.png') }}" class="w-100" controls autoplay muted="" controlsList="nodownload noplaybackrate" disablePictureInPicture onended="videoended()">
                  <source src="{{ url('uploads/Coaching_Space_Onboarding_Video.mp4')}}" type="video/mp4">
                    <source src="{{ url('uploads/Coaching_Space_Onboarding_Video.ogg')}}" type="video/ogg">
                    </video>
                  </div>
                  <div class="text-center mt-4">
                    <a href="javascript:void(0);" id="click_href"><button class="btn btn-main-primary px-5 disabled" id="nextButton" disabled="">Next <i class="fas fa-arrow-right ms-1"></i></button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @stop
        @section('js')
        <script type='text/javascript'>
          function videoended(){
            $("#click_href").attr("href", "{{ url('update-video') }}");
            $('#nextButton').removeClass("disabled");
            $('#nextButton').removeAttr("disabled");
          }

          //Disable video forwarding
          var video = document.getElementById('video_display');
          var supposedCurrentTime = 0;
          video.addEventListener('timeupdate', function() {
          if (!video.seeking) {
          supposedCurrentTime = video.currentTime;
          }
          });
          // prevent user from seeking
          video.addEventListener('seeking', function() {
          // guard agains infinite recursion:
          // user seeks, seeking is fired, currentTime is modified, seeking is fired, current time is modified, ....
          var delta = video.currentTime - supposedCurrentTime;
          // delta = Math.abs(delta); // disable seeking previous content if you want
          if (delta > 0.01) {
          video.currentTime = supposedCurrentTime;
          }
          });
          video.addEventListener('ended', function() {
          // reset state in order to allow for rewind
          supposedCurrentTime = 0;
          });
  </script>
  @stop