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
            <img src="{{ ($coach->profile_image) ? url('uploads/'.$coach->profile_image) : url('assets/admin/img/user.png') }}">
          </div>
          <h1 class="mb-0 mt-3">{{ $coach->name }}</h1>
          <p class="mb-0 fw-bold"><i class="icon-price-tag"></i> {{ $coach->tagline }}</p>
        </div>
        <ul class="list-inline coaching-details d-flex align-items-center justify-content-evenly mt-3 mb-4">
          <li class="d-flex align-items-center me-2">
            <span class="d-flex align-items-center justify-content-center me-2"><i class="fa-regular fa-calendar-plus"></i></span>
            <div>
              <p class="mb-0">Coaching Date</p>
              <h6 id="confirm_coach_date" class="mb-0">{{ $session->date }}</h6>
            </div>
          </li>
          <li class="d-flex align-items-center">
            <span class="d-flex align-items-center justify-content-center me-2"><i class="fa-regular fa-clock"></i></span>
            <div>
              <p class="mb-0">Coaching Time</p>
              <h6 id="confirm_coach_time" class="mb-0">{{ $session->time }}</h6>
            </div>
          </li>
        </ul>

        {!! Form::open(['url'=>url('cancel-session-submit'), 'id'=>'cancel-session-submit']) !!}
        <input type="hidden" name="sessionID" value="{{ $session->id }}">
        <div class="form-group">
          <label class="form-label mb-1">Cancel Reason</label>
          <textarea name="cancel_reason" class="form-control h-auto" rows="3"></textarea>
        </div>
        <div class="modal-footer p-0 border-0 justify-content-center">
          <input type="submit" name="submit" class="btn btn-main-primary mw-btn-185" value="Submit">
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>