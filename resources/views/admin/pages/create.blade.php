@extends('admin.layouts.default')
@section('content')
      <!-- Main section-->
      <section class="section-container">
        <!-- Page content-->
        <div class="content-wrapper">
          <div class="content-heading">
            <div>Pages</div>
          </div>
          <!-- START card-->
          <div class="card card-default">
             <div class="card-header"> @if(isset($data)){{'Edit Page'}}@else{{'Add Page'}}@endif
               <a href="{{route('admin.pages')}}" class="btn btn-danger f-right"><i class="fa fa-arrow-left"></i> Back</a>
             </div>
             <div class="card-body">
                <form id="pages-form" class="form-horizontal ajax_form" method="post" action="@if(isset($data)){{route('admin.pages.update',$data->id)}}@else{{route('admin.pages.store')}}@endif" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="alert ajax_report alert-info alert-hide" role="alert">
                    <span class="close" >&times;</span>
                    <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
                  </div>
                   <fieldset>
                      <div class="form-group row mb-2">
                         <label class="col-md-2 col-form-label">Title <span class="red">*</span> </label>
                         <div class="col-md-10">
                            <input class="form-control" type="text" value="@if(isset($data->title)){{$data->title}}@endif" placeholder="Title.." name="title">
                         </div>
                      </div>

                    @if (isset($data) && $data->slug == 'about')
                        <div class="form-group row mb-2">
                            <label class="col-md-2 col-form-label">Sub Title <span class="red">*</span> </label>
                            <div class="col-md-10">
                            <input class="form-control" type="text" value="@if(isset($data->page_meta['sub_title'])){{$data->page_meta['sub_title']}}@endif" placeholder="Sub Title.." name="sub_title">
                            </div>
                        </div>
                    @endif

                    @if (isset($data) && $data->slug == 'home')
                        <div class="form-group row mb-2">
                            <label class="col-md-2 col-form-label">Description <span class="red">*</span> </label>
                            <div class="col-md-10">
                            <textarea class="form-control" name="description">@if(isset($data->description)){{$data->description}}@endif</textarea>
                            </div>
                        </div>
                    @elseif((isset($data) && $data->slug != 'how-it-works') || !isset($data))
                        <div class="form-group row mb-2">
                            <label class="col-md-2 col-form-label">Description <span class="red">*</span> </label>
                            <div class="col-md-10">
                            <textarea class="form-control ckeditor" name="description">@if(isset($data->description)){{$data->description}}@endif</textarea>
                            </div>
                        </div>
                    @endif


                    @if (isset($data) && $data->slug == 'home')

                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Banner Image <span class="red">*</span></label>
                        <div class="col-md-10">
                            @if(isset($data->page_meta['banner_image']))
                            <img src="{{asset('uploads/'.$data->page_meta['banner_image'])}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="banner_image" >
                        </div>
                    </div>
                    <hr>

                    {{-- Join Section Starts --}}
                    <h6>Join Section:</h6>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Join Title <span class="red">*</span> </label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->page_meta['join_title'])){{$data->page_meta['join_title']}}@endif" placeholder="Title.." name="join_title">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Join Description <span class="red">*</span> </label>
                        <div class="col-md-10">
                            <textarea class="form-control" placeholder="Join Description.." name="join_description">@if(isset($data->page_meta['join_description'])){{$data->page_meta['join_description']}}@endif</textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Join Sub Title 1 <span class="red">*</span> </label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->page_meta['join_sub_title_1'])){{$data->page_meta['join_sub_title_1']}}@endif" placeholder="Sub Title 1.." name="join_sub_title_1">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Join Sub Description 1 <span class="red">*</span> </label>
                        <div class="col-md-10">
                            <textarea class="form-control" placeholder="Join Sub Description 1.." name="join_sub_description_1">@if(isset($data->page_meta['join_sub_description_1'])){{$data->page_meta['join_sub_description_1']}}@endif</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Join Section Image 1 <span class="red">*</span></label>
                        <div class="col-md-10">
                            @if(isset($data->page_meta['join_section_image_1']))
                            <img src="{{asset('uploads/'.$data->page_meta['join_section_image_1'])}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="join_section_image_1" >
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Join Sub Title 2 <span class="red">*</span> </label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->page_meta['join_sub_title_2'])){{$data->page_meta['join_sub_title_2']}}@endif" placeholder="Sub Title 2.." name="join_sub_title_2">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Join Sub Description 2 <span class="red">*</span> </label>
                        <div class="col-md-10">
                            <textarea class="form-control" placeholder="Join Sub Description 2.." name="join_sub_description_2">@if(isset($data->page_meta['join_sub_description_2'])){{$data->page_meta['join_sub_description_2']}}@endif</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Join Section Image 2 <span class="red">*</span></label>
                        <div class="col-md-10">
                            @if(isset($data->page_meta['join_section_image_2']))
                            <img src="{{asset('uploads/'.$data->page_meta['join_section_image_2'])}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="join_section_image_2" >
                        </div>
                    </div>
                    {{-- Join Section Ends --}}

                    {{-- Why Home4Hand Starts --}}
                    <hr>
                    <h6>Why? Section:</h6>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Why? Title <span class="red">*</span> </label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->page_meta['why_title'])){{$data->page_meta['why_title']}}@endif" placeholder="Why Title.." name="why_title">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Why? Sub Title <span class="red">*</span> </label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->page_meta['why_sub_title'])){{$data->page_meta['why_sub_title']}}@endif" placeholder="Why Sub Title.." name="why_sub_title">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Why? Description <span class="red">*</span> </label>
                        <div class="col-md-10">
                            <textarea class="form-control" placeholder="Why Description.." name="why_description">@if(isset($data->page_meta['why_description'])){{$data->page_meta['why_description']}}@endif</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Why? Image <span class="red">*</span></label>
                        <div class="col-md-10">
                            @if(isset($data->page_meta['why_image']))
                            <img src="{{asset('uploads/'.$data->page_meta['why_image'])}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="why_image" >
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Why? Youtube Video URL <span class="red">*</span> </label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->page_meta['video_url'])){{$data->page_meta['video_url']}}@endif" placeholder="Video URL.." name="video_url">
                        </div>
                    </div>
                    @endif


                    {{-- About us page content --}}
                    @if (isset($data) && $data->slug == 'about')
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Primary Image <span class="red">*</span></label>
                        <div class="col-md-10">
                            @if(isset($data->page_meta['primary_image']))
                            <img src="{{asset('uploads/'.$data->page_meta['primary_image'])}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="primary_image" >
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Secondary Image <span class="red">*</span></label>
                        <div class="col-md-10">
                            @if(isset($data->page_meta['secondary_image']))
                            <img src="{{asset('uploads/'.$data->page_meta['secondary_image'])}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="secondary_image" >
                        </div>
                    </div>
                    @endif


                    {{-- How it Works content --}}
                    @if (isset($data) && $data->slug == 'how-it-works')
                    <hr>
                    <h6>For a Host:</h6>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Host Sub Title 1 <span class="red">*</span> </label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->page_meta['host_sub_title_1'])){{$data->page_meta['host_sub_title_1']}}@endif" placeholder="Host Sub Title 1.." name="host_sub_title_1">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Host Description 1 <span class="red">*</span> </label>
                        <div class="col-md-10">
                            <textarea class="form-control" placeholder="Host Description 1.." name="host_description_1">@if(isset($data->page_meta['host_description_1'])){{$data->page_meta['host_description_1']}}@endif</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Host Image 1 <span class="red">*</span></label>
                        <div class="col-md-10">
                            @if(isset($data->page_meta['host_image_1']))
                            <img src="{{asset('uploads/'.$data->page_meta['host_image_1'])}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="host_image_1" >
                        </div>
                    </div>
                    <br>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Host Sub Title 2 <span class="red">*</span> </label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->page_meta['host_sub_title_2'])){{$data->page_meta['host_sub_title_2']}}@endif" placeholder="Host Sub Title 2.." name="host_sub_title_2">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Host Description 2 <span class="red">*</span> </label>
                        <div class="col-md-10">
                            <textarea class="form-control" placeholder="Host Description 2.." name="host_description_2">@if(isset($data->page_meta['host_description_2'])){{$data->page_meta['host_description_2']}}@endif</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Host Image 2 <span class="red">*</span></label>
                        <div class="col-md-10">
                            @if(isset($data->page_meta['host_image_2']))
                            <img src="{{asset('uploads/'.$data->page_meta['host_image_2'])}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="host_image_2" >
                        </div>
                    </div>

                    <hr>
                    <h6>For a Helper:</h6>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Helper Sub Title 1 <span class="red">*</span> </label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->page_meta['helper_sub_title_1'])){{$data->page_meta['helper_sub_title_1']}}@endif" placeholder="Helper Sub Title 1.." name="helper_sub_title_1">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Helper Description 1 <span class="red">*</span> </label>
                        <div class="col-md-10">
                            <textarea class="form-control" placeholder="Helper Description 1.." name="helper_description_1">@if(isset($data->page_meta['helper_description_1'])){{$data->page_meta['helper_description_1']}}@endif</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Helper Image 1 <span class="red">*</span></label>
                        <div class="col-md-10">
                            @if(isset($data->page_meta['helper_image_1']))
                            <img src="{{asset('uploads/'.$data->page_meta['helper_image_1'])}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="helper_image_1" >
                        </div>
                    </div>
                    <br>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Helper Sub Title 2 <span class="red">*</span> </label>
                        <div class="col-md-10">
                           <input class="form-control" type="text" value="@if(isset($data->page_meta['helper_sub_title_2'])){{$data->page_meta['helper_sub_title_2']}}@endif" placeholder="Helper Sub Title 2.." name="helper_sub_title_2">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Helper Description 2 <span class="red">*</span> </label>
                        <div class="col-md-10">
                            <textarea class="form-control" placeholder="Helper Description 2.." name="helper_description_2">@if(isset($data->page_meta['helper_description_2'])){{$data->page_meta['helper_description_2']}}@endif</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Helper Image 2 <span class="red">*</span></label>
                        <div class="col-md-10">
                            @if(isset($data->page_meta['helper_image_2']))
                            <img src="{{asset('uploads/'.$data->page_meta['helper_image_2'])}}" height="100px">
                            @endif
                            <input class="form-control" type="file" name="helper_image_2" >
                        </div>
                    </div>
                    @endif


                    {{-- Meta SEO Settings Starts --}}
                    <hr>
                    <h6>SEO Settings:</h6>

                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Meta Title <span class="red">*</span> </label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="@if(isset($data->meta_title)){{$data->meta_title}}@endif" placeholder="Meta Title.." name="meta_title">
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Meta Description </label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="meta_description" rows="5">@if(isset($data->meta_description)){{$data->meta_description}}@endif</textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-md-2 col-form-label">Meta Keywords </label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="@if(isset($data->meta_keywords)){{$data->meta_keywords}}@endif" placeholder="Meta Keywords.." name="meta_keywords">
                        </div>
                     </div>

                   </fieldset>
                   <fieldset>
                      <div class="text-right mt-3">
                           <a href="{{route('admin.pages')}}" class="btn btn-warning">Discard</a>
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
<script src="{{asset('vendor/ckeditor_full/ckeditor.js')}}"></script>
@stop
