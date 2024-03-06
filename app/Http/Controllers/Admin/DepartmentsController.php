<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Departments;
use Redirect;
use Storage;
use Str;


class DepartmentsController extends Controller
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
      $data = Departments::select('*')->get();
      return view('admin.departments.list',compact('data'));
    }

    public function create($id=null)
    {
      if($id!=null)
      {
        $data = Departments::select('*')->where('id',$id)->first();
        if($data)
        {
          return view('admin.departments.create',compact('data'));
        }
        else {
          $notification = array(
              'message' => 'Oops! Something went wrong..',
              'alert-type' => 'error'
          );
          return Redirect::route('admin.departments')->with($notification);
        }

      }

      return view('admin.departments.create');
    }

    public function store(Request $request, $id=null)
    {
        $input=$request->all();
        if($id!=null){
          $rules['title'] 	= "required|unique:departments,title,".$id;
        }
        else{
          $rules['title'] 	= "required|unique:departments,title";
        }
        $errorMsg		= "Oops ! Please fill the required fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else {
          Departments::updateOrCreate(['id'=>$id],$input);

          $output['status']		    = 'success';

          if($id!=null)
          $output['msg']			    = "Department updated successfully.";
          else
          $output['msg']			    = "Department created successfully.";

          $output['msgHead']	    = "Success! ";
          $output['msgType']	    = "success";
          $output['slideToTop']	  = true;
          $output['url']		      = route('admin.departments');
          return response()->json($output);
        }
    }

    public function delete($id)
    {
        try {
            $detail = Departments::select('*')->where('id',$id)->firstOrFail();
            $detail->delete();
            $notification = array(
                'message' => 'Success! Department deleted successfully.',
                'alert-type' => 'success'
            );
        } catch (\Exception $e) {
            $notification = array(
                  'message' => 'Oops! Something went wrong.',
                  'alert-type' => 'error'
              );
            return Redirect::route('admin.departments')->with($notification);
        }
        return Redirect::route('admin.departments')->with($notification);
    }

    public function change_status($id)
    {
      $detail = Departments::select('*')->where('id',$id)->first();
      if($detail)
      {
        if($detail->status == 0)
        Departmentswhere('id',$id)->update(['status' => 1]);
        else
        Departmentswhere('id',$id)->update(['status' => 0]);

        $output['msg']			    = "Department status updated successfully.";
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
