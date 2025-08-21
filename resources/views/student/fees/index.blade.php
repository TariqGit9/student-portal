@extends('layouts.student')
@section('content')

<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">My Fees</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
        </div>
    </div>
</div>
<div class="col-xl-12">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">My Fee Status - Class: {{ $class->name }}</h4>
            </div>
        </div>
            <div class="card-body">
                @php
                    $totalFees = collect($feeData)->sum('amount');
                    $totalPaid = collect($feeData)->sum('paid');
                    $totalDue = collect($feeData)->sum('due');
                    $paidCount = collect($feeData)->where('status', 'Paid')->count();
                    $unpaidCount = collect($feeData)->where('status', 'Unpaid')->count();
                    $partialCount = collect($feeData)->where('status', 'Partial')->count();
                    $lateCount = collect($feeData)->where('is_late', true)->count();
                @endphp

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-calculator"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Fees</span>
                                <span class="info-box-number">{{ currency($totalFees) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-check-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Paid</span>
                                <span class="info-box-number">{{ currency($totalPaid) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Due</span>
                                <span class="info-box-number">{{ currency($totalDue) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fa fa-exclamation-triangle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Overdue</span>
                                <span class="info-box-number">{{ $lateCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(count($feeData) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Fee Type</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feeData as $fee)
                                    <tr class="{{ $fee['is_late'] ? 'table-warning' : '' }}">
                                        <td>
                                            {{ $fee['type'] }}
                                            @if($fee['is_late'])
                                                <span class="badge badge-danger ml-2">Late</span>
                                            @endif
                                        </td>
                                        <td>{{ currency($fee['amount']) }}</td>
                                        <td>{{ currency($fee['paid']) }}</td>
                                        <td>{{ currency($fee['due']) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($fee['due_date'])->format('M d, Y') }}</td>
                                        <td>
                                            @if($fee['status'] == 'Paid')
                                                <span class="badge badge-success">Paid</span>
                                            @elseif($fee['status'] == 'Partial')
                                                <span class="badge badge-warning">Partial Payment</span>
                                            @else
                                                <span class="badge badge-danger">Unpaid</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('student.fee.details', $fee['id']) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle fa-2x mb-3"></i>
                        <h5>No Fees Assigned</h5>
                        <p>There are currently no fees assigned to your class.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($lateCount > 0)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning">
                <h5><i class="fa fa-exclamation-triangle"></i> Important Notice</h5>
                <p>You have {{ $lateCount }} overdue fee(s). Late fees may have been applied. Please contact the administration office for payment arrangements.</p>
            </div>
        </div>
    </div>
@endif

@endsection