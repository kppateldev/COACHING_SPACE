@extends('admin.layouts.default')
@section('content')
<?php $view=="add" || $view=="edit" ?>
      <!-- Main section-->
      <section class="section-container">
        <!-- Page content-->
        <div class="content-wrapper">
          <div class="content-heading">
            <div>Email Templates</div>
          </div>
          <!-- START card-->
          <div class="card card-default">
             <div class="card-header"> @if(isset($data)){{'Edit Email Template'}}@else{{'Add Email Template'}}@endif
               <a href="{{route('admin.email_templates')}}" class="btn btn-danger f-right"><i class="fa fa-arrow-left"></i> Back</a>
             </div>
             <div class="card-body">
                <form method="POST" name="email_body" id="email_body" action="{{url('admin/email_templates/action/')}}/{{$view}}/{{isset($data->id) ? $data->id: '0'}}">
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
                         <label class="col-md-2 col-form-label">Subject <span class="red">*</span></label>
                         <div class="col-md-10">
                            <input class="form-control" type="text" value="@if(isset($data->subject)){{$data->subject}}@endif" placeholder="Subject" name="subject">
                         </div>
                      </div>
                      <div class="form-group row mb-2">
                         <label class="col-md-2 col-form-label">Header <span class="red">*</span></label>
                         <div class="col-md-10">
                          <select class="form-control" name="header_id" id="header_id">
                            <option value="">Select header</option>
                            @foreach($headers as $header)
                            <option value="{{ $header->id }}" @if( isset($data->header_id) && $data->header_id == $header->id ) selected @endif>{{ $header->title }}</option>
                            @endforeach
                          </select>
                         </div>
                      </div>
                      <div class="form-group row mb-2">
                         <label class="col-md-2 col-form-label">Footer <span class="red">*</span></label>
                         <div class="col-md-10">
                          <select class="form-control" name="footer_id" id="footer_id">
                            <option value="">Select footer</option>
                            @foreach($footers as $footer)
                            <option value="{{ $footer->id }}" @if( isset($data->footer_id) && $data->footer_id == $footer->id ) selected @endif>{{ $footer->title }}</option>
                            @endforeach
                          </select>
                         </div>
                      </div>
                      <div class="form-group row mb-2">
                         <label class="col-md-2 col-form-label">Body <span class="red">*</span></label>
                         <div class="col-md-10">
                          <textarea class="form-control ckeditor" name="body" id="body" rows="6">{{$data->body ?? old('body')}}</textarea>
                          <span id="body-error"></span>
                         </div>
                      </div>
                   </fieldset>
                   <fieldset>
                      <div class="text-right mt-3">
                           <a href="{{route('admin.email_templates')}}" class="btn btn-warning">Discard</a>
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
      $("#email_body").validate({
        ignore: ".ignore",
         rules: {
            title: {
               required: true,
            },
            subject: {
               required: true,
            },
            header_id: {
               required: true,
            },
            footer_id:{
              required: true,
            },
            body: {
               required: true,
            }
         },
         messages: {
            title: {
               required: "Please enter a title.",
            },
            subject: {
               required: "Please enter a subject.",
            },
            header_id: {
               required: "Please select a header name.",
            },
            footer_id: {
               required: "Please select a footer name.",
            },
            body: {
               required: "Please enter body.",
            }
         },
         errorPlacement: function (error, element) {
            if (element.attr("type") == "input") {
              error.insertAfter(element.parent().parent());
            } else if (element.attr("name") == "body") {
              error.appendTo($('#body-error').show());
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
