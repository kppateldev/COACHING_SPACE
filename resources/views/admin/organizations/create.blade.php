@extends('admin.layouts.default')
@section('content')
<!-- Main section-->
<section class="section-container">
 <!-- Page content-->
 <div class="content-wrapper">
  <div class="content-heading">
   <div>Organization</div>
</div>
<!-- START card-->
<div class="card card-default">
  <div class="card-header"> @if(isset($data)){{'Edit Organization'}}@else{{'Add Organization'}}@endif
   <a href="{{route('admin.organizations')}}" class="btn btn-danger f-right"><i class="fa fa-arrow-left"></i> Back</a>
</div>
<div class="card-body">
  <form id="organizations-form" class="form-horizontal ajax_form" method="post" action="@if(isset($data)){{route('admin.organizations.update',$data->id)}}@else{{route('admin.organizations.store')}}@endif">
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
   <label class="col-md-2 col-form-label">Organisation Name <span class="red">*</span> </label>
   <div class="col-md-10">
      <input class="form-control" type="text" value="@if(isset($data->company_name)){{$data->company_name}}@endif" placeholder="Organisation Name" name="company_name">
   </div>
</div>

<div class="form-group row mb-2">
   <label class="col-md-2 col-form-label">Organisation Email address <span class="red">*</span> </label>
   <div class="col-md-10">
      <input class="form-control" type="text" value="@if(isset($data->email)){{$data->email}}@endif" placeholder="Organisation Email address" name="email" {{ (isset($data)) ? 'readonly' : '' }}>
   </div>
</div>

<div class="form-group row mb-2">
 <label class="col-md-2 col-form-label">Department Name<span class="red">*</span> </label>
   <div class="col-md-10">
    <select name="department_id" class="form-control">
     <option value="">Select a department</option>
     @foreach($departments as $department)
     <option value="{{ $department->id }}" {{ (isset($data) && $department->id == $data->organization_id) ? 'selected' : '' }}>{{ $department->title }}</option>
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
   <label class="col-md-2 col-form-label">Sessions Limit </label>
   <div class="col-md-10">
      <input class="form-control" type="number" value="@if(isset($data->sessions_limit)){{$data->sessions_limit}}@endif" placeholder="Sessions Limit" name="sessions_limit">
   </div>
</div>

<div class="form-group row mb-2">
   <label class="col-md-2 col-form-label">Status </label>
   <div class="col-md-10">
     <label class="switch mt-2">
       <input class="change_status" name="status" type="checkbox" @if(!isset($data)) ? checked @elseif(isset($data) && $data->status == "1") checked @endif>
       <span class="slider round"></span>
    </label>
 </div>
</div>

</fieldset>
<fieldset>
  <div class="text-right mt-3">
   <a href="{{route('admin.organizations')}}" class="btn btn-warning">Discard</a>
   <button class="btn btn-success submit" type="submit">Save</button>
</div>
</fieldset>
</form>
</div>
</div>
<!-- END card-->
</div>
</section>
@stop
@section('footer_scripts')
<script src="{{asset('vendor/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
   $(function() {

      jQuery.validator.addMethod("lettersonly", function(value, element) {
       return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please"); 

      $("#organizations-form").validate({
         rules: {
            first_name: {
               required: true,
               lettersonly: true
            },
            last_name: {
               required: true,
               lettersonly: true
            },
            company_name: {
               required: true,
            },
            department_id: {
               required: true,
            },
            email: {
               required: true,
               email: true
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
            company_name: {
               required: "Please enter organization name.",
            },
            department_id: {
               required: "Please select department name.",
            },
            email: {
               required: "Please enter a organization email address.",
               lettersonly: "Please enter a valid email address."
            },
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });
</script>
@stop
