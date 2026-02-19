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
                <h4 class="card-title" id="card-title">My Fee Status</h4>
            </div>
        </div>
        <div class="row ml-2 mr-2">
            <div class=" col-xl-3 col-lg-6 col-md-6">
                <div class="card  bg-info-gradient">
                    <div class="card-body">
                        <div class="counter-status d-flex md-mb-0">
                            <div class="counter-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div class="ml-auto">
                                <h5 class="tx-13 tx-white-8 mb-3">Total Fees</h5>
                                <h2 class="counter mb-0 text-white"  id="total-fees">--</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card  bg-success-gradient">
                    <div class="card-body">
                        <div class="counter-status d-flex md-mb-0">
                            <div class="counter-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="ml-auto">
                                <h5 class="tx-13 tx-white-8 mb-3">Total Paid</h5>
                                <h2 class="counter mb-0 text-white"  id="total-paid">--</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card  bg-warning-gradient">
                    <div class="card-body">
                        <div class="counter-status d-flex md-mb-0">
                            <div class="counter-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="ml-auto">
                                <h5 class="tx-13 tx-white-8 mb-3">Total Due</h5>
                                <h2 class="counter mb-0 text-white"  id="total-due">--</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card  bg-danger-gradient">
                    <div class="card-body">
                        <div class="counter-status d-flex md-mb-0">
                            <div class="counter-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="ml-auto">
                                <h5 class="tx-13 tx-white-8 mb-3">Total Overdue</h5>
                                <h2 class="counter mb-0 text-white"  id="total-overdue">--</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <div class="card-body">
            <!-- <div class="row mb-4">
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fa-calculator"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Fees</span>
                            <span class="info-box-number" id="total-fees">--</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Paid</span>
                            <span class="info-box-number" id="total-paid">--</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fa fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Due</span>
                            <span class="info-box-number" id="total-due">--</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fa fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Overdue</span>
                            <span class="info-box-number" id="total-overdue">--</span>
                        </div>
                    </div>
                </div>
            </div> -->

            <div id="fees-content">
                <div class="text-center py-4">
                    <img src="{{asset('assets/img/loader.svg')}}" width="40" height="40" alt="Loading">
                    <p class="mt-2 text-muted">Loading fees...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="overdue-alert-container"></div>

@endsection

@push('javascript')
<script>
$(document).ready(function() {
    axios.get("{{ route('student.get-my-fees') }}")
        .then(function(response) {
            var data = response.data;
            if (!data.success) return;

            $('#card-title').text('My Fee Status - Class: ' + data.class_name);

            var fees = data.fees;
            var totalFees = 0, totalPaid = 0, totalDue = 0, lateCount = 0;

            fees.forEach(function(f) {
                totalFees += f.amount;
                totalPaid += f.paid;
                totalDue += f.due;
                if (f.is_late) lateCount++;
            });

            // Use first fee's formatted string as a template to get currency symbol/format
            if (fees.length > 0) {
                var sym = fees[0].amount_formatted.replace(/[\d,.\s]+$/, '').trim() || fees[0].amount_formatted.replace(/[\d,.]+.*/, '').trim();
            }

            $('#total-fees').text(fees.length > 0 ? currency(totalFees, fees[0].amount_formatted) : '--');
            $('#total-paid').text(fees.length > 0 ? currency(totalPaid, fees[0].paid_formatted) : '--');
            $('#total-due').text(fees.length > 0 ? currency(totalDue, fees[0].due_formatted) : '--');
            $('#total-overdue').text(lateCount);

            if (fees.length === 0) {
                $('#fees-content').html(
                    '<div class="alert alert-info text-center">' +
                        '<i class="fa fa-info-circle fa-2x mb-3"></i>' +
                        '<h5>No Fees Assigned</h5>' +
                        '<p>There are currently no fees assigned to your class.</p>' +
                    '</div>'
                );
                return;
            }

            var html = '<div class="table-responsive"><table class="table table-bordered table-striped">' +
                '<thead><tr>' +
                    '<th>Fee Type</th><th>Amount</th><th>Paid</th><th>Due</th><th>Due Date</th><th>Status</th><th>Action</th>' +
                '</tr></thead><tbody>';

            fees.forEach(function(fee) {
                var rowClass = fee.is_late ? 'table-warning' : '';
                var lateBadge = fee.is_late ? ' <span class="badge badge-danger ml-2">Late</span>' : '';

                var statusBadge = '';
                if (fee.status === 'Paid') {
                    statusBadge = '<span class="badge badge-success">Paid</span>';
                } else if (fee.status === 'Partial') {
                    statusBadge = '<span class="badge badge-warning">Partial Payment</span>';
                } else {
                    statusBadge = '<span class="badge badge-danger">Unpaid</span>';
                }

                html += '<tr class="' + rowClass + '">' +
                    '<td>' + fee.type + lateBadge + '</td>' +
                    '<td>' + fee.amount_formatted + '</td>' +
                    '<td>' + fee.paid_formatted + '</td>' +
                    '<td>' + fee.due_formatted + '</td>' +
                    '<td>' + fee.due_date + '</td>' +
                    '<td>' + statusBadge + '</td>' +
                    '<td><a href="' + fee.details_url + '" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> View Details</a></td>' +
                '</tr>';
            });

            html += '</tbody></table></div>';
            $('#fees-content').html(html);

            if (lateCount > 0) {
                $('#overdue-alert-container').html(
                    '<div class="row"><div class="col-12">' +
                        '<div class="alert alert-warning">' +
                            '<h5><i class="fa fa-exclamation-triangle"></i> Important Notice</h5>' +
                            '<p>You have ' + lateCount + ' overdue fee(s). Late fees may have been applied. Please contact the administration office for payment arrangements.</p>' +
                        '</div>' +
                    '</div></div>'
                );
            }
        })
        .catch(function() {
            $('#fees-content').html(
                '<div class="alert alert-danger text-center">' +
                    '<i class="fa fa-exclamation-circle fa-2x mb-3"></i>' +
                    '<h5>Error Loading Fees</h5>' +
                    '<p>Something went wrong. Please refresh the page.</p>' +
                '</div>'
            );
        });

    // Helper: replace the number portion of a formatted currency string with a new value
    function currency(amount, template) {
        return template.replace(/[\d,]+(\.\d+)?/, amount.toLocaleString());
    }
});
</script>
@endpush
