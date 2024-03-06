<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Coach;
use App\Models\CoachingLevel;
use App\Models\Strengths;
use App\Models\AvailabilityDate;
use App\Models\UnAvailabilityDate;
use App\Models\Session as SessionModel;
use Storage;
use Redirect;
use Str;
use DataTables;
use View;
use Mail;
use DateTime;
use App\Mail\SendMarkdownMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request as Request2;

class CoachController extends Controller
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
        $adminId = 0;
        if( auth()->guard('admin')->check() ){
            $adminId = Auth::guard('admin')->user()->id;
        }
        if(isset($adminId) && $adminId == '1'){
            $count = Coach::select('*')->withTrashed()->orderBy('id','DESC')->count();
        }else{
            $count = Coach::select('*')->where('created_by','2')->withTrashed()->orderBy('id','DESC')->count();
        }   
        return view('admin.coach.list',compact('count'));
    }

    public function fetchCoachData(Request $request){
        $adminId = 0;
        if( auth()->guard('admin')->check() ){
            $adminId = Auth::guard('admin')->user()->id;
        }
        if(isset($adminId) && $adminId == '1'){
            $data = Coach::select('*')->withTrashed()->orderBy('id','DESC');
        }else{
            $data = Coach::select('*')->where('created_by','2')->withTrashed()->orderBy('id','DESC');
        }
        return DataTables::of($data)
        ->filter(function ($query) use ($request, $data) {
            if ($request->has('coach_name') && !empty($request->coach_name)) {
                $query->where(function($q) use ($request, $data) {
                    $q->where('name', 'like', "%{$request->get('coach_name')}%");
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
        ->addColumn('profile_image', function ($data) use ($request) {
            if($data->profile_image){
                $imageUrl = '<img class="coach_img" src="'.asset('uploads/'.$data->profile_image).'">';
            }else{
                $imageUrl = '<img class="coach_img" src="'.asset('assets/admin/img/user.png').'">';
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
            <input class="change_status" data-url="'.route('admin.coach.change_status',$data->id).'" type="checkbox" '.$is_active.'>
            <span class="slider round"></span>
            </label>';

        })
        ->addColumn('action', function ($data) {
            $action = '<button data-url="'.route('admin.coach.view_coach',$data->id).'" data-toggle="modal" data-target="#viewModal" class="btn btn-info" title="View"><i class="fa fa-eye"></i></button><a href="'. route('admin.coach.get_calender',['id'=>$data->id]) .'" class="btn btn-primary" title="Set Availability"><i class="fa fa-calendar"></i></a><a href="'. route('admin.coach.edit',['id'=>$data->id]) .'" class="btn btn-primary" title="Edit coach"><i class="fa fa-edit"></i></a>';

            if ($data->deleted_at == null){
                $action .='<button data-url="'.route('admin.coach.delete',$data->id).'" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger" title="Delete coach" data-name="'.$data->name.'"><i class="fas fa-ban"></i></button>';
            }else{
                $action .='<button data-url="'.route('admin.coach.restore',$data->id).'" data-toggle="modal" data-target="#restoreModal" class="btn btn-success" title="Restore coach" data-name="'.$data->name.'"><i class="icon-reload"></i></button>';
            };

            $action .='<button data-url="'.route('admin.coach.permentdelete',$data->id).'" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger" title="Delete Coach Permanently" data-name="'.$data->name.'" data-title="Permanently"><i class="fa fa-trash"></i></button>';

            return $action;

        })
        ->rawColumns(['action','is_active','profile_image'])
        ->make(true);
    }

    public function view_coach($id)
    {
        $data = Coach::where('id',$id)
        ->withTrashed()
        ->first();
        if($data){
            $view = View::make('admin.coach.view_coach_modal',compact('data'));
            $html = $view->render();
            return $view;
        }
        else {
            abort(404);
        }
    }

    public function create($id=null)
    {
        $coachingLevelsData = CoachingLevel::orderBy('id','DESC')->get();
        $strengthsData = Strengths::orderBy('id','DESC')->get();
        if($id!=null)
        {
            $data = Coach::select('*')->where('id',$id)->first();
            if($data)
            {
                return view('admin.coach.create',compact('data','coachingLevelsData','strengthsData'));
            }
            else {
                $notification = array(
                    'message' => 'Oops! Something went wrong..',
                    'alert-type' => 'error'
                );
                return Redirect::route('admin.coach')->with($notification);
            }
        }
        return view('admin.coach.create',compact('coachingLevelsData','strengthsData'));
    }

    public function store(Request $request, $id=null)
    {
        try {
            $input=$request->all();
            $old_record= Coach::where('email',$input['email'])->first();
            $adminId = 0;
            if( auth()->guard('admin')->check() ){
                $adminId = Auth::guard('admin')->user()->id;
            }
            if(!isset($id) || !isset($old_record) && $old_record != $input['email'])
            {
                $rules['email'] = "required|unique:coaches,email";
            }
            $rules['first_name'] = "required|string|max:30";
            $rules['last_name'] = "required|string|max:30";
            $rules['tagline'] = "required";
            //$rules['short_description'] = "required";
            $rules['about'] = "required";
            if($request->file('profile_image')){
                $rules['profile_image']     = "mimes:jpg,jpeg,png";
            }
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
                //$input['profile_image'] = $request->image_path;
                if($id!=null){
                    $records= Coach::Select('profile_image')->where('id',$id)->first();
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

                $input['coaching_level'] = $request->coaching_level;
                $input['strengths'] = $request->strengths;

                if(isset($request->id) && !empty($request->id)){
                    $coachSet = Coach::updateOrCreate(['id'=>$request->id],$input);
                }else{
                    $input['created_by'] = $adminId;
                    $coachSet = Coach::updateOrCreate(['id'=>$id],$input);    
                }
                
                if(!isset($id) || $id == null){
                    $coachGet = Coach::where('id',$coachSet->id)->first();
                    $coachGet->slug = $coachGet->slug."-".$coachGet->id;
                    $coachGet->update();
                }
                $output['status'] = 'success';
                if($id!=null)
                {
                    $output['msg'] = "Coach updated successfully.";
                }
                else
                {
                    $output['msg'] = "Coach created successfully.";
                }
                //$output['msgHead'] = "Success ! ";
                $output['msgType'] = "success";
                $output['slideToTop'] = true;
                $output['selfReload'] = true;
                return Redirect::route('admin.coach')->with('success',$output['msg']);
            }
        } catch (\Throwable $th) {
            return Redirect::back()->with('error', 'Something went wrong..'.$th->getMessage());
        }
    }

    public function permentdelete($id){
        $detail = Coach::select('*')->where('id',$id)->withTrashed()->first();
        $session = SessionModel::where('coach_id',$id)->where('status','upcoming')->get();
        if(isset($session) && count($session) > 0):
            $notification = array(
                'message' => "Can't delete the account until the book session is completed.",
                'alert-type' => 'error'
            );
            return Redirect::back()->with($notification);
        endif;
        $detail->forceDelete();
        $notification = array(
            'message' => 'Coach deleted permanently.',
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }

    public function delete($id)
    {
      $detail = Coach::select('*')->where('id',$id)->first();

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
                'message' => 'Coach deleted successfully.',
                'alert-type' => 'success'
            );
        }
        else{
            $notification = array(
                'message' => 'Oops! Something went wrong.',
                'alert-type' => 'error'
            );
        }

        //   return Redirect::route('admin.coach')->with($notification);
        return Redirect::back()->with($notification);
    }

    public function restore($id)
    {
      $detail = Coach::select('*')->where('id',$id)->withTrashed()->first();

      if($detail)
      {
        $detail->restore();
        $notification = array(
            'message' => 'Coach restored successfully.',
            'alert-type' => 'success'
        );
    }
    else{
        $notification = array(
            'message' => 'Oops! Something went wrong.',
            'alert-type' => 'error'
        );
        }

    //   return Redirect::route('admin.coach')->with($notification);
    return Redirect::back()->with($notification);
    }

    public function change_status($id)
    {
        try
        {
            $detail = Coach::select('*')->where('id',$id)->first();
            if($detail)
            {
                if($detail->is_active == 0){
                    Coach::where('id',$id)->update(['is_active' => 1]);
                    $output['msg']  = "Coach activated successfully.";
                    $subject = "Account activated!";
                    $message = "Congratulations! <br>Your account has been activated successfully.";
                }
                else{
                    Coach::where('id',$id)->update(['is_active' => 0]);
                    $output['msg']  = "Coach deactivated successfully.";
                    $subject = "Account deactivated!";
                    $message = "Your account has been deactivated by admin.";
                }

                /*$mailData['subject'] = $subject;
                $mailData['to_email'] = $detail->email;
                $mailData['to_name']= $detail->name;
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
                $imagePath = "coach/".time().".".$ext;
                file_put_contents("public/uploads/".$imagePath, $data);
                    //$imagePath = "public/user/thumb/".auth()->guard('user')->user()->id."-".time().".".$ext;
                    //file_put_contents($imagePath, $data);
                if(isset($request->id) && !empty($request->id)){
                    $user = Coach::findOrFail($request->id);
                    $user->profile_image = $imagePath;
                    //$user->update();
                }else{
                    $user_data['profile_image'] = $imagePath;
                    //$user = Coach::create($user_data);
                }
                echo '<img src="'.url("public/uploads/".$imagePath).'" class="profile-pic"/>';
                echo '<input type="hidden" name="image_path" value="'.$imagePath.'" id="image_path">';
            }
        }
    }

    //Calender Code Start
    public function get_calender($id)
    {
        $data = Coach::where('id',$id)
        ->withTrashed()
        ->first();
        $firstunavailibility = UnAvailabilityDate::where(['coach_id' => $data->id, 'type' => '0'])->orderBy('id', 'asc')->get();
        $secondunavailibility = UnAvailabilityDate::where(['coach_id' =>  $data->id, 'type' => '1'])->orderBy('id', 'asc')->get();

        //getavailability Start
        $getavailability = AvailabilityDate::where('coach_id',$data->id)->get();

        if(!empty($getavailability) && count($getavailability) > 0):
            foreach ($getavailability as $k => $v) {
                $new1[] = $v->date;
                $available = implode(',',$new1);
            }
        else:
            $available = '';
        endif;

        $getunavailability = UnAvailabilityDate::where('coach_id',$data->id)->where('type','0')->get();

        if(!empty($getunavailability) && count($getunavailability) > 0):
            foreach ($getunavailability as $key => $value) {
                $new2[] = $value->date;
                $unavailable = implode(',',$new2);
            }
        else:
            $unavailable = '';
        endif;
        //end getavailability

        $getbooked = SessionModel::where('coach_id', $data->id)->where('status','upcoming')->get();

        if(!empty($getbooked) && count($getbooked) > 0):
            foreach ($getbooked as $key => $value) {
                $new2[] = $value->date;
                $booked = implode(',',$new2);
            }
        else:
            $booked = '';
        endif;
        //end booked

        return view('admin.coach.calender',compact('data','firstunavailibility','secondunavailibility','available','unavailable','booked'));
    }

    public function storeAvailableData(Request $request){
        //$dates = [];
        /*for($i = $request->from_date; strtotime($i) <= strtotime($request->to_date); $i = date('d-m-Y', strtotime('1 day', strtotime($i)))){
            array_push($dates, $i);
        }*/
        //foreach($dates as $date){
            $datesData = AvailabilityDate::where('date', date("Y-m-d",strtotime($request->from_date)))->where('coach_id',$request->coach_id)->first();

            $tempArr = [];
            if(isset($request->select_timeslot) && !empty($request->select_timeslot)){
                foreach ($request->select_timeslot as $tkey => $tvalue) {
                    $tempArr[] = $tvalue;
                }
            }
            if(!$datesData){
                $datesData = new AvailabilityDate;
            }
            $datesData->coach_id = $request->coach_id;
            $datesData->day = date("l", strtotime($request->from_date));
            $datesData->date = date("Y-m-d",strtotime($request->from_date));
            $datesData->time_slots = $tempArr;
            $datesData->status = 'available';
            $datesData->save();
        //}
        //New code start
        /*foreach ($request->select_date as $dkey => $dvalue) {
            $tempArr = [];
            if(isset($request->select_timeslot) && !empty($request->select_timeslot)){
                foreach ($request->select_timeslot as $tkey => $tvalue) {
                    $tempArr[] = $tvalue;
                }
            }
            $datesData = AvailabilityDate::where('date', $dvalue)->where('coach_id',$request->coach_id)->first();
            if(!$datesData){
                $datesData = new AvailabilityDate;
            }
            $datesData->coach_id = $request->coach_id;
            $datesData->date = $dvalue;
            $datesData->day = $day = date("D", $dvalue);
            $datesData->status = 'available';
            $datesData->time_slots = $tempArr;
            $datesData->save();
        }*/
        return redirect()->route('admin.coach.get_calender',$request->coach_id)->with('success','Availability has been set successfully');

    }

    public function getData(Request $request){
        $datesArr = [];
        if($request->date != null){
            foreach($request->date as $date){
                array_push($datesArr, date('Y-m-d', strtotime($date)));
            }
        }
        sort($datesArr);
        $data = AvailabilityDate::where('coach_id', )->whereBetween('date', $datesArr)->get();
        return response()->json($data);
    }

    public function insertUnAvailable(Request $request){
        $date = (isset($request->time) && isset($request->datetwo)) ? $request->datetwo : $request->dateone;
        $type = (isset($request->time)  && isset($request->datetwo)) ? '1' : '0';
        $userData = Coach::where('id',$request->coach_id)->withTrashed()->first();
        $getCount = UnAvailabilityDate::where([
            "coach_id" => $userData->id,
            "date" => date('Y-m-d', strtotime(str_replace(',', '', $date))),
        ]);
        if ($getCount->count() == 0) :
            if (!isset($request->time) && empty($request->time)) :
                $result = UnAvailabilityDate::create([
                    "coach_id" => $userData->id,
                    "date" => date('Y-m-d', strtotime(str_replace(',', '', $request->dateone))),
                    "type" => '0'
                ]);
                if ($result) :
                    $append = '<div class="selected-date cal_addrow"><div class="head">'. date('d M, Y', strtotime(str_replace(',', '', $request->dateone))).' <a href="javascript:void(0);" class="remove-date minus_btn" data-id="' . $result->id . '"><i class="fa fa-trash"></i></a></div></div>';
                    //dd($append);
                    $res = array("result" => true, "message" => "Unavailability set successfully.", "append" => $append);
                else :
                    $res = array("result" => false, "message" => 'Something went wrong.');
                endif;
            else :
                $time = $request->time;
                $add = UnAvailabilityDate::create([
                    "coach_id" => $userData->id,
                    "time_slots" => $time,
                    "date" => date('Y-m-d', strtotime(str_replace(',', '', $request->datetwo))),
                    "type" => '1'
                ]);
                if ($add) :
                    $timeslot = '';
                    if (isset($time) and !empty($time)) {
                        foreach ($time as $slotkey => $slotval) {
                            $timeslot .= "<span class='tags'>" . $slotval . "<a href='javascript:void(0);' class='remove slot_remove' id='" . $slotval . "' data-id='" . $add->id . "' onclick='this.parentElement.style.display='none''><i class='fa fa-times'></i></a></span>";
                        }
                    }
                    $append = '<div class="selected-date cal_addrow"><div class="card border border-top-0"><div class="head">' . date('d M, Y', strtotime(str_replace(',', '', $request->datetwo))) . ' <a href="javascript:void(0);" class="remove-date minus_btn" data-id=' . $add->id . '><i class="fa fa-trash"></i></a></div><div class="body date_' . date('Y-m-d', strtotime($date)) . '"">' . $timeslot . '</div></div>';
                    $res = array("result" => true, "message" => "Unavailability set successfully.", "append" => $append, 'li_list' => '0');
                endif;
            endif;
        else :
            if ($getCount->first()->type == '1' && $getCount->first()->type == $type) :
                $dataRow = $getCount->orderBy('id', 'desc')->first();
                $avlSlot = $dataRow->time_slots;
                $newTimeSlot = array_unique(array_merge($avlSlot, $request->time));
                $time = array();
                foreach ($newTimeSlot as $key => $value) {
                    $time[] = $value;
                }
                $updateRecord = UnAvailabilityDate::where(["coach_id" => $userData->id, "date" => date('Y-m-d', strtotime(str_replace(',', '', $request->datetwo))), "type" => '1'])->update([
                    "time_slots" => $time
                ]);
                $unavailable_slots = UnAvailabilityDate::where('coach_id', $userData->id)->first();
                $timeslot = '';
                if (isset($time) and !empty($time)) {
                    foreach ($time as $slotkey => $slotval) {
                        $timeslot .= "<span class='tags'>" . $slotval . "<a href='javascript:void(0);' class='remove slot_remove' id='" . $slotval . "' data-id='" . $dataRow->id . "' onclick='this.parentElement.style.display='none''><i class='fa fa-times'></i></a></span>";

                    }
                }

                $append = '<div class="body date_' . date('Y-m-d', strtotime($date)) . '"">' . $timeslot . '</div>';

                $res = array("result" => true, "message" => "Unavailability set successfully.", "append" => $append, 'li_list' => '1', "class" => 'date_' . date('Y-m-d', strtotime($date)));
            else :
                $res = array("result" => false, "message" => 'This date is already added as unavailable date.');
            endif;
        endif;
        return json_encode($res);
    }

    public function removeUnavailabledate(Request $request){
        $result = UnAvailabilityDate::where('id', $request->id)->delete();
        if ($result) :
            $res = array("result" => true, "message" => "Unavailability record deleted successfully.");
        else :
            $res = array("result" => false, "message" => 'Something went wrong.');
        endif;
        return json_encode($res);
    }

    public function removeUnavailabledatetime(Request $request){
        $result = UnAvailabilityDate::where('id', $request->id)->first();
        $arr = $result['time_slots'];
        if (($key = array_search($request->slotval, $arr)) !== false) {
            unset($arr[$key]);
        }
        $upslot["time_slots"] = array_values($arr);
        if (count($arr) == 0) :
            $result = UnAvailabilityDate::where('id', $result->id)->delete();
        endif;
        $up = UnAvailabilityDate::where('id', $request->id)->update($upslot);
        //if ($up) :
        if (count($arr) == 0) :
           $res = array("result" => true, "message" => "Unavailability record deleted successfully.", "remove" => true);
        else :
            $res = array("result" => true, "message" => "Unavailability record deleted successfully.");
        endif;
        //else :
        //    $res = array("result" => true, "message" => 'Unavailability record deleted successfully.');
        //endif;
        return json_encode($res);
    }

    public function getTimeSlotByDate(Request $request){
        $date = date('Y-m-d',strtotime($request->date));
        $coachID = $request->coachID;
        $AvailabilityDates = AvailabilityDate::where('coach_id', $coachID)->where('date',$date)->first();
        if(isset($AvailabilityDates) && !empty($AvailabilityDates)){
            $dates = $AvailabilityDates['time_slots'];
        }else{
            $dates = '';
        }
        $UnAvailabilityDates = UnAvailabilityDate::where('coach_id', $coachID)->where('type','1')->where('date',$date)->first();
        if(isset($UnAvailabilityDates) && !empty($UnAvailabilityDates)){
            $unavailslots = $UnAvailabilityDates['time_slots'];
        }else{
            $unavailslots = array();
        }
        $booked = SessionModel::where('coach_id', $coachID)->where('status','upcoming')->where('date',$date)->first();
        if(isset($booked) && !empty($booked)){
            $bookedValue = array($booked['time']);
        }else{
            $bookedValue = array();
        }
        if(isset($dates) && !empty($dates)){
            $html='<div class="timeslot" id="timeslot_div"><ul>';
            foreach($dates as $key =>$timeslot)
            {
                if(in_array($timeslot, $bookedValue))
                {
                    $html .= '<li class="booked">'.$timeslot.'</li>';
                }
                elseif(in_array($timeslot, $unavailslots))
                {
                    $html .= '<li class="unavailable">'.$timeslot.'</li>';
                    
                }else{
                    $html .= '<li class="available">'.$timeslot.'</li>';
                }
            }
            $html .='</ul></div>';
        }else{
            //$slots = get_custom_slot(45);
            $html='<div class="timeslot" id="timeslot_div"><ul>';
            $html .= '<li>No timeslots found!</li>';
            $html .='</ul></div>';
        }
        $arr = array("success"=>"true","html"=>$html,"message"=> "");
        return response()->json($arr);
    }

    public function getAvailTimeSlotByDate(Request $request){
        $date = date('Y-m-d',strtotime($request->date));
        $coachID = $request->coachID;
        $AvailabilityDates = AvailabilityDate::where('coach_id', $coachID)->where('date',$date)->first();
        if(isset($AvailabilityDates) && !empty($AvailabilityDates)){
            $dates = $AvailabilityDates['time_slots'];
        }else{
            $dates = get_custom_slot(45);
        }
        if(isset($dates) && !empty($dates)){
            $html='<option value="All">All</option>';
            $slots = get_custom_slot(45);
            foreach($slots as $key =>$sval)
            {
                if(in_array($sval, $dates)) {
                    $html .= '<option value="'.$sval.'" selected>'.$sval.'</option>';
                }else{
                    $html .= '<option value="'.$sval.'">'.$sval.'</option>';
                }
            }
        }else{
            $slots = get_custom_slot(45);
            $html='<option value="All">All</option>';
            foreach($slots as $key =>$sval)
            {
                
                $html .= '<option value="'.$sval.'">'.$sval.'</option>';
            }
        }
        $arr = array("success"=>"true","html"=>$html,"message"=> "");
        return response()->json($arr);
    }

    //Full Calender Code
    public function fullCalender(){
        return view('admin.coach.full_calender');
    }
    public function getEvents(){
        $currDate = date("Y-m-d");
        $getavailability = AvailabilityDate::whereDate('date','>=',$currDate)->where('status','available')->get();
        $result = [];
        foreach($getavailability as $availability){
            $temp = [];
            $events = SessionModel::where('coach_id',$availability->coach_id)->where('status','upcoming')->whereDate('date',$availability->date)->first();
            if(isset($events) && !empty($events)){
                $expl = explode('-', $events['time']);
                $temp['className'] = "cal_booked";
                $temp['color'] = "#006600a1";
                $temp['title'] = $expl[0].' '.get_coach_by_id($events['coach_id']);
            }else{
                $temp['className'] = "cal_available";
                $temp['color'] = "#23b7e5";
                $temp['title'] = get_coach_by_id($availability->coach_id);
            }
            $temp['start'] = $availability->date;
            $temp['end'] = $availability->date;
            $result[] = $temp;
        }
        return response()->json($result);
    }


}
