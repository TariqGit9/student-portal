<?php

namespace App\Http\Controllers\Admin;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\ClassGrade;
use App\Models\User;
use App\Models\TeacherSubject;
use App\Models\UserDetails\TeacherDetails;
use App\Models\UserDetails\StudentDetails;
use App\Http\Controllers\Controller;
use App\Models\TeacherMailsOfStudent;
use App\Models\ResultType;
use App\Models\StudentMailsOfTeacher;
use App\Models\SchoolInformation;
use Session;

use App\Mail\RegisterTeacher;
use Mail;
//Request
use Illuminate\Http\Request;
//files Images
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use File;
use Auth;
//datatables
use DataTables;

//TeacherController

use App\Http\Controllers\Teacher\TeacherController;


class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard.index');
    }
    public function classes()
    {
      
        $grades = ClassGrade::where('school_id',Session::get('school_id'))->get();
        return view('admin.class.classes', compact('grades'));
       
    }
    public function addClass(Request $request)
    {
     
        $add_class = Classes::updateOrCreate(
            [
                'name' => $request->name,
                'grade_id' => $request->grade,
                'school_id' => Session::get('school_id'),
            ],
            [
                'name' => $request->name,
                'grade_id' => $request->grade,
                'school_id' => Session::get('school_id'),
            ]);
        return response()->json([
            'result' => 'Added successfully',
        ], 200);
    }
    public function editClass(Request $request)
    {
     
        $edit_class = Classes::find($request->editid);
        $edit_class->name = $request->editname;
        $edit_class->save();
        return response()->json([
            'result' => 'Edited successfully',
        ], 200);
    }
    public function deleteClass(Request $request)
    {
     
        $del_class = Classes::find($request->id);
        
        $del_class->delete();
        return response()->json([
            'result' => 'Deleted successfully',
        ], 200);
    }
    public function getClasses()
    {
        $number=0;
        $classes = Classes::where('school_id',Session::get('school_id'))->get();
        return DataTables::of($classes)
        ->addColumn('action', function ($classes) {
                
                // $button = '<a href="#" class="btn btn-info btn-sm  deleteClass"title="Edit" data-id=' . $classes->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                // $button = '<a href="#" class="btn btn-danger btn-sm  deleteClass"title="Delete" data-id=' . $classes->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
                $button = '<a href="'.route("class-subjects", $classes->id).'" class="btn btn-info btn-sm "title="Class Subjects "><i class="fa fa-book-open"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="'.route("class-teachers", $classes->id).'" class="btn btn-warning btn-sm "title="Class Teachers "><i class="fa fa-pen"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="'.route("class-students", $classes->id).'" class="btn btn-success btn-sm "title="Class Students"><i class="fa fa-users"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="'.route("class-subject-managment", $classes->id).'" class="btn btn-secondary btn-sm "title="Class Attendance "><i class="fa fa-calendar"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn bg-primary btn-sm text-white view-class-fees" title="Class Fees" data-class="'.$classes->id.'"><i class="fa fa-dollar-sign"></i></a>&nbsp;&nbsp;';  
                return $button;
        })->addColumn('grade', function ($classes) {
            // //gemolith/public/storage/images/
            if ($classes->grade == null) {
                $text = "Not Available";
                return $text;
            } else {
                $text = $classes->grade->name;
                return $text;

            }

        })
            ->rawColumns(['action'])
            ->make(true);
    }


    //subjects
    public function subjects()
    {
        //ClassGrade
        $grades = ClassGrade::where('school_id',Session::get('school_id'))->get();
        return view('admin.class.subjects', compact('grades'));
    }
    public function addSubject(Request $request)
    {
     
        $add_subject = Subject::updateOrCreate(
            [
                'name' => $request->name,
                'grade_id' => $request->grade,
                'author' => $request->author,
                'school_id' => Session::get('school_id'),
            ],
            [
                'name' => $request->name,
                'grade_id' => $request->grade,
                'type' => $request->type,
                'author' => $request->author, 
                'details' => $request->info,
                'school_id' => Session::get('school_id'),

            ]);
        return response()->json([
            'result' => 'Added successfully',
        ], 200);
    }
    public function getSubjects(Request $request)
    {
        $number=0;
        if( $request->id){
            $class = Classes::find($request->id); 
            $subjects =   $class->grade->subjects;
        }else{
            $subjects = Subject::where('school_id',Session::get('school_id'))->get();
        }
        return DataTables::of($subjects)
        ->addColumn('action', function ($subjects)use ($request) {
            $button ="No Action Available";
            
            if(! $request->id){
                $button = '<a href="#" class="btn btn-danger btn-sm   deleteSubject"title="Deactivate" data-id=' . $subjects->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-info btn-sm  editSubjectInfo " data-toggle="modal" data-target="#editSubjectModal"   data-id="' . $subjects->id .'" data-name="' . $subjects->name .'"data-grade="' . $subjects->grade_id .'"data-type="' . $subjects->type . '"data-author="' . $subjects->author . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
              //  $button .= '<a href="#" class="btn btn-danger btn-sm  float-right deleteSubject"title="Deactivate" data-id=' . $subjects->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
            }
                return $button;
                
        })->addColumn('grade', function ($subjects) {
            // //gemolith/public/storage/images/
            if ($subjects->grade == null) {
                $text = "Not Available";
                return $text;
            } else {

                $text = $subjects->grade->name;
                return $text;

            }

        })->addColumn('type', function ($subjects) {
            // //gemolith/public/storage/images/
            if ($subjects->type == null) {
                $text = "Not Available";
                return $text;
            } else {

                $text = $subjects->type;
                return $text;

            }

        })->addColumn('author', function ($subjects) {
            // //gemolith/public/storage/images/
            if ($subjects->author == null) {
                $text = "Not Available";
                return $text;
            } else {

                $text = $subjects->author;
                return $text;

            }

        })
        
            ->rawColumns(['action'])
            ->make(true);
    }
    public function editSubject(Request $request)
    {
     
        $edit_subject = Subject::find($request->edit_id);
        $edit_subject->name = $request->edit_name;
        if($request->edit_grade){
            $edit_subject->grade_id = $request->edit_grade;
        }
       

        $edit_subject->type = $request->edit_type;
        $edit_subject->author = $request->edit_author;
        $edit_subject->details = $request->edit_info;
        
        try{
            $edit_subject->save();
            return response()->json([
                'result' => 'Edited successfully',
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'result' => 'Please upload a smaller size picture',
                'success' => false,
            ], 200);
        }
     
    }
    public function deleteSubject(Request $request)
    {
     
        $del_sub = Subject::find($request->id);
        
        $del_sub->delete();
        return response()->json([
            'result' => 'Deleted successfully',
        ], 200);
    }
    public function getSubjectDetail(Request $request)
    {
     
        $edit_subject = Subject::find($request->id);
        
        if($edit_subject->details ==null){
         
            return response()->json([
                'result' =>'Not Available',
            ], 200);

        }
        else{

            return response()->json([
                'result' =>$edit_subject->details,
            ], 200);

        }
     
    }
    public function classSubjects($id)
    {
        //$class = Classes::find($id); , compact('class')
        return view('admin.class.class-subjects', compact('id'));
       
    }
    public function grades()
    {
     //   $grades = ClassGrade::all();
        return view('admin.class.grades');
       
    }
    public function addGrade(Request $request)
    {
     
        $add_grade = ClassGrade::updateOrCreate(
            [
                'name' => $request->name,
                'school_id' => Session::get('school_id'),
               
            ],
            [
                'name' => $request->name,
                'school_id' => Session::get('school_id'),
            ]);
        return response()->json([
            'result' => 'Added successfully',
        ], 200);
    }
    public function editGrade(Request $request)
    {
        
        $edit_class = ClassGrade::find($request->edit_id);
        $edit_class->name = $request->edit_name;
        $edit_class->save();
        return response()->json([
            'result' => 'Edited successfully',
        ], 200);
    }

    public function getGrades()
    {
        
        $grades = ClassGrade::where('school_id',Session::get('school_id'))->get();
        return DataTables::of($grades)
        ->addColumn('action', function ($grades) {
                
                // $button = '<a href="#" class="btn btn-info btn-sm  editGrade "title="edit" data-id=' . $grades->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button = '<a href="#" class="btn btn-info btn-sm  editGrade " data-toggle="modal" data-target="#editGradeModal"   data-id="' . $grades->id . '" data-name="' . $grades->name . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                // $button .= '<a href="#" class="btn btn-danger btn-sm   deleteGrade"title="Delete" data-id=' . $grades->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
        
                return $button;
                
        })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function deleteGrade(Request $request)
    {
     
        $del= ClassGrade::find($request->id);
        
        $del->delete();
        return response()->json([
            'result' => 'Deleted successfully',
        ], 200);
    }

        //Teacher Area Cruds 
    public function addTeacher(Request $request)
    {
        $filename="default.webp";
        if($request->hasFile('image')){
            if(@is_array(getimagesize($request->image))){
                $time = time();
                $file=$request->image;
                $extension = $file->getClientOriginalExtension();
                $filename = $time."teacher_avatar" . '.' . $extension;
                $resized_image = Image::make($file)->resize(200, 200)->encode($extension);
              
                Storage::disk(config('filesystems.default'))
                ->put('teacher_avatars/' . $filename, $resized_image);

            }
            else{
                return response()->json([
                    'success' => false,
                    'error' => "Not a Image.",
                ]);

            }
        }
        if($request->address_line_main==null){
            return response()->json([
                'success' => false,
                'error' => "Address line main is empty",
            ]);

        }
      //  dd($request->all());

       $user = User::where('email', $request->email) ->orWhere('user_name', $request->user_name)->first();
       if( $user){
            if ($user->user_name==$request->user_name) {
                return response()->json([
                    'success' => false,
                    'error' => "User Name already Exists.",
                ]);
            }
            if ($user->email==$request->email) {
                return response()->json([
                    'success' => false,
                    'error' => "Email already Exists.",
                ]);
            }
        }
        //for auto password genrate
            // $formate_string = str_split('abcdefghijklmnopqrstuvwxyz'
            //     . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            //     . '0123456789');// and any other characters
            // shuffle($formate_string); 
            // $rand = '';
            // foreach (array_rand($formate_string, 8) as $k) {
            //     $rand .= $seed[$k];
            // }
        $user = User::updateOrCreate(
            [
            'email' => $request->email,
            ],
            [
            'name' => $request->name,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'avatar' => $filename,
            'password' => bcrypt( $request->password ),
            'role_id' => 2,
            'status' => 1,
            'school_id' => Session::get('school_id'),
            'ip_address' => $request->ip(),

        ]);
   //TeacherDetails
        $userdetails = TeacherDetails::updateOrCreate(
            [
            'user_id' =>$user->id ,
            ],
            [
            'user_id' =>$user->id ,
            'phone' => $request->phone,
            'emergency_phone' => $request->emergency_phone,
            'address_line_main' => $request->address_line_main,
            'address_line_secondary' => $request->address_line_secondary,
            'display_info_status' => 1,
            'subject_specialities' => $request->subject_specialities,
        ]);
        Mail::to($request->email)->send(new RegisterTeacher($request->user_name,$request->password,$user));



        return response()->json([
            'success' => true,
            'result' => 'Added successfully',
        ], 200);
    }
//teachers
    public function teachers()
    {
        return view('admin.teacher.teachers');
    }
    public function getTeachers()
    {
        
        $data = User::where([[ 'school_id' , Session::get('school_id')],['role_id',2]])->get();
       
        return DataTables::of($data)
        ->addColumn('action', function ($data) {
                
                // $button = '<a href="#" class="btn btn-info btn-sm  editGrade "title="edit" data-id=' . $grades->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button = '<a href="#" class="btn btn-info btn-sm  editTeacher " data-toggle="modal" data-target="#editTeacherModal"   data-id="' . $data->id . '" data-name="' . $data->name . '"data-avatar="' . $data->avatar . '"data-user_name="' . $data->user_name . '"data-phone="' . $data->teacher_details->phone . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-danger btn-sm   deleteTeacher"title="Delete" data-id=' . $data->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
        
                return $button;
                
        })
        ->addColumn('image', function ($data) {
         
                $image = '<img src="' . asset("uploads/teacher_avatars/" . $data->avatar) . '" alt="logo" width="50" height="50">';
                return $image;
           

        })
        ->addColumn('phone', function ($data) {
         
            $phone = $data->teacher_details->phone;
            return $phone;
       

        })
            ->rawColumns(['action','image'])
            ->make(true);
    }
    public function getTeacherDetail(Request $request)
    {
     
        $teacher = User::withTrashed()->find($request->id);
        $details= $teacher->teacher_details->subject_specialities;
        $emergency_phone= $teacher->teacher_details->emergency_phone;
        $address_line_main= $teacher->teacher_details->address_line_main;
        $address_line_secondary= $teacher->teacher_details->address_line_secondary;

        return response()->json([
                'email' =>$teacher->email,
                'details' =>$details,
                'emergency_phone' =>$emergency_phone,
                'address_line_main' =>$address_line_main,
                'address_line_secondary' =>$address_line_secondary,
            ], 200);
    }
    public function editTeacher(Request $request)
    {
      
        $teacher = User::find($request->edit_id);
        $filename =$teacher->avatar;
        $oldfile =$teacher->avatar;
        if($request->hasFile('edit_image')){
            if(@is_array(getimagesize($request->edit_image))){
                $time = time();
                $file=$request->edit_image;
                $extension = $file->getClientOriginalExtension();
                $filename = $time."teacher_avatar" . '.' . $extension;
                $resized_image = Image::make($file)->resize(200, 200)->encode($extension);
              
                Storage::disk(config('filesystems.default'))
                ->put('teacher_avatars/' . $filename, $resized_image);
                if($teacher->avatar !="default.webp"){

                    $oldfileName = 'teacher_avatars/' . $oldfile;
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
      //  $teacher = User::find($request->edit_id);
        $teacher->name= $request->edit_name;
    
        $teacher->email= $request->edit_email;
        $teacher->avatar= $filename;
        $teacher->save();
        $teacher_details= TeacherDetails::where('user_id',$request->edit_id)->first();
        $teacher_details->phone= $request->edit_phone;
        $teacher_details->emergency_phone= $request->edit_emergency_phone;
        $teacher_details->address_line_main= $request->edit_address_line_main;
        $teacher_details->address_line_secondary= $request->edit_address_line_secondary;
        $teacher_details->subject_specialities= $request->edit_subject_specialities;
        $teacher_details->save();

        return response()->json([
            'success' => true,
            'result' => 'Edit successfully',
        ], 200);
    }
    public function deleteTeacher(Request $request)
    {
       // $teacher_details= TeacherDetails::where('user_id',$request->id)->delete();
        $del= User::find($request->id);
        
        $del->delete();
        return response()->json([
            'result' => 'Deleted successfully',
        ], 200);
    }



    //Delted Teachers
    public function deletedTeachers()
    {
        return view('admin.teacher.deleted-teachers');
    }

    public function getDeletedTeachers()
    {
        
        $data = User::onlyTrashed()->where([[ 'school_id' , Session::get('school_id')],['role_id',2]])->get();
       
        return DataTables::of($data)
        ->addColumn('action', function ($data) {
                
                 $button = '<a href="#" class="btn btn-success btn-sm   activateTeacher"title="Restore" data-id=' . $data->id . '><i class="fa fa-check"></i></a>&nbsp;&nbsp;';  
        
                return $button;
                
        })
        ->addColumn('image', function ($data) {
         
                $image = '<img src="' . asset("uploads/teacher_avatars/" . $data->avatar) . '" alt="logo" width="50" height="50">';
                return $image;
           

        })
        ->addColumn('phone', function ($data) {
         
            $phone = $data->teacher_details->phone;
            return $phone;
       

        })
            ->rawColumns(['action','image'])
            ->make(true);
    }
    public function activateTeacher(Request $request)
    {
        //$teacher_details= TeacherDetails::withTrashed()->where('user_id',$request->id)->delete();
        $act= User::withTrashed()->find($request->id)->restore();
        
        return response()->json([
            'result' => 'Activated successfully',
        ], 200);
    }

    //students
    public function students()
    {
       $classes= Classes::where('school_id',Session::get('school_id'))->get();
        return view('admin.student.student', compact('classes'));
    }

    public function addStudent(Request $request)
    { 
        $filename="default.webp";
        if($request->hasFile('image')){
            if(@is_array(getimagesize($request->image))){
                $time = time();
                $file=$request->image;
                $extension = $file->getClientOriginalExtension();
                $filename = $time."student_avatar" . '.' . $extension;
                $resized_image = Image::make($file)->resize(200, 200)->encode($extension);
              
                Storage::disk(config('filesystems.default'))
                ->put('student_avatars/' . $filename, $resized_image);

            }
            else{
                return response()->json([
                    'success' => false,
                    'error' => "Not a Image.",
                ]);

            }
        }
        if($request->address_line_main==null){
            return response()->json([
                'success' => false,
                'error' => "Address line main is empty",
            ]);

        }
      //  dd($request->all());
     // where('email', $request->email) ->or
        if($request->email){
            $user = User::where('email', $request->email)->orWhere('user_name', $request->user_name)->first();
        }
        else{
            $user = User::withTrashed()->where('user_name', $request->user_name)->first();
        }
      
       if( $user){
       
        if ($user->user_name==$request->user_name) {
                return response()->json([
                    'success' => false,
                    'error' => "User Name already Exists.(if you dont find it in active students please look in Deleted Students)",
                ]);
            }
            if ($user->email==$request->email) {
                return response()->json([
                    'success' => false,
                    'error' => "Email already Exists.",
                ]);
            }
        }
        //for auto password genrate
            // $formate_string = str_split('abcdefghijklmnopqrstuvwxyz'
            //     . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            //     . '0123456789');// and any other characters
            // shuffle($formate_string); 
            // $rand = '';
            // foreach (array_rand($formate_string, 8) as $k) {
            //     $rand .= $seed[$k];
            // }
        $user = User::create(
          
            [
            'name' => $request->name,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'avatar' => $filename,
            'password' => bcrypt( $request->password ),
            'role_id' => 3,
            'status' => 1,
            'school_id' => Session::get('school_id'),
            'ip_address' => $request->ip(),
        ]);
   //TeacherDetails
        // $count=  StudentDetails::count();
        $count = StudentDetails::whereHas('student' ,function ($q)use ($request){
            $q->where( 'school_id' , Session::get('school_id'));
        })->count();
        $count++;
        $userdetails = StudentDetails::updateOrCreate(
            [
            'user_id' =>$user->id ,
            ],
            [
            'user_id' =>$user->id ,
            'class_id' => $request->class_id,
            'reg_no' => "regno_".$count,

            'phone' => $request->phone,
            'emergency_phone' => $request->emergency_phone,
            'address_line_main' => $request->address_line_main,
            'address_line_secondary' => $request->address_line_secondary,
         
        ]);
        // Mail::to($request->email)->send(new RegisterTeacher($request->user_name,$request->password));



        return response()->json([
            'success' => true,
            'result' => 'Added successfully',
        ], 200);
    }

    public function getStudents(Request $request)
    {
        
      
        if($request->id){
            $data = User::where([[ 'school_id' , Session::get('school_id')],['role_id',3]])->whereHas('student_details' ,function ($q)use ($request){
                $q->where('class_id',$request->id);
            })->get();
            
        }
        else{
            $data = User::where([[ 'school_id' , Session::get('school_id')],['role_id',3]])->get();
        }
       



        return DataTables::of($data)
        ->addColumn('action', function ($data) {
                
                // $button = '<a href="#" class="btn btn-info btn-sm  editGrade "title="edit" data-id=' . $grades->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button = '<a href="#" class="btn btn-secondary btn-sm  viewMarks " title="View Student Marks of all subjects" data-id="' . $data->id . '"><i class="fa fa-book"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-info btn-sm  editStudent " data-toggle="modal" data-target="#editStudentModal" data-email="' . $data->email . '"  data-id="' . $data->id . '" data-name="' . $data->name . '"data-avatar="' . $data->avatar . '"data-user_name="' . $data->user_name . '"data-phone="' . $data->student_details->phone .'"data-ephone="' . $data->student_details->emergency_phone .'"data-class="' . $data->student_details->class_id . '"data-address_main="' . $data->student_details->address_line_main .'"data-address_sec="' . $data->student_details->address_line_secondary .'"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-danger btn-sm   deleteStudent"title="Delete" data-id=' . $data->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-success btn-sm   changeStudentPassword"title="Change Password" data-id=' . $data->id . '" data-name="' . $data->user_name . '"><i class="fa fa-key"></i></a>&nbsp;&nbsp;';  
                return $button;
                
        })
        ->addColumn('image', function ($data) {
         
                $image = '<img src="' . asset("uploads/student_avatars/" . $data->avatar) . '" alt="logo" width="50" height="50">';
                return $image;
           

        })
        ->addColumn('phone', function ($data) {
         
            $phone = $data->student_details->phone;
            return $phone;
       

        })
        ->addColumn('class', function ($data) {
         
            $class = $data->student_details->class->name;
          
            return $class;
       

        })
        ->addColumn('reg_no', function ($data) {
         
            $reg_no = $data->student_details->reg_no;
          
            return $reg_no;
       

        })
            ->rawColumns(['reg_no', 'action','class','image','phone'])
            ->make(true);
    }
    public function getStudentDetail(Request $request)
    {
     
        $student = User::withTrashed()->find($request->id);
       
        $emergency_phone= $student->student_details->emergency_phone;
        $address_line_main= $student->student_details->address_line_main;
        $address_line_secondary= $student->student_details->address_line_secondary;
      
        return response()->json([
                'email' =>$student->email,
                'emergency_phone' =>$emergency_phone,
                'address_line_main' =>$address_line_main,
                'address_line_secondary' =>$address_line_secondary,
            ], 200);
    }
    public function editStudent(Request $request)
    {
      
        $student = User::find($request->edit_id);
       // dd($request->all(), $student->avatar);
        $oldfile =$student->avatar;
        $filename =$student->avatar;
        if($request->hasFile('edit_image')){
            if(@is_array(getimagesize($request->edit_image))){
                $time = time();
                $file=$request->edit_image;
                $extension = $file->getClientOriginalExtension();
                $filename = $time."student_avatar" . '.' . $extension;
                $resized_image = Image::make($file)->resize(200, 200)->encode($extension);
              
                Storage::disk(config('filesystems.default'))
                ->put('student_avatars/' . $filename, $resized_image);
                if($student->avatar !="default.webp"){

                    $oldfileName = 'student_avatars/' . $oldfile;
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
        $student = User::find($request->edit_id);
        $student->name= $request->edit_name;
    
        $student->email= $request->edit_email;
        $student->avatar= $filename;
        $student->save();
        $student_details= StudentDetails::where('user_id',$request->edit_id)->first();
        $student_details->phone= $request->edit_phone;
        $student_details->emergency_phone= $request->edit_emergency_phone;
        $student_details->address_line_main= $request->edit_address_line_main;
        $student_details->address_line_secondary= $request->edit_address_line_secondary;
        // $student_details->subject_specialities= $request->edit_subject_specialities;
        $student_details->save();

        return response()->json([
            'success' => true,
            'result' => 'Edit successfully',
        ], 200);
    }
    public function deleteStudent(Request $request)
    {
       // $student_details= studentDetails::where('user_id',$request->id)->delete();
        $del= User::find($request->id);
        
        $del->delete();
        return response()->json([
            'result' => 'Deleted successfully',
        ], 200);
    }



    //Delted students
    public function deletedStudents()
    {
        return view('admin.student.deleted-students');
    }

    public function getDeletedStudents()
    {
        
        $data = User::onlyTrashed()->where([[ 'school_id' , Session::get('school_id')],['role_id',3]])->get();

        return DataTables::of($data)
        ->addColumn('action', function ($data) {
                
                 $button = '<a href="#" class="btn btn-success btn-sm   activatestudent"title="Delete" data-id=' . $data->id . '><i class="fa fa-check"></i></a>&nbsp;&nbsp;';  
        
                return $button;
                
        })
        ->addColumn('image', function ($data) {
         
                $image = '<img src="' . asset("uploads/student_avatars/" . $data->avatar) . '" alt="logo" width="50" height="50">';
                return $image;
           

        })
        ->addColumn('phone', function ($data) {
         
            $phone = $data->student_details->phone;
            return $phone;
       

        })
            ->rawColumns(['action','image'])
            ->make(true);
    }
    public function activatestudent(Request $request)
    {
        //$student_details= studentDetails::withTrashed()->where('user_id',$request->id)->delete();
        $act= User::withTrashed()->find($request->id)->restore();
        
        return response()->json([
            'result' => 'Activated successfully',
        ], 200);
    }
    //Class Teachers
    public function classTeachers($id)
    {
        $teachers = User::where([[ 'school_id' , Session::get('school_id')],['role_id',2]])->get();
        return view('admin.class.class-teachers', compact('id','teachers'));
    
    }
    public function getSubjectTeachers(Request $request)
    {
        $class = Classes::find($request->id); 
      //Wrong query
        $data =   $class->grade->subjects;
        
        //dd($subjects);
        return DataTables::of($data)
        ->addColumn('action', function ($data) {
                
                // $button = '<a href="#" class="btn btn-info btn-sm  editGrade "title="edit" data-id=' . $data->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button = '<a href="#" class="btn btn-info btn-sm  assignteacher " data-toggle="modal" data-target="#editTeacherSubjectModal"   data-id="' . $data->id . '" data-name="' . $data->name . '" data-grade="' . $data->grade_id . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                return $button;
                
        })
        ->addColumn('teacher', function ($data) use ($class){
            if($data->teacher_subject){   
                $teacher =$data->teacher_subject->where([['class_id',$class->id],['grade_id',$class->grade_id],['subject_id',$data->id]])->first();
                    if($teacher){
                        return $teacher->teacher_details->name;
                    }
                    else{
                        return "No Teacher assigned";
                    }
            }
            else{
                return "No Teacher assigned";
            }
            // if($data->teacher_subject){
            //    return $data->teacher_subject->teacher_details->name;
            // }
            // else{
            //     return "No Teacher assigned";
            // }
          
            
    })
            ->rawColumns(['action'])
            ->make(true);
    
    }


    public function assignTeacherToSubject(Request $request)
    {
        $assign = TeacherSubject::updateOrCreate(
            [
                'class_id' => $request->class_id,
                'grade_id' => $request->grade,
                'subject_id' => $request->subject_id,

            ],
            [
                'class_id' => $request->class_id,
                'grade_id' => $request->grade,
                'subject_id' => $request->subject_id,
                'user_id' => $request->teacher,
            ]);
    }
    public function classStudents($id)
    {
     //   $teachers = User::where('role_id',3)->get();
        return view('admin.class.class-students', compact('id'));
    }
    public function getClassStudents(Request $request)
    {
        
        $data = StudentDetails::where('class_id',$request->id)->first();
    
        return DataTables::of($data)
        ->addColumn('action', function ($data) {
            $button ='';
            
            if($data->student_details){
                // $button = '<a href="#" class="btn btn-info btn-sm  editGrade "title="edit" data-id=' . $grades->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button = '<a href="#" class="btn btn-info btn-sm  editStudent " data-toggle="modal" data-target="#editStudentModal"   data-id="' . $data->id . '" data-name="' . $data->name . '"data-avatar="' . $data->avatar . '"data-user_name="' . $data->user_name . '"data-phone="' . $data->student_details->phone .'"data-ephone="' . $data->student_details->emergency_phone .'"data-class="' . $data->student_details->class_id . '"data-address_main="' . $data->student_details->address_line_main .'"data-address_sec="' . $data->student_details->address_line_secondary .'"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-danger btn-sm   deleteStudent"title="Delete" data-id=' . $data->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
            }
                return $button;
                
        })
        ->addColumn('image', function ($data) {
         
                $image = '<img src="' . asset("uploads/student_avatars/" . $data->avatar) . '" alt="logo" width="50" height="50">';
                return $image;
           

        })
        ->addColumn('phone', function ($data) {
            if($data->student_details){
                $phone = $data->student_details->phone;
                return $phone;

            }
         
       

        })
        ->addColumn('class', function ($data) {
            if($data->student_details){
                $class = $data->student_details->class->name;
          
                return $class;

            }
          
       

        })
        ->addColumn('reg_no', function ($data) {
            if($data->student_details){
                $reg_no = $data->student_details->reg_no;
                return $reg_no;
            }
            
       

        })
            ->rawColumns(['reg_no', 'action','class','image','phone'])
            ->make(true);
    }

    public function teacherComplaintsOfStudents(Type $var = null)
    {
        return view('admin.teacher.complaints');
    }
    public function getTeacherComplaints(Request $request)
    {
                
        $data = TeacherMailsOfStudent::where('school_id' , Session::get('school_id'))->get();
        return DataTables::of($data)
        ->addColumn('action', function ($data) {
            $button = '<a href="#" class="btn btn-info btn-sm openComplaint " data-toggle="modal" data-target="#editTeacherModal"   data-id="' . $data->id . '"><i class="fa fa-file"></i></a>&nbsp;&nbsp;';  
            if($data->status==1){
                $button.= '<a  class="btn btn-success  btn-sm change-complain-status "title="Click to Mark as unseen" data-status ="0" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';  
    
            }else{
                $button.= '<a  class="btn btn-danger  btn-sm change-complain-status "title="Click to Mark as seen" data-status ="1" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-eye-slash"></i></a>&nbsp;&nbsp;';  
            }
            return $button;
        })
        ->addColumn('student', function ($data) {
            $student = $data->student_details;
            return  $student->name.' ( '.$student->student_details->reg_no.' ) ';
        })
        ->addColumn('teacher', function ($data) {
         
            $teacher = $data->teacher_details->name;
            return $teacher ;
        })
        ->addColumn('class', function ($data) {
         
            $teacher = $data->class_details->name;
            return $teacher ;
        })
        ->addColumn('title', function ($data) {
         
            $title = $data->title;
            return $title ;
        })
            ->rawColumns(['action','teacher','student','class'])
            ->make(true);
}
public function getTeacherComplainData(Request $request)
{
    $data = TeacherMailsOfStudent::find( $request->id );
    if($data->title===null){
        $title='N/A';
    }else{
        $title=$data->title;
    }
    return response()->json([
        'student' => $data->student_details->name.'( '.$data->student_details->student_details->reg_no.' )',
        'teacher' => $data->teacher_details->name,
        'title' => $title,
        'description' => $data->description,
        'complain_id' =>$request->id  ,
        'status' =>$this->getComplainStatus($data)  ,
    ], 200);
}
public function getComplainStatus($data){
    if($data->status==0){
        $status='Not Viewed yet';
    }elseif($data->status==1){
        $status=' Viewed and Recieved';
    }
    return $status;
}

public function changeComplainStatusTeacher(Request $request)
{
    $data = TeacherMailsOfStudent::find( $request->id );
    $data->status= $request->status;
    $data->save();
    return response()->json([
        'success' => true,
        
    ], 200);

}


public function changeStudentPassword(Request $request)
{
    $data = User::find( $request->id );
  
    $data->password= Hash::make($request->password);
    $data->save();
    return response()->json([
        'success' => true,
    ], 200);

}

public function getResultTypes(Request $request)
{
    return view('admin.class.roles');
}

public function getSchoolResultTypes()
{
    
    $data = ResultType::where('school_id',Session::get('school_id'))->get();
    return DataTables::of($data)
    ->addColumn('action', function ($data) {
            
            // $button = '<a href="#" class="btn btn-info btn-sm  editGrade "title="edit" data-id=' . $data->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
            $button = '<a href="#" class="btn btn-info btn-sm  editData " data-toggle="modal" data-target="#editDataModal"   data-id="' . $data->id . '" data-name="' . $data->name . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
            if($data->status==1){
                $button.= '<a  class="btn btn-success  btn-sm change_status "title="Click to Hide" data-status ="0" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';  

            }else{
                $button.= '<a  class="btn btn-danger  btn-sm change_status "title="Click to show" data-status ="1" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-eye-slash"></i></a>&nbsp;&nbsp;';  
            }
    
            return $button;
            
    })
    ->rawColumns(['action'])
    ->make(true);
}

public function addResultType(Request $request)
{
    $user = ResultType::create(
            [
            'name' => $request->name,
            'status' => 1,
            'school_id' => Session::get('school_id'),
            'ip_address' => $request->ip(),
            ]);
}
public function editResultType(Request $request)
{
    $data = ResultType::find( $request->edit_id);
    $data->name= $request->edit_name;
    $data->save();
}
public function changeResultTypeStatus(Request $request)
{
    $data = ResultType::find( $request->id);
    $data->status= $request->status;
    $data->save();
}


public function getStudentComplainData(Request $request)
{
    $data = StudentMailsOfTeacher::find( $request->id );
    if($data->title===null){
        $title='N/A';
    }else{
        $title=$data->title;
    }
    return response()->json([
        'student' => $data->student_details->name.'( '.$data->student_details->student_details->reg_no.' )',
        'teacher' => $data->teacher_details->name,
        'title' => $title,
        'description' => $data->description,
        'complain_id' =>$request->id  ,
        'status' =>$this->getComplainStatus($data)  ,
    ], 200);
}


public function StudentsComplaintsOfTeacher()
{
    return view('admin.student.complaints');
}
public function getStudentsComplaints(Request $request)
{
            
    $data = StudentMailsOfTeacher::where('school_id' , Session::get('school_id'))->get();
    return DataTables::of($data)
    ->addColumn('action', function ($data) {
        $button = '<a href="#" class="btn btn-info btn-sm openComplaint " data-toggle="modal" data-target="#editTeacherModal"   data-id="' . $data->id . '"><i class="fa fa-file"></i></a>&nbsp;&nbsp;';  
        if($data->status==1){
            $button.= '<a  class="btn btn-success  btn-sm change-complain-status "title="Click to Mark as unseen" data-status ="0" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';  

        }else{
            $button.= '<a  class="btn btn-danger  btn-sm change-complain-status "title="Click to Mark as seen" data-status ="1" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-eye-slash"></i></a>&nbsp;&nbsp;';  
        }
        return $button;
    })
    ->addColumn('student', function ($data) {
        $student = $data->student_details;
        return  $student->name.' ( '.$student->student_details->reg_no.' ) ';
    })
    ->addColumn('teacher', function ($data) {
    
        $teacher = $data->teacher_details->name;
        return $teacher ;
    })
    ->addColumn('class', function ($data) {
       
        $class = $data->class_details->name;
        return $class ;
    })
    ->addColumn('title', function ($data) {
     
        $title = $data->title;
        return $title ;
    })
        ->rawColumns(['action','teacher','student','class'])
        ->make(true);
}
public function getStudentsComplainData(Request $request)
{
$data = StudentMailsOfTeacher::find( $request->id );
if($data->title===null){
    $title='N/A';
}else{
    $title=$data->title;
}
return response()->json([
    'student' => $data->student_details->name.'( '.$data->student_details->student_details->reg_no.' )',
    'teacher' => $data->teacher_details->name,
    'title' => $title,
    'description' => $data->description,
    'complain_id' =>$request->id  ,
    'status' =>$this->getComplainStatus($data)  ,
], 200);
}
public function changeComplainStatusStudent(Request $request)
{
    $data = StudentMailsOfTeacher::find( $request->id );
    $data->status= $request->status;
    $data->save();
    return response()->json([
        'success' => true,
    ], 200);

}
public function allBranches()
{
   
    return view('admin.dashboard.school-branches');
}
public function getbranches()
{
    $main_school_id = Auth::user()->school_id;
    $data = SchoolInformation::where('id' ,$main_school_id )->orWhere('parent_school_id', '=',$main_school_id )->get();
  
    return DataTables::of($data)
    ->addColumn('action', function ($data) {
            $button = '<a href="#" class="btn btn-info btn-sm  edit_data"title="Edit" data-name= "' . $data->name . '" data-phone="' . $data->phone . '" data-phone2="' . $data->phone2 . '" data-email="' . $data->email . '" data-abbreviation="' . $data->abbreviation . '" data-avatar="' . $data->avatar . '" data-address="' . $data->address . '" data-id="' . $data->id . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
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
public function getBranchDetail(Request $request)
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
public function addBranch(Request $request)
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
        'parent_school_id' => Auth::user()->school_id,
        'abbreviation' => $request->abbreviation,
        'school_unique_id' => time().'-'.Auth::user()->school_id,
        'phone' =>  $request->phone,
        'phone2' =>  $request->phone2,
        'address' =>  $request->address,
        'details' => $request->school_details,
        'ip_address' => $request->ip(),
    ]);
    $data = SchoolInformation::where('id' ,Auth::user()->school_id )->orWhere('parent_school_id', '=',Auth::user()->school_id )->get();
    Session::put('all_branches', Auth::user()->school_id);
    return response()->json([
        'success' => true,
        'result' => 'Added successfully',
    ], 200);
}
public function editBranch(Request $request)
{

    $school = SchoolInformation::find($request->edit_id);
   
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

public function changeSchoolBranch(Request $request)
{
   
    $school = SchoolInformation::where('school_unique_id',$request->branch)->first();
    if($school){
        if(Auth::user()->school_id == $school->parent_school_id || Auth::user()->school_id == $school->id){
            Session::put('school_id', $school->id);
            return response()->json([
                'success' => true,
                'result' => 'Edit successfully',
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
            ], 200);  
        }
    }else{
        return response()->json([
            'success' => false,
        ], 200);  
    }
  
 

}
//
public function classSubjectManagment($id)
{ 
    return view('admin.class.class-subject-managment', compact('id'));

}

public function getSubjectforManagment(Request $request)
{
    

    $class = Classes::find($request->id); 
    $subjects = $class->grade->subjects;

    return DataTables::of($subjects)
    ->addColumn('action', function ($subjects)use ($request) {
        $button = '<a href="#" class="btn btn-info btn-sm  get_class_student_attendance "title="Attendance" data-class=' . $request->id . ' data-subject=' . $subjects->id . '><i class="fa fa-list-alt "></i></a>&nbsp;&nbsp;';  
       
        return $button;
            
    })
        ->rawColumns(['action'])
        ->make(true);
}


public function getStudentsSubjectAttendance(Request $request)
{ 
    $teacher_controller = new TeacherController;
    $result = $teacher_controller->getStudentsSubjectAttendance($request);
    return $result;

}


public function studentAttendance(Request $request)
{
    $teacher_controller = new TeacherController;
    $result = $teacher_controller->studentAttendance($request);
    return $result;
}
public function getStudentSubjectAttendance(Request $request)
{
    $teacher_controller = new TeacherController;
    $result = $teacher_controller->getStudentSubjectAttendance($request);
    return $result;
}
public function getStudentAttendanceStats(Request $request)
{
    $teacher_controller = new TeacherController;
    $result = $teacher_controller->getStudentAttendanceStats($request);
    return $result;
}
public function studentMarks(Request $request)
{
    $teacher_controller = new TeacherController;
    $result = $teacher_controller->studentMarks($request);
    return $result;
}
public function getStudentMarks(Request $request)
{
    $teacher_controller = new TeacherController;
    $result = $teacher_controller->getStudentMarks($request);
    return $result;
}
}