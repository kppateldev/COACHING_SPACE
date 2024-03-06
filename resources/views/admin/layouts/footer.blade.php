@yield('before_scripts')
<!-- =============== VENDOR SCRIPTS ===============-->
<!-- MODERNIZR-->
<!-- <script src="{{asset('vendor/modernizr/modernizr.custom.js')}}"></script> -->
<!-- JQUERY-->
<!-- <script src="{{asset('vendor/jquery/dist/jquery.js')}}"></script> -->
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<!-- BOOTSTRAP-->
<script src="{{asset('vendor/popper.js/dist/umd/popper.js')}}"></script>
<script src="{{asset('vendor/bootstrap/dist/js/bootstrap.js')}}"></script>
<!-- STORAGE API-->
<script src="{{asset('vendor/js-storage/js.storage.js')}}"></script>
<!-- JQUERY EASING-->
<script src="{{asset('vendor/jquery.easing/jquery.easing.js')}}"></script>
<!-- ANIMO-->
<!-- <script src="{{asset('vendor/animo/animo.js')}}"></script> -->
<!-- SCREENFULL-->
<script src="{{asset('vendor/screenfull/dist/screenfull.js')}}"></script>
<!-- LOCALIZE-->
<!-- <script src="{{asset('vendor/jquery-localize/dist/jquery.localize.js')}}"></script> -->
<!-- =============== PAGE VENDOR SCRIPTS ===============-->
<!-- SLIMSCROLL-->
<script src="{{asset('vendor/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<!-- SPARKLINE-->
<script src="{{asset('vendor/jquery-sparkline/jquery.sparkline.js')}}"></script>
<!-- MOMENT JS-->
<script src="{{asset('vendor/moment/min/moment-with-locales.js')}}"></script>
<!-- =============== APP SCRIPTS ===============-->
<script src="{{asset('assets/admin/js/app.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.form.js')}}"></script>
<script src="{{asset('assets/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/admin/js/formClass.js')}}"></script>
<script src="{{asset('assets/admin/js/toastr.min.js')}}"></script>
@yield('footer_scripts')
