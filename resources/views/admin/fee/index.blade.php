@extends('layouts.admin')
@section('content')

<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Fee Management</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
        </div>
    </div>
</div>
<div class="col-xl-12">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">Manage School Fees</h4>
                <i class="mdi">
                    <span class="float-right">&nbsp;<a href="{{ route('admin.fee.report') }}" class="btn btn-info">Fee Report</a></span>
                    <span class="float-right"><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addFeeModal">Add New Fee</button></span>
                </i>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="feesTable" class="table datatable" width="100%" cellspacing="0">
                    <thead class="text-primary">
                        <tr>
                            <th>Fee Type</th>
                            <th>Class</th>
                            <th>Amount</th>
                            <th>Late Fee</th>
                            <th>Due Date</th>
                            <th>Expiry Date</th>
                            <th>Total Collected</th>
                            <th>Students Paid</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Fee Modal -->
<div class="modal fade" id="addFeeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Fee</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="addFeeForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fee Type</label>
                        <select name="type" class="form-control" required>
                            <option value="">Select Fee Type</option>
                            <option value="Tuition Fee">Tuition Fee</option>
                            <option value="Examination Fee">Examination Fee</option>
                            <option value="Library Fee">Library Fee</option>
                            <option value="Sports Fee">Sports Fee</option>
                            <option value="Lab Fee">Lab Fee</option>
                            <option value="Transport Fee">Transport Fee</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Class</label>
                        <select name="class_id" class="form-control" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fee Amount</label>
                        <input type="number" name="fee_charge" class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Late Fee Amount</label>
                        <input type="number" name="late_fee_charge" class="form-control" step="0.01" min="0" value="0">
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Fee</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Fee Modal -->
<div class="modal fade" id="editFeeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Fee</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="editFeeForm">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fee Type</label>
                        <select name="edit_type" id="edit_type" class="form-control" required>
                            <option value="">Select Fee Type</option>
                            <option value="Tuition Fee">Tuition Fee</option>
                            <option value="Examination Fee">Examination Fee</option>
                            <option value="Library Fee">Library Fee</option>
                            <option value="Sports Fee">Sports Fee</option>
                            <option value="Lab Fee">Lab Fee</option>
                            <option value="Transport Fee">Transport Fee</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Class</label>
                        <select name="edit_class_id" id="edit_class_id" class="form-control" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fee Amount</label>
                        <input type="number" name="edit_fee_charge" id="edit_fee_charge" class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Late Fee Amount</label>
                        <input type="number" name="edit_late_fee_charge" id="edit_late_fee_charge" class="form-control" step="0.01" min="0" value="0">
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="date" name="edit_date" id="edit_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Expiry Date</label>
                        <input type="date" name="edit_expiry_date" id="edit_expiry_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Fee</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('javascript')
<script>
// Helper function for notifications
function showNotification(type, message) {
    if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } else {
        alert(type.toUpperCase() + ': ' + message);
    }
}

$(document).ready(function() {
    // Initialize DataTable
    var table = $('#feesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.get-fees') }}",
        columns: [
            { data: 'type', name: 'type' },
            { data: 'class_name', name: 'class_name' },
            { data: 'fee_charge', name: 'fee_charge', render: function(data) {
                return '{{ currency_symbol() }} ' + parseFloat(data).toFixed(2);
            }},
            { data: 'late_fee_charge', name: 'late_fee_charge', render: function(data) {
                return '{{ currency_symbol() }} ' + parseFloat(data).toFixed(2);
            }},
            { data: 'date', name: 'date' },
            { data: 'expiry_date', name: 'expiry_date' },
            { data: 'total_collected', name: 'total_collected', render: function(data) {
                return '{{ currency_symbol() }} ' + data;
            }},
            { data: 'students_paid', name: 'students_paid' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        error: function(xhr, error, code) {
            console.log('DataTable Error:', xhr, error, code);
            showNotification('error', 'Failed to load fees data');
        }
    });

    // Add Fee
    $('#addFeeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.add-fee') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#addFeeModal').modal('hide');
                    $('#addFeeForm')[0].reset();
                    table.ajax.reload();
                    showNotification('success', response.message);
                }
            },
            error: function(xhr) {
                console.log('Add Fee Error:', xhr);
                showNotification('error', 'An error occurred while adding fee');
            }
        });
    });

    // Edit Fee
    $(document).on('click', '.editFee', function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_type').val($(this).data('type'));
        $('#edit_class_id').val($(this).data('class'));
        $('#edit_fee_charge').val($(this).data('fee'));
        $('#edit_late_fee_charge').val($(this).data('late'));
        $('#edit_date').val($(this).data('date'));
        $('#edit_expiry_date').val($(this).data('expiry'));
    });

    $('#editFeeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.update-fee') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    $('#editFeeModal').modal('hide');
                    table.ajax.reload();
                    showNotification('success', response.message);
                }
            },
            error: function(xhr) {
                console.log('Edit Fee Error:', xhr);
                showNotification('error', 'An error occurred while updating fee');
            }
        });
    });

    // Delete Fee
    $(document).on('click', '.deleteFee', function() {
        if(confirm('Are you sure you want to delete this fee?')) {
            $.ajax({
                url: "{{ route('admin.delete-fee') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $(this).data('id')
                },
                success: function(response) {
                    if(response.success) {
                        table.ajax.reload();
                        showNotification('success', response.message);
                    }
                },
                error: function(xhr) {
                    console.log('Delete Fee Error:', xhr);
                    showNotification('error', 'An error occurred while deleting fee');
                }
            });
        }
    });
});
</script>
@endpush