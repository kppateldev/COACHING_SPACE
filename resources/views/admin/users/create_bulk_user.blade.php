@extends('admin.layouts.default')
@section('content')
<!-- Main section-->
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
    <div class="content-heading">
      <div>Users</div>
    </div>
    <!-- START card-->
    <div class="card card-default">
      <div class="card-header"> Add Multiple Users
        <a href="{{ url('uploads/coaching_space_bulk_user.xlsx')}}" class="btn btn-info f-left" download=""><i class="fa fa-download"></i>  Download Sample CSV File</a>
        <a href="{{route('admin.users')}}" class="btn btn-danger f-right"><i class="fa fa-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="users-form" action="{{ url('admin/users/file-import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <div class="alert ajax_report alert-info alert-hide" role="alert">
            <span class="close" >&times;</span>
            <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
          </div>
          <fieldset>
            <div class="form-group row mb-2">
              <div class="col-md-6">
                <input type="file" name="file" class="form-control" id="customFile">
              </div>
            </div>
            <label id="file-error"></label>
          </fieldset>
          <fieldset>
           <div class="text-right mt-3">
            <a href="{{route('admin.users')}}" class="btn btn-warning">Discard</a>
            <input type="submit" name="submit" value="Submit" class="btn btn-success submit">
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
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
 $(function() {
      $("#users-form").validate({
        rules: {
          file: {
            required: true
          }
        },
        messages: {
          file: {
            required: "Please upload a file."
          }
        },
        errorPlacement: function (error, element) {
          if (element.attr("name") == "file") {
            error.appendTo($('#file-error').show());
          } else {
            error.insertAfter(element);
          }
        },
        submitHandler: function(form) {
          form.submit();
        }
    });
});
</script>
@stop
