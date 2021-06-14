<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class checkTeacher
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
        
        if(Auth::user()->role_id == 2)
        {
            if(Auth::user()->school->status==1 && Auth::user()->status==1  ){
                return $next($request);
            }else{
                if(Auth::user()->school->status==1){
                return response()->view('error.user_blocked');
                }
                else{
                    return response()->view('error.school_blocked');
                }
            }
        }
        return redirect('/login');
    }
}
