@extends('layouts.admin')
@section('content')

@php
    $grandTotalExpected = 0;
    $grandTotalCollected = 0;
    $grandTotalPending = 0;
    foreach($report as $row) {
        $grandTotalExpected += $row['total_expected'];
        $grandTotalCollected += $row['total_collected'];
        $grandTotalPending += $row['total_pending'];
    }
    $overallRate = $grandTotalExpected > 0 ? round(($grandTotalCollected / $grandTotalExpected) * 100, 1) : 0;
@endphp

<div class="card-header mt-2 mb-2 pb-0">
    <div class="d-flex justify-content-between ">
        <h4 class="card-title mg-b-0">Fee Collection Report :</h4>
        <select class="form-control mb-4" id="classFilter">
            <option value="">All Classes</option>
            @if(isset($classes))
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>


<br>

<!-- Summary Cards -->
<div class="row row-sm">
    <div class="col-lg-6 col-xl-3 col-md-6 col-12">
        <div class="card bg-primary-gradient text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="icon1 mt-2 text-center">
                            <i class="fa fa-file-invoice-dollar tx-40"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-0 text-center">
                            <span class="text-white">Total Expected</span>
                            <h3 class="text-white mb-0">{{ currency($grandTotalExpected) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 col-md-6 col-12">
        <div class="card bg-success-gradient text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="icon1 mt-2 text-center">
                            <i class="fa fa-check-circle tx-40"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-0 text-center">
                            <span class="text-white">Total Collected</span>
                            <h3 class="text-white mb-0">{{ currency($grandTotalCollected) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 col-md-6 col-12">
        <div class="card bg-danger-gradient text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="icon1 mt-2 text-center">
                            <i class="fa fa-exclamation-triangle tx-40"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-0 text-center">
                            <span class="text-white">Total Pending</span>
                            <h3 class="text-white mb-0">{{ currency($grandTotalPending) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 col-md-6 col-12">
        <div class="card bg-info-gradient text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="icon1 mt-2 text-center">
                            <i class="fa fa-chart-line tx-40"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-0 text-center">
                            <span class="text-white">Collection Rate</span>
                            <h3 class="text-white mb-0">Percent {{ $overallRate }}%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Table -->
@forelse($report as $row)
<div class="card report-row" data-class-id="{{ $row['class_id'] ?? '' }}">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mg-b-0 text-primary">{{ $row['class'] }}</h4>
            <span class="badge badge-{{ $row['collection_rate'] >= 80 ? 'success' : ($row['collection_rate'] >= 50 ? 'warning' : 'danger') }}">
                Collected : {{ $row['collection_rate'] }}%
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered mg-b-0 text-md-nowrap">
                <thead>
                    <tr>
                        <th>Total Expected</th>
                        <th>Total Collected</th>
                        <th>Total Pending</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ currency($row['total_expected']) }}</td>
                        <td class="text-success font-weight-bold">{{ currency($row['total_collected']) }}</td>
                        <td class="{{ $row['total_pending'] > 0 ? 'text-danger' : 'text-muted' }} font-weight-bold">{{ currency($row['total_pending']) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@empty
<div class="card">
    <div class="card-body text-center text-muted py-5">
        No fee data available
    </div>
</div>
@endforelse

@push('javascript')
<script>
$('#classFilter').on('change', function() {
    var selected = $(this).val();
    if (!selected) {
        $('.report-row').show();
    } else {
        $('.report-row').hide();
        $('.report-row[data-class-id="' + selected + '"]').show();
    }
});
</script>
@endpush

@endsection

@section('styles')
<style>
@media print {
    .main-header, .main-sidebar, .btn, #classFilter { display: none !important; }
    .content-wrapper { margin-left: 0 !important; }
}
</style>
@endsection
