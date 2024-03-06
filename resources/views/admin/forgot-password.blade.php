<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <link rel="shortcut icon" type="image/x-icon" href="{{ url('front_assets/images/sidebar-logo.png') }}"/>
   <title>Forgot Password - {{get_settings('site_name') ?? 'Site Title'}}</title>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free-webfonts/css/fa-brands.css')}}">
   <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free-webfonts/css/fa-regular.css')}}">
   <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free-webfonts/css/fa-solid.css')}}">
   <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free-webfonts/css/fontawesome.css')}}">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="{{asset('vendor/simple-line-icons/css/simple-line-icons.css')}}">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.css')}}" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="{{asset('assets/admin/css/app.css')}}" id="maincss">
   <link rel="stylesheet" href="{{asset('assets/admin/css/toastr.css')}}">
   <link rel="stylesheet" href="{{asset('assets/admin/css/custom.css')}}">
</head>

<body>
   <div class="wrapper">
      <div class="block-center mt-5 wd-xl">
         <!-- START card-->
         <div class="card card-flat">
            <div class="card-header text-center">
                @if(get_settings('logo'))
                    <a href="{{ route('admin.login')}}">
                        <img class="block-center rounded" src="{{asset('uploads/'.get_settings('logo'))}}" height="100px" alt="Image" style="background-color: white;">
                    </a>
                @else
                    <a href="{{ route('admin.login')}}">
                        <img class="block-center rounded" src="{{asset('assets/admin/img/logo.png')}}" alt="Image" style="background-color: white;">
                    </a>
                @endif
            </div>
            <div class="card-body">
               <p class="text-center py-2">PASSWORD RESET</p>
               <form method="post" class="ajax_form" id="recoverForm" action="{{route('admin.forgotPassword.post')}}">

                 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="alert ajax_report alert-info alert-hide" role="alert">
                    <span class="close" >&times;</span>
                    <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
                  </div>

                  <p class="text-center">Fill with your registered email to reset your password.</p>
                  <div class="form-group">
                     <label class="text-muted" for="resetInputEmail1">Email address</label>
                     <div class="input-group with-focus">
                        <input class="form-control border-right-0" id="resetInputEmail1" type="text" name="email" placeholder="Enter email" autocomplete="off">
                        <div class="input-group-append">
                           <span class="input-group-text text-muted bg-transparent border-left-0">
                              <em class="fa fa-envelope"></em>
                           </span>
                        </div>
                     </div>
                  </div>
                  <button class="btn btn-danger btn-block submit" type="submit">Reset</button>
               </form>
            </div>
         </div>
         <!-- END card-->
         <div class="p-3 text-center">
            <p>{{get_settings('copyright_text') ?? 'Copyright Text'}}</p>
         </div>
      </div>
   </div>
   <!-- =============== VENDOR SCRIPTS ===============-->
   <!-- MODERNIZR-->
   <script src="{{asset('vendor/modernizr/modernizr.custom.js')}}"></script>
   <!-- JQUERY-->
   <!-- <script src="{{asset('vendor/jquery/dist/jquery.js')}}"></script> -->
   <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
   <!-- BOOTSTRAP-->
   <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.js')}}"></script>
   <!-- STORAGE API-->
   <script src="{{asset('vendor/js-storage/js.storage.js')}}"></script>
   <!-- PARSLEY-->
   <script src="{{asset('vendor/parsleyjs/dist/parsley.js')}}"></script>
   <!-- =============== APP SCRIPTS ===============-->
   <script src="{{asset('assets/admin/js/app.js')}}"></script>
   <script src="{{asset('assets/admin/js/jquery.form.js')}}"></script>
   <script src="{{asset('assets/admin/js/formClass.js')}}"></script>
   <script src="{{asset('assets/admin/js/toastr.min.js')}}"></script>

</body>

</html>
