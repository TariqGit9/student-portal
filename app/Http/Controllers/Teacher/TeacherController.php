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
use App\Models\ClassAttendance;
use App\Models\ClassStudentAttendance;
use App\Mail\Teacher\ReportStudent;
use App\Models\SchoolSession;
use App\Models\SchoolInformation;
use Mail;
use Session;
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
           $button.= '<a  class="btn btn-primary btn-sm class_student_marks"title="Class Students Marks" data-class_id ="'. $data->class_id.' "data-subject_id ="'. $data->subject_id.'"style="color:white;"><i class="fa fa-file" ></i></a>&nbsp;&nbsp;';  
           $button.= '<a  class="btn btn-secondary btn-sm class_student_attendance"title="Mark Students Attendance" data-class_id ="'. $data->class_id.' "data-subject_id ="'. $data->subject_id.'"style="color:white;"><i class="fa fa-list-alt " ></i></a>&nbsp;&nbsp;';  
           $button.= '<a  class="btn btn-warning btn-sm get_class_student_attendance"title="Class Students Attendance" data-class_id ="'. $data->class_id.' "data-subject_id ="'. $data->subject_id.'"style="color:white;"><i class="la la-calendar " ></i></a>&nbsp;&nbsp;';  
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
                
                $button = '<a href="#" class="btn btn-info btn-sm  getStudentdetailsReport " title="Report to Principle" data-toggle="modal" data-target="#student_report" data-name="' . $data->name . '" data-user_name="' . $data->user_name . '"  data-reg-no="' . $data->student_details->reg_no . '" data-id="' . $data->id . '"><i class="fa fa-envelope"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-success btn-sm  viewMarks " title="View Student Marks of all subjects" data-id="' . $data->id . '"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-warning btn-sm  viewAttendance " title="View Student Attendance of all subjects" data-id="' . $data->id . '"><i class="la la-calendar "></i></a>&nbsp;&nbsp;';  
                return   $button ;
                
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
        $types = ResultType::where([['school_id', Auth::user()->school->id],['status', 1]])->get();
        if($class !=null && $subject!=null ){
            return view('teacher.insert-students-marks',compact('class','students','subject','types'));
        }else{
            return redirect()->route('home');
        }
    }
    public function addStudentResult(Request $request)
    {
        if(Auth::user()->school->school_session){
            $school_session_id= Auth::user()->school->school_session->id;
        }else{
            $school_session_id=null;
        }
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
                'school_session_id'=>$school_session_id,
                'passing_marks' => $request->passing_marks,
                'total_marks' => $request->total_marks,
            ]);
            foreach($data as $key=>$info){

                $id= $info['id'];
                $obt_marks=  $info['obt_marks'];
                if( $obt_marks  >  $request->total_marks ){
                    $obt_marks=$request->total_marks;
                }

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
    if(Auth::user()->school->school_session){
        $school_session_id= Auth::user()->school->school_session->id;
    }else{
        $school_session_id=null;
    }
    $result = StudentAssessment::where([['class_id',$request->class_id],['subject_id',$request->subject_id],['teacher_id',Auth::user()->id],['school_session_id',$school_session_id]])->get(); 
   

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
    'school_id' => Auth::user()->school_id,
    'class_id' => $request->class_id,
    'title' => $request->title,
    'description' => $request->description,
]);

    $teacher=  Auth::user();
    $student= User::find($request->student_id);
    
    Mail::to('m.tariq.sarfraz.007@gmail.com')->send(new ReportStudent($student,$teacher,$report));
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
    $data1 = StudentAssessment::find($request->id);
    $passing_marks = $data1->passing_marks;
        return DataTables::of($result)
        ->addColumn('action', function ($data) {
       
           $button= '<a  class="btn btn-info  btn-sm studentMarks "title="Edit" data-name ="'. $data->student->name .' ( '.$data->student->student_details->reg_no.' ) '.'" data-marks ="'. $data->obtained_marks.'" data-id ="'. $data->id.'" style="color:white;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
          
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
public function editMarks(Request $request)
{
    $data = StudentMarks::find($request->edit_id);
    $data->obtained_marks = $request->marks;
    $data->save();

    return response()->json([
        'success' => true,
    ], 200);

}
public function studentMarks(Request $request)
{
    $student = User::find($request->student_id);
    $class =   $student->student_details->class;
    $grade = $class->grade;
    $subjects = $grade->subjects;
    if(Auth::user()->role_id==1){
        $user = 'admin';
    }else if(Auth::user()->role_id==2){
        $user = 'teacher';
    }
    return view('student.courses.marks',compact('subjects','class','student','user'));
}
public function getStudentMarks(Request $request)
{
    $student = User::find($request->student_id);
    $school =   $student->school;
    $school_session = $school->school_session;
    if($school_session){
      $school_session_id =$school_session->id;
    }else{
      $school_session_id = null;
    }
    $school_result_types =  ResultType::where([['school_id', $school->id],['status', 1]])->get();
    $html="";
    $html_footer_data ="";
    $colors = array("primary","success",  "secondary", "warning","danger","primary","success",  "secondary", "warning","danger");
    $counter =0;
    $number =0;
    foreach($school_result_types as $result_type){
        $student_marks_of_type = StudentAssessment::where([['school_session_id',$school_session_id],['type_id',$result_type->id],['subject_id',$request->id],['status', 1]])
        ->whereHas('student_marks' ,function ($q)use ($request , $student){
            $q->where('student_id', $student->id);
        })->get();
      
        $total_marks = $student_marks_of_type->sum('total_marks');
           
        if(! $student_marks_of_type->isEmpty()){
            $obt_marks=0;
           
            foreach($student_marks_of_type as $data){
               
                if($data->student_marks){
                        $final_result =$data->student_marks->where('student_id', $request->student_id)->first();
                        $obt_marks= $obt_marks + $final_result->obtained_marks;
                       
                }
            }
            $percentage = '--';
            if( $total_marks !=0 &&  $total_marks != null ){
                $percentage = $obt_marks / $total_marks ;
                $percentage = $percentage * 100 ;
                $percentage =number_format((float)$percentage, 2, '.', '');
            }
            
            $user_id = $request->student_id;
            $data =  view('student.courses.tables-view.marks-tables-view',compact('result_type','number','obt_marks','total_marks','student_marks_of_type','counter','colors','user_id'))->render();
            $html= $html. $data;
            $footer_data =  view('student.courses.tables-view.result-footer',compact('percentage','result_type','obt_marks','total_marks','counter','colors','user_id'))->render();
            $html_footer_data = $html_footer_data. $footer_data;
            $counter++;
        }

    }
    $html_footer =' <div class="row"> ';
    $html_footer_end =' </div>';
    $html_footer =$html_footer .$html_footer_data.$html_footer_end;
    $html = $html.$html_footer;
    return response()->json([
        'success' => $html,
    ], 200);
    

}
public function teacherInsertStudentAttendance(Request $request)
{
    $students = User::where('role_id',3)->whereHas('student_details' ,function ($q)use ($request){
        $q->where('class_id',$request->class_id);
    })->get(); 
   
    $subject = Subject::find($request->subject_id);
    $class = Classes::find($request->class_id);
    $types = ResultType::where([['school_id', Auth::user()->school->id],['status', 1]])->get();
    if($class !=null && $subject!=null ){
        $school =  Auth::user()->school;
        $school_session = $school->school_session;
        return view('teacher.insert-students-attendance',compact('class','students','subject','types','school_session'));
    }else{
        return redirect()->route('home');
    }
}
public function addStudentAttendance(Request $request)
{

    $data= $request->attendance;
    if(Auth::user()->school->school_session){
        $school_session= Auth::user()->school->school_session->id;
    }else{
        return response()->json([
            'success' =>false,
            'msg' =>'Session is not set',
        ], 200);
    }
    if( $data){
        $class_attendance=ClassAttendance::create([
            'teacher_id' => Auth::user()->id,
            'type' => $request->type,
            'date' =>$request->date,
            'time' => $request->time,
            'grade_id' => $request->grade_id,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'school_session_id'=>$school_session,
            'ip_address' => $request->ip(),
        ]);
        foreach($data as $key=>$info){
         
            $id= $info['id'];
            $attendance=  $info['attendance'];
            $marks = ClassStudentAttendance::create([
                'attendance_id' => $class_attendance->id,
                'student_id' => $id,
                'attendance' => $attendance,
                'ip_address' => $request->ip(),
            ]);
        }
    
        return response()->json([
            'success' =>true,
            'msg' =>'Attendance added successfully',
        ], 200);
    }
    return response()->json([
        'success' =>false,
        'msg' =>'Error',
    ], 200);
}
public function getStudentsSubjectAttendance(Request $request)
{ 
    $first_check=false;
    $last_check=false;
    $date = null;
    $class_id =$request->class_id;
    $subject_id =$request->subject_id;
  
    if(Auth::user()->role_id==2){
        $school =  Auth::user()->school;
        $school_session = $school->school_session;
        $layout_user = "teacher";
      
    }
    else if (Auth::user()->role_id==1){
        $school_session = Session::get('school_id');
        $layout_user = "admin";
        // $school_session = SchoolSession::find($school_session);
        $school = SchoolInformation::find($school_session);
        $school_session = $school->school_session;
        
    }
    if($school_session){
        $school_session_id =$school_session->id;
    }else{
        $school_session_id = null;
    }
   
    if($request->last_row){
        $result =  ClassAttendance::where([['school_session_id',  $school_session_id ], ['subject_id', $request->subject_id],['class_id', $request->class_id],['id', '<', $request->last_row]])->with('student_attendance')->latest()->take(6)->orderBy('id', 'DESC')->get();
        $all_class_attendance = ClassStudentAttendance::whereHas('class_attendance' ,function ($q)use ($request ,  $school_session_id){
        $q->where([['school_session_id',  $school_session_id ],['subject_id', $request->subject_id],['class_id', $request->class_id],['id', '<', $request->last_row]])->latest()->take(6);
        })->get();
        $last_attendance  =  ClassAttendance::where([['school_session_id',  $school_session_id ], ['subject_id', $request->subject_id],['class_id', $request->class_id],['id', '<', $request->last_row]])->with('student_attendance')->count();
        $first_check=true;
        if($last_attendance>6){
            $last_check=true;
        }
       
    }else if($request->first_row){
        
        $result =  ClassAttendance::where([['school_session_id',  $school_session_id ], ['subject_id', $request->subject_id],['class_id', $request->class_id],['id', '>', $request->first_row]])->with('student_attendance')->take(6)->get();
        $result =  $result->reverse(); 
        $all_class_attendance = ClassStudentAttendance::whereHas('class_attendance' ,function ($q)use ($request ,  $school_session_id){
        $q->where([['school_session_id',  $school_session_id ],['subject_id', $request->subject_id],['class_id', $request->class_id],['id', '>',$request->first_row]])->take(6);
        })->get();  
        $last_attendance  =  ClassAttendance::where([['school_session_id',  $school_session_id ], ['subject_id', $request->subject_id],['class_id', $request->class_id],['id', '>', $request->first_row]])->with('student_attendance')->count();
        $last_check=true; 
        if($last_attendance>6){
            $first_check=true;
        }
    }else if($request->search_date){

        $make_date=date_create($request->search_date);

        $date = date_format($make_date,"j-n-Y");
       
        $result =  ClassAttendance::where([['school_session_id',  $school_session_id ], ['subject_id', $request->subject_id],['class_id', $request->class_id],['date',$date]])->with('student_attendance')->get();
       
        $all_class_attendance = ClassStudentAttendance::whereHas('class_attendance' ,function ($q)use ($request ,  $school_session_id , $date){
        $q->where([['school_session_id',  $school_session_id ],['subject_id', $request->subject_id],['class_id', $request->class_id],['date',$date]]);
        })->get();  
       
    }else{
        $result =  ClassAttendance::where([['school_session_id',  $school_session_id ], ['subject_id', $request->subject_id],['class_id', $request->class_id]])->with('student_attendance')->latest()->take(6)->orderBy('id', 'DESC')->get();
        $last_attendance  =  ClassAttendance::where([['school_session_id',  $school_session_id ], ['subject_id', $request->subject_id],['class_id', $request->class_id]])->with('student_attendance')->count();
        if($last_attendance>6){
            $last_check=true;
        }
        $all_class_attendance = ClassStudentAttendance::whereHas('class_attendance' ,function ($q)use ($request ,  $school_session_id){
        $q->where([['school_session_id',  $school_session_id ],['subject_id', $request->subject_id],['class_id', $request->class_id]])->latest()->take(6);
        })->get();
    } 
    $class_students = User::where('role_id',3)->whereHas('student_details' ,function ($q)use ($request){
    $q->where('class_id',$request->class_id);
    })->get();
   if($layout_user == 'teacher'){
     
        return view('teacher.get-students-attendance',compact('layout_user','result','all_class_attendance','date','class_students','last_check','first_check','class_id','subject_id'));
   }else{
        $response = view('teacher.get-students-attendance',compact('layout_user','result','all_class_attendance','date','class_students','last_check','first_check','class_id','subject_id'));
        return $response; 
   }
}
public function studentAttendance(Request $request)
{
    $student_id=  $request->student_id;
 
    $student = User::find($student_id);
    if(Auth::user()->role_id==2){
        $school =  Auth::user()->school;
        $school_session = $school->school_session;
        $user_layout ="teacher";
    }
    else if (Auth::user()->role_id==1){
        $school_session = Session::get('school_id');
        $user_layout = "admin";
        // $school_session = SchoolSession::find($school_session);
        $school = SchoolInformation::find($school_session);
        $school_session = $school->school_session;
        
    }
    $class = $student->student_details->class;
    $grade = $class->grade;
    $subjects = $grade->subjects;
    $student_subjects =  ClassAttendance::where([['school_session_id', $school_session->id], ['class_id', $class->id]])->pluck('subject_id')->unique()->toArray();
    return view('student.courses.attendance',compact('user_layout','student_subjects','class','subjects','student'));
}
public function getStudentSubjectAttendance(Request $request)
{
   $student_id=  $request->student_id;
   if(Auth::user()->role_id==2){
        $school =  Auth::user()->school;
        $school_session = $school->school_session;
    }
    else if (Auth::user()->role_id==1){
        $school_session = Session::get('school_id');
        $school = SchoolInformation::find($school_session);
        $school_session = $school->school_session;
    }

   $student = User::find($student_id);
   $class = $student->student_details->class;
   $result =  ClassAttendance::where([['school_session_id', $school_session->id], ['subject_id', $request->subject_id],['class_id', $class->id]])
   ->whereHas('student_attendance' ,function ($q) use ($student_id){
    $q->where([['student_id',$student_id]]);    
    })->orderBy('id', 'DESC')->get();
   return DataTables::of($result)
   ->addColumn('date', function ($data) {
     
       return ' <div class="text-center">'.$data->date.'</div>';   
   })
   ->addColumn('time', function ($data) {
 
    return ' <div class="text-center">'.$data->time.'</div>';     
    })
   ->addColumn('attendance', function ($data) use($student_id){
    $button = ' <div class="text-center">';
    

    if($data->student_attendance){
        $check = $data->student_attendance->where('student_id', $student_id)->first();
        if($check->attendance =="Present"){
            $button.= '<a  class="btn btn-success  btn-sm  "title="Present" style="color:white;" >Present</a>&nbsp;&nbsp;'; 
        }elseif($check->attendance=="Leave"){
            $button.= '<a  class="btn btn-secondary  btn-sm  "title="Leave" style="color:white;" >Leave</a>&nbsp;&nbsp;'; 
        }elseif($check->attendance=="Absent"){
            $button.= '<a  class="btn btn-warning  btn-sm  "title="Absent"  style="color:white;">Absent</a>&nbsp;&nbsp;'; 
        }else{
            return  $button."--";
        }
        return  $button.' </div>';
    }else{
        return  $button."-- </div>";
    }
       
   })
   ->rawColumns(['attendance','date','time'])
   ->make(true);
}
public function getStudentAttendanceStats(Request $request)
{
 
    if(Auth::user()->role_id==2){
        $school =  Auth::user()->school;
        $school_session = $school->school_session;
    }
    else if (Auth::user()->role_id==1){
        $school_session = Session::get('school_id');
        $school = SchoolInformation::find($school_session);
        $school_session = $school->school_session;
    }
   $student_id=  $request->student_id;
   $student = User::find($student_id);
   $class = $student->student_details->class;
  
   $result_present =  ClassAttendance::where([['school_session_id', $school_session->id], ['subject_id', $request->subject_id],['class_id', $class->id]])->whereHas('student_attendance' ,function ($q) use ($student_id){
    $q->where([['attendance','Present'],['student_id', $student_id]]);     
    })->count();
   
    $result_leaves =  ClassAttendance::where([['school_session_id', $school_session->id], ['subject_id', $request->subject_id],['class_id', $class->id]])->whereHas('student_attendance' ,function ($q) use ($student_id){
        $q->where([['attendance','Leave'],['student_id', $student_id]]);   
        })->count();
    $result_absents =  ClassAttendance::where([['school_session_id', $school_session->id], ['subject_id', $request->subject_id],['class_id', $class->id]])->whereHas('student_attendance' ,function ($q) use ($student_id){
        $q->where([['attendance','Absent'],['student_id', $student_id]]);     
        })->count();
    return response()->json([
        'success' => true,
        'result_present' => $result_present,
        'result_leaves' => $result_leaves,
        'result_absents' => $result_absents,
    ], 200);

}



}
