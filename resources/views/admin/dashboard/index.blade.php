@extends('layouts.admin')
@push('styles')
<link href="{{asset('assets/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
@endpush
@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Welcome Admin ...</h4>
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
          <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#newNotificationModal" id="openCreateModal"><i class="fe fe-plus mr-1"></i> New Notification</button>
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

<!-- Create / Edit Notification Modal -->
<div class="modal fade" id="newNotificationModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"><i class="fe fe-send mr-2"></i>Send Notification</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="notif_id" value="">
        <div class="form-group">
          <label class="form-label form-required">Send To</label>
          <select class="form-control" id="notif_audience">
            <option value="student">Students</option>
            <option value="teacher">Teachers</option>
            <option value="teacher_and_student">Teachers & Students</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label form-required">Title</label>
          <input type="text" class="form-control" id="notif_title" placeholder="Notification title">
        </div>
        <div class="form-group">
          <label class="form-label form-required">Message</label>
          <textarea class="summernote" id="notif_message"></textarea>
        </div>
        <div class="form-group">
          <label class="form-label form-required">Expiry Date</label>
          <input type="date" class="form-control" id="notif_expiry">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="saveNotification">Send Notification</button>
      </div>
    </div>
  </div>
</div>

@push('javascript')
<script src="{{asset('assets/plugins/summernote/summernote-bs4.js')}}"></script>
<script>
$(document).ready(function() {
  $('.summernote').summernote({ height: 150, toolbar: [
    ['style', ['bold', 'italic', 'underline']],
    ['para', ['ul', 'ol']],
    ['view', ['codeview']]
  ]});

  loadNotifications();
});

var allNotifications = [];

function loadNotifications() {
  axios.get("{{ route('get-notifications') }}").then(function(response) {
    if (response.data.success) {
      allNotifications = response.data.notifications;
      renderNotifications(allNotifications);
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
    html += '    <div class="d-flex justify-content-between align-items-start">';
    html += '      <div style="flex:1">';
    html += '        <h6 class="mb-1">' + n.title + '</h6>';
    html += '        <div class="text-muted mb-2">' + n.message + '</div>';
    html += '        <small class="text-muted"><i class="fe fe-user mr-1"></i>' + n.sender_name + ' &middot; ' + n.created_at + '</small>';
    html += '        <span class="badge badge-' + (audienceColors[n.target_audience] || 'secondary') + ' ml-2">' + (audienceLabels[n.target_audience] || n.target_audience) + '</span>';
    html += '        <small class="text-muted ml-2"><i class="fe fe-clock mr-1"></i>Expires ' + n.expiry_date + '</small>';
    html += '      </div>';
    if (n.is_mine) {
      html += '    <div class="d-flex">';
      html += '      <button class="btn btn-sm btn-outline-primary ml-2 editNotification" data-id="' + n.id + '" title="Edit"><i class="fe fe-edit"></i></button>';
      html += '      <button class="btn btn-sm btn-outline-danger ml-1 deleteNotification" data-id="' + n.id + '" title="Delete"><i class="fe fe-trash-2"></i></button>';
      html += '    </div>';
    }
    html += '    </div>';
    html += '  </div>';
    html += '</div>';
  });
  container.html(html);
}

// Reset modal for creating
$('#openCreateModal').on('click', function() {
  $('#notif_id').val('');
  $('#notif_title').val('');
  $('#notif_message').summernote('code', '');
  $('#notif_audience').val('student');
  $('#notif_expiry').val('');
  $('#modalTitle').html('<i class="fe fe-send mr-2"></i>Send Notification');
  $('#saveNotification').text('Send Notification');
});

// Edit button — populate modal with existing data
$(document).on('click', '.editNotification', function() {
  var id = $(this).data('id');
  var n = allNotifications.find(function(x) { return x.id === id; });
  if (!n) return;

  $('#notif_id').val(n.id);
  $('#notif_title').val(n.title);
  $('#notif_message').summernote('code', n.message);
  $('#notif_audience').val(n.target_audience);
  $('#notif_expiry').val(n.expiry_date_raw);
  $('#modalTitle').html('<i class="fe fe-edit mr-2"></i>Edit Notification');
  $('#saveNotification').text('Update Notification');
  $('#newNotificationModal').modal('show');
});

// Save — create or update
$('#saveNotification').on('click', function() {
  var id = $('#notif_id').val();
  var title = $('#notif_title').val();
  var message = $('#notif_message').summernote('code');
  var audience = $('#notif_audience').val();
  var expiry = $('#notif_expiry').val();

  if (!title) { toastr.warning('Warning!', 'Please enter a title', { "positionClass": "toast-bottom-right" }); return; }
  if ($('#notif_message').summernote('isEmpty')) { toastr.warning('Warning!', 'Please enter a message', { "positionClass": "toast-bottom-right" }); return; }
  if (!expiry) { toastr.warning('Warning!', 'Please select an expiry date', { "positionClass": "toast-bottom-right" }); return; }

  $('#saveNotification').attr('disabled', true);
  var url = id ? "{{ route('update-notification') }}" : "{{ route('store-notification') }}";
  var payload = { title: title, message: message, target_audience: audience, expiry_date: expiry };
  if (id) payload.id = id;

  axios.post(url, payload).then(function(response) {
    $('#saveNotification').attr('disabled', false);
    if (response.data.success) {
      toastr.success('Success!', response.data.result, { "positionClass": "toast-bottom-right" });
      $('#newNotificationModal').modal('hide');
      loadNotifications();
    } else {
      toastr.warning('Warning!', response.data.error, { "positionClass": "toast-bottom-right" });
    }
  });
});

$(document).on('click', '.deleteNotification', function() {
  var id = $(this).data('id');
  Swal.fire({
    title: 'Delete this notification?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ca0b00',
    confirmButtonText: 'Delete',
    reverseButtons: true
  }).then(function(result) {
    if (result.isConfirmed) {
      axios.post("{{ route('delete-notification') }}", { id: id }).then(function(response) {
        if (response.data.success) {
          toastr.success('Success!', response.data.result, { "positionClass": "toast-bottom-right" });
          loadNotifications();
        }
      });
    }
  });
});
</script>
@endpush
@endsection
