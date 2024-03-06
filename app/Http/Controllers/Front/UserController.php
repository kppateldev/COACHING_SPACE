<?php
namespace App\Http\Controllers\Front;

use Request, Redirect, DB, Session, Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use App\Models\Coach;
use App\Models\AvailabilityDate;
use App\Models\UnAvailabilityDate;
use App\Models\Session as SessionModel;
//use App\Http\Requests\Request;
use Illuminate\Http\Request as Request2;

class UserController extends Controller {
	
	protected $viewPath;
	protected $actionURL;

	public function __construct()
	{

	}
	
	public function myProfile(Request $request){
		$this->viewPath = 'front/myprofile';
		$this->actionURL = 'myprofile';
		$userId = 0;
		if( auth()->guard('user')->check() ):
			$userId = auth()->guard('user')->user()->id;
			$user = User::where('id',$userId)->first();
		endif;
		$organizations = Organization::where('status',1)->orderBy('id','DESC')->get();

		$pass_array = array(
			'_meta_title' => "My Profile",
			'_meta_keyword' => "My Profile",
			'_meta_desc' => "My Profile",
			'user' => $user,
			'organizations' => $organizations
		);
		return view($this->viewPath, $pass_array );
	}

	public function myProfileUpdate(Request2 $request){
		$userId = 0;
		if(auth()->guard('user')->check()):
			$userId = auth()->guard('user')->user()->id;
			$user = User::where('id',$userId)->first();
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			//$user->email = $request->email;
			$user->phone_number = $request->phone_number;
			//$user->organization_id = $request->organization_id;
			$user->update();
			return Redirect::back()->with('success','Profile updated successfully.');
		else:
			return Redirect::back()->with('error','Something went wrong.');
		endif;
	}

	public function dashboard(Request2 $request)
	{
		$data = Request::all();
		$userId = 0;
		if( auth()->guard('user')->check() ):
			$userId = auth()->guard('user')->user()->id;
			$user = User::where('id',$userId)->first();
		endif;
		$all_coaches = Coach::where('is_active',1)->orderBy('created_at','DESC')->get();
		
		$coaches = Coach::where('is_active',1);

        if((isset($request->select_date) && !empty($request->select_date)) && (isset($request->select_timeslot) && !empty($request->select_timeslot))){
			//$day = array(date('l',strtotime($request->select_date)));
			$date = array(date("Y-m-d", strtotime($request->select_date)));
			$timeslot = $request->select_timeslot;
        	$coaches->whereHas('availability', function($query) use ($date,$timeslot)  {
	        	$query->whereDate('date', $date);
	        	$query->where('time_slots', 'LIKE', '%"'.$timeslot.'"%');
	        });
		}elseif(isset($request->select_date) && !empty($request->select_date)){
            //$day = array(date('l',strtotime($request->select_date)));
        	$date = array(date("Y-m-d", strtotime($request->select_date)));
        	$coaches->whereHas('availability', function($query) use ($date)  {
	        	$query->whereNotNull('time_slots');
	        	$query->where('time_slots','!=','[]');
	        	$query->whereDate('date', $date);
	        });
		}

		if(isset($request->keyword) && !empty($request->keyword))
		{
			$keyword = $request->keyword;
			$coaches = $coaches->where('name', 'like', '%'.$keyword.'%');
		}
		if(isset($request->sort_by_val) && $request->sort_by_val != '')
		{
			$sort_by = $request->sort_by_val;
			if($sort_by == 'avg_review_high_low'){
				$coaches = $coaches->orderBy('rating_count', 'desc');
			}
			if($sort_by == 'avg_review_low_high'){
				$coaches = $coaches->orderBy('rating_count', 'asc');
			}
			if($sort_by == 'rating_count_high_low'){
				$coaches = $coaches->orderBy('avg_rating', 'desc');
			}
			if($sort_by == 'rating_count_low_high'){
				$coaches = $coaches->orderBy('avg_rating', 'asc');
			}
		}
		$coaches = $coaches->where('coaches.is_active','1');
		$coaches = $coaches->orderBy('coaches.created_at','DESC');
		$coaches = $coaches->paginate(9);
		
		$pass_array = array(
			'_meta_title' => "Dashboard - Coach Listings",
			'_meta_keyword' => "Dashboard - Coach Listings",
			'_meta_desc' => "Dashboard - Coach Listings",
			'user' => $user,
			'coaches' => $coaches,
			'all_coaches' => $all_coaches,
		);
		return view('front/dashboard', $pass_array);
	}

	public function cropProfile(Request2 $request)
	{
			//print_r($request->all()); die;
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
				$imagePath = "public/uploads/users/".auth()->guard('user')->user()->id."-".time().".".$ext;
				file_put_contents($imagePath, $data);
					//$imagePath = "public/user/thumb/".auth()->guard('user')->user()->id."-".time().".".$ext;
					//file_put_contents($imagePath, $data);
				$imageName = "users/".auth()->guard('user')->user()->id."-".time().".".$ext;
				$user = User::findOrFail(auth()->guard('user')->user()->id);
				$user->profile_image = $imageName;
				$user->update();
				echo '<img src="'.url($imagePath).'" class="profile-pic"/>';
			}
		}
	}

	public function getChangePassword(){
		$pass_array = array(
			'_meta_title' => "Change Password",
			'_meta_keyword' => "Change Password",
			'_meta_desc' => "Change Password",
		);
		$this->viewPath = 'front/user-change-password';
		$this->actionURL = 'user-change-password';
		return view($this->viewPath, $pass_array );
	}

	public function postChangePassword()
	{
		$post_data = Request::all();
		$user = User::where('id', auth()->guard('user')->user()->id)->first();
		if(!isset($user)){
			return back()->with('error','Something wrong please try again later'); 
		}
		if(!Hash::check($post_data['password'], $user->password)){
			return back()->with('error','Your current password does not match the password you provided.');
		}
		if(strcmp($post_data['password'], $post_data['new_password']) == 0){
			return back()->with("error","New password cannot be the same as your current password. Please choose a different password.");
		}
		$update=array('password'=>Hash::make($post_data['new_password']));
		User::find($user->id)->update($update);
		return back()->with('success','Your password has been successfully updated');
	}

	public function coachprofile(Request2 $request,$slug)
	{
		$coach_date = '';
		$coach_timeslot = '';
		$coach = Coach::where('is_active',1)->where('slug',$slug)->first();
		if(!isset($coach))
        {   
            return redirect('/dashboard')->with('error', "Coach not found!");
        }
        $coach_date = $request->coach_date ?? '';
        $coach_timeslot = $request->coach_timeslot ?? '';
        //getavailability Start
		$getavailability = AvailabilityDate::where('coach_id',$coach->id)->get();

		if(!empty($getavailability) && count($getavailability) > 0):
			foreach ($getavailability as $k => $v) {
				$new1[] = $v->date;
				$available = implode(',',$new1);
			}
		else:
			$available = '';
		endif;
		//end getavailability
		//start getunavailability
		$getunavailability = UnAvailabilityDate::where('coach_id',$coach->id)->where('type','0')->get();
		if(!empty($getunavailability) && count($getunavailability) > 0):
			foreach ($getunavailability as $key => $value) {
				$new2[] = $value->date;
				$unavailable = implode(',',$new2);
			}
		else:
			$unavailable = '';
		endif;
		//end getunavailability
		$pass_array = array(
			'_meta_title' => $coach->name ?? '',
			'_meta_keyword' => $coach->name ?? '',
			'_meta_desc' => $coach->name ?? '',
			'coach' => $coach,
			'available' =>$available,
			'unavailable' =>$unavailable,
			'coach_date' => $coach_date,
			'coach_timeslot' => $coach_timeslot,
		);
		$this->viewPath = 'front/coach-profile';
		return view($this->viewPath, $pass_array );
	}

	public function confirmSessionPopup(Request2 $request)
	{
		$userId = 0;
		if( auth()->guard('user')->check() ):
			$userId = auth()->guard('user')->user()->id;
			$user = User::where('id',$userId)->first();
		endif;

		$date = $request->date;
		$time = $request->time;
		$coachID = $request->coachID;
		$coach = Coach::where('id',$coachID)->first();
		$html = view('front/confirm_session_popup', compact('user','coach','date','time'))->render();
		return $html;
	}

	public function confirmSessionSubmit(Request2 $request)
	{
		return Redirect::back()->with('success','Oops! Booking facility will be in our next phase.');
		print_r($request->all()); die;
	}

	public function deleteAccount()
	{
		if(auth()->guard('user')->check() ):
			$userId = auth()->guard('user')->user()->id;
			$session = SessionModel::where('user_id',$userId)->where('status','upcoming')->get();
			if(isset($session) && count($session) > 0):
				return redirect('myprofile')->with("error","Can't delete the account until the book session is completed.");
			endif;
			$user = User::where('id', $userId)->first();
			$user->delete();
			$auth = auth()->guard('user');
			$auth->logout();
			return redirect('/login')->with('success', 'Account deleted successfully.');
		endif;
	}

	public function getTimeSlotByDay(Request2 $request){
		$date = date('Y-m-d',strtotime($request->date));
		$coachID = $request->coachID;
		$AvailabilityDates = AvailabilityDate::where('coach_id', $coachID)->where('date',$date)->first();
		if(isset($AvailabilityDates) && !empty($AvailabilityDates)){
			$arr = $AvailabilityDates['time_slots'];	
		}else{
			$arr = '';
		}
		
		$getunavailability = UnAvailabilityDate::where('coach_id',$coachID)->where('date',$date)->where('type','1')->first();

		$getbooking = SessionModel::where('coach_id',$coachID)->where('date',$date)->where('status','upcoming')->get();

		/*if(isset($getunavailability) && !empty($getunavailability)){
			$unavailable = $getunavailability['time_slots'];
			foreach ($unavailable as $key => $value) {
				if (($key = array_search($value, $arr)) !== false) {
					unset($arr[$key]);
				}
			}
			$dates = $arr;
		}else{
			$dates = $arr;
		}*/
		if(isset($getbooking) && !empty($getbooking)){
			foreach ($getbooking as $key => $value) {
				if (($key = array_search($value->time, $arr)) !== false) {
					unset($arr[$key]);
				}
			}
			$dates = $arr;
		}
		$html='<div class="timeslot" id="timeslot_div"><select name="timeslot" id="timeslot_select" class="form-select">';
		$html .= '<option value="">Select timeslot</option>';
		foreach($dates as $key =>$timeslot)
		{
			$html .= '<option value="'.$timeslot.'">'.$timeslot.'</option>';
		}
		$html .='</select></div>';
		$arr = array("success"=>"true","html"=>$html,"message"=> "");
        return response()->json($arr);
	}
}