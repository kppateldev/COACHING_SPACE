<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Settings;
use Storage;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
      return view('admin.settings.site-settings');
    }

    public function store(Request $request)
    {
        $input=$request->all();
        // echo "<pre>"; print_r($input); die;

        $rules['site_name'] 	= "required";
        $rules['admin_email'] 	= "required|email|max:255|string";
        $rules['admin_mobile_no'] 	= "required|numeric";
        
        if($input['logo']){
          $rules['logo']  = 'mimes:jpg,jpeg,png|max:2048';
        }elseif($input['favicon']){
          $rules['favicon']  = 'mimes:jpg,jpeg,png|max:2048';
        }elseif($input['footer_logo']){
          $rules['footer_logo']  = 'mimes:jpg,jpeg,png|max:2048';
        }

        $errorMsg		= "Oops ! Please fill the required fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else {

          $old_logo = get_settings('logo');

          if ($file = $request->file('logo'))
          {

            $extension = $file->getClientOriginalExtension();
            $folderName = 'site_settings';
            $safeName = Str::random(10) . '.' . $extension;
            Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
            $filePath = $folderName.'/'.$safeName;
            $input['logo'] = $filePath;

            if(isset($old_logo))
            {
              Storage::disk('uploads')->delete($old_logo);
            }

          }
          else
          {
            if(isset($old_logo)) {
              $input['logo'] = $old_logo;
            }
          }

          $old_favicon = get_settings('favicon');

          if ($file = $request->file('favicon'))
          {

            $extension = $file->getClientOriginalExtension();
            $folderName = 'site_settings';
            $safeName = Str::random(10) . '.' . $extension;
            Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
            $filePath = $folderName.'/'.$safeName;
            $input['favicon'] = $filePath;

            if(isset($old_favicon))
            {
              Storage::disk('uploads')->delete($old_favicon);
            }

          }
          else
          {
            if(isset($old_favicon)) {
              $input['favicon'] = $old_favicon;
            }
          }

          $old_footer_logo = get_settings('footer_logo');

          if ($file = $request->file('footer_logo'))
          {

            $extension = $file->getClientOriginalExtension();
            $folderName = 'site_settings';
            $safeName = Str::random(10) . '.' . $extension;
            Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
            $filePath = $folderName.'/'.$safeName;
            $input['footer_logo'] = $filePath;

            if(isset($old_footer_logo))
            {
              Storage::disk('uploads')->delete($old_footer_logo);
            }

          }
          else
          {
            if(isset($old_footer_logo)) {
              $input['footer_logo'] = $old_footer_logo;
            }
          }

            if(isset($input)) {
                foreach($input as $field => $value){
                    if(!in_array($field, ['_method', '_token'])){
                    $setings = Settings::updateOrCreate(
                        ['field' => $field],
                        ['value' => $value]);
                    }
                }
            }

          $output['status']		    = 'success';
          $output['msg']			    = "Site Settings Updated Successfully.";
          $output['msgHead']	    = "Success ! ";
          $output['msgType']	    = "success";
          $output['slideToTop']	  = true;
          $output['selfReload']		= true;
          return response()->json($output);
        }
    }

    public function storePayment(Request $request)
    {
        $input=$request->all();

        $rules = array();

        // $rules['publishable_key'] 	= "required|string";

        $errorMsg  = "Oops ! Please fill the required fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else {

            if(isset($input)) {
                foreach($input as $field => $value){
                    if(!in_array($field, ['_method', '_token'])){
                    $setings = Settings::updateOrCreate(
                        ['field' => $field],
                        ['value' => $value]);
                    }
                }
            }

            $output['status']		    = 'success';
            $output['msg']			    = "Payment Settings Updated Successfully.";
            $output['msgHead']	    = "Success ! ";
            $output['msgType']	    = "success";
            $output['slideToTop']	  = true;
            // $output['selfReload']		= true;
            return response()->json($output);
        }
    }

    public function storeOther(Request $request)
    {
        $input=$request->all();

        $rules = array();

        // $rules['google_map_key'] 	= "required|string";

        $errorMsg  = "Oops ! Please fill the required fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else {

            if(isset($input)) {
                foreach($input as $field => $value){
                    if(!in_array($field, ['_method', '_token'])){
                    $setings = Settings::updateOrCreate(
                        ['field' => $field],
                        ['value' => $value]);
                    }
                }
            }

            $output['status']		    = 'success';
            $output['msg']			    = "Other Settings Updated Successfully.";
            $output['msgHead']	    = "Success ! ";
            $output['msgType']	    = "success";
            $output['slideToTop']	  = true;
            // $output['selfReload']		= true;
            return response()->json($output);
        }
    }

}
