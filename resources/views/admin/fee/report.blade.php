@extends('layouts.admin')
@section('content')

<style>
.fee-header {
    background: linear-gradient(135deg, #e3e8ff 0%, #f0f3ff 100%);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.table-fee-report {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.table-fee-report thead {
    background: #f8f9fa;
}

.table-fee-report th {
    border: none;
    padding: 15px;
    font-weight: 600;
    color: #5a5c69;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

.table-fee-report td {
    padding: 15px;
    border-top: 1px solid #e3e6f0;
    vertical-align: middle;
}

.progress {
    height: 25px;
    border-radius: 10px;
    background: #f0f0f0;
}

.progress-bar {
    border-radius: 10px;
    font-weight: 600;
}
</style>

<div class="fee-header">
    <h3 class="mb-0">Fee Collection Report</h3>
</div>

<div class="col-xl-12">
    <div class="card-header pb-0 bg-white mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">SUBJECTS / TEACHER :</h4>
            <div>
                <select class="form-control d-inline-block w-auto mr-2">
                    <option>All Classes</option>
                    @if(isset($classes))
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    @endif
                </select>
                <a href="{{ route('admin.fees') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <button onclick="window.print()" class="btn btn-info">
                    <i class="fa fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    Show 
                    <select class="form-control d-inline-block" style="width: 70px;">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    entries
                </div>
                <div>
                    <input type="text" class="form-control" placeholder="Search:" style="width: 200px;">
                </div>
            </div>

            <div class="table-responsive table-fee-report">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>CLASS</th>
                            <th>TOTAL EXPECTED</th>
                            <th>TOTAL COLLECTED</th>
                            <th>TOTAL PENDING</th>
                            <th>COLLECTION RATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grandTotalExpected = 0;
                            $grandTotalCollected = 0;
                            $grandTotalPending = 0;
                        @endphp
                        
                        @foreach($report as $row)
                            @php
                                $grandTotalExpected += $row['total_expected'];
                                $grandTotalCollected += $row['total_collected'];
                                $grandTotalPending += $row['total_pending'];
                            @endphp
                            <tr>
                                <td><strong>{{ $row['class'] }}</strong></td>
                                <td>{{ currency($row['total_expected']) }}</td>
                                <td class="text-success">{{ currency($row['total_collected']) }}</td>
                                <td class="text-warning">{{ currency($row['total_pending']) }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar 
                                            @if($row['collection_rate'] >= 80) bg-success
                                            @elseif($row['collection_rate'] >= 50) bg-warning
                                            @else bg-danger
                                            @endif" 
                                            style="width: {{ $row['collection_rate'] }}%">
                                            {{ $row['collection_rate'] }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="background: #f8f9fa;">
                        <tr>
                            <th>TOTAL</th>
                            <th>{{ currency($grandTotalExpected) }}</th>
                            <th class="text-success">{{ currency($grandTotalCollected) }}</th>
                            <th class="text-warning">{{ currency($grandTotalPending) }}</th>
                            <th>
                                @php
                                    $overallRate = $grandTotalExpected > 0 ? round(($grandTotalCollected / $grandTotalExpected) * 100, 2) : 0;
                                @endphp
                                <div class="progress">
                                    <div class="progress-bar 
                                        @if($overallRate >= 80) bg-success
                                        @elseif($overallRate >= 50) bg-warning
                                        @else bg-danger
                                        @endif" 
                                        style="width: {{ $overallRate }}%">
                                        {{ $overallRate }}%
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing 1 to {{ count($report) }} of {{ count($report) }} entries
                </div>
                <div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row row-sm justify-content-center mt-4">
        <div class="col-lg-6 col-xl-4 col-md-6 col-12">
            <div class="card bg-success-gradient text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fe fe-check-circle tx-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-white">Total Collected</span>
                                <h2 class="text-white mb-0">{{ currency($grandTotalCollected) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-4 col-md-6 col-12">
            <div class="card bg-warning-gradient text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fe fe-clock tx-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-white">Total Pending</span>
                                <h2 class="text-white mb-0">{{ currency($grandTotalPending) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-4 col-md-6 col-12">
            <div class="card bg-info-gradient text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="icon1 mt-2 text-center">
                                <i class="fe fe-trending-up tx-40"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-0 text-center">
                                <span class="text-white">Collection Rate</span>
                                <h2 class="text-white mb-0">{{ $overallRate }}%</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
@media print {
    .main-header, .main-sidebar, .card-tools, .btn, select, input[type="text"], .pagination, .stats-card {
        display: none !important;
    }
    .content-wrapper {
        margin-left: 0 !important;
    }
    .fee-header {
        background: none !important;
        border: 1px solid #ddd;
    }
}
</style>
@endsection