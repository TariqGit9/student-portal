<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\SchoolInformation;

class checkAdmin
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
            if(Auth::user()->role_id == 1)
            {
                if(Auth::user()->school->status==1 && Auth::user()->status==1  ){
                  
                    if (! Session::has('school_id'))
                    {
                        Session::put('school_id', Auth::user()->school_id);
                        $main_school_id = Session::get('school_id');
                        $data = SchoolInformation::where('id' ,Auth::user()->school_id )->orWhere('parent_school_id', '=',Auth::user()->school_id )->get();
                        Session::put('all_branches', $data);
                       
                    }
               
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
        }
        return redirect('/login');
    }
}
