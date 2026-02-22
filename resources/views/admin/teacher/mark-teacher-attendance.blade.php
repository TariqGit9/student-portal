@extends('layouts.admin')
@section('content')
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Mark Teacher Attendance</h4>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        @if(!$school_session)
          <div class="card bg-danger text-white">
            <div class="card-body">
              School Session is not started yet. Please set an active session first.
            </div>
          </div>
        @endif
        <form id="submit_teacher_attendance">
          @csrf
          <div class="row row-sm mb-4">
            <div class="col-lg-4">
              <label class="font-weight-bold">Date</label>
              <input class="form-control" name="date" id="date" type="date">
            </div>
            <div class="col-lg-4">
              <label class="font-weight-bold">Time</label>
              <input class="form-control" name="time" id="time" type="text" readonly>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-xl-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
          <h4 class="card-title mg-b-0">Teachers</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mg-b-0 text-md-nowrap">
            <thead>
              <tr>
                <th>#</th>
                <th>Teacher</th>
                <th>Status</th>
                <th class="text-center">On Time</th>
              </tr>
            </thead>
            <tbody>
              @foreach($teachers as $index => $teacher)
              <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('uploads/teacher_avatars/' . ($teacher->avatar ?: 'default.webp')) }}" class="rounded-circle" width="36" height="36" style="object-fit: cover;">
                    <span class="ml-2">{{ $teacher->name }}</span>
                  </div>
                </td>
                <td>
                  <input type="hidden" name="attendance[att-{{ $index }}][id]" value="{{ $teacher->id }}">
                  <select class="form-control" name="attendance[att-{{ $index }}][attendance]" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                    <option value="Leave">Leave</option>
                  </select>
                </td>
                <td class="text-center">
                  <input type="hidden" name="attendance[att-{{ $index }}][on_time]" value="0">
                  <input type="checkbox" name="attendance[att-{{ $index }}][on_time]" value="1" checked class="on-time-check" style="width:18px; height:18px; cursor:pointer;">
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @if($school_session)
          <button type="button" class="btn btn-primary mt-3 save-teacher-attendance">Save Attendance</button>
        @endif
      </div>
    </div>
  </div>
</div>

@push('javascript')
<script>
// Auto fill date and time
(function(){
  var today = new Date();
  // Set date input value in YYYY-MM-DD format for native date picker
  var yyyy = today.getFullYear();
  var mm = String(today.getMonth()+1).padStart(2, '0');
  var dd = String(today.getDate()).padStart(2, '0');
  $("#date").val(yyyy + '-' + mm + '-' + dd);
  var hours = today.getHours();
  var minutes = today.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12;
  minutes = minutes < 10 ? '0' + minutes : minutes;
  $("#time").val(hours + ':' + minutes + ' ' + ampm);
})();

// Convert date input (YYYY-MM-DD) to j-n-Y format for backend
function getFormattedDate() {
  var val = $('#date').val();
  if (!val) return '';
  var parts = val.split('-');
  return parseInt(parts[2]) + '-' + parseInt(parts[1]) + '-' + parts[0];
}

$(document).on('click', '.save-teacher-attendance', function() {
    Swal.fire({
        title: 'Submit Teacher Attendance?',
        text: "Are you sure you want to save this attendance?",
        icon: 'info',
        showCancelButton: true,
        cancelButtonText: "Cancel",
        confirmButtonText: 'Yes, Save',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Build data manually to handle checkboxes properly
            var attendanceData = [];
            @foreach($teachers as $index => $teacher)
            attendanceData.push({
                id: "{{ $teacher->id }}",
                attendance: $('select[name="attendance[att-{{ $index }}][attendance]"]').val(),
                on_time: $('input[type="checkbox"][name="attendance[att-{{ $index }}][on_time]"]').is(':checked') ? 1 : 0
            });
            @endforeach

            axios.post("{{ route('admin-save-teacher-attendance') }}", {
                date: getFormattedDate(),
                time: $('#time').val(),
                attendance: attendanceData
            }).then(function(response) {
                if (response.data.success) {
                    toastr.success('Success!', response.data.msg, {
                        "positionClass": "toast-bottom-right"
                    });
                } else {
                    toastr.error('Error!', response.data.msg, {
                        "positionClass": "toast-bottom-right"
                    });
                }
            });
        }
    });
});
</script>
@endpush
@endsection
