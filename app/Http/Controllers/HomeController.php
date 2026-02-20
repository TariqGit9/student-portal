<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return redirect('/admin');
            } else if (Auth::user()->role_id == 2) {
                return redirect('/teacher');
            } else if (Auth::user()->role_id == 3) {
                return redirect('/student');
            } else if (Auth::user()->role_id == 4) {
                return redirect('/super-admin');
            }
        }

        return view('landing');
    }
    public function changeUserPassword(Request $request)
    {
        if (Hash::check($request->current_password,Auth::user()->password)) {

            $user = User::find(Auth::user()->id);
            $user->password =Hash::make($request->confirm_new_password) ;
            $user->save();
            return response()->json(['success'=>true, 'message' => 'Password Changed']);
        }
        else{
            return response()->json([
                'success' => false,
                'msg' => 'Your Current Password in wrong .',
            ], 200);
        }

    }
  
}
