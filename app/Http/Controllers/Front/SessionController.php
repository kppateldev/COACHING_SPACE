<?php

namespace App\Http\Controllers\Front;

use Redirect, DB, Session, Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Coach;
use App\Models\Organization;
use App\Models\Session as SessionModel;
use Illuminate\Http\Request as Request2;
use Carbon\Carbon;
use DateTime;

class SessionController extends Controller
{
    protected $viewPath;
    protected $actionURL;

    public function __construct()
    {

    }

    public function confirmSessionSubmit(Request2 $request)
    {
        //return Redirect::back()->with('success','Oops! Booking facility will be in our next phase.');
        $userId = 0;
        if( auth()->guard('user')->check() ):
            $userId = auth()->guard('user')->user()->id;
            $user = User::where('id',$userId)->first();
        endif;
        $coach = Coach::where('id',$request->coachID)->first();

        //KP=01092022 Start
        $organization = Organization::where('id',$user->organization_id)->first();
        //start week data
        $selectDate = $request->bookingDate;
        $week = date('w', strtotime($selectDate));
        $date = new DateTime($selectDate);
        $weekStartDate = $date->modify("-".$week." day")->format("Y-m-d");
        $weekEndDate = $date->modify("+6 day")->format("Y-m-d");
        //end week data

        if(isset($organization) && !empty($organization)){
            $countSessions = SessionModel::where('organization_id',$user->organization_id)->whereBetween('date',[$weekStartDate,$weekEndDate])->where('status','upcoming')->count();
            if($countSessions >= $organization->sessions_limit){
                return Redirect::back()->with('error','Your booking session limit is over. So Please contact to admin.');
            }
        }
        //KP=01092022 end
        
        $bookTimeArr = explode('-',$request->bookingTime);
        $bookStartTime = date("Y-m-d H:i:s",strtotime($request->bookingDate." ".$bookTimeArr[0]));
        $bookEndTime =  date("Y-m-d H:i:s",strtotime($request->bookingDate." ".$bookTimeArr[1]));

        $extraStartTime = date("Y-m-d H:i:s", strtotime('-15 minutes', strtotime($bookStartTime)));
        $extraEndTime = date("Y-m-d H:i:s", strtotime('+15 minutes', strtotime($bookEndTime)));
        
        $checkIfBooked = SessionModel::where('coach_id',$request->coachID)->where('session_start_time','>=',$extraStartTime)->where('session_end_time','<=',$extraEndTime)->where('status','upcoming')->get();
        
        if($checkIfBooked->count() > 0)
        {
            return Redirect::back()->with('error','Session is already booked, please choose another date/time.');
        }
        /* Code Start = KP*/
        $startDate = date('Y-m-d', strtotime($request->bookingDate. ' - 3 days'));
        $endDate = date('Y-m-d', strtotime($request->bookingDate. ' + 3 days'));

        $checkIfBooked3Days = SessionModel::where('user_id',$userId)->whereBetween('date',[$startDate,$endDate])->where('status','upcoming')->get();
        if($checkIfBooked3Days->count() > 0)
        {
            foreach ($checkIfBooked3Days as $key => $value) {
                $startDate = date('Y-m-d', strtotime($value->date));
                $endDate = date('Y-m-d', strtotime($value->date. ' + 3 days'));

                $checkIfBooked = SessionModel::where('user_id',$userId)->whereBetween('date',[$startDate,$endDate])->get();
                if($checkIfBooked->count() > 0)
                {
                    return Redirect::back()->with('error','User cannot book appointments same day or within 3 days of each other, please choose another date/time.');
                }
            }
        }
        /* Code End = KP*/
        /* Start MS Link Generate */
        $startDateTime = Carbon::parse($request->bookingDate)->format('Y-m-d').'T'.Carbon::parse($bookTimeArr[0])->format('H:i:s').'.6491364Z';

        $endDateTime = Carbon::parse($request->bookingDate)->format('Y-m-d').'T'.Carbon::parse($bookTimeArr[1])->format('H:i:s').'.6491364Z';
        $subject = 'Coaching Space Session!';
        
        //Start Generate Token
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://login.microsoftonline.com/90587058-d91d-4e6e-94da-1a244a189c26/oauth2/v2.0/token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=76af2bb4-93b5-4966-adf2-4df564fd878e&client_secret=E3u8Q~KuKMqHoDDiig46P8unQXD0QXz5XxpZDbBj&scope=https://graph.microsoft.com/.default',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie: fpc=AmAjpsbmqTxBsoNUpbyk6zmgvPszAQAAAHb1D9oOAAAAcX1QCgEAAACZ9Q_aDgAAAFU_qu8BAAAAuPUP2g4AAAA; stsservicecookie=estsfd; x-ms-gateway-slice=estsfd'
          ),
        ));

        $response1 = curl_exec($curl);
        //dd($response1);

        curl_close($curl);
        $res=json_decode($response1);
        // End Generate Token

        //dd($res);
        //$token = get_settings('ms_link_token');
        $token = $res->access_token;
        $postdata = '{
                "startDateTime": "'.$startDateTime.'",
                "endDateTime": "'.$endDateTime.'",
                "subject": "'.$subject.'",
                "AutoAdmittedUsers": "Everyone",
                "accessLevel": "everyone",
                "entryExitAnnouncement": true,
        }';
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://graph.microsoft.com/v1.0/users/d0313d94-9436-4f5d-8a85-b383020501ff/onlineMeetings',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$postdata,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response=json_decode($response);
        //dd($response);
        /* End MS Link Generate */
        if(isset($response) && !empty($response->id)){
            $sessionData = new SessionModel;
            $sessionData->coach_id = $request->coachID;
            $sessionData->user_id = $userId;
            //KP=01092022 Start
            $sessionData->organization_id = $user->organization_id;
            //KP=01092022 end
            $sessionData->date = date("Y-m-d",strtotime($request->bookingDate));
            $sessionData->time = $request->bookingTime;
            $sessionData->session_start_time = $bookStartTime;
            $sessionData->session_end_time = $bookEndTime;
            $sessionData->like_to_discuss = strip_tags($request->like_to_discuss);
            $sessionData->ms_join_web_url = $response->joinWebUrl;
            $sessionData->ms_response_json = json_encode($response);
            $sessionData->save();

            $link = $response->joinWebUrl;
            $userEmail = $sessionData->UserData->email;
            $userName = $sessionData->UserData->name;
            $coachEmail = $sessionData->CoachData->email;
            $coachName = $sessionData->CoachData->name;
            $adminEmail = get_settings('admin_email');
            $adminName = 'Admin';

            $new_email_data['NAME'] = character_limit($userName,25);
            $new_email_data['LINK'] = $link;
            $new_email_data['MESSAGE'] = 'Coaching Space Session.';
            $new_email_data['SESSION_ID'] = $sessionData->id;
            $new_email_data['DATE_TIME'] = date("d M, Y",strtotime($sessionData->date)).' '.$sessionData->time;
            $new_email_data['USERNAME'] = character_limit($sessionData->UserData->name,30);
            $new_email_data['COACH_NAME'] = character_limit($sessionData->CoachData->name,30);
            $new_email_data['DISCUSSION'] = $sessionData->like_to_discuss;

            $new_email_data = _email_template_content("45",$new_email_data);

            $new_subject = 'Coaching Space Session!';
            $new_content = $new_email_data[1];

            //User Email
            $new_fromdata = ['email' => $userEmail,'name' => $userName];
            $new_mailids = [$userEmail => $userName];
            _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
            createOutLookEvent($userName,$userEmail,$link,$bookStartTime,$bookEndTime);
            
            //Coach Email
            $new_fromdata = ['email' => $coachEmail,'name' => $coachName];
            $new_mailids = [$coachEmail => $coachName];
            _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
            createOutLookEvent($coachName,$coachEmail,$link,$bookStartTime,$bookEndTime);
            
            //Admin Email
            $new_fromdata = ['email' => $adminEmail,'name' => $adminName];
            $new_mailids = [$adminEmail => $adminName];
            _mail_send_general($new_fromdata, $new_subject , $new_content , $new_mailids);

            //Microsoft Event Create with outlook calander
            return Redirect::to('/booking-confirmed/'. $sessionData->id);
        }else{
            return Redirect::back()->with('error',$response->error->message);
        }
    }

    public function bookingConfirmed($sessionID)
    {
        $session = SessionModel::where('id',$sessionID)->first();
        if(auth()->guard('user')->user()->id != $session->user_id)
        {
            return Redirect::back()->with('error','Something went wrong.');
        }
        $user = User::where('id',$session->user_id)->first();
        $coach = Coach::where('id',$session->coach_id)->first();
        $pass_array = array(
            '_meta_title' => "Thank You",
            '_meta_keyword' => "Thank You",
            '_meta_desc' => "Thank You",
            'user' => $user,
            'coach' => $coach,
            'session' => $session,
        );
        return view('front/booking_confirmed', $pass_array);
    }

    //KP 06082022
    public function cancelSessionPopup(Request2 $request)
    {
        $sessionID = $request->id;
        $session = SessionModel::where('id',$sessionID)->first();
        $user = User::where('id',$session->user_id)->first();
        $coach = Coach::where('id',$session->coach_id)->first();     
        $html = view('front/cancel_session_popup', compact('user','coach','session'))->render();
        return $html;
    }

    public function cancelSessionSubmit(Request2 $request)
    {
        $userId = 0;
        if( auth()->guard('user')->check() ):
            $userId = auth()->guard('user')->user()->id;
            $user = User::where('id',$userId)->first();
        endif;
        $data['status'] = 'canceled';
        $data['cancel_reason'] = strip_tags($request->cancel_reason);
        SessionModel::where('id', $request->sessionID)->update($data);

        //Email Start
        $sessionData = SessionModel::where('id',$request->sessionID)->first();

        $userEmail = $sessionData->UserData->email;
        $userName = $sessionData->UserData->name;
        $coachEmail = $sessionData->CoachData->email;
        $coachName = $sessionData->CoachData->name;
        $adminEmail = get_settings('admin_email');
        $adminName = 'Admin';

        $link = url('/my-sessions-details/'.$sessionData->id);

        $new_email_data['NAME'] = character_limit($userName,25);
        $new_email_data['LINK'] = $link;
        $new_email_data['MESSAGE'] = 'Cancel Session';
        $new_email_data['SESSION_ID'] = $sessionData->id;
        $new_email_data['DATE_TIME'] = date("d M, Y",strtotime($sessionData->date)).' '.$sessionData->time;
        $new_email_data['USERNAME'] = character_limit($sessionData->UserData->name,30);
        $new_email_data['COACH_NAME'] = character_limit($sessionData->CoachData->name,30);
        $new_email_data['DISCUSSION'] = $sessionData->cancel_reason;

        $new_email_data = _email_template_content("46",$new_email_data);

        $new_subject = 'Cancel Session!';
        $new_content = $new_email_data[1];

        //User Email
        $new_fromdata = ['email' => $userEmail,'name' => $userName];
        $new_mailids = [$userEmail => $userName];
        _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );

        //Coach Email
        $new_fromdata = ['email' => $coachEmail,'name' => $coachName];
        $new_mailids = [$coachEmail => $coachName];
        _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );

        //Admin Email
        /*$new_fromdata = ['email' => $adminEmail,'name' => $adminName];
        $new_mailids = [$adminEmail => $adminName];
        _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );*/

        return Redirect::to('/my-sessions')->with('success','Session has been canceled successfully.');
    }
    //KP 06082022

    public function mysessions(Request2 $request){
        $userId = 0;
        if( auth()->guard('user')->check() ):
            $userId = auth()->guard('user')->user()->id;
            $user = User::where('id',$userId)->first();
        endif;
        $sessions = SessionModel::where('user_id',$userId);
        if(isset($request->keyword) && !empty($request->keyword))
        {
            $value = $request->keyword;
            $sessions->with(['CoachData'])
            ->whereHas('CoachData', function($q) use($value) {
            // Query the name field in Coach table
            $q->where("name","LIKE",strtolower("%{$value}%")); // '=' is optional
            });
        }
        if(isset($request->sort_by_val) && $request->sort_by_val != '')
        {
            $sessions = $sessions->where('status',$request->sort_by_val);
        }
        $sessions = $sessions->orderBy('id','DESC');
        $sessions = $sessions->paginate(10);
        $pass_array = array(
            '_meta_title' => "My Sessions",
            '_meta_keyword' => "My Sessions",
            '_meta_desc' => "My Sessions",
            'user' => $user,
            'sessions' => $sessions,
        );
        return view('front/my_sessions', $pass_array);

    }
    public function userNotesPopup(Request2 $request)
    {
        $sessionID = $request->id;
        $session = SessionModel::where('id',$sessionID)->first();
        $user = User::where('id',$session->user_id)->first();
        $coach = Coach::where('id',$session->coach_id)->first();     
        $html = view('front/user_notes_popup', compact('user','coach','session'))->render();
        return $html;
    }

    public function userNotesSubmit(Request2 $request)
    {
        $userId = 0;
        if( auth()->guard('user')->check() ):
            $userId = auth()->guard('user')->user()->id;
            $user = User::where('id',$userId)->first();
        endif;
        $data['user_notes'] = strip_tags($request->user_notes);
        SessionModel::where('id', $request->sessionID)->update($data);
        return Redirect::to('/my-sessions')->with('success','Notes has been added successfully.');
    }

    public function mySessionDetails($id)
    {
        $session = SessionModel::where('id',$id)->first();
        if(!isset($session))
        {
            return Redirect::to('/my-sessions')->with('error','Session not found!');
        }
        $pass_array = array(
            '_meta_title' => "My Session Detail",
            '_meta_keyword' => "My Session Detail",
            '_meta_desc' => "My Session Detail",
            'session' => $session,
        );
        return view('front/my_session_details', $pass_array);
    }


}
