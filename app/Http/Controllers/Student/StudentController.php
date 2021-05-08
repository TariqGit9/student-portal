<?php

namespace App\Http\Controllers\Student;
use App\Models\StudentAssessment;
use App\Models\TeacherSubject;
use App\Models\ResultType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class StudentController extends Controller
{
    public function student()
    {
        return view('student.index');
    }
    public function studentMarks()
    {
        $class = Auth::user()->student_details->class;
        $grade = $class->grade;
        $subjects = $grade->subjects;
        
        return view('student.courses.marks',compact('subjects','class'));
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
                    $obt_marks= $obt_marks + $data->student_marks[0]->obtained_marks;
                }
                $data =  view('student.courses.tables-view.marks-tables-view',compact('result_type','number','obt_marks','total_marks','student_marks_of_type','counter','colors'))->render();
                $html= $html. $data;
                $counter++;
            }
        }
        return response()->json([
            'success' => $html,
        ], 200);
        
   
    }
}
