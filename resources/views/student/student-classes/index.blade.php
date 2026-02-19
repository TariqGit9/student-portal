@extends('layouts.student')
@push('styles')
@endpush
@section('content')

<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Classes</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">Classes </h4>
        {{-- <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Class</button></span></i> --}}
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="Table" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                      <th >Class</th>
                      <th >Subject</th>
                      <th style="width: 35%">Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
{{-- Report teacher modal hidden for now
<div class="modal fade " id="student_report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Report a Student </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form id="report_student">
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col ">
            <label class="bmd-label-floating form-required">Name </label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" disabled>
          </div>
          <input type="hidden" class="form-control" id="teacher_id" name="teacher_id" aria-describedby="emailHelp">
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label class="bmd-label-floating">Title</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" >

          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label class="bmd-label-floating">Description</label>
            <textarea  class="editsummer summernote" name="description"
            id="description"  ></textarea>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary sendreport">Save changes</button>
      </form>
      </div>
    </div>
  </div>
</div>
--}}

@push('javascript')
<script>
        var datatable = $('#Table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-class-teacher-student')}}",
        },
        columns: [
        {
            data: 'subject',
            name: 'subject',
          
        },
        {
            data: 'teacher',
            name: 'teacher',
          
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
});
/* Report handlers hidden for now
$(document).on('click', '.getStudentdetailsReport', function() {

var id = $(this).data('id');
var name = $(this).data('name');
var subject = $(this).data('subject');


$("#teacher_id").val(id);
$("#name").val(name);
$("#subject").val(subject);


});
$(document).on('click', '.sendreport', function() {

  var form = $("#report_student");
  var formData = new FormData(form[0]);
  if($("#title").val()=='' ){
    toastr.warning('Warning!', "Please add a title", {
          "positionClass": "toast-bottom-right"
    });
    return;
  }
  if ($('#description').summernote('isEmpty'))
  {
    toastr.warning('Warning!', "Please add some description", {
          "positionClass": "toast-bottom-right"
    });
    return;
  }
  $('#please_wait').modal('show');
  axios.post("{{route('report-teacher-to-admin')}}",
      formData
  ).then(function(response) {

  if(response.data.success){
    $('#please_wait').modal('hide');

    $('#student_report').modal('hide');
    toastr.success('Success!', 'Student Reported Successfully',{
            "positionClass": "toast-bottom-right"
        })
        $(".summernote").summernote("code", "");

  }
  else{

    toastr.warning('Warning!', response.data.error,{
            "positionClass": "toast-bottom-right"
        })


  }
  });

});
*/
</script>
@endpush
@endsection