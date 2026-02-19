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
                <h4 class="card-title" id="card-title">Fee Details</h4>
                <i class="mdi">
                    <span class="float-right"><a href="{{ route('student.fees') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back to My Fees</a></span>
                </i>
            </div>
        </div>
        <div class="card-body" id="fee-details-content">
            <div class="text-center py-4">
                <img src="{{asset('assets/img/loader.svg')}}" width="40" height="40" alt="Loading">
                <p class="mt-2 text-muted">Loading fee details...</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('javascript')
<script>
$(document).ready(function() {
    axios.get("{{ route('student.get-fee-details', $feeId) }}")
        .then(function(response) {
            var data = response.data;
            if (!data.success) return;

            var fee = data.fee;
            var payment = data.payment;

            $('#card-title').text('Fee Details: ' + fee.type);

            var html = '<div class="row"><div class="col-md-6">';

            // Fee info table
            html += '<table class="table table-borderless">' +
                '<tr><th width="40%">Fee Type:</th><td>' + fee.type + '</td></tr>' +
                '<tr><th>Class:</th><td>' + fee.class_name + '</td></tr>' +
                '<tr><th>Original Amount:</th><td>' + fee.original_amount + '</td></tr>';

            if (fee.late_fee) {
                html += '<tr><th>Late Fee:</th><td class="text-warning">' + fee.late_fee + '</td></tr>' +
                    '<tr><th>Total Amount:</th><td class="font-weight-bold">' + fee.total_amount + '</td></tr>';
            }

            html += '<tr><th>Due Date:</th><td>' + fee.due_date + '</td></tr>' +
                '<tr><th>Expiry Date:</th><td>' + fee.expiry_date + '</td></tr>' +
                '</table></div>';

            // Payment info
            html += '<div class="col-md-6">';

            if (payment) {
                var headerClass = payment.amount_left_raw == 0 ? 'bg-success' : 'bg-warning';
                var statusBadge = payment.status === 'Paid'
                    ? '<span class="badge badge-success">Fully Paid</span>'
                    : '<span class="badge badge-warning">Partial Payment</span>';
                var amountLeftClass = payment.amount_left_raw > 0 ? 'text-warning' : 'text-success';

                html += '<div class="card"><div class="card-header ' + headerClass + ' text-white">' +
                    '<h5 class="mb-0"><i class="fa fa-check-circle"></i> Payment Information</h5></div>' +
                    '<div class="card-body"><table class="table table-borderless mb-0">' +
                    '<tr><th width="40%">Amount Paid:</th><td class="text-success font-weight-bold">' + payment.amount_paid + '</td></tr>' +
                    '<tr><th>Amount Due:</th><td class="font-weight-bold ' + amountLeftClass + '">' + payment.amount_left + '</td></tr>' +
                    '<tr><th>Date Paid:</th><td>' + payment.date_paid + '</td></tr>' +
                    '<tr><th>Status:</th><td>' + statusBadge + '</td></tr>';

                if (payment.description) {
                    html += '<tr><th>Description:</th><td>' + payment.description + '</td></tr>';
                }

                html += '</table></div></div>';
            } else {
                html += '<div class="card"><div class="card-header bg-warning text-white">' +
                    '<h5 class="mb-0"><i class="fa fa-exclamation-triangle"></i> Payment Status</h5></div>' +
                    '<div class="card-body text-center">' +
                    '<i class="fa fa-clock fa-3x text-warning mb-3"></i>' +
                    '<h5>Payment Pending</h5>' +
                    '<p>No payment has been recorded for this fee yet.</p>' +
                    '<p class="mb-0"><strong>Amount Due: ' + data.total_fee_formatted + '</strong></p>' +
                    '</div></div>';
            }

            html += '</div></div>';

            // Alerts
            if (fee.is_past_due && (!payment || payment.amount_left_raw > 0)) {
                html += '<div class="alert alert-danger mt-3">' +
                    '<h5><i class="fa fa-exclamation-triangle"></i> Overdue Notice</h5>' +
                    '<p>This fee is past its expiry date. Late fees may have been applied. Please contact the administration office immediately to arrange payment.</p>';
                if (fee.late_fee) {
                    html += '<p class="mb-0"><strong>Late Fee Applied: ' + fee.late_fee + '</strong></p>';
                }
                html += '</div>';
            } else if (payment && payment.amount_left_raw == 0) {
                html += '<div class="alert alert-success mt-3">' +
                    '<h5><i class="fa fa-check-circle"></i> Payment Complete</h5>' +
                    '<p class="mb-0">Thank you! Your fee payment has been completed successfully.</p></div>';
            }

            html += '<div class="mt-4 text-center"><div class="alert alert-info">' +
                '<h6><i class="fa fa-info-circle"></i> Payment Instructions</h6>' +
                '<p class="mb-0">For fee payments, please visit the school administration office or contact the accounts department. Online payments are not currently available through this portal.</p>' +
                '</div></div>';

            $('#fee-details-content').html(html);
        })
        .catch(function(error) {
            var msg = 'Something went wrong. Please refresh the page.';
            if (error.response && error.response.status === 403) {
                msg = 'You are not authorized to view this fee.';
            }
            $('#fee-details-content').html(
                '<div class="alert alert-danger text-center">' +
                    '<i class="fa fa-exclamation-circle fa-2x mb-3"></i>' +
                    '<h5>Error</h5><p>' + msg + '</p>' +
                '</div>'
            );
        });
});
</script>
@endpush
