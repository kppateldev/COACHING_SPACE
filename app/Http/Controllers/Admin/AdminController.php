<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\Models\User;
use App\Models\Organization;
use App\Models\Session;
use App\Models\AvailabilityDate;
use App\Models\UnAvailabilityDate;
use App\Models\Coach;
use App\Models\Admin;
use Artisan;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;

class AdminController extends Controller
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

    public function dashboard()
    {
        $data = array();
        
        //start week data
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');
        //end week data
        $weeklyavailableData = AvailabilityDate::whereBetween('date',[$weekStartDate,$weekEndDate])->get();
        
        $data['weekStartDate'] = $weekStartDate;
        $data['weekEndDate'] = $weekEndDate;

        $total_coach = Coach::where('is_active',1)->withTrashed()->get();
        $countCoach = count($total_coach);
        $weekDates = getBetweenDates($weekStartDate,$weekEndDate);
        $slots = get_custom_slot(45);
        $daysCount = '7';
        
        $tempArray = array();
        $countArr = array();
        if(isset($weeklyavailableData) && count($weeklyavailableData) > 0){
            foreach ($weeklyavailableData as $key => $val) {
                array_push($tempArray, $val->time_slots);
            }
            foreach ($tempArray as $key => $value) {
                $countArr[] = count($value);

            }
            $total = array_sum($countArr);
        }else{
            $total = 0;
        }
        
        //Weekly Sessions
        $data['weekly_book_sessions'] = Session::where('status','upcoming')->whereBetween('date',[$weekStartDate,$weekEndDate])->count();

        if(isset($total) && !empty($total)){
            $data['total_weekly_sessions'] = $total - $data['weekly_book_sessions'];
        }else{
            $data['total_weekly_sessions'] = $total;
        }


        //All Available Sessions
        $availableData = AvailabilityDate::where('status','available')->get();
        $tempArray1 = array();
        $countArr1 = array();
        if(isset($availableData) && count($availableData) > 0){
            foreach ($availableData as $key => $val) {
                array_push($tempArray1, $val->time_slots);    
            }
            foreach ($tempArray1 as $key => $value) {
                $countArr1[] = count($value);

            }
            $total1 = array_sum($countArr1);
        }else{
            $total1 = 0;
        }
        
        $data['total_book_sessions'] = Session::where('status','upcoming')->count();
        if(isset($total1) && !empty($total1)){
            $data['total_available_sessions'] = $total1 - $data['total_book_sessions'];
        }else{
            $data['total_available_sessions'] = $total1;
        }

        //end

        $data['total_users'] = User::where('is_active',1)->count();
        $data['total_organizations'] = Organization::where('status',1)->count();
        
        $adminId = 0;
        if( auth()->guard('admin')->check() ){
            $adminId = Auth::guard('admin')->user()->id;
        }
        if(isset($adminId) && $adminId == '1'){
            $data['total_coach'] = Coach::where('is_active',1)->count();
        }else{
            $data['total_coach'] = Coach::where('is_active',1)->where('created_by','2')->count();
        }
        return view('admin.dashboard', $data);
    }

    public function logout()
    {
        $auth = auth()->guard('admin');
        $auth->logout();
        return Redirect::route('admin.login');
    }

    public function cache_clear()
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');

        $notification = array(
            'message' => 'Website Cache cleared successfully!.',
            'alert-type' => 'success'
        );
        // die('sadasd');
        return Redirect::back()->with($notification);
    }
    public function userSettings() {
        $adminId = 0;
        if( auth()->guard('admin')->check() ){
            $adminId = Auth::guard('admin')->user()->id;
            $user = Admin::where('id',$adminId)->first();
            return view('admin.user-settings', $user);
        }
        return Redirect::route('admin.login');
    }

    public function updateSettings($type, Request $request)
    {
        $adminId = 0;
        if( auth()->guard('admin')->check() ){
            $adminId = Auth::guard('admin')->user()->id;
        }
        $user = Admin::where('id',$adminId)->first();

        $input=$request->all();
        if($type === 'profile')
        {
            $rules['name']  = "required|string|max:30|min:3";
        }
        else 
        {
          $rules['current_password']        = "required|min:16";
          $rules['new_password']            = "required|min:16|regex:/^.*(?=.{9,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[-@_$!#%]).*$/|confirmed|different:current_password";
          $rules['new_password_confirmation']   = "required|min:16";
          }
          $errorMsg     = "Oops ! Please fill the required fields.";
          if($type === 'password' && $input['current_password'] != null) {
              if(!Hash::check( $input['current_password'], $user->password )) {
                $errorMsg       = "Oops ! Your current password does not match.";
            }
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
          return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else 
        {
            $output['status']         = 'success';
            if($type === 'profile') {
            $name = $input['name'];
            Admin::where('id',$adminId)->update(['name'=>$input['name']]);
            $output['msg']              = "Admin settings updated successfully.";
            }
            else {
            $newHashedPassword = Hash::make($input['new_password']);
            Admin::where('id',$adminId)->update(['password'=>$newHashedPassword]);
            $output['msg'] = "Password updated successfully.";
            //$output['url'] = route('admin.logout');
            }
            $output['msgHead']      = "Success ! ";
            $output['msgType']      = "success";
            $output['slideToTop']     = true;
            return response()->json($output);
        }
    }

}
