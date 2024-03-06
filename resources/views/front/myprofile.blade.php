  @extends('front.app.index')
  @section('css') @stop
  @section('content')

  @include('front.app.sidebar')
  
  <!-- -->
  <div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog modal-upload-img">
      <div class="modal-content">
        <div class="modal-header d-block">
          <button type="button" class="close float-end" data-bs-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">Upload Image</h4>
        </div>
        <div class="modal-body p-sm-4 p-3">
          <div class="row">
            <div class="col-md-12 text-center">
              <div id="image_demo" style="width:350px; margin-top:30px; margin: auto;"></div>
            </div>
            <div class="col-md-12 text-center pt-sm-4 pt-2">
              <button class="button ripple-effect btn btn-rounded btn-w250 crop_image btn-main-primary">Crop & Upload</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content position-relative">
        <div class="modal-header text-center flex-column p-0 border-0">
          <h5 class="modal-title title-main-lg fs-28" id="exampleModalLabel">Are you sure you want to delete this account ? </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-footer p-0 border-0 justify-content-center">
          <a href="{{ url('delete-account') }}"><button type="button" class="btn btn-main-primary mw-btn-185">Yes</button></a>
          <button type="button" class="btn btn-main-primary mw-btn-185" data-bs-dismiss="modal">No</button>
        </div>
        </form>
      </div>
    </div>
  </div> 
  <style>
    .croppie-container {
      height:auto;   
    }
    .modal-header .close{
      color: white;
      font-size: 20px;
    }
    button.btn.btn-success.crop_image {
      background: #488EFF;
    }
    .sub-loader{
      z-index: 99999;
    }
    label.profile_image_ierror{
      color: red;
    }
  </style>
  <link href="{{ asset('front_assets/css/croppie.css') }}" rel="stylesheet" />
  <div class="site-wrapper">
    <section class="main-body-wrapper">
      <div class="topbar-main py-4">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="topbar-col-left me-md-4">
              <h1 class="title-main-md mb-md-0">My Profile
                <button class="btn btn-main-primary mw-btn-185" style="float: right;" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Account</button></h1>
            </div>
          </div>
        </div>
      </div>
      <div class="content-inner-wrapper">
        <div class="row">
          <div class="col-lg-auto">
            <div class="my-profile-img">
              <div class="user-profile position-relative">
                <span class="profile-img" id="profile_image_thumbnail"><img src="{{ (isset($user->profile_image)) ? url('uploads/'.$user->profile_image) : url('assets/admin/img/user.png') }}"></span>
                <!-- <p class="p-name mt-3 text-center">Delete</p> -->
                <style type="text/css">
                  .my-profile-img .user-profile .edit-profile{
                    bottom: 5px;
                    cursor: pointer;
                  }
                </style>
                <div class="edit-profile">
                  <div class="edit-profile-icon position-relative">
                    <input accept="image/*" name="profile_image" id="profile_image" type="file" class="file-input">
                    <i class="fa-solid fa-pencil"></i>
                  </div>
                </div>
              </div>
            </div>
            <label class="profile_image_ierror"></label>
          </div>

          <div class="col-lg-8 ps-lg-5">
            <div class="my-profile-form">
              @include('front.includes.flash-message')
              {!! Form::open(['url'=>url('myprofile'), 'id'=>'myprofileForm']) !!}
              <div class="row">
                <div class="form-group col-md-6">
                  <label class="form-label">First Name</label>
                  <div class="position-relative">
                    <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
                  </div>  
                </div>
                <div class="form-group col-md-6">
                  <label class="form-label">Last Name</label>
                  <div class="position-relative">
                    <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                  </div>  
                </div>
                <div class="form-group col-md-6">
                  <label class="form-label">Email Address</label>
                  <div class="position-relative">
                    <input readonly type="email" name="email" class="form-control" value="{{ $user->email }}">
                  </div>  
                </div>
                <div class="form-group col-md-6">
                  <label class="form-label">Phone Number</label>
                  <div class="position-relative">
                    <input type="tel" name="phone_number" class="form-control" value="{{ $user->phone_number }}">
                  </div>  
                </div>
                <div class="form-group col-md-12">
                  <label class="form-label">Organization Name</label>
                  <div class="position-relative">
                    <select name="organization_id" class="form-control" disabled>
                     <option value="">No organization</option>
                     @foreach($organizations as $organization)
                     <option value="{{ $organization->id }}" {{ (isset($user) && $organization->id == $user->organization_id) ? 'selected' : '' }}>{{ $organization->company_name }}</option>
                     @endforeach
                   </select>
                 </div>  
               </div>
               <div class="">
                <button type="submit" class="btn btn-main-primary mw-btn-185">Update</button>
              </div>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <!-- Footer -->
  </section>
</div>
@stop

@section('js')
<script src="{{ asset('front_assets/js/croppie.js') }}"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
  $(function() {
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please"); 

    $("#myprofileForm").validate({
      rules: {
        first_name: {
          required: true,
          lettersonly: true,
          minlength:2,
          maxlength:20,
        },
        last_name: {
          required: true,
          lettersonly: true,
          minlength:2,
          maxlength:20,
        },
        email: {
          required: true,
          email: true
        },
        /*organization_id: {
          required: true
        },*/
        phone_number:{
          required:true,
          digits:true,
          minlength:10,
          maxlength:10,
        }

      },
      messages: {
        first_name: {
          required: "Please enter a first name.",
          lettersonly: "Please enter only alphabets."
        },
        last_name: {
          required: "Please enter a last name.",
          lettersonly: "Please enter only alphabets."
        },
        email: {
          required: "Please enter a email.",
          lettersonly: "Please enter a valid email."
        },
        /*organization_id: {
          required: "Please select a organization."
        },*/
        phone_number:{
          required:"Please enter phone number.",
        }
      },
      submitHandler: function(form) {
        form.submit();
        $('.sub-loader').show();
      }
    });
  });


  $(document).ready(function(){
    $image_crop = $('#image_demo').croppie({
      enableExif: true,
      viewport: {
        width:150,
        height:150,
                type:'circle' //square
              },
              boundary:{
                width:300,
                height:300
              }
            });

    $('#profile_image').on('change', function(){
      var fileInput = document.getElementById('profile_image');
      var files = fileInput.files;
      $(".profile_image_ierror").html('');
      for (var i = 0; i < files.length; i++) {
        var file = files[i]
        var imageType = /image.*/;
        if (!file.type.match(imageType)) {
          $(".profile_image_ierror").html("<label class='profile_image_ierror'>Select jpg,jpeg and png file</label>");
          $("#profile_image").val("");
          return false;
        }
        if(file.size > 2000000)
        {
          $(".profile_image_ierror").html("<label class='profile_image_ierror'>File size max 2 mb</label>");
          $("#profile_image").val("");
          return false;
        }

        var reader = new FileReader();
        reader.onload = function (event) {
          $image_crop.croppie('bind', {
            url: event.target.result
          }).then(function(){
            console.log('jQuery bind complete');
          });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
      }
    });

    $('.crop_image').click(function(event){
      $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function(response){
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url:"{{ route('cropprofile') }}",
          type: "POST",
          data:{"_token": "{{ csrf_token() }}","image": response},
          beforeSend: function() {
            $('.sub-loader').show();
          },
          success:function(data)
          {
            $('#uploadimageModal').modal('hide');
            $('#profile_image_thumbnail').html(data);
          },
          complete: function() {
            $('.sub-loader').hide();
          },
        });
      })
    });

    $(".upload-button").on('click', function() {
      $(".file-upload1").click();
    });

    var addressInputElement = $('#user_autosuggestion_id');
    $(document).on('focus click', addressInputElement,  function(e){
      var pacContainer = $('.pac-container');
      $(addressInputElement.closest('div.form-group')).append(pacContainer);
    });

    var uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
      var clean_uri = uri.substring(0, uri.indexOf("?"));
      window.history.replaceState({}, document.title, clean_uri);
    }

  });
</script>
@stop
