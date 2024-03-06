<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Organization;
use App\Models\Departments;
use App\Models\Session as SessionModel;
use Storage;
use Redirect;
use Str;
use DataTables;
use View;
use Mail;
use App\Mail\SendMarkdownMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request as Request2;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;

class UserController extends Controller
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
        $count = User::select('*')->withTrashed()->orderBy('id','DESC')->count();
        return view('admin.users.list',compact('count'));
    }

    public function createBulkUser()
    {
        return view('admin.users.create_bulk_user');
    }

    public function fileImport(Request $request) 
    {
        Excel::import(new UsersImport, $request->file('file')->store('temp'));
        //return back();
        $output['msg'] = "User created successfully.";
        $output['msgType'] = "success";
        $output['slideToTop'] = true;
        $output['selfReload'] = true;
        return Redirect::route('admin.users')->with('success',$output['msg']);
    }

    public function fileExport() 
    {
        return Excel::download(new UsersExport, 'users-collection.xlsx');
    }    

    public function fetchUserData(Request $request){
        $data = User::select('*')->withTrashed()->orderBy('id','DESC');

        return DataTables::of($data)
        ->filter(function ($query) use ($request, $data) {
            if ($request->has('user_name') && !empty($request->user_name)) {
                $query->where(function($q) use ($request, $data) {
                    $q->where('name', 'like', "%{$request->get('user_name')}%");
                });
            }
        })
        ->addColumn('location', function ($data) use ($request) {
            return ($data->city ? $data->city.", " : '').($data->state ? $data->state.", " : '').($data->country ?? 'N/A');
            // return ($data->location ?? 'N/A');
        })
        ->addColumn('registration_date', function ($data) use ($request) {
            return nice_date_time($data->created_at);
        })
        ->addColumn('organization', function ($data) use ($request) {
            return $data->organization->company_name ?? '--';
        })
        ->addColumn('profile_image', function ($data) use ($request) {
            if($data->profile_image){
                $imageUrl = '<img class="user_img" src="'.asset('uploads/'.$data->profile_image).'">';
            }else{
                $imageUrl = '<img class="user_img" src="'.asset('assets/admin/img/user.png').'">';
            }

            return $imageUrl;
        })
        ->addColumn('is_active', function ($data) {
            $is_active = '';
            $statusText = 'Inactive';
            if($data->is_active == "1"){
                $is_active = 'checked';
                $statusText = 'Active';
            }

            return '<label class="switch" title="'.$statusText.'">
            <input class="change_status" data-url="'.route('admin.users.change_status',$data->id).'" type="checkbox" '.$is_active.'>
            <span class="slider round"></span>
            </label>';

        })
        ->addColumn('action', function ($data) {
            $action = '<button data-url="'.route('admin.users.view_user',$data->id).'" data-toggle="modal" data-target="#viewModal" class="btn btn-info" title="View"><i class="fa fa-eye"></i></button><a href="'. route('admin.users.edit',['id'=>$data->id]) .'" class="btn btn-primary" title="Edit User"><i class="fa fa-edit"></i></a>';

            if ($data->deleted_at == null){
                $action .='<button data-url="'.route('admin.users.delete',$data->id).'" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger" title="Delete User" data-name="'.$data->name.'"><i class="fas fa-ban"></i></button>';
            }else{
                $action .='<button data-url="'.route('admin.users.restore',$data->id).'" data-toggle="modal" data-target="#restoreModal" class="btn btn-success" title="Restore User" data-name="'.$data->name.'"><i class="icon-reload"></i></button>';
            };

            $action .='<button data-url="'.route('admin.users.permentdelete',$data->id).'" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger" title="Delete User Permanently" data-name="'.$data->name.'" data-title="Permanently"><i class="fa fa-trash"></i></button>';

            return $action;

        })
        ->rawColumns(['action','is_active','profile_image','organization'])
        ->make(true);
    }

    public function view_user($id)
    {
        $data = User::where('users.id',$id)
        ->withTrashed()
        ->first();
        if($data){
            $view = View::make('admin.users.view_user_modal',compact('data'));
            $html = $view->render();

            return $view;
        }
        else {
            abort(404);
        }
    }

    public function create($id=null)
    {
        $organizations = Organization::where('status',1)->orderBy('id','DESC')->get();
        $departments = Departments::select('*')->get();
        if($id!=null)
        {
            $data = User::select('*')->where('id',$id)->first();
            if($data)
            {
                return view('admin.users.create',compact('data','organizations','departments'));
            }
            else {
                $notification = array(
                    'message' => 'Oops! Something went wrong..',
                    'alert-type' => 'error'
                );
                return Redirect::route('admin.users')->with($notification);
            }
        }
        return view('admin.users.create',compact('organizations','departments'));
    }

    public function store(Request $request, $id=null)
    {
        try {
            $input=$request->all();
            $old_record= User::where('email',$input['email'])->first();
            if(!isset($id) || !isset($old_record) && $old_record != $input['email'])
            {
                $rules['email'] = "required|unique:users,email";
            }
            $rules['first_name'] = "required|string|max:30";
            $rules['organization_id'] = "required";
            $rules['department_id'] = "required";
            $rules['last_name'] = "required|string|max:30";
            
            if($request->is_active == 'on'){
                $input['is_active'] = 1;
            }else{
                $input['is_active'] = 0;
            }

            $errorMsg = "Oops ! Please fill the required fields.";
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()->with('error',$validator->errors());
                //return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
            }
            else {
                $name = $input['first_name']." ".$input['last_name'];
                $input['name'] = $name;
                $slug = Str::slug($name);
                $input['slug'] = $slug;
                /*if(isset($input['password'])){
                    $input['password'] = Hash::make($input['password']);
                }*/

                if($id!=null){
                    $records= User::Select('profile_image')->where('id',$id)->first();
                    $slug = Str::slug($name)."-".$id;
                    $input['slug'] = $slug;
                }

                if ($file = $request->image_path)
                {
                    $input['profile_image'] = $request->image_path;
                }
                else
                {
                    if(isset($records->profile_image)) {
                        $input['profile_image'] = $records->profile_image;
                    }
                }

                if(!isset($id))
                {
                    $generatePassword = $this->get_password();
                    $input['password'] = Hash::make($generatePassword); 
                }

                $input['organization_id'] = $request->organization_id;
                $input['department_id'] = $request->department_id;

                if(isset($request->id) && !empty($request->id)){
                    $userSet = User::updateOrCreate(['id'=>$request->id],$input);
                }else{
                    $userSet = User::updateOrCreate(['id'=>$id],$input);    
                }

                $output['status'] = 'success';
                if($id!=null)
                {
                    $output['msg'] = "User updated successfully.";
                }
                else
                {
                    $output['msg'] = "User created successfully.";
                    // Mail send start
                    $name = $userSet->name;
                    $email = $userSet->email;
                    $subject = "Account created!";
                    $mailData['SUBJECT'] = $subject;
                    $mailData['EMAIL'] = $email;
                    $mailData['NAME']= $name;
                    $mailData['LINK'] = url('/');
                    $mailData['PASSWORD'] = $generatePassword;
                    $mailData['MESSAGE'] = 'Your account has been created by an administrator! ';

                    $mailData['NAME'] = $name;
                    $new_email_data = _email_template_content("44",$mailData);
                    $new_subject = isset( $new_email_data[0] ) ? $new_email_data[0] : '';
                    $new_content = $new_email_data[1];
                    $new_fromdata = ['email' => $email,'name' => $name];
                    $new_mailids = [$email => $name];
                    _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
                    //Mail::send(new SendMarkdownMail($mailData));

                    //Verify Email start
                    $encrypted = Crypt::encryptString($email);
                    $link=url("verification").'/'.$encrypted;
                    $new_mail_data['NAME'] = $name;
                    $new_mail_data['LINK'] = $link;
                    $new_email_data = _email_template_content("1",$new_mail_data);
                    $new_subject = isset( $new_email_data[0] ) ? $new_email_data[0] : '';
                    $new_content = $new_email_data[1];
                    $new_fromdata = ['email' => $email,'name' => $name];
                    $new_mailids = [$email => $name];
                    _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
                    //Verify Email end
                    //$userSet->sendEmailVerificationNotification();
                    // Mail send end
                }
                //$output['msgHead'] = "Success ! ";
                $output['msgType'] = "success";
                $output['slideToTop'] = true;
                $output['selfReload'] = true;
                return Redirect::route('admin.users')->with('success',$output['msg']);
            }
        } catch (\Throwable $th) {
            return Redirect::back()->with('error', 'Something went wrong..'.$th->getMessage());
        }
    }

    function get_password($upper = 1, $lower = 5, $numeric = 2, $other = 1) { 
        $pass_order = Array(); 
        $passWord = ''; 

        //Create contents of the password 
        for ($i = 0; $i < $upper; $i++) { 
            $pass_order[] = chr(rand(65, 90)); 
        } 
        for ($i = 0; $i < $lower; $i++) { 
            $pass_order[] = chr(rand(97, 122)); 
        } 
        for ($i = 0; $i < $numeric; $i++) { 
            $pass_order[] = chr(rand(48, 57)); 
        } 
        for ($i = 0; $i < $other; $i++) { 
            $pass_order[] = chr(rand(33, 47)); 
        } 

        //using shuffle() to shuffle the order
        shuffle($pass_order); 

        //Final password string 
        foreach ($pass_order as $char) { 
            $passWord .= $char; 
        } 
        return $passWord;  
    }

    public function permentdelete($id){
        $detail = User::select('*')->where('id',$id)->withTrashed()->first();
        $session = SessionModel::where('user_id',$id)->where('status','upcoming')->get();
        if(isset($session) && count($session) > 0):
            $notification = array(
                'message' => "Can't delete the account until the book session is completed.",
                'alert-type' => 'error'
            );
            return Redirect::back()->with($notification);
        endif;
        $detail->forceDelete();
        $notification = array(
            'message' => 'User deleted permanently.',
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }
    
    public function delete($id)
    {
      $detail = User::select('*')->where('id',$id)->first();

      $name = $detail->name;
      $email = $detail->email;
      $subject = "Account deleted!";
      $message = "Your account has been deleted by admin.";

      if($detail)
      {
        $detail->delete();

        /*$mailData['subject'] = $subject;
        $mailData['to_email'] = $email;
        $mailData['to_name']= $name;
        $mailData['view'] = 'emails.markdown_mail';
        $mailData['message'] = $message;
        Mail::send(new SendMarkdownMail($mailData));*/

        $name = $detail->name;
        $email = $detail->email;
        $mailData['SUBJECT'] = $subject;
        $mailData['EMAIL'] = $email;
        $mailData['MESSAGE'] = $message;
        $mailData['NAME'] = $name;
        $new_email_data = _email_template_content("34",$mailData);
        $new_subject = $subject;
        $new_content = $new_email_data[1];
        $new_fromdata = ['email' => $email,'name' => $name];
        $new_mailids = [$email => $name];
        _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );

        $notification = array(
            'message' => 'User deleted successfully.',
            'alert-type' => 'success'
        );
    }
    else
    {
        $notification = array(
            'message' => 'Oops! Something went wrong.',
            'alert-type' => 'error'
        );
    }

    //   return Redirect::route('admin.users')->with($notification);
    return Redirect::back()->with($notification);
}

public function restore($id)
{
  $detail = User::select('*')->where('id',$id)->withTrashed()->first();

  if($detail)
  {
    $detail->restore();
    $notification = array(
        'message' => 'User restored successfully.',
        'alert-type' => 'success'
    );
}
else{
    $notification = array(
        'message' => 'Oops! Something went wrong.',
        'alert-type' => 'error'
    );
}

    //   return Redirect::route('admin.users')->with($notification);
return Redirect::back()->with($notification);
}

public function change_status($id)
{
    try
    {
        $detail = User::select('*')->where('id',$id)->first();
        if($detail)
        {
            if($detail->is_active == 0){
                User::where('id',$id)->update(['is_active' => 1]);
                $output['msg']  = "User activated successfully.";
                $subject = "Account activated!";
                $message = "Congratulations! <br>Your account has been activated successfully.";
            }
            else{
                User::where('id',$id)->update(['is_active' => 0]);
                $output['msg']  = "User deactivated successfully.";
                $subject = "Account deactivated!";
                $message = "Your account has been deactivated by admin.";
            }

            /*$mailData['subject'] = $subject;
            $mailData['to_email'] = $detail->email;
            $mailData['to_name']= $detail->name;
            $mailData['view'] = 'emails.markdown_mail';
            $mailData['message'] = $message;*/
            //Mail::send(new SendMarkdownMail($mailData));


            $name = $detail->name;
            $email = $detail->email;
            $mailData['SUBJECT'] = $subject;
            $mailData['EMAIL'] = $email;
            $mailData['MESSAGE'] = $message;
            $mailData['NAME'] = $name;
            $new_email_data = _email_template_content("34",$mailData);
            $new_subject = $subject;
            $new_content = $new_email_data[1];
            $new_fromdata = ['email' => $email,'name' => $name];
            $new_mailids = [$email => $name];
            _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );

            //$output['msgHead'] = "Success! ";
            $output['msgType'] = "success";

            return response()->json($output);
        }
        else {
            $output['msg'] = "Something went wrong.";
            $output['msgHead'] = "Oops! ";
            $output['msgType'] = "error";

            return response()->json($output);
        }
    } catch (\Throwable $th) {
        $output['msg'] = $th->getMessage();
        return response()->json($output);
    }
}


public function cropProfile(Request2 $request)
{
    if(isset($request->image))
    {
        $data = $request->image;
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
        if($mime_type == "image/jpg")
        {
            $ext = 'jpg'; 
        }
        else if($mime_type == "image/jpg")
        {
            $ext = 'jpeg';  
        }
        else if($mime_type == "image/png")
        {
            $ext = 'png';  
        }
        $supported_image = array('jpg','jpeg','png');
        if (in_array($ext, $supported_image)) {
            $imagePath = "users/".time().".".$ext;
            file_put_contents("public/uploads/".$imagePath, $data);
                //$imagePath = "public/user/thumb/".auth()->guard('user')->user()->id."-".time().".".$ext;
                //file_put_contents($imagePath, $data);
            if(isset($request->id) && !empty($request->id)){
                $user = User::findOrFail($request->id);
                $user->profile_image = $imagePath;
                //$user->update();
            }else{
                $user_data['profile_image'] = $imagePath;
                //$user = User::create($user_data);
            }
            echo '<img src="'.url("public/uploads/".$imagePath).'" class="profile-pic"/>';
            echo '<input type="hidden" name="image_path" value="'.$imagePath.'" id="image_path">';
        }
    }
}

}
