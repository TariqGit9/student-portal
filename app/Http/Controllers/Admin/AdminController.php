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

//Mail
use App\Mail\RegisterTeacher;
use Mail;
//Request
use Illuminate\Http\Request;
//files Images
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use File;

//datatables
use DataTables;
class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard.index');
    }
    public function classes()
    {
        $grades = ClassGrade::all();
        return view('admin.class.classes', compact('grades'));
       
    }
    public function addClass(Request $request)
    {
     
        $add_class = Classes::updateOrCreate(
            [
                'name' => $request->name,
                'grade_id' => $request->grade,
            ],
            [
                'name' => $request->name,
                'grade_id' => $request->grade,
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
        $classes = Classes::all();
        return DataTables::of($classes)
        ->addColumn('action', function ($classes) {
                
                // $button = '<a href="#" class="btn btn-info btn-sm  deleteClass"title="Edit" data-id=' . $classes->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button = '<a href="#" class="btn btn-danger btn-sm  deleteClass"title="Delete" data-id=' . $classes->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="'.route("class-subjects", $classes->id).'" class="btn btn-info btn-sm "title="Class Subjects "><i class="fa fa-book-open"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="'.route("class-teachers", $classes->id).'" class="btn btn-warning btn-sm "title="Class Teachers "><i class="fa fa-pen"></i></a>&nbsp;&nbsp;';  
             
                $button .= '<a href="'.route("class-students", $classes->id).'" class="btn btn-success btn-sm "title="Class Students"><i class="fa fa-users"></i></a>&nbsp;&nbsp;';  
              
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
        $grades = ClassGrade::all();
        return view('admin.class.subjects', compact('grades'));
    }
    public function addSubject(Request $request)
    {
     
        $add_subject = Subject::updateOrCreate(
            [
                'name' => $request->name,
                'grade' => $request->grade,
                'author' => $request->author,
            ],
            [
                'name' => $request->name,
                'grade' => $request->grade,
                'type' => $request->type,
                'author' => $request->author, 
                'details' => $request->info,

            ]);
        return response()->json([
            'result' => 'Added successfully',
        ], 200);
    }
    public function getSubjects(Request $request)
    {
        $number=0;
        $subjects = Subject::all();
        if( $request->id){
            $class = Classes::find($request->id); 
            $subjects =   $class->grade->subjects;

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
        
        $edit_subject->save();
        return response()->json([
            'result' => 'Edited successfully',
        ], 200);
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
               
            ],
            [
                'name' => $request->name,
               
            ]);
        return response()->json([
            'result' => 'Added successfully',
        ], 200);
    }
    public function editGrade(Request $request)
    {
     
        $edit_class = Classes::find($request->editid);
        $edit_class->name = $request->editname;
        $edit_class->save();
        return response()->json([
            'result' => 'Edited successfully',
        ], 200);
    }

    public function getGrades()
    {
        
        $grades = ClassGrade::all();
        return DataTables::of($grades)
        ->addColumn('action', function ($grades) {
                
                // $button = '<a href="#" class="btn btn-info btn-sm  editGrade "title="edit" data-id=' . $grades->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button = '<a href="#" class="btn btn-info btn-sm  editGrade " data-toggle="modal" data-target="#editGradeModal"   data-id="' . $grades->id . '" data-name="' . $grades->name . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-danger btn-sm   deleteGrade"title="Delete" data-id=' . $grades->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
        
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
        Mail::to($request->email)->send(new RegisterTeacher($request->user_name,$request->password));



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
        
        $data = User::where('role_id',2)->get();
       
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
        
        $data = User::onlyTrashed()->where('role_id',2)->get();
       
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
       $classes= Classes::all();
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
            $user = User::where('email', $request->email) ->orWhere('user_name', $request->user_name)->first();
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
        ]);
   //TeacherDetails
        $count=  StudentDetails::count();
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
            $data = User::where('role_id',3)->whereHas('student_details' ,function ($q)use ($request){
                $q->where('class_id',$request->id);
            })->get();
            
        }
        else{
            $data = User::where('role_id',3)->get();
        }
       



        return DataTables::of($data)
        ->addColumn('action', function ($data) {
                
                // $button = '<a href="#" class="btn btn-info btn-sm  editGrade "title="edit" data-id=' . $grades->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button = '<a href="#" class="btn btn-info btn-sm  editStudent " data-toggle="modal" data-target="#editStudentModal" data-email="' . $data->email . '"  data-id="' . $data->id . '" data-name="' . $data->name . '"data-avatar="' . $data->avatar . '"data-user_name="' . $data->user_name . '"data-phone="' . $data->student_details->phone .'"data-ephone="' . $data->student_details->emergency_phone .'"data-class="' . $data->student_details->class_id . '"data-address_main="' . $data->student_details->address_line_main .'"data-address_sec="' . $data->student_details->address_line_secondary .'"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-danger btn-sm   deleteStudent"title="Delete" data-id=' . $data->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
        
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
        
        $data = User::onlyTrashed()->where('role_id',3)->get();
        // if($request->id){
        //     $data = User::where('role_id',3)->whereHas('student_details' ,function ($q)use ($request){
        //         $q->where('class_id',$request->id);
        //     })->get();
            
        // }
        // else{
        //     $data = User::where('role_id',3)->get();
        // }
       



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
        $teachers = User::where('role_id',2)->get();
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
        
        //$data = StudentDetails::where('class_id',$request->id)->first();
    
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
        return view('admin.index');

    }
}
