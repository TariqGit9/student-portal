@extends('layouts.admin')
@section('content')

<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">School Sessions</h4>
      <span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>

<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title user-titles">Manage Sessions</h4>
        <span class="float-right">
          <button type="button" id="add_session" class="btn btn-secondary" data-toggle="modal" data-target="#add-session-modal">Add Session</button>
        </span>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="table_data" width="100%" cellspacing="0">
          <thead class="text-primary">
            <tr>
              <th>Session</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Session Modal -->
<div class="modal fade" id="add-session-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add a Session</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="add-sessionForm">
        @csrf
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col">
              <label class="bmd-label-floating form-required">Name</label>
              <input type="text" class="form-control" id="session_name" name="name" placeholder="e.g. 2025-2026">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col">
              <label class="bmd-label-floating">Status</label>
              <select class="form-control selectpicker" data-live-search="true" name="status" id="session_status">
                <option value="0">Deactivate</option>
                <option value="1">Activate</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add-session-btn">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('javascript')
<script>
var datatable = $('#table_data').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('admin-get-school-sessions') }}",
        type: 'post',
        data: {
            "_token": "{{ csrf_token() }}",
        }
    },
    columns: [
        { data: 'name', name: 'name', orderable: false },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false }
    ]
});

// Add session
$(document).on('click', '.add-session-btn', function() {
    if ($("#session_name").val() == "") {
        toastr.warning('Warning!', "Please enter session name", {
            "positionClass": "toast-bottom-right"
        });
        $("#session_name").focus();
        return;
    }

    if ($("#session_status").val() == 1) {
        $('#add-session-modal').modal('hide');
        Swal.fire({
            title: 'Are you sure?',
            text: 'Activating this session will deactivate the current active session.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#4BB543',
            cancelButtonText: "Cancel",
            confirmButtonText: "Ok",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                addSession();
            } else {
                $('#add-session-modal').modal('show');
            }
        });
    } else {
        addSession();
    }
});

function addSession() {
    $('#please_wait').modal('show');
    $('.add-session-btn').attr("disabled", true);
    axios.post("{{ route('admin-add-session') }}", $('#add-sessionForm').serialize())
    .then(function(response) {
        $('.add-session-btn').attr("disabled", false);
        $('#please_wait').modal('hide');
        if (response.data.success) {
            $('#add-session-modal').modal('hide');
            toastr.success('Success!', 'Session added successfully', {
                "positionClass": "toast-bottom-right"
            });
            $("#session_name").val("");
            $(".selectpicker").selectpicker("refresh");
            datatable.draw();
        }
    });
}

// Toggle session status
$(document).on('click', '.toggle_block_data', function() {
    var id = $(this).data('id');
    var status = $(this).data('status');

    if (status == 1) {
        var Text_message = "Activating this session will deactivate all other sessions.";
        var Text_button = "Activate";
        var color = '#4BB543';
    } else {
        var Text_message = "Are you sure you want to deactivate this session?";
        var Text_button = "Deactivate";
        var color = '#ca0b00';
    }

    Swal.fire({
        title: 'Change Session Status',
        text: Text_message,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: color,
        cancelButtonText: "Cancel",
        confirmButtonText: Text_button,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post("{{ route('admin-change-school-session') }}", {
                status: status, id: id,
            }).then(function(response) {
                toastr.success('Success!', 'Session status changed successfully', {
                    "positionClass": "toast-bottom-right"
                });
                datatable.draw();
            });
        }
    });
});
</script>
@endpush
@endsection
