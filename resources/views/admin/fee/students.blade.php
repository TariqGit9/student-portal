@extends('layouts.admin')
@section('content')

<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Student Fee Payments</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
        </div>
    </div>
</div>
<div class="col-xl-12">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">Fee: {{ $fee->type }} - Class: {{ $class->name }}</h4>
                <i class="mdi">
                    <span class="float-right"><a href="{{ route('admin.fees') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back to Fees</a></span>
                </i>
            </div>
        </div>
            <div class="card-body">
                <div class="row row-sm mb-4">
                    <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                        <div class="card bg-info-gradient text-white">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="icon1 mt-2 text-center">
                                            <i class="fe fe-dollar-sign tx-30"></i>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="mt-0">
                                            <span class="text-white" style="font-size: 12px;">Fee Amount</span>
                                            <h4 class="text-white mb-0">{{ currency($fee->fee_charge) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                        <div class="card bg-warning-gradient text-white">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="icon1 mt-2 text-center">
                                            <i class="fe fe-clock tx-30"></i>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="mt-0">
                                            <span class="text-white" style="font-size: 12px;">Late Fee</span>
                                            <h4 class="text-white mb-0">{{ currency($fee->late_fee_charge) }}</h4>
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
                                    <div class="col-4">
                                        <div class="icon1 mt-2 text-center">
                                            <i class="fe fe-calendar tx-30"></i>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="mt-0">
                                            <span class="text-white" style="font-size: 12px;">Due Date</span>
                                            <h4 class="text-white mb-0">{{ \Carbon\Carbon::parse($fee->date)->format('M d, Y') }}</h4>
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
                                    <div class="col-4">
                                        <div class="icon1 mt-2 text-center">
                                            <i class="fe fe-users tx-30"></i>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="mt-0">
                                            <span class="text-white" style="font-size: 12px;">Total Students</span>
                                            <h4 class="text-white mb-0">{{ count($students) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="studentFeesTable" class="table datatable" width="100%" cellspacing="0">
                        <thead class="text-primary">
                            <tr>
                            <th>Registration No</th>
                            <th>Student Name</th>
                            <th>Fee Amount</th>
                            <th>Amount Paid</th>
                            <th>Amount Due</th>
                            <th>Date Paid</th>
                            <th>Status</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Record Payment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="paymentForm">
                @csrf
                <input type="hidden" name="student_id" id="payment_student_id">
                <input type="hidden" name="fee_id" value="{{ $fee->id }}">
                <input type="hidden" name="payment_id" id="payment_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" id="payment_student_name" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Amount Due</label>
                        <input type="text" id="payment_amount_due" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Payment Amount</label>
                        <input type="number" name="amount" id="payment_amount" class="form-control" step="0.01" min="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Payment Description (Optional)</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Cash/Check/Bank Transfer etc."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Record Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Payment History Modal -->
<div class="modal fade" id="paymentHistoryModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Payment History</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Student:</strong> <span id="history_student_name"></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Fee:</strong> <span id="history_fee_type"></span> - <span id="history_class_name"></span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h6>Total Fee</h6>
                                <h4 id="history_total_fee"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h6>Total Paid</h6>
                                <h4 id="history_total_paid"></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h6>Amount Left</h6>
                                <h4 id="history_amount_left"></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <h5>Payment Timeline</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Running Total</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody id="payment_timeline">
                            <!-- Payment history will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('javascript')
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#studentFeesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.get-student-fees') }}",
            data: { fee_id: {{ $fee->id }} }
        },
        columns: [
            { data: 'reg_no', name: 'reg_no' },
            { data: 'name', name: 'name' },
            { data: 'fee_amount', name: 'fee_amount', render: function(data) {
                return '{{ currency_symbol() }} ' + parseFloat(data).toFixed(2);
            }},
            { data: 'amount_paid', name: 'amount_paid', render: function(data) {
                return '{{ currency_symbol() }} ' + parseFloat(data).toFixed(2);
            }},
            { data: 'amount_left', name: 'amount_left', render: function(data) {
                return '{{ currency_symbol() }} ' + parseFloat(data).toFixed(2);
            }},
            { data: 'date_paid', name: 'date_paid', render: function(data) {
                return data || 'Not Paid';
            }},
            { data: 'status_badge', name: 'status', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Record Payment
    $(document).on('click', '.recordPayment', function() {
        $('#payment_student_id').val($(this).data('student'));
        $('#payment_student_name').val($(this).data('name'));
        $('#payment_amount_due').val('{{ currency_symbol() }} ' + parseFloat($(this).data('amount')).toFixed(2));
        $('#payment_amount').val($(this).data('amount'));
        $('#payment_amount').attr('max', $(this).data('amount'));
        $('#payment_id').val($(this).data('payment') || '');
    });

    $('#paymentForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.record-payment') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#paymentModal').modal('hide');
                    $('#paymentForm')[0].reset();
                    table.ajax.reload();
                    toastr.success(response.message);
                }
            },
            error: function(xhr) {
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    for(var key in errors) {
                        toastr.error(errors[key][0]);
                    }
                } else {
                    toastr.error('An error occurred');
                }
            }
        });
    });

    // View Payment History
    $(document).on('click', '.viewPaymentHistory', function() {
        var paymentId = $(this).data('payment');
        
        $.ajax({
            url: "{{ route('admin.payment-history', '') }}/" + paymentId,
            method: 'GET',
            success: function(response) {
                if(response.success) {
                    // Populate modal with payment data
                    $('#history_student_name').text(response.student);
                    $('#history_fee_type').text(response.fee_type);
                    $('#history_class_name').text(response.class_name);
                    $('#history_total_fee').text('{{ currency_symbol() }} ' + parseFloat(response.total_fee).toFixed(2));
                    $('#history_total_paid').text('{{ currency_symbol() }} ' + parseFloat(response.total_paid).toFixed(2));
                    $('#history_amount_left').text('{{ currency_symbol() }} ' + parseFloat(response.amount_left).toFixed(2));
                    
                    // Populate payment timeline
                    var timelineHtml = '';
                    response.payment_history.forEach(function(payment) {
                        var rowClass = payment.is_latest ? 'table-success' : '';
                        timelineHtml += '<tr class="' + rowClass + '">';
                        timelineHtml += '<td>' + payment.date + '</td>';
                        timelineHtml += '<td>{{ currency_symbol() }} ' + parseFloat(payment.amount).toFixed(2) + '</td>';
                        timelineHtml += '<td>{{ currency_symbol() }} ' + parseFloat(payment.running_total).toFixed(2) + '</td>';
                        timelineHtml += '<td>' + payment.description + '</td>';
                        timelineHtml += '</tr>';
                    });
                    $('#payment_timeline').html(timelineHtml);
                    
                    // Show modal
                    $('#paymentHistoryModal').modal('show');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to load payment history');
            }
        });
    });
});
</script>
@endpush