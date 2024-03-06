<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Strengths;
use Redirect;
use Storage;
use Str;


class StrengthsController extends Controller
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
      $data = Strengths::select('*')->get();
      return view('admin.strengths.list',compact('data'));
    }

    public function create($id=null)
    {
      if($id!=null)
      {
        $data = Strengths::select('*')->where('id',$id)->first();
        if($data)
        {
          return view('admin.strengths.create',compact('data'));
        }
        else {
          $notification = array(
              'message' => 'Oops! Something went wrong..',
              'alert-type' => 'error'
          );
          return Redirect::route('admin.strengths')->with($notification);
        }

      }

      return view('admin.strengths.create');
    }

    public function store(Request $request, $id=null)
    {
        $input=$request->all();
        if($id!=null){
          $rules['title'] 	= "required|unique:strengths,title,".$id;
        }
        else{
          $rules['title'] 	= "required|unique:strengths,title";
        }
        $errorMsg		= "Oops ! Please fill the required fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else {
          Strengths::updateOrCreate(['id'=>$id],$input);

          $output['status']		    = 'success';

          if($id!=null)
          $output['msg']			    = "Strength updated successfully.";
          else
          $output['msg']			    = "Strength created successfully.";

          $output['msgHead']	    = "Success! ";
          $output['msgType']	    = "success";
          $output['slideToTop']	  = true;
          $output['url']		      = route('admin.strengths');
          return response()->json($output);
        }
    }

    public function delete($id)
    {
        try {
            $detail = Strengths::select('*')->where('id',$id)->firstOrFail();
            $detail->delete();
            $notification = array(
                'message' => 'Success! Strength deleted successfully.',
                'alert-type' => 'success'
            );
        } catch (\Exception $e) {
            $notification = array(
                  'message' => 'Oops! Something went wrong.',
                  'alert-type' => 'error'
              );
            return Redirect::route('admin.strengths')->with($notification);
        }
        return Redirect::route('admin.strengths')->with($notification);
    }

    public function change_status($id)
    {
      $detail = Strengths::select('*')->where('id',$id)->first();
      if($detail)
      {
        if($detail->status == 0)
        Strengths::where('id',$id)->update(['status' => 1]);
        else
        Strengths::where('id',$id)->update(['status' => 0]);

        $output['msg']			    = "Strengths status updated successfully.";
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
      $detail = Strengths::select('*')->where('id',$id)->first();
      if($detail)
      {
        if($detail->featured == 0) {
          Strengths::where('id',$id)->update(['featured' => 1]);
          $output['msg']			    = "Strengths featured successfully.";
        }
        else {
          Strengths::where('id',$id)->update(['featured' => 0]);
          $output['msg']			    = "Strengths unfeatured successfully.";
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
