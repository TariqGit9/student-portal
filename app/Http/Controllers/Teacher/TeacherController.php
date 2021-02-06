<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\ClassGrade;
use App\Models\User;
use App\Models\ResultType;
use App\Models\StudentAssessment;
use App\Models\TeacherSubject;
use App\Models\StudentMarks;
use App\Models\UserDetails\TeacherDetails;
use App\Models\UserDetails\StudentDetails;
use Mail;

//files Images
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use File;

//datatables
use DataTables;
use Auth;


class TeacherController extends Controller
{
    public function teacher()
    {
        return view('teacher.index');
    }
    public function teacherClass()
    {
        return view('teacher.my-classes');
    }
    public function getTeacherClass()
    {
        $result = TeacherSubject::where('user_id',Auth::user()->id)->get(); 
        return DataTables::of($result)
        ->addColumn('action', function ($data) {
                
           $button= '<a  class="btn btn-success  btn-sm class_students"title="Class Students" data-class_id ="'. $data->class_id.'" style="color:white;"><i class="fa fa-users"></i></a>&nbsp;&nbsp;';  
           $button.= '<a class="btn btn-info btn-sm upload_student_marks"title="Upload Students Marks" data-class_id ="'. $data->class_id.'"data-subject_id ="'. $data->subject_id.'" style="color:white;"><i class="fa fa-list"></i></a>&nbsp;&nbsp;';  
           
           return $button;
                
        })
        ->addColumn('class', function ($data) {
               return $data->class_details->name;     
        })
        ->addColumn('subject', function ($data) {
            return $data->subject_details->name;     
        })
                ->rawColumns(['action','class','subject'])
                ->make(true);
    
    }
    public function teacherClassStudent(Request $request)
    {
        $id= $request->class_id;   
        return view('teacher.class-students',compact('id'));
    }

    public function getTeacherClassStudent(Request $request)
    {
        if($request->id){
            $data = User::where('role_id',3)->whereHas('student_details' ,function ($q)use ($request){
                $q->where('class_id',$request->id);
            })->get();
            
        }
        
        return DataTables::of($data)
        ->addColumn('action', function ($data) {
                
                $button = '<a href="#" class="btn btn-info btn-sm  editStudent " title="Report to Principle" data-toggle="modal" data-target="#editStudentModal"   data-id="' . $data->id . '" data-name="' . $data->name . '"data-avatar="' . $data->avatar . '"data-user_name="' . $data->user_name . '"data-phone="' . $data->student_details->phone .'"data-ephone="' . $data->student_details->emergency_phone .'"data-class="' . $data->student_details->class_id . '"data-address_main="' . $data->student_details->address_line_main .'"data-address_sec="' . $data->student_details->address_line_secondary .'"><i class="fa fa-envelope"></i></a>&nbsp;&nbsp;';  
        
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
    public function teacherInsertStudentMarks(Request $request)
    {
        
        $students = User::where('role_id',3)->whereHas('student_details' ,function ($q)use ($request){
            $q->where('class_id',$request->class_id);
        })->get(); 
        
        $subject = Subject::find($request->subject_id);
        $class = Classes::find($request->class_id);
        $types = ResultType::all();
       
        return view('teacher.insert-students-marks',compact('class','students','subject','types'));
    }
    public function addStudentResult(Request $request)
    {

 
        $data= $request->marks;
        if( $data){
            $assesment=StudentAssessment::create([
                'teacher_id' => Auth::user()->id,
                'type_id' => $request->type_id,
                'grade_id' => $request->grade_id,
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'test_date' => $request->date,
                'description' => $request->description,
                'passing_marks' => $request->passing_marks,
                'total_marks' => $request->total_marks,
            ]);
            foreach($data as $key=>$info){
                $id= $info['id'];
                $obt_marks=  $info['obt_marks'];
                $marks = StudentMarks::create([
                    'assesment_id' => $assesment->id,
                    'student_id' => $id,
                    'obtained_marks' => $obt_marks,
                ]);
            }
            return response()->json([
                'success' =>true,
                'msg' =>'Marks added successfully',
            ], 200);
        }
        return response()->json([
            'success' =>false,
            'msg' =>'Error',
        ], 200);
    }
}
