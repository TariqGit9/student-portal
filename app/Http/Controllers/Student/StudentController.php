<?php

namespace App\Http\Controllers\Student;
use App\Models\StudentAssessment;
use App\Models\TeacherSubject;
use App\Models\ResultType;
use App\Models\User;
use App\Models\StudentMailsOfTeacher;
use App\Models\ClassFee;
use App\Models\ClassStudentFee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Student\ReportTeacher;
use App\Models\ClassAttendance;
use App\Models\ClassStudentAttendance;
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
        $html_footer_data ="";
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
                $percentage = '--';
                if( $total_marks !=0 &&  $total_marks != null ){
                    $percentage = $obt_marks / $total_marks ;
                    $percentage = $percentage * 100 ;
                    $percentage =number_format((float)$percentage, 2, '.', '');
                }
                

                $user_id = Auth::user()->id;
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
                // Report button hidden for now
                // $button = '<a href="#" class="btn btn-info btn-sm getStudentdetailsReport" title="Report to Principle" data-toggle="modal" data-target="#student_report" data-name="' . $data->teacher_subject->teacher_details->name . '" data-id="' . $data->teacher_subject->teacher_details->id . '"  data-subject="' . $data->teacher_subject->name .  '"><i class="fa fa-envelope"></i></a>&nbsp;&nbsp;';
                $button = '';
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


    public function studentAttendance()
    {
        $school =  Auth::user()->school;
        $school_session = $school->school_session;
        $class = Auth::user()->student_details->class;
       
        $grade = $class->grade;
        $subjects = $grade->subjects;
        
        $student_subjects =  ClassAttendance::where([['school_session_id', $school_session->id], ['class_id', $class->id]])->pluck('subject_id')->unique()->toArray();
        $user_layout ="student";
        return view('student.courses.attendance',compact('user_layout','student_subjects','class','subjects'));
    }
    public function getStudentSubjectAttendance(Request $request)
    {
       $school =  Auth::user()->school;
       $school_session = $school->school_session;
       $class = Auth::user()->student_details->class;
       $result =  ClassAttendance::where([['school_session_id', $school_session->id], ['subject_id', $request->subject_id],['class_id', $class->id]])->with('login_student_attendance')->orderBy('id', 'DESC')->get();
      
       return DataTables::of($result)
       ->addColumn('date', function ($data) {
         
           return ' <div class="text-center">'.$data->date.'</div>';   
       })
       ->addColumn('time', function ($data) {
     
        return ' <div class="text-center">'.$data->time.'</div>';     
        })
       ->addColumn('attendance', function ($data) {
        $button = ' <div class="text-center">';
        if($data->login_student_attendance){
            if($data->login_student_attendance->attendance =="Present"){
                $button.= '<a  class="btn btn-success  btn-sm  "title="Present" style="color:white;" >Present</a>&nbsp;&nbsp;'; 
            }elseif($data->login_student_attendance->attendance=="Leave"){
                $button.= '<a  class="btn btn-secondary  btn-sm  "title="Leave" style="color:white;" >Leave</a>&nbsp;&nbsp;'; 
            }elseif($data->login_student_attendance->attendance=="Absent"){
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
       $school =  Auth::user()->school;
       $school_session = $school->school_session;

       $class = Auth::user()->student_details->class;
       $result_present =  ClassAttendance::where([['school_session_id', $school_session->id], ['subject_id', $request->subject_id],['class_id', $class->id]])->whereHas('login_student_attendance' ,function ($q){
        $q->where([['attendance','Present']]);    
        })->count();
        $result_leaves =  ClassAttendance::where([['school_session_id', $school_session->id], ['subject_id', $request->subject_id],['class_id', $class->id]])->whereHas('login_student_attendance' ,function ($q){
            $q->where([['attendance','Leave']]);    
            })->count();
        $result_absents =  ClassAttendance::where([['school_session_id', $school_session->id], ['subject_id', $request->subject_id],['class_id', $class->id]])->whereHas('login_student_attendance' ,function ($q){
            $q->where([['attendance','Absent']]);    
            })->count();
            
        // $result_absents =  ClassAttendance::where([['school_session_id', $school_session->id], ['subject_id', $request->subject_id],['class_id', $class->id]])->whereHas('login_student_attendance' ,function ($q){
        //     $q->where([['attendance','Present'],['student_id',Auth::user()->id]]);      
        //         })->count();
        // $result_present =  ClassAttendance::where([['school_session_id', $school_session->id], ['subject_id', $request->subject_id],['class_id', $class->id]])->whereHas('student_attendance' ,function ($q){
        //     $q->where([['attendance','Present'],['student_id',Auth::user()->id]]);    
        //     })->count();

        return response()->json([
            'success' => true,
            'result_present' => $result_present,
            'result_leaves' => $result_leaves,
            'result_absents' => $result_absents,
        ], 200);

    }

    public function myFees()
    {
        return view('student.fees.index');
    }

    public function getMyFees()
    {
        $student = Auth::user();
        $class = $student->student_details->class;

        $fees = ClassFee::where([
            ['school_id', $student->school_id],
            ['class_id', $class->id]
        ])->with('class')->get();

        $feeData = [];
        foreach ($fees as $fee) {
            $payment = ClassStudentFee::where([
                ['student_id', $student->id],
                ['fee_id', $fee->id]
            ])->first();

            $isPastDue = now()->greaterThan($fee->expiry_date);
            $totalFee = $isPastDue && !$payment ? $fee->fee_charge + $fee->late_fee_charge : $fee->fee_charge;
            $paid = $payment ? $payment->amount_paid : 0;
            $due = $payment ? $payment->amount_left : $totalFee;

            $feeData[] = [
                'id' => $fee->id,
                'type' => $fee->type,
                'amount' => $totalFee,
                'amount_formatted' => currency($totalFee),
                'paid' => $paid,
                'paid_formatted' => currency($paid),
                'due' => $due,
                'due_formatted' => currency($due),
                'due_date' => \Carbon\Carbon::parse($fee->date)->format('M d, Y'),
                'status' => $payment && $payment->amount_left == 0 ? 'Paid' : ($payment ? 'Partial' : 'Unpaid'),
                'is_late' => $isPastDue && (!$payment || $payment->amount_left > 0),
                'details_url' => route('student.fee.details', $fee->id),
            ];
        }

        return response()->json([
            'success' => true,
            'class_name' => $class->name,
            'fees' => $feeData,
        ]);
    }

    public function feeDetails($id)
    {
        return view('student.fees.details', ['feeId' => $id]);
    }

    public function getFeeDetails($id)
    {
        $student = Auth::user();
        $fee = ClassFee::with('class')->findOrFail($id);

        if ($fee->class_id != $student->student_details->class_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $payment = ClassStudentFee::where([
            ['student_id', $student->id],
            ['fee_id', $fee->id]
        ])->first();

        $isPastDue = now()->greaterThan($fee->expiry_date);
        $totalFee = $isPastDue && !$payment ? $fee->fee_charge + $fee->late_fee_charge : $fee->fee_charge;

        $data = [
            'type' => $fee->type,
            'class_name' => $fee->class->name,
            'original_amount' => currency($fee->fee_charge),
            'late_fee' => $fee->late_fee_charge > 0 && $isPastDue ? currency($fee->late_fee_charge) : null,
            'total_amount' => currency($totalFee),
            'due_date' => \Carbon\Carbon::parse($fee->date)->format('M d, Y'),
            'expiry_date' => \Carbon\Carbon::parse($fee->expiry_date)->format('M d, Y'),
            'is_past_due' => $isPastDue,
            'late_fee_charge' => $fee->late_fee_charge,
        ];

        $paymentData = null;
        if ($payment) {
            $paymentData = [
                'amount_paid' => currency($payment->amount_paid),
                'amount_left' => currency($payment->amount_left),
                'amount_left_raw' => $payment->amount_left,
                'date_paid' => \Carbon\Carbon::parse($payment->date_paid)->format('M d, Y g:i A'),
                'status' => $payment->amount_left == 0 ? 'Paid' : 'Partial',
                'description' => $payment->amount_description,
            ];
        }

        return response()->json([
            'success' => true,
            'fee' => $data,
            'payment' => $paymentData,
            'total_fee_formatted' => currency($totalFee),
        ]);
    }

}
