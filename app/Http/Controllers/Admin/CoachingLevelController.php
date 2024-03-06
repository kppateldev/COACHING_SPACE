<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\CoachingLevel;
use Redirect;
use Storage;
use Str;


class CoachingLevelController extends Controller
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
      $data = CoachingLevel::select('*')->get();
      return view('admin.coaching_levels.list',compact('data'));
    }

    public function create($id=null)
    {
      if($id!=null)
      {
        $data = CoachingLevel::select('*')->where('id',$id)->first();
        if($data)
        {
          return view('admin.coaching_levels.create',compact('data'));
        }
        else {
          $notification = array(
              'message' => 'Oops! Something went wrong..',
              'alert-type' => 'error'
          );
          return Redirect::route('admin.coaching_levels')->with($notification);
        }

      }

      return view('admin.coaching_levels.create');
    }

    public function store(Request $request, $id=null)
    {
        $input=$request->all();
        if($id!=null){
          $rules['title'] 	= "required|unique:coaching_levels,title,".$id;
        }
        else{
          $rules['title'] 	= "required|unique:coaching_levels,title";
        }
        $errorMsg		= "Oops ! Please fill the required fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else {
          CoachingLevel::updateOrCreate(['id'=>$id],$input);

          $output['status']		    = 'success';

          if($id!=null)
          $output['msg']			    = "Coaching level updated successfully.";
          else
          $output['msg']			    = "Coaching level created successfully.";

          $output['msgHead']	    = "Success! ";
          $output['msgType']	    = "success";
          $output['slideToTop']	  = true;
          $output['url']		      = route('admin.coaching_levels');
          return response()->json($output);
        }
    }

    public function delete($id)
    {
        try {
            $detail = CoachingLevel::select('*')->where('id',$id)->firstOrFail();
            $detail->delete();
            $notification = array(
                'message' => 'Success! Coaching level deleted successfully.',
                'alert-type' => 'success'
            );
        } catch (\Exception $e) {
            $notification = array(
                  'message' => 'Oops! Something went wrong.',
                  'alert-type' => 'error'
              );
            return Redirect::route('admin.coaching_levels')->with($notification);
        }
        return Redirect::route('admin.coaching_levels')->with($notification);
    }

    public function change_status($id)
    {
      $detail = CoachingLevel::select('*')->where('id',$id)->first();
      if($detail)
      {
        if($detail->status == 0)
        CoachingLevel::where('id',$id)->update(['status' => 1]);
        else
        CoachingLevel::where('id',$id)->update(['status' => 0]);

        $output['msg']			    = "Coaching level status updated successfully.";
        $output['msgHead']	    = "Success! ";
        $output['msgType']	    = "success";

        return response()->json($output);
      }
      else {
        $output['msg']			    = "Something went wrong.";
        $output['msgHead']	    = "Oops! ";
        $output['msgType']	    = "error";

        return response()->json($output);
      }
    }

    public function change_featured($id)
    {
      $detail = CoachingLevel::select('*')->where('id',$id)->first();
      if($detail)
      {
        if($detail->featured == 0) {
          CoachingLevel::where('id',$id)->update(['featured' => 1]);
          $output['msg']			    = "Coaching level featured successfully.";
        }
        else {
          CoachingLevel::where('id',$id)->update(['featured' => 0]);
          $output['msg']			    = "Coaching level unfeatured successfully.";
        }

        $output['msgHead']	    = "Success! ";
        $output['msgType']	    = "success";

        return response()->json($output);
      }
      else {
        $output['msg']			    = "Something went wrong.";
        $output['msgHead']	    = "Oops! ";
        $output['msgType']	    = "error";

        return response()->json($output);
      }
    }

}
