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
use App\Models\TeacherMailsOfStudent;
use App\Models\UserDetails\TeacherDetails;
use App\Models\UserDetails\StudentDetails;

use App\Mail\Teacher\ReportStudent;
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
           $button.= '<a  class="btn btn-info btn-sm class_student_marks"title="Class Students Marks" data-class_id ="'. $data->class_id.' "data-subject_id ="'. $data->subject_id.'"style="color:white;"><i class="fa fa-file" ></i></a>&nbsp;&nbsp;';  
        
           //class_student_marks  
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
        
        $class=Classes::find($id);
        if($class !=null ){
            return view('teacher.class-students',compact('id','class'));
        }else{
            return redirect()->route('home');
        }
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
                
                $button = '<a href="#" class="btn btn-info btn-sm  editStudent " title="Report to Principle" data-toggle="modal" data-target="#student_report" data-name="' . $data->name . '" data-user_name="' . $data->user_name . '"  data-reg-no="' . $data->student_details->reg_no . '" data-id="' . $data->id . '"><i class="fa fa-envelope"></i></a>&nbsp;&nbsp;';  
        
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
        if($class !=null && $subject!=null ){
            return view('teacher.insert-students-marks',compact('class','students','subject','types'));
        }else{
            return redirect()->route('home');
        }
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
                'status' =>0,
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
public function classStudentResults(Request $request)
{
    
    $id = $request->class_id;
    $class=Classes::find($id);
    $subject_id= $request->subject_id;
    if($class){
        return view('teacher.class-student-results',compact('class','id','subject_id'));
    }else{
        return redirect()->route('home');
    }
}
//getClassAssesments
public function getClassAssesments(Request $request)
{
    $result = StudentAssessment::where([['class_id',$request->class_id],['subject_id',$request->subject_id],['teacher_id',Auth::user()->id]])->get(); 
   

        return DataTables::of($result)
        ->addColumn('action', function ($data) {
                
           $button= '<a  class="btn btn-info  btn-sm assesmentClassStudent "title="View Student performance" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';  
            if($data->status==1){
                $button.= '<a  class="btn btn-success  btn-sm assessments_status "title="Test published" data-status ="0" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-check"></i></a>&nbsp;&nbsp;';  

            }else{
                $button.= '<a  class="btn btn-danger  btn-sm assessments_status "title="Test are hidden" data-status ="1" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-times"></i></a>&nbsp;&nbsp;';  
            }
           return $button;
                
        })
        ->addColumn('total_marks', function ($data) {
               return $data->total_marks;     
        })
        ->addColumn('description', function ($data) {
            return $data->description;     
        })
        ->addColumn('type', function ($data) {
            if($data->assessments_type){
                return $data->assessments_type->name;
            }else{
                return '--';
            }   
        })
        ->addColumn('passing_marks', function ($data) {
            return $data->passing_marks;     
        })
        // ->addColumn('subject', function ($data) {
        //     return $data->subject_details->name;     
        // })
        // ->addColumn('class', function ($data) {
        //     return $data->class_details->name;     
        // })
        ->addColumn('date', function ($data) {
            return $data->test_date;     
        })
                ->rawColumns(['action','class','subject','passing_marks','description','total_marks'])
                ->make(true);
    
}
public function reportStudentToAdmin(Request $request)
{
  
   $report=TeacherMailsOfStudent::create([
    'teacher_id' => Auth::user()->id,
    'student_id' => $request->student_id,
    'class_id' => $request->class_id,
    'title' => $request->title,
    'description' => $request->description,
]);

    
    $student= User::find($request->student_id);
    Mail::to('m.tariq.sarfraz.007@gmail.com')->send(new ReportStudent($student,$request->description));
    return response()->json([
        'success' => true,
        'result' => 'Reported successfully',
    ], 200);
}
public function toggleAssessmentsStatus(Request $request)
{
 
   $data = StudentAssessment::find($request->id);
   $data->status=$request->status;
   $data->save();

   return response()->json([
    'success' => true,
], 200);
}
public function assesmentClassStudent(Request $request)
{

//    
    $id= $request->assessment;
    $data = StudentAssessment::find($id);
    if($data){
        return view('teacher.student-assessment',compact('data','id'));
    }else{
        return redirect()->route('home');
    }

   return response()->json([
    'success' => true,
], 200);
}
public function getClassAssesmentsResults(Request $request)
{
    $result = StudentMarks::where('assesment_id',$request->id)->get();
    $data = StudentAssessment::find($request->id);
    $passing_marks = $data->passing_marks;
        return DataTables::of($result)
        ->addColumn('action', function ($data) {
                
           $button= '<a  class="btn btn-info  btn-sm assesmentClassStudent "title="Edit" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
          
           return $button;
                
        })
        ->addColumn('result', function ($data)  use ($passing_marks) {
            if($passing_marks > $data->obtained_marks){
                $button= '<a  class="btn btn-danger  btn-sm  "title="Failed"  style="color:white;"><i class="fa fa-times"></i></a>&nbsp;&nbsp;';  
              
            }else{
                $button= '<a  class="btn btn-success  btn-sm  "title="Passed"  style="color:white;"><i class="fa fa-check"></i></a>&nbsp;&nbsp;'; 
          
            }
               return $button;     
        })
        ->addColumn('student_name', function ($data) {
            if($data->student){
                return $data->student->name .' ( '.$data->student->student_details->reg_no.' ) '; 
            }else{
                return '--';
            }
        })
     
        ->addColumn('obtained_marks', function ($data) {
            return $data->obtained_marks;     
        })
       
        ->rawColumns(['action','result','student_name','obtained_marks'])
        ->make(true);
    
}


}
