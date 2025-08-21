<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassFee;
use App\Models\ClassStudentFee;
use App\Models\Classes;
use App\Models\User;
use App\Models\SchoolSession;
use Illuminate\Http\Request;
use DataTables;
use Session;
use DB;

class FeeController extends Controller
{
    public function index()
    {
        try {
            $school_id = Session::get('school_id');
            
            $classes = Classes::where('school_id', $school_id)->get();
            $sessions = SchoolSession::where('school_id', $school_id)->get();
            
            return view('admin.fee.index', compact('classes', 'sessions'));
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to load fee management');
        }
    }

    public function getFees(Request $request)
    {
        try {
            $school_id = Session::get('school_id');
            
            if (!$school_id) {
                return response()->json(['error' => 'School ID not found in session'], 400);
            }

            $fees = ClassFee::where('school_id', $school_id)
                ->with('class')
                ->get();

            return DataTables::of($fees)
                ->addColumn('action', function ($fee) {
                    $button = '<a href="#" class="btn btn-info btn-sm editFee" data-toggle="modal" data-target="#editFeeModal" data-id="' . $fee->id . '" data-type="' . $fee->type . '" data-class="' . $fee->class_id . '" data-fee="' . $fee->fee_charge . '" data-late="' . $fee->late_fee_charge . '" data-date="' . $fee->date . '" data-expiry="' . $fee->expiry_date . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
                    $button .= '<a href="#" class="btn btn-danger btn-sm deleteFee" data-id="' . $fee->id . '"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';
                    $button .= '<a href="' . route('admin.fee.students', $fee->id) . '" class="btn btn-success btn-sm" title="View Students"><i class="fa fa-users"></i></a>';
                    return $button;
                })
                ->addColumn('class_name', function ($fee) {
                    return $fee->class ? $fee->class->name : 'All Classes';
                })
                ->addColumn('total_collected', function ($fee) {
                    $total = ClassStudentFee::where('fee_id', $fee->id)->sum('amount_paid');
                    return number_format($total, 2);
                })
                ->addColumn('students_paid', function ($fee) {
                    return ClassStudentFee::where('fee_id', $fee->id)->count();
                })
                ->rawColumns(['action'])
                ->make(true);
                
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load fees'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'class_id' => 'required',
            'fee_charge' => 'required|numeric|min:0',
            'date' => 'required',
            'expiry_date' => 'required'
        ]);

        ClassFee::create([
            'type' => $request->type,
            'class_id' => $request->class_id,
            'fee_charge' => $request->fee_charge,
            'late_fee_charge' => $request->late_fee_charge ?? 0,
            'date' => $request->date,
            'expiry_date' => $request->expiry_date,
            'school_id' => Session::get('school_id'),
            'school_session_id' => $request->session_id,
            'ip_address' => $request->ip()
        ]);

        return response()->json(['success' => true, 'message' => 'Fee added successfully']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|exists:class_fees,id',
            'edit_type' => 'required',
            'edit_fee_charge' => 'required|numeric|min:0'
        ]);

        $fee = ClassFee::find($request->edit_id);
        $fee->update([
            'type' => $request->edit_type,
            'class_id' => $request->edit_class_id,
            'fee_charge' => $request->edit_fee_charge,
            'late_fee_charge' => $request->edit_late_fee_charge ?? 0,
            'date' => $request->edit_date,
            'expiry_date' => $request->edit_expiry_date
        ]);

        return response()->json(['success' => true, 'message' => 'Fee updated successfully']);
    }

    public function destroy(Request $request)
    {
        ClassFee::find($request->id)->delete();
        return response()->json(['success' => true, 'message' => 'Fee deleted successfully']);
    }

    public function studentFees($feeId)
    {
        $fee = ClassFee::findOrFail($feeId);
        $class = Classes::find($fee->class_id);
        
        // Get students in this class
        $students = User::where([
            ['school_id', Session::get('school_id')],
            ['role_id', 3]
        ])->whereHas('student_details', function ($q) use ($fee) {
            $q->where('class_id', $fee->class_id);
        })->get();

        return view('admin.fee.students', compact('fee', 'students', 'class'));
    }

    public function getStudentFees(Request $request)
    {
        $fee = ClassFee::find($request->fee_id);
        
        // Get all students in the class
        $students = User::where([
            ['school_id', Session::get('school_id')],
            ['role_id', 3]
        ])->whereHas('student_details', function ($q) use ($fee) {
            $q->where('class_id', $fee->class_id);
        })->get();

        $data = [];
        foreach ($students as $student) {
            $payment = ClassStudentFee::where([
                ['student_id', $student->id],
                ['fee_id', $fee->id]
            ])->first();

            $isPastDue = now()->greaterThan($fee->expiry_date);
            $feeAmount = $isPastDue && !$payment ? $fee->fee_charge + $fee->late_fee_charge : $fee->fee_charge;
            
            $data[] = [
                'id' => $student->id,
                'name' => $student->name,
                'reg_no' => $student->student_details->reg_no,
                'fee_amount' => $feeAmount,
                'amount_paid' => $payment ? $payment->amount_paid : 0,
                'amount_left' => $payment ? $payment->amount_left : $feeAmount,
                'date_paid' => $payment ? $payment->date_paid : null,
                'status' => $payment && $payment->amount_left == 0 ? 'Paid' : ($payment ? 'Partial' : 'Unpaid'),
                'payment_id' => $payment ? $payment->id : null
            ];
        }

        return DataTables::of($data)
            ->addColumn('action', function ($row) use ($fee) {
                $button = '';
                if ($row['status'] != 'Paid') {
                    $button = '<a href="#" class="btn btn-success btn-sm recordPayment" data-toggle="modal" data-target="#paymentModal" data-student="' . $row['id'] . '" data-name="' . $row['name'] . '" data-fee="' . $fee->id . '" data-amount="' . $row['amount_left'] . '" data-payment="' . $row['payment_id'] . '"><i class="fa fa-money-bill"></i> Record Payment</a>';
                } else {
                    $button = '<span class="badge badge-success">Fully Paid</span>';
                }
                if ($row['payment_id']) {
                    $button .= ' <a href="#" class="btn btn-info btn-sm viewPaymentHistory" data-payment="' . $row['payment_id'] . '"><i class="fa fa-history"></i></a>';
                }
                return $button;
            })
            ->addColumn('status_badge', function ($row) {
                if ($row['status'] == 'Paid') {
                    return '<span class="badge badge-success">Paid</span>';
                } elseif ($row['status'] == 'Partial') {
                    return '<span class="badge badge-warning">Partial</span>';
                } else {
                    return '<span class="badge badge-danger">Unpaid</span>';
                }
            })
            ->rawColumns(['action', 'status_badge'])
            ->make(true);
    }

    public function recordPayment(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'fee_id' => 'required|exists:class_fees,id',
            'amount' => 'required|numeric|min:0'
        ]);

        $fee = ClassFee::find($request->fee_id);
        $isPastDue = now()->greaterThan($fee->expiry_date);
        $totalFee = $isPastDue ? $fee->fee_charge + $fee->late_fee_charge : $fee->fee_charge;

        $payment = ClassStudentFee::where([
            ['student_id', $request->student_id],
            ['fee_id', $request->fee_id]
        ])->first();

        if ($payment) {
            // Update existing payment
            $newAmountPaid = $payment->amount_paid + $request->amount;
            $amountLeft = max(0, $totalFee - $newAmountPaid);
            
            $payment->update([
                'amount_paid' => $newAmountPaid,
                'amount_left' => $amountLeft,
                'date_paid' => now(),
                'amount_description' => $request->description ?? 'Payment received'
            ]);
        } else {
            // Create new payment record
            $amountLeft = max(0, $totalFee - $request->amount);
            
            ClassStudentFee::create([
                'student_id' => $request->student_id,
                'fee_id' => $request->fee_id,
                'amount_paid' => $request->amount,
                'amount_left' => $amountLeft,
                'date_paid' => now(),
                'amount_description' => $request->description ?? 'Payment received',
                'fees_left' => $amountLeft,
                'fees_left_description' => $amountLeft > 0 ? 'Pending payment' : 'Fully paid',
                'school_id' => Session::get('school_id'),
                'school_session_id' => $fee->school_session_id
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Payment recorded successfully']);
    }

    public function paymentHistory($paymentId)
    {
        $payment = ClassStudentFee::with(['student', 'fee.class'])->findOrFail($paymentId);
        
        // Get all payments for this student and fee combination
        $allPayments = ClassStudentFee::where([
            ['student_id', $payment->student_id],
            ['fee_id', $payment->fee_id]
        ])->orderBy('created_at', 'desc')->get();
        
        // Calculate payment timeline
        $paymentHistory = [];
        $runningTotal = 0;
        
        foreach ($allPayments->reverse() as $index => $p) {
            $runningTotal += $p->amount_paid;
            $paymentHistory[] = [
                'date' => $p->created_at->format('M d, Y g:i A'),
                'amount' => $p->amount_paid,
                'running_total' => $runningTotal,
                'description' => $p->amount_description ?? 'Payment received',
                'is_latest' => $index === $allPayments->count() - 1
            ];
        }
        
        return response()->json([
            'success' => true,
            'student' => $payment->student->name,
            'fee_type' => $payment->fee->type,
            'class_name' => $payment->fee->class->name,
            'total_fee' => $payment->fee->fee_charge,
            'total_paid' => $payment->amount_paid,
            'amount_left' => $payment->amount_left,
            'payment_history' => $paymentHistory
        ]);
    }

    public function feeReport()
    {
        $classes = Classes::where('school_id', Session::get('school_id'))->get();
        
        $report = [];
        foreach ($classes as $class) {
            $fees = ClassFee::where([
                ['school_id', Session::get('school_id')],
                ['class_id', $class->id]
            ])->get();
            
            $totalExpected = 0;
            $totalCollected = 0;
            $totalPending = 0;
            
            foreach ($fees as $fee) {
                $studentCount = User::where([
                    ['school_id', Session::get('school_id')],
                    ['role_id', 3]
                ])->whereHas('student_details', function ($q) use ($class) {
                    $q->where('class_id', $class->id);
                })->count();
                
                $expectedAmount = $fee->fee_charge * $studentCount;
                $collectedAmount = ClassStudentFee::where('fee_id', $fee->id)->sum('amount_paid');
                
                $totalExpected += $expectedAmount;
                $totalCollected += $collectedAmount;
                $totalPending += ($expectedAmount - $collectedAmount);
            }
            
            $report[] = [
                'class' => $class->name,
                'total_expected' => $totalExpected,
                'total_collected' => $totalCollected,
                'total_pending' => $totalPending,
                'collection_rate' => $totalExpected > 0 ? round(($totalCollected / $totalExpected) * 100, 2) : 0
            ];
        }
        
        return view('admin.fee.report', compact('report'));
    }
}