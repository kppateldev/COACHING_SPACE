<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Session;
use Carbon\Carbon;
use App\Models\VerificationCodeAdmin;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

         if(auth()->guard('admin')->check())
        {
            $now = Carbon::now();
            $verificationCodeAdmin = VerificationCodeAdmin::where('user_id', auth()->guard('admin')->user()->id)->whereNotNull('otp')->first();
            if($verificationCodeAdmin):
                return redirect('admin/otp-verification');
            endif;
        }
        //return $next($request);
        $coach_arr = array('admin/organizations','admin/organizations/create','admin/organizations/edit/*','admin/users','admin/users/create','admin/users/edit/*','admin/email_header_template','admin/email_header_template/create','admin/email_header_template/edit/*','admin/email_footer_template','admin/email_footer_template/create','admin/email_footer_template/edit/*','admin/email_templates','admin/email_templates/create','admin/email_templates/edit/*','admin/reviews','admin/reviews/create','admin/reviews/edit/*','admin/coaching_levels','admin/coaching_levels/create','admin/coaching_levels/edit/*','admin/strengths','admin/strengths/create','admin/strengths/edit/*','admin/departments','admin/departments/create','admin/departments/edit/*','admin/site-settings');
        if(auth()->guard('admin')->check()){
            if(auth()->guard('admin')->user()->user_type == "2" && in_array(\Route::getCurrentRoute()->uri(),$coach_arr)){
                return redirect('admin')->with('error','You\'re not authenticated to access this page.');
            }else{
                return $next($request);
            }
        }
        return redirect(route('admin.login'));
    }
}
