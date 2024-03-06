<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\Models\VerificationCodeAdmin;

class AdminWeb
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
            $verificationCodeAdmin = VerificationCodeAdmin::where('user_id', auth()->guard('admin')->user()->id)->first();
            if($verificationCodeAdmin && $now->isAfter($verificationCodeAdmin->expire_at)):
                return $next($request);
            endif;
        }
        return $next($request);
    }
}
