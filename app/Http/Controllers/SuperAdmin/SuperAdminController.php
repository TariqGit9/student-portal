<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolInformation;
use App\Models\User;
use App\Models\UserDetails\TeacherDetails;
use App\Models\UserDetails\StudentDetails;
use App\Models\UserDetails\AdminDetails;
//files Images
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\SchoolSession;
use File;
use Auth;
use Mail;

//datatables
use DataTables;

class SuperAdminController extends Controller
{
    public function superAdmin()
    {
        return view('super-admin.dashboard.index');
    }
    public function allSchools()
    {
       
        return view('super-admin.managment.index');
    }
    public function getSchools()
    {
       
        $data = SchoolInformation::all();
      
        return DataTables::of($data)
        ->addColumn('action', function ($data) {
                if($data->status==0){
                    $button = '<a href="#" class="btn btn-danger btn-sm   toggle_block_data"title=" Click to unblock"  data-status="1"  data-id="' . $data->id . '"><i class="fa fa-times"></i></a>&nbsp;&nbsp;';  

                }else{
                    $button = '<a href="#" class="btn btn-success btn-sm   toggle_block_data"title=" Click to block"  data-status="0"  data-id="' . $data->id . '"><i class="fa fa-check"></i></a>&nbsp;&nbsp;';  

                }
                $button .= '<a href="#" class="btn btn-info btn-sm  edit_data"title="Edit" data-name= "' . $data->name . '" data-phone="' . $data->phone . '" data-phone2="' . $data->phone2 . '" data-email="' . $data->email . '" data-abbreviation="' . $data->abbreviation . '" data-avatar="' . $data->avatar . '" data-address="' . $data->address . '" data-id="' . $data->id . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-secondary btn-sm   view_all_school_users"title=" View School Users"  data-status="0"  data-id="' . $data->id . '"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;'; 
                $button .= '<a href="#" class="btn btn-warning btn-sm   view_all_school_sessions"title=" School Sessions"  data-status="0"  data-id="' . $data->id . '"><i class="fa fa-calendar"></i></a>&nbsp;&nbsp;';   
                return $button;
        })
        ->addColumn('name', function ($data) {
            if ($data->name === null) {
                $text = "Not Available";
                return $text;
            } else {
                $text = $data->name.'('. $data->abbreviation.')';
                return $text;
            }
        })
        ->addColumn('email', function ($data) {
            if ($data->email === null) {
                $text = "Not Available";
                return $text;
            } else {
                $text = $data->email;
                return $text;
            }
        })
        ->addColumn('phone', function ($data) {
            if ($data->phone === null) {
                $text = "Not Available";
                return $text;
            } else {
                $text ="<div > <p>". $data->phone."</p> <p> ".$data->phone2."<div>";
                return $text;
            }
        })
        ->addColumn('unique_id', function ($data) {
            if ($data->school_unique_id === null) {
                $text = "Not Available";
                return $text;
            } else {
                $text = $data->school_unique_id;
                return $text;
            }
        })
        ->addColumn('image', function ($data) {
         
            $image = '<img src="' . asset("uploads/school_avatars/" . $data->avatar) . '" alt="logo" width="50" height="50">';
            return $image;
        })
            ->rawColumns(['action','address','image','name','phone','email','unique_id'])
            ->make(true);
    }
    public function getSchoolDetail(Request $request)
    {
   
        $school_info = SchoolInformation::find($request->id);
        $details=$school_info->details;
        $address=$school_info->address;
        if( $details == null){
            $details="Not Available";
        }
        if( $address == null){
            $address="Not Available";
        }
        return response()->json([
            'address' =>$address,
            'details' =>$details,
        ], 200);
     
    }
    public function addSchool(Request $request)
    { 
        $filename="default.webp";
        if($request->hasFile('image')){
            if(@is_array(getimagesize($request->image))){
                $time = time();
                $file=$request->image;
                $extension = $file->getClientOriginalExtension();
                $filename = $time."school_avatar" . '.' . $extension;
                $resized_image = Image::make($file)->resize(200, 200)->encode($extension);
              
                Storage::disk(config('filesystems.default'))
                ->put('school_avatars/' . $filename, $resized_image);

            }
            else{
                return response()->json([
                    'success' => false,
                    'error' => "Not a Image.",
                ]);

            }
        }
 
      //  dd($request->all());
     // where('email', $request->email) ->or
        if($request->email){
            $school = SchoolInformation::where('email', $request->email)->first();
        }
       
      
       if( $school){
            if ($school->email==$request->email) {
                return response()->json([
                    'success' => false,
                    'error' => "Email already Exists.",
                ]);
            }
        }
        $school = SchoolInformation::create(
            [
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $filename,
            'abbreviation' => $request->abbreviation,
            'school_unique_id' => time(),
            'phone' =>  $request->phone,
            'phone2' =>  $request->phone2,
            'address' =>  $request->address,
            'details' => $request->school_details,
            'ip_address' => $request->ip(),
        ]);
  
        return response()->json([
            'success' => true,
            'result' => 'Added successfully',
        ], 200);
    }
    public function editSchool(Request $request)
    {
    
        $school = SchoolInformation::find($request->edit_id);
       // dd($request->all(), $school->avatar);
        $oldfile =$school->avatar;
        $filename =$school->avatar;
        if($request->hasFile('edit_image')){
            if(@is_array(getimagesize($request->edit_image))){
                $time = time();
                $file=$request->edit_image;
                $extension = $file->getClientOriginalExtension();
                $filename = $time."school_avatar" . '.' . $extension;
                $resized_image = Image::make($file)->resize(200, 200)->encode($extension);
              
                Storage::disk(config('filesystems.default'))
                ->put('school_avatars/' . $filename, $resized_image);
                if($school->avatar !="default.webp"){

                    $oldfileName = 'school_avatars/' . $oldfile;
                    if (Storage::exists($oldfileName)) {
                   
                        Storage::delete($oldfileName);
                    }
                }
            }
            else{
                return response()->json([
                    'success' => false,
                    'error' => "Not a Image.",
                ]);

            }
        }
       
        $school->name= $request->edit_name;
        $school->email= $request->edit_email;
        $school->abbreviation= $request->edit_abbreviation;
        $school->phone= $request->edit_phone;
        $school->phone2= $request->edit_phone2;
        $school->address= $request->edit_address;
        $school->details= $request->edit_details;
        $school->avatar= $filename;
        $school->save();

        return response()->json([
            'success' => true,
            'result' => 'Edit successfully',
        ], 200);
    }

    public function changeSchoolStatus(Request $request)
    {
        $school = SchoolInformation::find($request->id);
        $school->status= $request->status;
        $school->save();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
    public function allSchoolUsers(Request $request)
    {
        if(!$request->school_id){
            return view('super-admin.managment.index');
        }
        $school_id = $request->school_id;
        $school = SchoolInformation::find($request->school_id);
        return view('super-admin.managment.school-users', compact('school_id','school'));
    }
    public function getSchoolUsers(Request $request)
    {
      
        $role_id=$request->role_id;
        $data = User::where([['role_id',$request->role_id],['school_id',$request->school_id]])->get();
        $user_details=null;
        $picture= '';
        if($data->first() !=null){
            if($data[0]->role_id==1){
                if($data[0]->admin_details){
                    $user_details='admin_details';
                }else{
                    $user_details=null;
                }
                $picture= 'admin';
            }else if($data[0]->role_id==2){
                
                $user_details='teacher_details';
                $picture= 'teacher';
            }else if($data[0]->role_id==3){
                $user_details='student_details';
                $picture= 'student';
            }
        }
     
        
        
        return DataTables::of($data)
        ->addColumn('action', function ($data) use ( $user_details){
                
            if($data->status==0){
                $button = '<a href="#" class="btn btn-danger btn-sm   toggle_block_data"title=" Click to unblock"  data-status="1"  data-id="' . $data->id . '"><i class="fa fa-times"></i></a>&nbsp;&nbsp;';  

            }else{
                $button = '<a href="#" class="btn btn-success btn-sm   toggle_block_data"title=" Click to block"  data-status="0"  data-id="' . $data->id . '"><i class="fa fa-check"></i></a>&nbsp;&nbsp;';  

            }
        
                return $button;
                
        })
        ->addColumn('image', function ($data)  use ( $user_details , $picture) {
                $image = '<img src="' . asset("uploads/".$picture."_avatars/" . $data->avatar) . '" alt="logo" width="50" height="50">';
                return $image;
        })
        ->addColumn('phone', function ($data)  use ( $user_details) {
        
                if($data->$user_details){
                  
                    if($data->$user_details->phone){
                        $phone = $data->$user_details->phone;
                    }
                    else{
                        $phone ='N/A'; 
                    }
                }else{
                    $phone ='N/A'; 
                }
         
                return $phone;
       

        })
        ->addColumn('email', function ($data)  use ( $user_details) {
         
           if($data->email){
            $email = $data->email;
           }else{
            $email = 'N/A';
           }
            return $email;
       

        })

            ->rawColumns([ 'action','image','phone','email'])
            ->make(true);
    }
    public function getUserDetails(Request $request)
    {
        $data = User::find($request->id);
        if( $data->role_id==1){
            if($data->admin_details){
                $html ='<strong >Address Line</strong >: '.$data->admin_details->address_line_main;
                if($data->admin_details->address_line_secondary){
                    $html .='<br><strong > Address Line 2 </strong >: '.$data->admin_details->address_line_secondary;
                }
                if($data->admin_details->emergency_phone){
                    $html .='<br><strong > Emergency Phone </strong >: '.$data->admin_details->emergency_phone;
                }
            }else{
                $html ='Address not available';
            }
        }
        else if( $data->role_id==2){
            $html ='<strong >Address Line</strong >: '.$data->teacher_details->address_line_main;
            if($data->teacher_details->address_line_secondary){
                $html .='<br><strong > Address Line 2 </strong >: '.$data->teacher_details->address_line_secondary;
            }
            if($data->teacher_details->emergency_phone){
                $html .='<br><strong > Emergency Phone </strong >: '.$data->teacher_details->emergency_phone;
            }
        }  
        else if( $data->role_id==3){
            $html ='<strong >Address Line</strong >: '.$data->student_details->address_line_main;
            if($data->student_details->address_line_secondary){
                $html .='<br><strong > Address Line 2 </strong >: '.$data->student_details->address_line_secondary;
            }
            if($data->student_details->emergency_phone){
                $html .='<br><strong > Emergency Phone </strong >: '.$data->student_details->emergency_phone;
            }
        }
        return response()->json([
            'success' => true,
            'html' => $html,
        ], 200);
    }
    public function changeUserStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status= $request->status;
        $user->save();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
    public function allSchoolSessions(Request $request)
    {
        if(!$request->school_id){
            return view('super-admin.managment.index');
        }
        $school_id = $request->school_id;
        $school = SchoolInformation::find($request->school_id);
        return view('super-admin.managment.school-session', compact('school_id','school'));
    }
    public function getSchoolSessions(Request $request)
    {
        $data = SchoolSession::where('school_id',$request->school_id)->orderBy('id', 'DESC')->get();

        return DataTables::of($data)
        ->addColumn('action', function ($data){
            if($data->status==0){
                $button = '<a href="#" class="btn btn-danger btn-sm   toggle_block_data"title=" Click to open"  data-status="1"  data-id="' . $data->id . '"><i class="fa fa-times"></i></a>&nbsp;&nbsp;';  
            }else{
                $button = '<a href="#" class="btn btn-success btn-sm   toggle_block_data"title=" Click to close"  data-status="0"  data-id="' . $data->id . '"><i class="fa fa-check"></i></a>&nbsp;&nbsp;';  
            }
        //  $button .= '<a href="#" class="btn btn-info btn-sm  edit_data"title="Edit" data-name= "' . $data->name . '" data-id="' . $data->id . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
            return $button;
        })
        ->addColumn('name', function ($data)  {
            $name =$data->name;
            return $name;
        })
        ->addColumn('status', function ($data)  {
            if($data->status==0){
                return '<a href="#" class="btn btn-danger btn-sm   "title=" Click to open"   >Not active</a>&nbsp;&nbsp;';  
            }else{
                return  '<a href="#" class="btn btn-success btn-sm   "title=" Click to close" >Active</a>&nbsp;&nbsp;';  
            }
        })
        ->rawColumns([ 'action','name','status'])
        ->make(true);
    }
    public function addSessions(Request $request)
    {
       
        if($request->status==1){
            $old_sessions=SchoolSession::where('school_id',$request->school_id)->update(['status'=>0]);
        }
        $session = SchoolSession::create(
        [
            'name' => $request->name,
            'status' =>$request->status,
            'school_id' =>$request->school_id,
        ]);
  
        return response()->json([
            'success' => true,
        ], 200);
    }

    // 
    public function changeSchoolSession(Request $request)
    {
        if($request->status==1){
            $old_sessions=SchoolSession::where('school_id',$request->school_id)->update(['status'=>0]);
        }
        $session=SchoolSession::find($request->id);
        $session->status=$request->status;
        $session->save();
        return response()->json([
            'success' => true,
        ], 200);
    }
}
