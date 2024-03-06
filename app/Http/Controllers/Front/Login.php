<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\LoginRequest;
use Request, Lang, Str, Hash, Auth, Session, Response,Carbon\Carbon;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use App\Models\Admin as AdminModel;
use App\Models\VerificationCode;
//use App\Http\Requests\Request;

class Login extends Controller
{
    private function checkLoginRedirect()
    {
    	return redirect('myprofile');
    	
    }
    protected function login(){
    	if ( auth()->guard('user')->check() ):
            return $this->checkLoginRedirect();
		endif;
		$_meta_title = 'Login';
		$_meta_keyword = 'Login';
		$_meta_desc = 'Login';
		$pass_array = array(
			'_meta_title' => $_meta_title,
			'_meta_keyword' => $_meta_keyword,
			'_meta_desc' => $_meta_desc,
		);
		return view( 'front/login', $pass_array );
	}

	protected function postLogin(LoginRequest $request){
		//start 23112022
		if(auth()->guard('admin')){
			$auth = auth()->guard('admin');
			$auth->logout();
		}
		//end 23112022
		$remember_me = $request->only('remember') ? true : false;
		if($remember_me == TRUE){
			setcookie('cs_email',$request->post('email'));
			setcookie('cs_password',$request->post('password'));
			setcookie('cs_remember',$request->post('remember'));
		}else{
			setcookie('cs_email','');
			setcookie('cs_password','');
			setcookie('cs_remember','');
		}   
		$email = $request->post('email');
		$auth = auth()->guard('user');
		if ($auth->attempt($request->only('email', 'password'), $remember_me)):
			if (auth()->guard('user')->user()->email_verified_at == NULL):
				Auth::guard('user')->logout();
				return redirect('verification-email/'.Crypt::encryptString($email))->with( 'error', 'Please verify your email address in order to access the Coaching Space platform.');
			endif;
			if (auth()->guard('user')->user()->status == "2"):
				Auth::guard('user')->logout();
				return redirect('login')->with( 'error', 'Sorry, your account has been placed on hold. You should have received an email detailing why. Please reach out to us via the contact us page if you have further questions.');
			endif;
			# Generate An OTP
			$verificationCode = $this->generateOtp();
			$message = "<p>Your Verification code to login is - <strong>".$verificationCode->otp."</strong></p>";
			$message.= "<p>The Verification code  is expired after <strong>10 minutes</strong>.</p>";
        	# Return With OTP 

			$userSet = UserModel::where('id',auth()->guard('user')->user()->id)->first();
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

			return redirect('otp-verification');

			if (auth()->guard('user')->user()->first_time_status == 0):
				return redirect('change-password');
			elseif(auth()->guard('user')->user()->first_time_status == 1):
				return redirect('video');
			elseif(auth()->guard('user')->user()->first_time_status == 2):
				return redirect('agreement');
			elseif(auth()->guard('user')->user()->first_time_status == 3):
				return redirect('dashboard');
			endif;
		else:
			return redirect('login')->with( 'error', Lang::get('message.invalidCredentials') );
		endif;
	}

	public function generateOtp()
    {
    	# User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', auth()->guard('user')->user()->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode){
        	$verificationCode->update([
                'otp' => rand(123456, 999999),
	            'expire_at' => Carbon::now()->addMinutes(10)
            ]);
            return $verificationCode;
        }else{
        	// Create a New OTP
	        return VerificationCode::create([
	            'user_id' => auth()->guard('user')->user()->id,
	            'otp' => rand(123456, 999999),
	            'expire_at' => Carbon::now()->addMinutes(10)
	        ]);
	        return $verificationCode;
        }

    }

    public function otpVerification()
    {
    	if (!auth()->guard('user')->check()):
			return redirect('login');
		endif;
    	$user_id = auth()->guard('user')->user()->id;
    	$verificationCode = VerificationCode::where('user_id', auth()->guard('user')->user()->id)->first();
    	$now = Carbon::now();
        if($verificationCode && $now->isafter($verificationCode->expire_at)){
			$auth = auth()->guard('user');
			$auth->logout();
        	return redirect('login')->with('error', 'Your OTP has been expired. Please login again.');
    	}else{
        	return view('front/otp-verification', compact('user_id'));
    	}
    }

    public function loginWithOtp()
    {
    	if (!auth()->guard('user')->check()):
			return redirect('login');
		endif;
    	$post_data = Request::all();
    	#Validation Logic
        $verificationCode   = VerificationCode::where('user_id', $post_data['user_id'])->where('otp', $post_data['otp'])->first();
        
        $now = Carbon::now();
        if (!$verificationCode) {
        	return redirect()->back()->with('error', 'Your OTP is not correct.');
        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
        	$auth = auth()->guard('user');
			$auth->logout();
        	return redirect('login')->with('error', 'Your OTP has been expired. Please login again.');
        }
        $user = UserModel::whereId($post_data['user_id'])->first();
        if($user){
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);
            return redirect('/dashboard');
        }
        $auth = auth()->guard('user');
		$auth->logout();
        return redirect('login')->with('error', 'Your Otp is not correct.');
    }

	protected function Logout() {
		$auth = auth()->guard('user');
		$auth->logout();
		return redirect('/login')->with('success', 'You have been logged out.');
	}

	protected function getForgotPassword() {
		
		if(auth()->guard('user')->check()):
            return $this->checkLoginRedirect();
        endif;
		$pass_array = array(
			'_meta_title' => "Forgot Password",
			'_meta_keyword' => "Forgot Password",
			'_meta_desc' => "Forgot Password",
		);
        return view('front/forgotpassword', $pass_array);
	}

	protected function postForgotPassword() {
		$post_data = Request::all();
		if (auth()->guard('user')->check()):
            return $this->checkLoginRedirect();
		endif;
		$email = $post_data['email'];
		$data = UserModel::where('email',$email)->first();
        if(isset($data) && !empty($data)):
			$update=array('reset_password_token'=>md5($data->id));
			$link=url("new-password").'/'.$update['reset_password_token'];
			/* Mail send start */
			$email = $data->email;
			$name = $data->first_name.' '.$data->last_name;
			$new_mail_data['NAME']		=	$name;
			$new_mail_data['LINK']		=	$link;
			$new_mail_data['LINK_1']	=	url('contact-us');
			$new_email_data = _email_template_content("4",$new_mail_data);
			// << Email Template Data
			$new_subject = isset( $new_email_data[0] ) ? $new_email_data[0] : '';
			$new_content = $new_email_data[1];
			// From, To and Send Email
			$new_fromdata = ['email' => $email,'name' => $name];
			$new_mailids = [$email => $name];
			_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
			/* Mail send end */
			UserModel::find($data->id)->update($update);

			return redirect('forgotpassword')->with('success', Lang::get('message.checkEmail'));
		else:
			return redirect('forgotpassword')->with('error', Lang::get('message.emailNotExist'));
		endif;
	}

	protected function newPassword($id) {
		$data = Request::all();
		if (auth()->guard('user')->check()):
			// return redirect('myprofile');
            return $this->checkLoginRedirect();
		endif;
		$data = UserModel::where("reset_password_token",$id)->first();
		if(isset($data) && !empty($data)):
			$_data=array('id'=>$id,'successlink'=>1);
	        return view( 'front/new-password', $_data );
		else:
			$_data=array('id'=>$id,'successlink'=>0);
	        return view( 'front/new-password', $_data);
		endif;
	}

	protected function postConfirmNewPassword() {
		$post_data = Request::all();
		$data = UserModel::where("reset_password_token",$post_data['id'])->first();
		if(isset($data) && !empty($data)):
			$update=array('reset_password_token'=>"",'password'=>Hash::make($post_data['password']));
			UserModel::find($data->id)->update($update);
			$_data=array('id'=>$post_data['id'],'success'=>1);
			return redirect('login')->with('success','Your password has been successfully updated.');
		else:
			$_data=array('id'=>$post_data['id'],'success'=>0);
			return redirect('new-password/'.$post_data['id']);				
		endif;
	}

    protected function verifyEmail(){
        $data = Request::all();
        $email_count =  UserModel::where('email', $data['email'])->count();
        if($email_count > 0):
            return json_encode(false);
        else:
            return json_encode(true);
        endif;
    }

    protected function verifyPassword(){
        $data = Request::all();
        $user = UserModel::where('id',auth()->guard('user')->user()->id)->first();
        if(!Hash::check($data['password'], $user->password)):
            return json_encode(false);
        else:
            return json_encode(true);
        endif;
    }

    public function changepassword(){
    	if (!auth()->guard('user')->check()):
			return redirect('login');
		endif;
    	if (auth()->guard('user')->check() && auth()->guard('user')->user()->first_time_status != 0):
			return redirect('dashboard');
		endif;
    	$_meta_title = 'Change Password';
		$_meta_keyword = 'Change Password';
		$_meta_desc = 'Change Password';
		$pass_array = array(
			'_meta_title' => $_meta_title,
			'_meta_keyword' => $_meta_keyword,
			'_meta_desc' => $_meta_desc,
		);
		return view( 'front/changepassword', $pass_array );
    }

    public function updatechangepassword(Request $request){
    	if (!auth()->guard('user')->check()):
			return redirect('login');
		endif;
    	$post_data = Request::all();
		$data = UserModel::where("id",auth()->guard('user')->user()->id)->first();
		if(isset($data) && !empty($data)):
			$update=array('first_time_status'=>"1",'password'=>Hash::make($post_data['password']));
			UserModel::find($data->id)->update($update);
			return redirect('/video')->with('success','Your password has been successfully updated.');
		else:
			return redirect('change-password/');				
		endif;
    }

    public function video(){
    	if (!auth()->guard('user')->check()):
			return redirect('login');
		endif;
    	if (auth()->guard('user')->check() && auth()->guard('user')->user()->first_time_status != 1):
			return redirect('dashboard');
		endif;
    	$_meta_title = 'Video';
		$_meta_keyword = 'Video';
		$_meta_desc = 'Video';
		$pass_array = array(
			'_meta_title' => $_meta_title,
			'_meta_keyword' => $_meta_keyword,
			'_meta_desc' => $_meta_desc,
		);
		return view( 'front/video', $pass_array );
    }

    public function updatevideo(){
    	if (!auth()->guard('user')->check()):
			return redirect('login');
		endif;
    	$data = UserModel::where("id",auth()->guard('user')->user()->id)->first();
		if(isset($data) && !empty($data)):
			$update=array('first_time_status'=>"2");
			UserModel::find($data->id)->update($update);
		endif;
		return redirect('/agreement');
    }

    public function agreement(){
    	if (!auth()->guard('user')->check()):
			return redirect('login');
		endif;
    	if (auth()->guard('user')->check() && auth()->guard('user')->user()->first_time_status != 2):
			return redirect('dashboard');
		endif;
    	$_meta_title = 'Agreement';
		$_meta_keyword = 'Agreement';
		$_meta_desc = 'Agreement';
		$pass_array = array(
			'_meta_title' => $_meta_title,
			'_meta_keyword' => $_meta_keyword,
			'_meta_desc' => $_meta_desc,
		);
		return view('front/agreement', $pass_array );
    }

    public function updateagreement(){
    	if (!auth()->guard('user')->check()):
			return redirect('login');
		endif;
		$data = UserModel::where("id",auth()->guard('user')->user()->id)->first();
		if(isset($data) && !empty($data) && $_GET['agree'] == 1):
			$update=array('first_time_status'=>"3");
			UserModel::find($data->id)->update($update);
		endif;
		return redirect('/dashboard');
    }

	/*protected function register()
	{
	if ( auth()->guard('user')->check() ):
	return $this->checkLoginRedirect();
	endif;
	$pass_array = array(
	'_meta_title' => "Register",
	'_meta_keyword' => "Register",
	'_meta_desc' => "Register",
	'states' => _states(),
	'specialities' => _specialities()
	);
	$states = _states();
	$specialities = _specialities();
	return view('front/register', $pass_array);
	}

	protected function postRegister(){
	try{
	$data = Request::all();
	unset($data['token']);
	unset($data['agree']);
	$email_count =  UserModel::where('email', $data['email'])->count();
	if($email_count > 0):
	return redirect('register')->with('error', 'Email already registred');
	endif;
	$data['password'] = Hash::make( $data['password'] );
	$slug = Str::slug($data['first_name'].' '.$data['last_name']);
	$cnt = UserModel::where("slug",'like',$slug."%")->count();
	$data['slug'] = $slug;
	if($cnt > 0):
	$result = $slug."-".($cnt-1);
	$data['slug'] = ++$result;
	endif;
	$data['status'] = '1';
	UserModel::create($data);
	$encrypted = Crypt::encryptString($data['email']);
	$link=url("verification").'/'.$encrypted;
	$email = $data['email'];
	$name = $data['first_name'].' '.$data['last_name'];
	$new_mail_data['NAME']		=	$name;
	$new_mail_data['LINK']		=	$link;
	$new_email_data = _email_template_content("1",$new_mail_data);
	// << Email Template Data
	$new_subject = isset( $new_email_data[0] ) ? $new_email_data[0] : '';
	$new_content = $new_email_data[1];
	// From, To and Send Email
	$new_fromdata = ['email' => $email,'name' => $name];
	$new_mailids = [$email => $name];
	_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
	return view('front/verify-email')->with(['success' => 'Verification email resent successfully', 'token' => $encrypted]);
	} catch(\Exception $e){
	return redirect('register')->with('error', "Something went wrong");
	}
	}*/

    function verificationEmail( $token=null ){
		$link = "front/verify-email";
    	if($token):
	        $user = UserModel::where('email',Crypt::decryptString($token))->first();
	        if(!($user)):
	        	return redirect('login');
        	endif;
	        if(empty($user->email_verified_at)):
		    	$user->email_verified_at = Carbon::now();
		    	$user->save();
			else:
				return redirect('login')->with('error', 'Email already verified');
			endif;
			$link = "front/success-email-verification";
		else:
			return redirect('/')->with('error', 'Something went wrong');
		endif;
	        $_meta_title = 'Login';
			$_meta_keyword = 'Login';
			$_meta_desc = 'Login';
			$pass_array = array(
				'_meta_title' => $_meta_title,
				'_meta_keyword' => $_meta_keyword,
				'_meta_desc' => $_meta_desc
			);
	    return view( $link, $pass_array );
    }

    public function verificationEmailAfterLogin( $token ){
    	if($token):
	        $user = UserModel::where('email',Crypt::decryptString($token))->first();
	        if(!$user):
	       		return redirect('login');
	        endif;
		endif;
	        $_meta_title = 'Verification';
			$_meta_keyword = 'Verification';
			$_meta_desc = 'Verification';
			$pass_array = array(
				'_meta_title' => $_meta_title,
				'_meta_keyword' => $_meta_keyword,
				'_meta_desc' => $_meta_desc,
				'token' => $token
			);
	    return view( 'front/verify-email', $pass_array );
    }

    public function resendEmail(Request $request){
    	$data = Request::all();
	    $user = UserModel::where('email',Crypt::decryptString($data['token']))->first();
	    if ($user->email_verified_at != NULL):
			return redirect('login')->with( 'error', 'Email already verified');
		endif;
		$link=url("verification").'/'.$data['token'];
        $email = $user->email;
		$name = $user->first_name.' '.$user->last_name;
		$new_mail_data['NAME']		=	$name;
		$new_mail_data['LINK']		=	$link;
		$new_email_data = _email_template_content("1",$new_mail_data);
		// << Email Template Data
		$new_subject = isset( $new_email_data[0] ) ? $new_email_data[0] : '';
		$new_content = $new_email_data[1];
		// From, To and Send Email
		$new_fromdata = ['email' => $email,'name' => $name];
		$new_mailids = [$email => $name];
		_mail_send_general( $new_fromdata, $new_subject , $new_content , $new_mailids );
		return redirect('verification-email/'.$data['token'])->with( 'success', 'Verification email sent please check your inbox');
    }
} 

