<?php

namespace App\Http\Controllers\Student;
use App\Models\StudentAssessment;
use App\Models\TeacherSubject;
use App\Models\ResultType;
use App\Models\User;
use App\Models\StudentMailsOfTeacher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Student\ReportTeacher;
use Auth;
//datatables
use DataTables;
class StudentController extends Controller
{
    public function student()
    {
        $users = User::where('role_id',2)->get();
        return view('student.index',compact('users'));
    }
    public function studentMarks()
    {
        $class = Auth::user()->student_details->class;
        $grade = $class->grade;
        $subjects = $grade->subjects;
        $user = 'student'; 
        return view('student.courses.marks',compact('subjects','class','user'));
    }
    public function getStudentMarks(Request $request)
    {
        $school =  Auth::user()->school;
        $school_session = $school->school_session;
        $school_result_types =  ResultType::where([['school_id', $school->id],['status', 1]])->get();
        $html="";
        $colors = array("primary","success",  "secondary", "warning","danger","primary","success",  "secondary", "warning","danger");
        $counter =0;
        $number =0;
        foreach($school_result_types as $result_type){

            $student_marks_of_type = StudentAssessment::where([['school_session_id',$school_session->id],['type_id',$result_type->id],['subject_id',$request->id],['status', 1]])
            ->whereHas('student_marks' ,function ($q)use ($request){
                $q->where('student_id',Auth::user()->id);
            })->get();
      
            $total_marks = $student_marks_of_type->sum('total_marks');
           
            if(! $student_marks_of_type->isEmpty()){
                $obt_marks=0;
                foreach($student_marks_of_type as $data){
                    if($data->student_marks){
                        $final_result =$data->student_marks->where('student_id',Auth::user()->id)->first();
                        $obt_marks= $obt_marks + $final_result->obtained_marks;
                    }
                }
              

                $user_id = Auth::user()->id;
                $data =  view('student.courses.tables-view.marks-tables-view',compact('result_type','number','obt_marks','total_marks','student_marks_of_type','counter','colors','user_id'))->render();
                $html= $html. $data;
                $counter++;
            }
        }
        return response()->json([
            'success' => $html,
        ], 200);
        
   
    }
    public function studentTeachers()
    {
        $class = Auth::user()->student_details->class;
        $grade = $class->grade;
        $subjects = $grade->subjects;
        
        return view('student.student-classes.index',compact('subjects','class'));
    }
    public function getClassTeachers(Request $request)
    {
        
        $class = Auth::user()->student_details->class;
        $grade = $class->grade;
        $result = $grade->subjects;
            return DataTables::of($result)
            ->addColumn('action', function ($data) {
                $button = '<a href="#" class="btn btn-info btn-sm getStudentdetailsReport" title="Report to Principle" data-toggle="modal" data-target="#student_report" data-name="' . $data->teacher_subject->teacher_details->name . '" data-id="' . $data->teacher_subject->teacher_details->id . '"  data-subject="' . $data->teacher_subject->name .  '"><i class="fa fa-envelope"></i></a>&nbsp;&nbsp;';  
                return $button;
                    
            })
            ->addColumn('subject', function ($data) {
                return $data->name;     
            })
            ->addColumn('teacher', function ($data) {
                return  $data->teacher_subject->teacher_details->name;     
            })
            ->rawColumns(['action','teacher','subject'])
            ->make(true);
    }

    public function reportTeacherToAdmin(Request $request)
    {
         
        $report=StudentMailsOfTeacher::create([
            'teacher_id' =>  $request->teacher_id ,
            'student_id' => Auth::user()->id,
            'school_id' => Auth::user()->school_id,
            'class_id' => Auth::user()->student_details->class_id,
            'subject_id' =>  $request->subject_id ,
            'title' => $request->title,
            'description' => $request->description,
        ]);

            
        $student= User::find($request->student_id);
        $admin= User::where([['role_id',1],['school_id',Auth::user()->school_id]])->first();
        Mail::to($admin->email)->send(new ReportTeacher($student,$teacher,$report));
        return response()->json([
            'success' => true,
            'result' => 'Reported successfully',
        ], 200);
    }
}
