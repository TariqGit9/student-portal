@extends('layouts.teacher')
@section('content')
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">My Attendance</h4>
    </div>
  </div>
</div>

@if(!$school_session)
<div class="card bg-danger text-white mb-3">
  <div class="card-body">
    School Session is not started yet. Please contact administration.
  </div>
</div>
@endif

<!-- Stats Cards -->
<div class="row mb-4">
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card">
      <div class="card-body text-center">
        <h3 class="text-success" id="stat-present">-</h3>
        <p class="mb-0 text-muted">Present</p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card">
      <div class="card-body text-center">
        <h3 class="text-warning" id="stat-absent">-</h3>
        <p class="mb-0 text-muted">Absent</p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card">
      <div class="card-body text-center">
        <h3 class="text-secondary" id="stat-leave">-</h3>
        <p class="mb-0 text-muted">Leave</p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card">
      <div class="card-body text-center">
        <h3 class="text-danger" id="stat-late">-</h3>
        <p class="mb-0 text-muted">Late</p>
      </div>
    </div>
  </div>
</div>

<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <h4 class="card-title mg-b-0">Attendance Records</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="table_data" width="100%" cellspacing="0">
          <thead class="text-primary">
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Status</th>
              <th>On Time</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@push('javascript')
<script>
// Load stats
axios.post("{{ route('teacher-get-my-attendance-stats') }}", {})
.then(function(response) {
    if (response.data.success) {
        $('#stat-present').text(response.data.present);
        $('#stat-absent').text(response.data.absent);
        $('#stat-leave').text(response.data.leave);
        $('#stat-late').text(response.data.late);
    }
});

// DataTable
$('#table_data').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('teacher-get-my-attendance') }}",
        type: 'post',
        data: {
            "_token": "{{ csrf_token() }}",
        }
    },
    columns: [
        { data: 'date', name: 'date' },
        { data: 'time', name: 'time' },
        { data: 'attendance', name: 'attendance', orderable: false },
        { data: 'on_time', name: 'on_time', orderable: false }
    ]
});
</script>
@endpush
@endsection
