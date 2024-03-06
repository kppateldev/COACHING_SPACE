<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Facilities;
use Redirect;
use Storage;
use Str;


class FacilitiesController extends Controller
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
      $data = Facilities::select('*')->get();
      return view('admin.facilities.list',compact('data'));
    }

    public function create($id=null)
    {
      if($id!=null)
      {
        $data = Facilities::select('*')->where('id',$id)->first();
        if($data)
        {
          return view('admin.facilities.create',compact('data'));
        }
        else {
          $notification = array(
              'message' => 'Oops! Something went wrong..',
              'alert-type' => 'error'
          );
          return Redirect::route('admin.facilities')->with($notification);
        }

      }

      return view('admin.facilities.create');
    }

    public function store(Request $request, $id=null)
    {
        $input=$request->all();
        // echo "<pre>"; print_r($input); die;

        if($request->image){
          $rules['image'] 	= "mimes:jpg,jpeg,png";
        }

        if($id!=null){
          $rules['title'] 	= "required|unique:facilities,title,".$id;
        }
        else{
          $rules['title'] 	= "required|unique:facilities,title";
        }

        $errorMsg		= "Oops ! Please fill the required fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else {

          if($id!=null){
            $records= Facilities::Select('image')->where('id',$id)->first();
          }

          if ($file = $request->file('image'))
          {

            $extension = $file->getClientOriginalExtension();
            $folderName = 'facilities';
            $safeName = Str::random(10) . '.' . $extension;
            Storage::disk('uploads')->putFileAs($folderName, $file,$safeName);
            $filePath = $folderName.'/'.$safeName;
            $input['image'] = $filePath;

            if(isset($records->image))
            {
              Storage::disk('uploads')->delete($records->image);
            }

          }
          else
          {
            if(isset($records->image))
            {
              $input['image'] = $records->image;
            }
          }

          //echo "<pre>"; print_r($input); die;

          Facilities::updateOrCreate(['id'=>$id],$input);

          $output['status']		    = 'success';

          if($id!=null)
          $output['msg']			    = "Facilities updated successfully.";
          else
          $output['msg']			    = "Facilities created successfully.";

          $output['msgHead']	    = "Success! ";
          $output['msgType']	    = "success";
          $output['slideToTop']	  = true;
          $output['url']		      = route('admin.facilities');
          return response()->json($output);
        }
    }

    // public function delete($id)
    // {

    //     try {

    //         $detail = Facilities::select('*')->where('id',$id)->firstOrFail();
    //         $imgPath = $detail->image;
    //         $detail->delete();

    //         Storage::disk('uploads')->delete($imgPath);

    //         $notification = array(
    //             'message' => 'Success! Facility deleted successfully.',
    //             'alert-type' => 'success'
    //         );

    //     } catch (\Exception $e) {

    //         $notification = array(
    //               'message' => 'Oops! Something went wrong.',
    //               'alert-type' => 'error'
    //           );
    //         return Redirect::route('admin.facilities')->with($notification);

    //     }

    //     return Redirect::route('admin.facilities')->with($notification);

    // }

    public function change_status($id)
    {
      $detail = Facilities::select('*')->where('id',$id)->first();
      if($detail)
      {
        if($detail->status == 0)
        Facilities::where('id',$id)->update(['status' => 1]);
        else
        Facilities::where('id',$id)->update(['status' => 0]);

        $output['msg']			    = "Facility status updated successfully.";
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
      $detail = Facilities::select('*')->where('id',$id)->first();
      if($detail)
      {
        if($detail->featured == 0) {
          Facilities::where('id',$id)->update(['featured' => 1]);
          $output['msg']			    = "Facility featured successfully.";
        }
        else {
          Facilities::where('id',$id)->update(['featured' => 0]);
          $output['msg']			    = "Facility unfeatured successfully.";
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
