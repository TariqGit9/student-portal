@extends('layouts.admin')
@section('content')
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Teacher Attendance History</h4>
    </div>
  </div>
</div>

<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title mg-b-0">Attendance Records</h4>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="table_data" width="100%" cellspacing="0">
          <thead class="text-primary">
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Present</th>
              <th>Absent</th>
              <th>Leave</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Attendance Detail - <span id="detail-date"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table mg-b-0">
            <thead>
              <tr>
                <th>#</th>
                <th>Teacher</th>
                <th>Status</th>
                <th>On Time</th>
              </tr>
            </thead>
            <tbody id="detail-body">
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

@push('javascript')
<script>
var datatable = $('#table_data').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('admin-get-teacher-attendance-records') }}",
        type: 'post',
        data: {
            "_token": "{{ csrf_token() }}",
        }
    },
    columns: [
        { data: 'date', name: 'date' },
        { data: 'time', name: 'time' },
        { data: 'total_present', name: 'total_present', orderable: false },
        { data: 'total_absent', name: 'total_absent', orderable: false },
        { data: 'total_leave', name: 'total_leave', orderable: false },
        { data: 'action', name: 'action', orderable: false }
    ]
});

$(document).on('click', '.view-attendance-detail', function() {
    var id = $(this).data('id');
    axios.post("{{ route('admin-get-teacher-attendance-detail') }}", {
        id: id
    }).then(function(response) {
        if (response.data.success) {
            $('#detail-date').text(response.data.date + ' ' + response.data.time);
            var html = '';
            response.data.details.forEach(function(detail, index) {
                var statusColor = detail.attendance == 'Present' ? 'success' : (detail.attendance == 'Leave' ? 'secondary' : 'warning');
                var onTimeHtml = detail.attendance != 'Present' ? '<span class="text-muted">--</span>' : (detail.on_time ? '<span class="badge badge-success">On Time</span>' : '<span class="badge badge-danger">Late</span>');
                html += '<tr>';
                html += '<td>' + (index + 1) + '</td>';
                html += '<td><div class="d-flex align-items-center"><img src="/student-portal/uploads/teacher_avatars/' + detail.avatar + '" class="rounded-circle" width="30" height="30" style="object-fit:cover;"><span class="ml-2">' + detail.teacher_name + '</span></div></td>';
                html += '<td><span class="badge badge-' + statusColor + '">' + detail.attendance + '</span></td>';
                html += '<td>' + onTimeHtml + '</td>';
                html += '</tr>';
            });
            $('#detail-body').html(html);
            $('#detail-modal').modal('show');
        }
    });
});
</script>
@endpush
@endsection
