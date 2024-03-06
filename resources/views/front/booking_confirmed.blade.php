  @extends('front.app.index')
  @section('css') @stop
  @section('content')

  @include('front.app.sidebar')

  <div class="site-wrapper">
      <section class="main-body-wrapper">
        <div class="content-inner-wrapper">
          <div class="row">
            <div class="col-md-12 thank-you-box">
              <div class="box-container mw-563 text-center mx-auto mt-4">
                <h1 class="fs-28 title-main-md">Booking Confirmation</h1>
                <div class="ty-check mt-4 pt-1"><img src="{{ url('front_assets/images/green-check.png')  }}"></div>
                <div class="ty-table mt-5 pb-0 overflow-auto">
                  <table class="table mb-0">
                      <thead>
                        <tr>
                          <th>Coach</th>
                          <th>Date</th>
                          <th>Time</th>
                      </tr>
                  </thead>
                  <tbody class="border-0">
                    <tr>
                      <td>
                        <div class="ty-coach-name d-flex align-items-center text-start">
                            <img src="{{ ($session->CoachData->profile_image) ? url('uploads/'.$coach->profile_image) : url('assets/admin/img/user.png') }}">
                            <div>
                                <p class="mb-0">{{ $session->CoachData->name ? character_limit($session->CoachData->name,25) : '---' }}</p>
                                <p class="mb-0">{{ $session->CoachData->tagline ? character_limit($session->CoachData->tagline,25) : '---' }}</p>
                            </div>
                        </div>
                        
                    </td>
                    <td class="text-nowrap">
                        {{ date('d M, Y',strtotime($session->date)) }}
                    </td> 
                    <td class="text-nowrap">{{ $session->time }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-center mt-4">
        <a class="btn btn-main-primary mw-btn-185 card-btn" href="{{ url('my-sessions') }}">My Sessions</a>
  </div>
</div>
</div>
</div>
</div>
</section>
</div>

@stop