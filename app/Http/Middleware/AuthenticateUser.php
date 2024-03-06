<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session,Lang;
use App\Models\User;
use Carbon\Carbon;
use App\Models\VerificationCode;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        if ( Auth::guard('user')->check() ) {
            User::where('id', auth()->guard('user')->user()->id)->update(['last_seen' => Carbon::now()]);
            $clientIP = \Request::getClientIp(true);
            User::where('id', auth()->guard('user')->user()->id)->update(['ip_address' => $clientIP]);
            $verificationCode = VerificationCode::where('user_id', auth()->guard('user')->user()->id)->first();

            $now = Carbon::now();
            
            //check if account deactive by Admin.
            if(Auth::guard('user')->user()->is_active != '1'):
                auth()->guard('user')->logout();
				return redirect('login')->with( 'error', Lang::get('message.inactiveAccount'));
            elseif($verificationCode && $now->isBefore($verificationCode->expire_at)):
                return redirect('otp-verification');
            elseif(auth()->guard('user')->user()->first_time_status == 0 && !\Request::is('create-password')):
                return redirect('change-password');
            elseif(auth()->guard('user')->user()->first_time_status == 1 && (!\Request::is('video') && !\Request::is('update-video'))):
                return redirect('video');
            elseif(auth()->guard('user')->user()->first_time_status == 2 && (!\Request::is('agreement') && !\Request::is('update-agreement'))):
                return redirect('agreement');
            else:
        	   return $next($request);
            endif;
        }

        //start 23112022
        if(Auth::guard('admin')->check()){
            return redirect('admin/login');
        }
        //end 23112022

		Session::put('url.intended', url()->current()); // redirect intended url

		Session::put('backUrl', url()->current() );
		
		return redirect('login')->with([
			'error' => 'You must login to enter the platform.',
		]);

    }
}
