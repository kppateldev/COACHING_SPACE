@extends('admin.layouts.default')
@section('content')
      <!-- Main section-->
      <section class="section-container">
        <div class="content-wrapper">
            <div class="content-heading">
                <div>Site Settings
                  <small data-localize="dashboard.WELCOME"></small>
                </div>
            </div>
            <div class="container-fluid">
               <div class="row">
                  <div class="col-lg-2">
                     <div class="card b">
                        {{-- <div class="card-header bg-gray-lighter text-bold">User Settings</div> --}}
                        <div class="list-group">
                           <a class="list-group-item list-group-item-action active" href="#general" data-toggle="tab">General Setting</a>
                           <!-- <a class="list-group-item list-group-item-action" href="#payment" data-toggle="tab">Payment Setting</a> -->
                           <a class="list-group-item list-group-item-action" href="#other" data-toggle="tab">Other Setting</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-10">
                     <div class="tab-content p-0 b0">
                        <div class="tab-pane active" id="general">
                           <div class="card b">
                              <div class="card-header bg-gray-lighter text-bold">General Setting</div>
                              <div class="card-body">
                                <form id="Site-setting-form" class="form-horizontal ajax_form" method="post" action="{{route('admin.site-settings.store')}}">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                  <div class="alert ajax_report alert-info alert-hide" role="alert">
                                    <span class="close" >&times;</span>
                                    <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
                                  </div>
                                   <fieldset>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Site Name <span class="red">*</span></label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('site_name')}}" placeholder="Site Name" name="site_name">
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Admin Email <span class="red">*</span></label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('admin_email')}}" placeholder="Admin Email" name="admin_email">
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Admin Mobile No. <span class="red">*</span></label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('admin_mobile_no')}}" placeholder="Admin Mobile No." name="admin_mobile_no">
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Site Email</label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('site_email')}}" placeholder="Site Email" name="site_email">
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Site Mobile No.</label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('site_mobile_no')}}" placeholder="Mobile No." name="site_mobile_no">
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                        <label class="col-md-2 col-form-label">Website URL</label>
                                        <div class="col-md-10">
                                           <input class="form-control" type="text" value="{{get_settings('website_url')}}" placeholder="Website URL" name="website_url">
                                        </div>
                                     </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Copyright Text</label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('copyright_text')}}" placeholder="Copyright Text" name="copyright_text">
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Address</label>
                                         <div class="col-md-10">
                                            <textarea class="form-control" rows="5" placeholder="Address" name="address">{{get_settings('address')}}</textarea>
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Facebook URL</label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('facebook_url')}}" placeholder="Facebook URL" name="facebook_url">
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Twitter URL</label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('twitter_url')}}" placeholder="Twitter URL" name="twitter_url">
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Instagram URL</label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('instagram_url')}}" placeholder="Instagram URL" name="instagram_url">
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Youtube URL</label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('youtube_url')}}" placeholder="Youtube URL" name="youtube_url">
                                         </div>
                                      </div>
                                      {{-- <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Pinterest URL</label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('pinterest_url')}}" placeholder="Pinterest URL" name="pinterest_url">
                                         </div>
                                      </div> --}}
                                      <div class="form-group row mb-2">
                                        <label class="col-md-2 col-form-label">LinkedIn URL</label>
                                        <div class="col-md-10">
                                           <input class="form-control" type="text" value="{{get_settings('linkedin_url')}}" placeholder="LinkedIn URL" name="linkedin_url">
                                        </div>
                                     </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Meta Title</label>
                                         <div class="col-md-10">
                                            <input class="form-control" type="text" value="{{get_settings('meta_title')}}" placeholder="Brief description..." name="meta_title">
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                         <label class="col-md-2 col-form-label">Meta Description</label>
                                         <div class="col-md-10">
                                            <textarea class="form-control" rows="5" placeholder="Max 255 characters..." name="meta_description">{{get_settings('meta_description')}}</textarea>
                                         </div>
                                      </div>
                                      <div class="form-group row mb-2">
                                        <label class="col-md-2 col-form-label">Meta Keywords</label>
                                        <div class="col-md-10">
                                           <input class="form-control" type="text" value="{{get_settings('meta_keywords')}}" placeholder="Meta Keywords..." name="meta_keywords">
                                        </div>
                                     </div>

                                      <div class="form-group row mb-2" id="profile_image_div">
                                         <label class="col-md-2 col-form-label">Logo</label>
                                         <div class="col-md-10">
                                            @if(get_settings('logo'))
                                            <img src="{{asset('uploads/'.get_settings('logo'))}}" height="100px" style="background: #ccc;">
                                            @else
                                            <img src="{{asset('assets/admin/img/dummy.png')}}" height="100px">
                                            @endif
                                            <input class="form-control" type="file" name="logo" accept="image/png, image/jpeg, image/jpg">
                                         </div>
                                      </div>

                                      <div class="form-group row mb-2">
                                        <label class="col-md-2 col-form-label">Favicon</label>
                                        <div class="col-md-10">
                                           @if(get_settings('favicon'))
                                           <img src="{{asset('uploads/'.get_settings('favicon'))}}" height="100px" style="background: #ccc;">
                                           @else
                                           <img src="{{asset('assets/admin/img/dummy.png')}}" height="100px">
                                           @endif
                                           <input class="form-control" type="file" name="favicon" accept="image/png, image/jpeg, image/jpg">
                                        </div>
                                     </div>

                                     <div class="form-group row mb-2">
                                        <label class="col-md-2 col-form-label">Footer Logo</label>
                                        <div class="col-md-10">
                                           @if(get_settings('footer_logo'))
                                           <img src="{{asset('uploads/'.get_settings('footer_logo'))}}" height="100px" style="background: #ccc;">
                                           @else
                                           <img src="{{asset('assets/admin/img/dummy.png')}}" height="100px">
                                           @endif
                                           <input class="form-control" type="file" name="footer_logo" accept="image/png, image/jpeg, image/jpg">
                                        </div>
                                     </div>

                                   </fieldset>
                                   <fieldset>
                                      <div class="text-right mt-3">
                                           <a href="{{route('admin.dashboard')}}" class="btn btn-warning">Discard</a>
                                           <button class="btn btn-success submit" type="submit">Save</button>
                                     </div>
                                  </fieldset>
                                </form>
                             </div>
                           </div>
                        </div>

                        <div class="tab-pane" id="payment">
                           <div class="card b">
                              <div class="card-header bg-gray-lighter text-bold">Payment Setting</div>
                              <div class="card-body">
                                <form id="payment-setting-form" class="form-horizontal ajax_form" method="post" action="{{route('admin.site-settings.store.payment')}}">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="alert ajax_report alert-info alert-hide" role="alert">
                                      <span class="close" >&times;</span>
                                      <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
                                    </div>

                                    <fieldset>
                                        <div class="form-group row mb-2">
                                            <label class="col-md-2 col-form-label">Currency Icon <span class="red">*</span></label>
                                            <div class="col-md-10">
                                               <input class="form-control" type="text" value="{{get_settings('currency_icon')}}" placeholder="Currency Icon" name="currency_icon">
                                            </div>
                                         </div>
                                         <div class="form-group row mb-2">
                                            <label class="col-md-2 col-form-label">Currency Name <span class="red">*</span></label>
                                            <div class="col-md-10">
                                               <input class="form-control" type="text" value="{{get_settings('currency_name')}}" placeholder="Currency Name" name="currency_name">
                                            </div>
                                         </div>
                                    </fieldset>

                                     <fieldset>
                                        <strong>Stripe details:</strong>
                                        <hr>
                                        <div class="form-group row mb-2">
                                           <label class="col-md-2 col-form-label">Publishable Key <span class="red">*</span></label>
                                           <div class="col-md-10">
                                              <input class="form-control" type="text" value="{{get_settings('publishable_key')}}" placeholder="Publishable Key" name="publishable_key">
                                           </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                           <label class="col-md-2 col-form-label">Secret Key <span class="red">*</span></label>
                                           <div class="col-md-10">
                                              <input class="form-control" type="text" value="{{get_settings('secret_key')}}" placeholder="Secret Key" name="secret_key">
                                           </div>
                                        </div>
                                     </fieldset>

                                     <fieldset>
                                        <strong>Paypal details:</strong>
                                        <hr>
                                        <div class="form-group row mb-2">
                                            <label class="col-md-2 col-form-label">Paypal Mode <span class="red">*</span></label>
                                            <div class="col-md-10">
                                                <select name="paypal_mode" class="form-control">
                                                    <option value="">Select</option>
                                                    <option {{(get_settings('paypal_mode') == 'sandbox') ? 'selected' : ''}} value="sandbox">Sandbox</option>
                                                    <option {{(get_settings('paypal_mode') == 'live') ? 'selected' : ''}} value="live">Live</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                           <label class="col-md-2 col-form-label">Paypal Client ID <span class="red">*</span></label>
                                           <div class="col-md-10">
                                              <input class="form-control" type="text" value="{{get_settings('paypal_client')}}" placeholder="Paypal Client ID" name="paypal_client">
                                           </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                           <label class="col-md-2 col-form-label">Paypal Secret <span class="red">*</span></label>
                                           <div class="col-md-10">
                                              <input class="form-control" type="text" value="{{get_settings('paypal_secret')}}" placeholder="Paypal Secret" name="paypal_secret">
                                           </div>
                                        </div>
                                     </fieldset>

                                     <fieldset>
                                        <div class="text-right mt-3">
                                             <a href="{{route('admin.dashboard')}}" class="btn btn-warning">Discard</a>
                                             <button class="btn btn-success submit" type="submit">Save</button>
                                       </div>
                                    </fieldset>
                                  </form>
                              </div>
                           </div>
                        </div>

                        <div class="tab-pane" id="other">
                            <div class="card b">
                               <div class="card-header bg-gray-lighter text-bold">Other Setting</div>
                               <div class="card-body">
                                 <form id="other-setting-form" class="form-horizontal ajax_form" method="post" action="{{route('admin.site-settings.store.other')}}">
                                     <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                     <div class="alert ajax_report alert-info alert-hide" role="alert">
                                       <span class="close" >&times;</span>
                                       <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
                                     </div>
                                      <fieldset>
                                         <div class="form-group row mb-2">
                                            <label class="col-md-2 col-form-label">Google Map Key <span class="red">*</span></label>
                                            <div class="col-md-10">
                                               <input class="form-control" type="text" value="{{get_settings('google_map_key')}}" placeholder="Google Map Key" name="google_map_key">
                                            </div>
                                         </div>
                                         <div class="form-group row mb-2">
                                            <label class="col-md-2 col-form-label">Google Captcha Key <span class="red">*</span></label>
                                            <div class="col-md-10">
                                               <input class="form-control" type="text" value="{{get_settings('google_captcha_key')}}" placeholder="Google Captcha Key" name="google_captcha_key">
                                            </div>
                                         </div>
                                         <div class="form-group row mb-2">
                                            <label class="col-md-2 col-form-label">Google Captcha Secret <span class="red">*</span></label>
                                            <div class="col-md-10">
                                               <input class="form-control" type="text" value="{{get_settings('google_captcha_secret')}}" placeholder="Google Captcha Secret" name="google_captcha_secret">
                                            </div>
                                         </div>
                                         <div class="form-group row mb-2">
                                            <label class="col-md-2 col-form-label">Enable Reviews <span class="red">*</span></label>
                                            <div class="col-md-10 pt-2">
                                                <label for="enable_reviews_yes">
                                                    <input type="radio" {{ get_settings('enable_reviews')=='yes' ? 'checked' : '' }} value="yes" name="enable_reviews" id="enable_reviews_yes"> Yes
                                                </label>
                                                <label for="enable_reviews_no">
                                                    <input type="radio" {{get_settings('enable_reviews')=='no' ? 'checked' : '' }} value="no" name="enable_reviews" id="enable_reviews_no"> No
                                                </label>
                                            </div>
                                         </div>
                                      </fieldset>
                                      <fieldset>
                                         <div class="text-right mt-3">
                                              <a href="{{route('admin.dashboard')}}" class="btn btn-warning">Discard</a>
                                              <button class="btn btn-success submit" type="submit">Save</button>
                                        </div>
                                     </fieldset>
                                   </form>
                               </div>
                            </div>
                         </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
@stop
@section('footer_scripts')
@stop
