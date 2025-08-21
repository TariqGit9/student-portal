@extends('layouts.student')
@section('content')

<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Fee Details</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
        </div>
    </div>
</div>
<div class="col-xl-12">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">Fee Details: {{ $fee->type }}</h4>
                <i class="mdi">
                    <span class="float-right"><a href="{{ route('student.fees') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back to My Fees</a></span>
                </i>
            </div>
        </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Fee Type:</th>
                                <td>{{ $fee->type }}</td>
                            </tr>
                            <tr>
                                <th>Class:</th>
                                <td>{{ $fee->class->name }}</td>
                            </tr>
                            <tr>
                                <th>Original Amount:</th>
                                <td>{{ currency($fee->fee_charge) }}</td>
                            </tr>
                            @if($fee->late_fee_charge > 0 && $isPastDue)
                                <tr>
                                    <th>Late Fee:</th>
                                    <td class="text-warning">{{ currency($fee->late_fee_charge) }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount:</th>
                                    <td class="font-weight-bold">{{ currency($totalFee) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Due Date:</th>
                                <td>{{ \Carbon\Carbon::parse($fee->date)->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Expiry Date:</th>
                                <td>{{ \Carbon\Carbon::parse($fee->expiry_date)->format('M d, Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        @if($payment)
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fa fa-check-circle"></i> Payment Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <th width="40%">Amount Paid:</th>
                                            <td class="text-success font-weight-bold">{{ currency($payment->amount_paid) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount Due:</th>
                                            <td class="font-weight-bold {{ $payment->amount_left > 0 ? 'text-warning' : 'text-success' }}">
                                                {{ currency($payment->amount_left) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Date Paid:</th>
                                            <td>{{ \Carbon\Carbon::parse($payment->date_paid)->format('M d, Y g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                @if($payment->amount_left == 0)
                                                    <span class="badge badge-success">Fully Paid</span>
                                                @else
                                                    <span class="badge badge-warning">Partial Payment</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($payment->amount_description)
                                            <tr>
                                                <th>Description:</th>
                                                <td>{{ $payment->amount_description }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0"><i class="fa fa-exclamation-triangle"></i> Payment Status</h5>
                                </div>
                                <div class="card-body text-center">
                                    <i class="fa fa-clock fa-3x text-warning mb-3"></i>
                                    <h5>Payment Pending</h5>
                                    <p>No payment has been recorded for this fee yet.</p>
                                    <p class="mb-0">
                                        <strong>Amount Due: {{ currency($totalFee) }}</strong>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($isPastDue && (!$payment || $payment->amount_left > 0))
                    <div class="alert alert-danger mt-3">
                        <h5><i class="fa fa-exclamation-triangle"></i> Overdue Notice</h5>
                        <p>This fee is past its expiry date. Late fees may have been applied. Please contact the administration office immediately to arrange payment.</p>
                        @if($fee->late_fee_charge > 0)
                            <p class="mb-0"><strong>Late Fee Applied: {{ currency($fee->late_fee_charge) }}</strong></p>
                        @endif
                    </div>
                @elseif($payment && $payment->amount_left == 0)
                    <div class="alert alert-success mt-3">
                        <h5><i class="fa fa-check-circle"></i> Payment Complete</h5>
                        <p class="mb-0">Thank you! Your fee payment has been completed successfully.</p>
                    </div>
                @endif

                <div class="mt-4 text-center">
                    <div class="alert alert-info">
                        <h6><i class="fa fa-info-circle"></i> Payment Instructions</h6>
                        <p class="mb-0">For fee payments, please visit the school administration office or contact the accounts department. Online payments are not currently available through this portal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection