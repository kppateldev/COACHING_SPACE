<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Pages;
use Redirect;
use Storage;
use Str;

class PagesController extends Controller
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
      $data = Pages::select('*')->get();
      return view('admin.pages.list',compact('data'));
    }

    public function create($id=null)
    {
      if($id!=null)
      {
        $data = Pages::select('*')->where('id',$id)->first();
        if($data)
        {
          return view('admin.pages.create',compact('data'));
        }
        else {
          $notification = array(
              'message' => 'Oops! Something went wrong..',
              'alert-type' => 'error'
          );
          return Redirect::route('admin.pages')->with($notification);
        }
      }

      return view('admin.pages.create');
    }

    public function store(Request $request, $id=null)
    {
        $input=$request->all();
        // echo "<pre>"; print_r($input); die;

        $rules['title'] 	= "required|max:255";
        // $rules['description'] 	= "required";
        // $rules['meta_title'] 	= "required|max:255";

        $errorMsg		= "Oops ! Please fill the required fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else {

            $page_meta = [];

            if($id!=null){
                $old_data = Pages::where('id',$id)->first();

                if ($file = $request->file('banner_image'))
                {
                    $extension = $file->getClientOriginalExtension();
                    $folderName = 'cms_pages';
                    $safeName = Str::random(10) . '.' . $extension;
                    Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
                    $filePath = $folderName.'/'.$safeName;
                    $page_meta['banner_image'] = $filePath;

                    if(isset($old_data->page_meta['banner_image'])) {
                        Storage::disk('uploads')->delete($old_data->page_meta['banner_image']);
                    }
                }
                else
                {
                    if(isset($old_data->page_meta['banner_image'])) {
                        $page_meta['banner_image'] = $old_data->page_meta['banner_image'];
                    }
                }


                // Join Section Starts
                if(isset($request->join_title)){
                    $page_meta['join_title'] = $request->join_title;
                }
                if(isset($request->join_description)){
                    $page_meta['join_description'] = $request->join_description;
                }

                if(isset($request->join_sub_title_1)){
                    $page_meta['join_sub_title_1'] = $request->join_sub_title_1;
                }
                if(isset($request->join_sub_description_1)){
                    $page_meta['join_sub_description_1'] = $request->join_sub_description_1;
                }
                if ($file = $request->file('join_section_image_1'))
                {
                    $extension = $file->getClientOriginalExtension();
                    $folderName = 'cms_pages';
                    $safeName = Str::random(10) . '.' . $extension;
                    Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
                    $filePath = $folderName.'/'.$safeName;
                    $page_meta['join_section_image_1'] = $filePath;

                    if(isset($old_data->page_meta['join_section_image_1'])) {
                        Storage::disk('uploads')->delete($old_data->page_meta['join_section_image_1']);
                    }
                }
                else
                {
                    if(isset($old_data->page_meta['join_section_image_1'])) {
                        $page_meta['join_section_image_1'] = $old_data->page_meta['join_section_image_1'];
                    }
                }

                if(isset($request->join_sub_title_2)){
                    $page_meta['join_sub_title_2'] = $request->join_sub_title_2;
                }
                if(isset($request->join_sub_description_2)){
                    $page_meta['join_sub_description_2'] = $request->join_sub_description_2;
                }
                if ($file = $request->file('join_section_image_2'))
                {
                    $extension = $file->getClientOriginalExtension();
                    $folderName = 'cms_pages';
                    $safeName = Str::random(10) . '.' . $extension;
                    Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
                    $filePath = $folderName.'/'.$safeName;
                    $page_meta['join_section_image_2'] = $filePath;

                    if(isset($old_data->page_meta['join_section_image_2'])) {
                        Storage::disk('uploads')->delete($old_data->page_meta['join_section_image_2']);
                    }
                }
                else
                {
                    if(isset($old_data->page_meta['join_section_image_2'])) {
                        $page_meta['join_section_image_2'] = $old_data->page_meta['join_section_image_2'];
                    }
                }


                // Why Section Starts
                if(isset($request->why_title)){
                    $page_meta['why_title'] = $request->why_title;
                }
                if(isset($request->why_sub_title)){
                    $page_meta['why_sub_title'] = $request->why_sub_title;
                }
                if(isset($request->why_description)){
                    $page_meta['why_description'] = $request->why_description;
                }
                if ($file = $request->file('why_image'))
                {
                    $extension = $file->getClientOriginalExtension();
                    $folderName = 'cms_pages';
                    $safeName = Str::random(10) . '.' . $extension;
                    Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
                    $filePath = $folderName.'/'.$safeName;
                    $page_meta['why_image'] = $filePath;

                    if(isset($old_data->page_meta['why_image'])) {
                        Storage::disk('uploads')->delete($old_data->page_meta['why_image']);
                    }
                }
                else
                {
                    if(isset($old_data->page_meta['why_image'])) {
                        $page_meta['why_image'] = $old_data->page_meta['why_image'];
                    }
                }
                if(isset($request->video_url)){
                    $page_meta['video_url'] = $request->video_url;
                }


                // About us page content Starts
                if(isset($request->sub_title)){
                    $page_meta['sub_title'] = $request->sub_title;
                }
                if ($file = $request->file('primary_image'))
                {
                    $extension = $file->getClientOriginalExtension();
                    $folderName = 'cms_pages';
                    $safeName = Str::random(10) . '.' . $extension;
                    Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
                    $filePath = $folderName.'/'.$safeName;
                    $page_meta['primary_image'] = $filePath;

                    if(isset($old_data->page_meta['primary_image'])) {
                        Storage::disk('uploads')->delete($old_data->page_meta['primary_image']);
                    }
                }
                else
                {
                    if(isset($old_data->page_meta['primary_image'])) {
                        $page_meta['primary_image'] = $old_data->page_meta['primary_image'];
                    }
                }

                if ($file = $request->file('secondary_image'))
                {
                    $extension = $file->getClientOriginalExtension();
                    $folderName = 'cms_pages';
                    $safeName = Str::random(10) . '.' . $extension;
                    Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
                    $filePath = $folderName.'/'.$safeName;
                    $page_meta['secondary_image'] = $filePath;

                    if(isset($old_data->page_meta['secondary_image'])) {
                        Storage::disk('uploads')->delete($old_data->page_meta['secondary_image']);
                    }
                }
                else
                {
                    if(isset($old_data->page_meta['secondary_image'])) {
                        $page_meta['secondary_image'] = $old_data->page_meta['secondary_image'];
                    }
                }


                // How it works for Host Starts
                if(isset($request->host_sub_title_1)){
                    $page_meta['host_sub_title_1'] = $request->host_sub_title_1;
                }
                if(isset($request->host_description_1)){
                    $page_meta['host_description_1'] = $request->host_description_1;
                }
                if ($file = $request->file('host_image_1'))
                {
                    $extension = $file->getClientOriginalExtension();
                    $folderName = 'cms_pages';
                    $safeName = Str::random(10) . '.' . $extension;
                    Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
                    $filePath = $folderName.'/'.$safeName;
                    $page_meta['host_image_1'] = $filePath;

                    if(isset($old_data->page_meta['host_image_1'])) {
                        Storage::disk('uploads')->delete($old_data->page_meta['host_image_1']);
                    }
                }
                else
                {
                    if(isset($old_data->page_meta['host_image_1'])) {
                        $page_meta['host_image_1'] = $old_data->page_meta['host_image_1'];
                    }
                }

                if(isset($request->host_sub_title_2)){
                    $page_meta['host_sub_title_2'] = $request->host_sub_title_2;
                }
                if(isset($request->host_description_2)){
                    $page_meta['host_description_2'] = $request->host_description_2;
                }
                if ($file = $request->file('host_image_2'))
                {
                    $extension = $file->getClientOriginalExtension();
                    $folderName = 'cms_pages';
                    $safeName = Str::random(10) . '.' . $extension;
                    Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
                    $filePath = $folderName.'/'.$safeName;
                    $page_meta['host_image_2'] = $filePath;

                    if(isset($old_data->page_meta['host_image_2'])) {
                        Storage::disk('uploads')->delete($old_data->page_meta['host_image_2']);
                    }
                }
                else
                {
                    if(isset($old_data->page_meta['host_image_2'])) {
                        $page_meta['host_image_2'] = $old_data->page_meta['host_image_2'];
                    }
                }


                // How it works for Helper Starts
                if(isset($request->helper_sub_title_1)){
                    $page_meta['helper_sub_title_1'] = $request->helper_sub_title_1;
                }
                if(isset($request->helper_description_1)){
                    $page_meta['helper_description_1'] = $request->helper_description_1;
                }
                if ($file = $request->file('helper_image_1'))
                {
                    $extension = $file->getClientOriginalExtension();
                    $folderName = 'cms_pages';
                    $safeName = Str::random(10) . '.' . $extension;
                    Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
                    $filePath = $folderName.'/'.$safeName;
                    $page_meta['helper_image_1'] = $filePath;

                    if(isset($old_data->page_meta['helper_image_1'])) {
                        Storage::disk('uploads')->delete($old_data->page_meta['helper_image_1']);
                    }
                }
                else
                {
                    if(isset($old_data->page_meta['helper_image_1'])) {
                        $page_meta['helper_image_1'] = $old_data->page_meta['helper_image_1'];
                    }
                }

                if(isset($request->helper_sub_title_2)){
                    $page_meta['helper_sub_title_2'] = $request->helper_sub_title_2;
                }
                if(isset($request->helper_description_2)){
                    $page_meta['helper_description_2'] = $request->helper_description_2;
                }
                if ($file = $request->file('helper_image_2'))
                {
                    $extension = $file->getClientOriginalExtension();
                    $folderName = 'cms_pages';
                    $safeName = Str::random(10) . '.' . $extension;
                    Storage::disk('uploads')->putFileAs($folderName, $file, $safeName);
                    $filePath = $folderName.'/'.$safeName;
                    $page_meta['helper_image_2'] = $filePath;

                    if(isset($old_data->page_meta['helper_image_2'])) {
                        Storage::disk('uploads')->delete($old_data->page_meta['helper_image_2']);
                    }
                }
                else
                {
                    if(isset($old_data->page_meta['helper_image_2'])) {
                        $page_meta['helper_image_2'] = $old_data->page_meta['helper_image_2'];
                    }
                }


            }

            $input['page_meta'] = $page_meta;

            Pages::updateOrCreate(['id'=>$id],$input);

            $output['status']		    = 'success';
            if($id!=null)
            $output['msg']			    = "Page Updated Successfully.";
            else
            $output['msg']			    = "Page Created Successfully.";
            $output['msgHead']	    = "Success ! ";
            $output['msgType']	    = "success";
            $output['slideToTop']	  = true;
            $output['selfReload']	  = true;
            //   $output['url']		      = route('admin.pages');

            return response()->json($output);
        }
    }

    // public function delete($id)
    // {
    //   $detail = Pages::select('*')->where('id',$id)->first();

    //   if($detail)
    //   {
    //     $detail->delete();
    //     $notification = array(
    //         'message' => 'Success! Page deleted successfully.',
    //         'alert-type' => 'success'
    //     );
    //   }
    //   else{
    //     $notification = array(
    //         'message' => 'Oops! Something went wrong.',
    //         'alert-type' => 'error'
    //     );
    //   }

    //   return Redirect::route('admin.pages')->with($notification);
    // }

    // public function change_status($id)
    // {
    //   $detail = Pages::select('*')->where('id',$id)->first();
    //   if($detail)
    //   {
    //     if($detail->status == 0)
    //     Pages::where('id',$id)->update(['status' => 1]);
    //     else
    //     Pages::where('id',$id)->update(['status' => 0]);

    //     $output['msg']			    = "Page status updated successfully.";
    //     $output['msgHead']	    = "Success! ";
    //     $output['msgType']	    = "success";

    //     return response()->json($output);
    //   }
    //   else {
    //     $output['msg']			    = "Something went wrong.";
    //     $output['msgHead']	    = "Oops! ";
    //     $output['msgType']	    = "error";

    //     return response()->json($output);
    //   }
    // }

}
