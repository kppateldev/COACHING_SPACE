@extends('admin.layouts.default')
@section('content')
    <!-- Main section-->
    <section class="section-container">
         <!-- Page content-->
         <div class="content-wrapper">
            <div class="content-heading">
                <div>Admin Settings
                  <small data-localize="dashboard.WELCOME"></small>
                </div>
            </div>
            <div class="container-md">
               <div class="row">
                  <div class="col-lg-3">
                     <div class="card b">
                        <div class="list-group">
                           <a class="list-group-item list-group-item-action active" href="#tabSetting1" data-toggle="tab">Profile Details</a>
                           <a class="list-group-item list-group-item-action" href="#tabSetting2" data-toggle="tab">Change Password</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-9">
                     <div class="tab-content p-0 b0">
                        <div class="tab-pane active" id="tabSetting1">
                           <div class="card b">
                              <div class="card-header bg-gray-lighter text-bold">Profile Details</div>
                              <div class="card-body">
                                 <form id="updateSettings" class="ajax_form" method="post" action="{{route('admin.updateSettings','profile')}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="alert ajax_report alert-info alert-hide" role="alert">
                                        <span class="close" >&times;</span>
                                        <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
                                    </div>
                                    <div class="form-group">
                                       <label>Name</label>
                                       <input class="form-control" placeholder="Name" type="text" name="name" value="{{$name}}">
                                    </div>
                                    <div class="form-group">
                                       <label>Email</label>
                                       <input class="form-control" type="text" value="{{$email}}" disabled="disabled">
                                    </div>
                                    <button class="btn btn-info submit" type="submit">Update settings</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane" id="tabSetting2">
                           <div class="card b">
                              <div class="card-header bg-gray-lighter text-bold">Change Password</div>
                              <div class="card-body">
                                 <form id="passwordSettings" class="ajax_form" method="post" action="{{route('admin.updateSettings','password')}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="alert ajax_report alert-info alert-hide" role="alert">
                                        <span class="close" >&times;</span>
                                        <span class="ajax_message"><strong>Please wait! </strong>Processing...</span>
                                    </div>
                                    <div class="form-group">
                                       <label>Current Password</label>
                                       <input class="form-control" placeholder="Current Password" type="password" name="current_password">
                                    </div>
                                    <div class="form-group">
                                       <label>New Password</label>
                                       <input class="form-control" placeholder="New Password" type="password" name="new_password">
                                    </div>
                                    <div class="form-group">
                                       <label>Confirm New Password</label>
                                       <input class="form-control" placeholder="Confirm New Password" type="password" name="new_password_confirmation">
                                    </div>
                                    <button class="btn btn-info submit" type="submit">Update password</button>
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
