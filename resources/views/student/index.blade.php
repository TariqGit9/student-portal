@extends('layouts.student')
@push('styles')
@endpush
@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Welcome {{Auth::user()->name}} ...</h4>
    </div>
  </div>
</div>

<!-- Noticeboard -->
<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title mg-b-0"><i class="fe fe-bell mr-2"></i>Noticeboard</h4>
        </div>
      </div>
      <div class="card-body">
        <div id="notifications-container">
          <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('javascript')
<script>
$(document).ready(function() {
  loadNotifications();
});

function loadNotifications() {
  axios.get("{{ route('get-notifications') }}").then(function(response) {
    if (response.data.success) {
      renderNotifications(response.data.notifications);
    }
  });
}

function renderNotifications(notifications) {
  var container = $('#notifications-container');
  if (notifications.length === 0) {
    container.html('<div class="text-center py-5"><i class="fe fe-bell-off tx-50 text-muted"></i><p class="text-muted mt-3 mb-0">No notifications yet</p></div>');
    return;
  }
  var html = '';
  notifications.forEach(function(n) {
    var audienceLabels = { admin: 'Admins', teacher: 'Teachers', student: 'Students', teacher_and_student: 'Teachers & Students' };
    var audienceColors = { admin: 'danger', teacher: 'info', student: 'success', teacher_and_student: 'warning' };
    html += '<div class="card border mb-3">';
    html += '  <div class="card-body p-3">';
    html += '    <div style="flex:1">';
    html += '      <h6 class="mb-1">' + n.title + '</h6>';
    html += '      <div class="text-muted mb-2">' + n.message + '</div>';
    html += '      <small class="text-muted"><i class="fe fe-user mr-1"></i>' + n.sender_name + ' &middot; ' + n.created_at + '</small>';
    html += '      <small class="text-muted ml-2"><i class="fe fe-clock mr-1"></i>Expires ' + n.expiry_date + '</small>';
    html += '    </div>';
    html += '  </div>';
    html += '</div>';
  });
  container.html(html);
}
</script>
@endpush
@endsection
