<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Organization;
use App\Models\Departments;
use Storage;
use Redirect;
use Str;
use DataTables;
use View;
use Mail;
use App\Mail\SendMarkdownMail;
use Illuminate\Support\Facades\Hash;

class OrganizationController extends Controller
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
        $count = Organization::select('*')->withTrashed()->orderBy('id','DESC')->count();
        return view('admin.organizations.list',compact('count'));
    }

    public function fetchOrganizationData(Request $request){
        $data = Organization::select('*')->withTrashed()->orderBy('id','DESC');

        return DataTables::of($data)
        ->filter(function ($query) use ($request, $data) {
            if ($request->has('company_name') && !empty($request->company_name)) {
                $query->where(function($q) use ($request, $data) {
                    $q->where('company_name', 'like', "%{$request->get('company_name')}%");
                });
            }
        })
        ->addColumn('no_of_users', function ($data) {
            return $data->users()->count();
        })
        ->addColumn('department', function ($data) {
            return _getDepartmentTitle($data->department_id);
        })
        ->addColumn('session_limit', function ($data) {
            return $data->users()->count();
        })
        ->addColumn('statusHTML', function ($data) {
            $status = '';
            $statusText = 'Inactive';
            if($data->status == "1"){
                $status = 'checked';
                $statusText = 'Active';
            }
            return '<label class="switch" title="'.$statusText.'">
            <input class="change_status" data-url="'.route('admin.organizations.change_status',$data->id).'" type="checkbox" '.$status.'>
            <span class="slider round"></span>
            </label>';

        })
        ->addColumn('action', function ($data) {
            $action = '<button data-url="'.route('admin.organizations.view_organization',$data->id).'" data-toggle="modal" data-target="#viewModal" class="btn btn-info" title="View"><i class="fa fa-eye"></i></button>
            <a href="'. route('admin.organizations.users.list',['id'=>$data->id]) .'" class="btn btn-primary" title="No. of users"><i class="fa fa-list"></i></a>
            <a href="'. route('admin.organizations.edit',['id'=>$data->id]) .'" class="btn btn-primary" title="Edit organization"><i class="fa fa-edit"></i></a>';
            if ($data->deleted_at == null){
                $action .='<button data-url="'.route('admin.organizations.delete',$data->id).'" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger" title="Delete organization" data-name="'.$data->company_name.'"><i class="fas fa-ban"></i></button>';
            }else{
                $action .='<button data-url="'.route('admin.organizations.restore',$data->id).'" data-toggle="modal" data-target="#restoreModal" class="btn btn-success" title="Restore organization" data-name="'.$data->company_name.'"><i class="icon-reload"></i></button>';
            };
            $action .='<button data-url="'.route('admin.organizations.permentdelete',$data->id).'" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger" title="Delete Organization Permanently" data-name="'.$data->name.'" data-title="Permanently"><i class="fa fa-trash"></i></button>';
            return $action;
        })
        ->rawColumns(['action','statusHTML','no_of_users'])
        ->make(true);
    }

    public function view_organization($id)
    {
        $data = Organization::select('organizations.*')
        ->where('organizations.id',$id)
        ->withTrashed()
        ->first();

        if($data){
            $view = View::make('admin.organizations.view_organization_modal',compact('data'));
            $html = $view->render();

            return $view;
        }
        else {
            abort(404);
        }
    }

    public function create($id=null)
    {
        $departments = Departments::select('*')->get();
        if($id!=null)
        {
            $data = Organization::select('*')->where('id',$id)->first();
            if($data)
            {
                return view('admin.organizations.create',compact('data','departments'));
            }
            else 
            {
                $notification = array(
                    'message' => 'Oops! Something went wrong..',
                    'alert-type' => 'error'
                );
                return Redirect::route('admin.organizations')->with($notification);
            }
        }
        $departments = Departments::select('*')->get();
        return view('admin.organizations.create',compact('departments'));
    }

public function store(Request $request, $id=null)
{
    try {
        $input=$request->all();
        if(!isset($id))
        {
            $rules['email']    = "required|unique:organizations,email";
        }
        $rules['first_name'] 	= "required|string";
        $rules['last_name'] 	= "required|string";
        $rules['company_name']     = "required|string";
        $rules['department_id']     = "required";
        //$rules['phone_number'] 	= "required|numeric|digits_between:10,12";
        if($request->status == 'on'){
            $input['status'] = 1;
        }else{
            $input['status'] = 0;
        }
        $errorMsg = "Oops ! Please fill the required fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            //return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
            return Redirect::back()->with('error',$validator->errors());
        }
        else
        {
            $name = $input['first_name']." ".$input['last_name'];
            $slug = Str::slug($name);  
            //$input['name'] = $name;
            //$input['slug'] = $slug;
            Organization::updateOrCreate(['id'=>$id],$input);
            $output['status'] = 'success';
            if($id!=null)
            {
                $output['msg'] = "Organization updated successfully.";
            }
            else
            {
                $output['msg'] = "Organization created successfully.";
            }
            //$output['msgHead'] = "Success ! ";
            $output['msgType'] = "success";
            $output['slideToTop'] = true;
            $output['selfReload'] = true;
            return Redirect::route('admin.organizations')->with('success',$output['msg']);
        }
    } catch (\Throwable $th) {
        return Redirect::back()->with('error', 'Something went wrong..'.$th->getMessage());
    }
}

public function permentdelete($id){
    $detail = Organization::select('*')->where('id',$id)->withTrashed()->first();
    $detail->forceDelete();
    $notification = array(
        'message' => 'Organization deleted permanently.',
        'alert-type' => 'success'
    );
    return Redirect::back()->with($notification);
}

public function delete($id)
{
    try
    {
        $detail = Organization::select('*')->where('id',$id)->first();
        $name = $detail->company_name;
        $email = $detail->email;
        $subject = "Account deleted!";
        $message = "Your account has been deleted by admin.";

        if($detail)
        {
            $detail->delete();
            
            //Organization deleted by admin
            $organizations = User::select('*')->where('organization_id',$id)->get();
            foreach ($organizations as $okey => $ovalue) {
                $subject = "Organization deleted!";
                $message = "Your organization has been deleted by admin.";
                $name = $ovalue->first_name.' '.$ovalue->last_name;
                $email = $ovalue->email;
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
            }
        //end organization deleted by admin
            
            $name = $detail->first_name.' '.$detail->last_name;
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
                'message' => 'Success! organization deleted successfully.',
                'alert-type' => 'success'
            );
        }
        else{
            $notification = array(
                'message' => 'Oops! Something went wrong.',
                'alert-type' => 'error'
            );
        }
        return Redirect::back()->with($notification);
    } catch (\Throwable $th) {
        return Redirect::back()->with(' error',$th->getMessage());
    }

}

public function restore($id)
{
    $detail = Organization::select('*')->where('id',$id)->withTrashed()->first();
    if($detail)
    {
        $detail->restore();
        $notification = array(
            'message' => 'Success! organization restored successfully.',
            'alert-type' => 'success'
        );
    }
    else{
        $notification = array(
            'message' => 'Oops! Something went wrong.',
            'alert-type' => 'error'
        );
    }
    return Redirect::back()->with($notification);
}

public function change_status($id)
{
    try
    {
        $detail = Organization::select('*')->where('id',$id)->first();
        if($detail)
        {
            if($detail->status == 0){
                Organization::where('id',$id)->update(['status' => 1]);
                $output['msg']	= "Organization activated successfully.";
                $subject = "Account activated!";
                $message = "Congratulations! <br>Your account has been activated successfully.";
            }
            else{
                Organization::where('id',$id)->update(['status' => 0]);
                $output['msg']	= "Organization deactivated successfully.";
                $subject = "Account deactivated!";
                $message = "Your account has been deactivated by admin.";
            }

            /*$mailData['subject'] = $subject;
            $mailData['to_email'] = $detail->email;
            $mailData['to_name']= $detail->company_name;
            $mailData['view'] = 'emails.markdown_mail';
            $mailData['message'] = $message;
            Mail::send(new SendMarkdownMail($mailData));*/

            $name = $detail->first_name.' '.$detail->last_name;
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

            //$output['msgHead']	    = "Success! ";
            $output['msgType']	    = "success";

            return response()->json($output);
        }
        else {
            $output['msg']			= "Something went wrong.";
            $output['msgHead']	    = "Oops! ";
            $output['msgType']	    = "error";

            return response()->json($output);
        }
    } catch (\Throwable $th) {
        $output['msg'] = $th->getMessage();
        return response()->json($output);
    }
}


public function usersList($id)
{
    try
    {
        $organization = Organization::select('*')->where('id',$id)->withTrashed()->first();
        return view('admin.organizations.users_list',compact('organization'));
    } catch (\Throwable $th) {
        $output['msg'] = $th->getMessage();
        return response()->json($output);
    }
}

public function usersListData($id,Request $request){
        $data = User::where('organization_id',$id);
        return DataTables::of($data)
        ->filter(function ($query) use ($request, $data) {
            if ($request->has('user_name') && !empty($request->user_name)) {
                $query->where(function($q) use ($request, $data) {
                    $q->where('name', 'like', "%{$request->get('user_name')}%");
                });
            }
        })
        ->addColumn('action', function ($data) {
            $action = '<button data-url="'.route('admin.organizations.view_organization',$data->id).'" data-toggle="modal" data-target="#viewModal" class="btn btn-info" title="View"><i class="fa fa-eye"></i></button>';
            return $action;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

}
