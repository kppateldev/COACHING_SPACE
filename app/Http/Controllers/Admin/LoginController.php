<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
use App\Models\Admin;
use App\Models\VerificationCodeAdmin;
use Str;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Session;
use Carbon\Carbon;

class LoginController extends Controller
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

    public function login()
    {
      return view('admin.login');
    }
    public function loginPost(Request $request)
    {
        //start 23112022
        if(auth()->guard('user')){
          $auth = auth()->guard('user');
          $auth->logout();
        }
        //end 23112022
        // echo print_r($request->all()); die;
        $rules['email']             = "required|email";
        $rules['password']      = "required";
        $errorMsg       = "Oops ! Please check form fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else {
            $result = Admin::where('email',$request->email)->first();
            if($result!=null){
                $email              = $request->get('email');
                $password           = $request->get('password');
                if($request->get('remember')){
                    $remember = true;
                }
                else {
                    $remember = false;
                }

                //=========== Register User Credentials ============//
                $loginCredentials   =[
                    'email'         => $request->get('email'),
                    'password'      => $request->get('password')
                ];
                // echo "Before authenticate"; die;
                $auth = auth()->guard('admin');
                if($auth->attempt($loginCredentials, $remember)) {
                    $urlIntended = Session::get('url.intended');
                    Session::forget('url.intended');
                    # Generate An OTP
                    $verificationCode = $this->generateOtp();
                    $message = "<p>Your Verification code to login is - <strong>".$verificationCode->otp."</strong></p>";
                    $message.= "<p>The Verification code  is expired after <strong>10 minutes</strong>.</p>";
                    # Return With OTP 

                    $userSet = Admin::where('id',auth()->guard('admin')->user()->id)->first();
                        // Mail send start
                    $name = $userSet->name;
                    $email = $userSet->email;
                    $subject = "Login Verification Code";
                    $mailData['EMAIL'] = $email;
                    $mailData['NAME']= $name;
                    $mailData['MESSAGE'] = $message;
                    $mailData['NAME'] = $name;
                    $new_email_data = _email_template_content("33",$mailData);
                    $new_subject = $subject;
                    $new_content = $new_email_data[1];
                    $new_fromdata = ['email' => $email,'name' => $name];
                    $new_mailids = [$email => $name];
                    _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
                    $output['status']   = 'success';
                    $output['msg']      = "Your Verification code send to your registered email.";
                    $output['msgType']  = "success";
                    $output['slideToTop']   = true;
                    if(empty($urlIntended)){
                        $output['url']      = url('admin/otp-verification');
                    }else{
                        $output['url']      = $urlIntended;
                    }
                    return response()->json($output);
                }
                else {
                    return response()->json(['error_msg'=>"Sorry! Your login details is not correct, please enter correct email and password.",'slideToTop'=>'yes']);
                }

            }
            else {
                return response()->json(['error_msg'=>"Sorry! Your login details is not correct, please enter correct email and password.",'slideToTop'=>'yes']);
            }

        }

    }

    public function generateOtp()
    {
        if (!auth()->guard('admin')->check()):
            return redirect('admin/');
        endif;
        # User Does not Have Any Existing OTP
        $VerificationCodeAdmin = VerificationCodeAdmin::where('user_id', auth()->guard('admin')->user()->id)->latest()->first();
        $now = Carbon::now();
        if($VerificationCodeAdmin){
            $VerificationCodeAdmin->update([
                'otp' => rand(123456, 999999),
                'expire_at' => Carbon::now()->addMinutes(10)
            ]);
            return $VerificationCodeAdmin;
        }else{
            // Create a New OTP
            return VerificationCodeAdmin::create([
                'user_id' => auth()->guard('admin')->user()->id,
                'otp' => rand(123456, 999999),
                'expire_at' => Carbon::now()->addMinutes(10)
            ]);
            return $VerificationCodeAdmin;
        }

    }

    public function otpVerification()
    {
        if (!auth()->guard('admin')->check()):
            return redirect('admin/');
        endif;
        $user_id = auth()->guard('admin')->user()->id;
        $VerificationCodeAdmin = VerificationCodeAdmin::where('user_id', auth()->guard('admin')->user()->id)->first();
        $now = Carbon::now();
        if($VerificationCodeAdmin && $now->isafter($VerificationCodeAdmin->expire_at)){
            $auth = auth()->guard('admin');
            $auth->logout();
            return redirect('admin/login')->with('error', 'Your OTP has been expired. Please login again.');
        }else{
            return view('admin/otp-verification', compact('user_id'));
        }
    }

    public function loginWithOtp(Request $request)
    {
        if (!auth()->guard('admin')->check()):
            return redirect('admin/');
        endif;
        $post_data = $request->all();
        #Validation Logic
        $VerificationCodeAdmin   = VerificationCodeAdmin::where('user_id', $post_data['user_id'])->where('otp', $post_data['otp'])->first();
        $now = Carbon::now();
        if (!$VerificationCodeAdmin) {
            return redirect()->back()->with('error', 'Your OTP is not correct.');
        }elseif($VerificationCodeAdmin && $now->isAfter($VerificationCodeAdmin->expire_at)){
            $auth = auth()->guard('admin');
            $auth->logout();
            return redirect('login')->with('error', 'Your OTP has been expired. Please login again.');
        }
        $user = Admin::whereId($post_data['user_id'])->first();
        if($user){
            // Expire The OTP
            $VerificationCodeAdmin->update([
                'expire_at' => Carbon::now(),
                'otp' =>NULL
            ]);
            return redirect('admin/');
        }
        $auth = auth()->guard('admin');
        $auth->logout();
        return redirect('admin/login')->with('error', 'Your Otp is not correct.');
    }


    public function forgotPassword()
    {
      return view('admin.forgot-password');
    }

    public function forgotPasswordPost(Request $request)
    {
        $input=$request->all();
        $rules['email'] = "required|max:255|email|string";
        $errorMsg       = "Oops ! Please fill the required fields.";
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(['errorArray'=>$validator->errors(),'error_msg'=>$errorMsg,'slideToTop'=>'yes']);
        }
        else {

          $user = Admin::select('*')->where('email',$input['email'])->first();

          if($user) {
              $generatePassword = $this->get_password();
              $newHashedPassword = Hash::make($generatePassword);
              Admin::where('id',$user->id)->update(['password'=>$newHashedPassword]);


              // Mail send start
              $name = $user->name;
              $email = $user->email;
              $subject = "You Have Successfully Reset Your Password.";
              $message = "Dear admin your new password is: <b>".$generatePassword."</b>";      
              $mailData['SUBJECT'] = $subject;
              $mailData['EMAIL'] = $email;
              $mailData['NAME']= $name;
              $mailData['MESSAGE'] = $message;
              $mailData['NAME'] = $name;
              $new_email_data = _email_template_content("33",$mailData);
              $new_subject = $subject;
              $new_content = $new_email_data[1];
              $new_fromdata = ['email' => $email,'name' => $name];
              $new_mailids = [$email => $name];
              _mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );

          }
          else {
            return response()->json(['error_msg'=>'Sorry! Your email address is not registered.','slideToTop'=>'yes']);
          }

          $output['status']         = 'success';
          $output['msg']                = "You have mailed your new password Successfully.";
          //$output['msgHead']      = "Success ! ";
          $output['msgType']        = "success";
          $output['slideToTop']   = true;
          $output['resetform']    = true;
          return response()->json($output);
        }
    }

    function get_password($upper = 1, $lower = 12, $numeric = 2, $other = 1) { 
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

}
