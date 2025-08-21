<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class checkStudent
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
        if(Auth::check())
        {
            if(Auth::user()->role_id == 3)
            {
                // Check if user and school are active
                if(Auth::user()->status == 1 && Auth::user()->school && Auth::user()->school->status == 1)
                {
                    return $next($request);
                }
                else
                {
                    if(!Auth::user()->school || Auth::user()->school->status != 1)
                    {
                        return response()->view('error.school_blocked');
                    }
                    else
                    {
                        return response()->view('error.user_blocked');
                    }
                }
            }
        }
        return redirect('/login');
    }
}
