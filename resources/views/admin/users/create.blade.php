@extends('admin.layouts.default')
@section('content')
<link href="{{ asset('front_assets/css/croppie.css') }}" rel="stylesheet" />
<!-- -->
  <div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Image</h4>
        </div>
        <div class="modal-body p-4">
          <div class="row">
            <div class="col-md-12 text-center">
              <div id="image_demo" style="width:350px; margin-top:30px; margin: auto;"></div>
            </div>
            <div class="col-md-12 text-center" style="padding-top:30px;">
              <button class="button ripple-effect btn btn-rounded btn-w250 crop_image">Crop & Upload</button>
            </div>
          </div>
        </div>
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
    .profile-img
    {
      border-radius: 100px;
      background-color: #ffffff;
      display: inline-block;
      padding: 4px;
    }
    .profile-img img
    {
      width: 67px;
      height: 67px;
      border-radius: 100px;
    }
    .user-profile .p-name
    {
      font-size: 14px;
      color: #272727;
      font-weight: bold;
      text-transform: capitalize;
    }
    .file-input
    {
      overflow: hidden;
      opacity: 0;
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
    }
    .edit-profile-icon
    {
      width: 25px;
      height: 25px;
      border-radius: 50px;
      background-color: #00aee8;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 12px;
      cursor: pointer;
    }
    .edit-profile
    {
      position: absolute;
      right: 43px;
      top: 54px;
    }
    .modal-backdrop.show{display: none;}
    #uploadimageModal .modal-header
    {
      flex-direction: row-reverse;
      background: none;
      box-shadow: none;
      justify-content: space-between;
      background-color: #00aee8;
      border-radius: .375rem .375rem 0 0;
    }
    #uploadimageModal .modal-header .close
    {
      color: #fff;
      opacity: 1;
      font-size: 26px;
      padding: 0;
      margin: 0;
      text-shadow: none;
    }
    #uploadimageModal .modal-header .modal-title{color: #fff;}
  </style>
  <!-- Main section-->
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
    <div class="content-heading">
      <div>User</div>
   </div>
   <!-- START card-->
   <div class="card card-default">
    <div class="card-header"> @if(isset($data)){{'Edit User'}}@else{{'Add User'}}@endif
      <a href="{{route('admin.users')}}" class="btn btn-danger f-right"><i class="fa fa-arrow-left"></i> Back</a>
   </div>
   <div class="card-body">
    <form id="users-form" class="form-horizontal ajax_form" method="post" action="@if(isset($data)){{route('admin.users.update',$data->id)}}@else{{route('admin.users.store')}}@endif" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <div class="alert ajax_report alert-info alert-hide" role="alert">
        <span class="close" >&times;</span>
        <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
     </div>
     <fieldset>
       <div class="form-group row mb-2">
          <label class="col-md-2 col-form-label">First Name <span class="red">*</span> </label>
          <div class="col-md-10">
             <input class="form-control" type="text" value="@if(isset($data->first_name)){{$data->first_name}}@endif" placeholder="First Name" name="first_name">
          </div>
       </div>
       <div class="form-group row mb-2">
         <label class="col-md-2 col-form-label">Last Name <span class="red">*</span> </label>
         <div class="col-md-10">
            <input class="form-control" type="text" value="@if(isset($data->last_name)){{$data->last_name}}@endif" placeholder="Last Name" name="last_name">
         </div>
      </div>
      <div class="form-group row mb-2">
         <label class="col-md-2 col-form-label">Email Address <span class="red">*</span> </label>
         <div class="col-md-10">
            <input class="form-control" type="text" value="@if(isset($data->email)){{$data->email}}@endif" placeholder="Email Address" name="email">
         </div>
      </div>

      @if(!isset($data))
      <!-- <div class="form-group row mb-2">
         <label class="col-md-2 col-form-label">Password <span class="red">*</span> </label>
         <div class="col-md-10">
            <input class="form-control" type="password" value="@if(isset($data->password)){{$data->password}}@endif" placeholder="Password" name="password">
         </div>
      </div> -->
      @endif

      <div class="form-group row mb-2">
         <label class="col-md-2 col-form-label">Organisation <span class="red">*</span> </label>
         <div class="col-md-10">
            <select name="organization_id" class="form-control">
               <option value="">Select an organisation</option>
               @foreach($organizations as $organization)
               <option value="{{ $organization->id }}" {{ (isset($data) && $organization->id == $data->organization_id) ? 'selected' : '' }}>{{ $organization->company_name }}</option>
               @endforeach
            </select>
         </div>
      </div>

      <div class="form-group row mb-2">
       <label class="col-md-2 col-form-label">Department<span class="red">*</span> </label>
       <div class="col-md-10">
        <select name="department_id" class="form-control">
         <option value="">Select a department</option>
         @foreach($departments as $department)
         <option value="{{ $department->id }}" {{ (isset($data) && $department->id == $data->department_id) ? 'selected' : '' }}>{{ $department->title }}</option>
         @endforeach
       </select>
     </div>
   </div>


      {{--<div class="form-group row mb-2">
         <label class="col-md-2 col-form-label">Phone Number </label>
         <div class="col-md-10">
            <input class="form-control" type="tel" value="@if(isset($data->phone_number)){{$data->phone_number}}@endif" placeholder="Phone Number" name="phone_number">
         </div>
      </div>--}}
    <div class="form-group row mb-2">
         <label class="col-md-2 col-form-label">Profile Photo </label>
          <div class="col-md-10">
            <div class="my-profile-img">
              <div class="user-profile position-relative d-inline-block">
                <span class="profile-img" id="profile_image_thumbnail"><img src="{{ (isset($data->profile_image)) ? url('uploads/'.$data->profile_image) : url('assets/admin/img/user.png') }}"></span>
                <!-- <p class="p-name mt-3 text-center">Delete</p> -->
                <style type="text/css">
                  .my-profile-img .user-profile .edit-profile{
                    bottom: 5px;
                    cursor: pointer;
                  }
                </style>
                <div class="edit-profile position-absolute end-0" style="right: 0;">
                  <div class="edit-profile-icon position-relative">
                    <input accept="image/*" name="profile_image1" id="profile_image" type="file" class="file-input">
                    <i class="icon-pencil"></i>
                  </div>
                </div>
              </div>
            </div>
            <label class="profile_image_ierror"></label>
          </div>
    </div>
    <div class="form-group row mb-2">
      <label class="col-md-2 col-form-label">Is Active?  </label>
      <div class="col-md-10">
       <label class="switch mt-2">
        <input class="change_status" name="is_active" type="checkbox" @if(!isset($data)) ? checked @elseif(isset($data) && $data->is_active == "1") checked @endif>
        <span class="slider round"></span>
     </label>
  </div>
</div>

</fieldset>
<fieldset>
 <div class="text-right mt-3">
   <a href="{{route('admin.users')}}" class="btn btn-warning">Discard</a>
   <input type="submit" name="Save" value="Save" class="btn btn-success submit">
   <!-- <button class="btn btn-success submit" type="submit">Save</button> -->
</div>
</fieldset>
</form>
</div>
</div>
<!-- END card-->
</div>
</section>
<input type="hidden" name="user_id" value="{{ (isset($data->id)) ? $data->id : '' }}" id="user_id">
@stop
@section('footer_scripts')
<script src="{{ asset('front_assets/js/croppie.js') }}"></script>
<script src="{{asset('vendor/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
   $(function() {

      jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
     }, "Letters only please"); 

      $("#users-form").validate({
         rules: {
            first_name: {
               required: true,
               lettersonly: true
            },
            last_name: {
               required: true,
               lettersonly: true
            },
            email: {
               required: true,
               email: true
            },
            organization_id: {
              required: true
            },
            department_id: {
              required: true
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
               required: "Please enter an email address.",
               lettersonly: "Please enter a valid email address."
            },
            organization_id: {
              required: "Please select an organization."
            },
            department_id: {
              required: "Please select a department."
            }
         },
         submitHandler: function(form) {
            form.submit();
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
      var id = $('#user_id').val();
      $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function(response){
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url:"{{ route('admin.users.cropprofile') }}",
          type: "POST",
          data:{"_token": "{{ csrf_token() }}","image": response,"id":id},
          beforeSend: function() {
            $('.sub-loader').show();
          },
          success:function(data)
          {
            $('#uploadimageModal').modal('hide');
            $('#profile_image_thumbnail').html(data);
            $('#id').html(data);
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

  });
</script>
@stop
