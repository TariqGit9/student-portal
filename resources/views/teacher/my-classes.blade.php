@extends('layouts.teacher')
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
<form id="student-marks" method="post" action="teacher-insert-student-marks">
  @csrf
  <input id="class_id" name ="class_id" type="hidden" value="">
  <input id="subject_id" name ="subject_id" type="hidden" value="">
</form >
<form id="class_students" method="post" action="teacher-class-students">
    @csrf
    <input id="class_id" class="class_id" name ="class_id" type="hidden" value="">
 
</form >
@push('javascript')
<script>
        var datatable = $('#Table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-teacher-classes')}}",
        },
        columns: [
      
        {
            data: 'class',
            name: 'class',
          
        },
        {
            data: 'subject',
            name: 'subject',
          
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
});


$(document).on('click', '.upload_student_marks', function() {
 
  var class_id = $(this).data('class_id');
  var subject_id = $(this).data('subject_id');
  
  $('#subject_id').val(subject_id);
  $('#class_id').val(class_id);
  $('#student-marks').submit();

});

$(document).on('click', '.class_students', function() {
 
 var class_id = $(this).data('class_id');
 $('.class_id').val(class_id);
 
 $('#class_students').submit();
});

</script>
@endpush
@endsection