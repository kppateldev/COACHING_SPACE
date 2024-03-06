@extends('admin.layouts.default')
@section('content')
      <!-- Main section-->
      <section class="section-container">
        <!-- Page content-->
        <div class="content-wrapper">
          <div class="content-heading">
            <div>Facilities</div>
          </div>
          <!-- START card-->
          <div class="card card-default">
             <div class="card-header"> @if(isset($data)){{'Edit Facility'}}@else{{'Add Facility'}}@endif
               <a href="{{route('admin.facilities')}}" class="btn btn-danger f-right"><i class="fa fa-arrow-left"></i> Back</a>
             </div>
             <div class="card-body">
                <form id="facilities-form" class="form-horizontal ajax_form" method="post" action="@if(isset($data)){{route('admin.facilities.update',$data->id)}}@else{{route('admin.facilities.store')}}@endif">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="alert ajax_report alert-info alert-hide" role="alert">
                    <span class="close" >&times;</span>
                    <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
                  </div>
                   <fieldset>
                      <div class="form-group row mb-2">
                         <label class="col-md-2 col-form-label">Facility Title <span class="red">*</span></label>
                         <div class="col-md-10">
                            <input class="form-control" type="text" value="@if(isset($data->title)){{$data->title}}@endif" placeholder="Title" name="title">
                         </div>
                      </div>

                      <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Facility Icon <span class="red">*</span></label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->icon)){{$data->icon}}@endif" placeholder="Icon Class" name="icon">
                        </div>
                     </div>
                     <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Display Order <span class="red">*</span></label>
                        <div class="col-md-10">
                           <input class="form-control" type="number" value="@if(isset($data->display_order)){{$data->display_order}}@endif" placeholder="Display Order" name="display_order">
                        </div>
                     </div>

                      {{-- <div class="form-group row mb-2">
                         <label class="col-md-2 col-form-label">Facility Image</label>
                         <div class="col-md-10">
                            @if(isset($data->image))
                            <img src="{{asset('uploads/'.$data->image)}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="image" >
                         </div>
                      </div> --}}
                   </fieldset>
                   <fieldset>
                      <div class="text-right mt-3">
                           <a href="{{route('admin.facilities')}}" class="btn btn-warning">Discard</a>
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
@stop
