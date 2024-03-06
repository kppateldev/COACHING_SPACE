@extends('admin.layouts.default')
@section('content')
<?php $view=="add" || $view=="edit" ?>
      <!-- Main section-->
      <section class="section-container">
        <!-- Page content-->
        <div class="content-wrapper">
          <div class="content-heading">
            <div>Email Footer</div>
          </div>
          <!-- START card-->
          <div class="card card-default">
             <div class="card-header"> @if(isset($data)){{'Edit Email Footer'}}@else{{'Add Email Footer'}}@endif
               <a href="{{route('admin.email_footer_template')}}" class="btn btn-danger f-right"><i class="fa fa-arrow-left"></i> Back</a>
             </div>
             <div class="card-body">
                <form method="POST" name="email_footer_template" id="email_footer_template" action="{{url('admin/email_footer_template/action/')}}/{{$view}}/{{isset($data->id) ? $data->id: '0'}}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="alert ajax_report alert-info alert-hide" role="alert">
                    <span class="close" >&times;</span>
                    <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
                  </div>
                   <fieldset>
                      <div class="form-group row mb-2">
                         <label class="col-md-2 col-form-label">Title <span class="red">*</span></label>
                         <div class="col-md-10">
                            <input class="form-control" type="text" value="@if(isset($data->title)){{$data->title}}@endif" placeholder="Title" name="title">
                         </div>
                      </div>
                      <div class="form-group row mb-2">
                         <label class="col-md-2 col-form-label">Description <span class="red">*</span></label>
                         <div class="col-md-10">
                          <textarea class="form-control ckeditor" name="description" id="description" rows="6">{{$data->description ?? old('description')}}</textarea>
                          <span id="description-error"></span>
                         </div>
                      </div>
                   </fieldset>
                   <fieldset>
                      <div class="text-right mt-3">
                           <a href="{{route('admin.email_footer_template')}}" class="btn btn-warning">Discard</a>
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
      $("#email_footer_template").validate({
        ignore: ".ignore",
         rules: {
            title: {
               required: true,
            },
            description: {
               required: true,
            }
         },
         messages: {
            title: {
               required: "Please enter a title.",
            },
            description: {
               required: "Please enter description.",
            }
         },
         errorPlacement: function (error, element) {
            if (element.attr("type") == "input") {
              error.insertAfter(element.parent().parent());
            } else if (element.attr("name") == "description") {
              error.appendTo($('#description-error').show());
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
