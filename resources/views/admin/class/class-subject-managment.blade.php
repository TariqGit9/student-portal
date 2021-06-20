@extends('layouts.admin')
@push('styles')
<style>
td.details-control {


background: url('https://cdn.rawgit.com/DataTables/DataTables/6c7ada53ebc228ea9bc28b1b216e793b1825d188/examples/resources/details_open.png') no-repeat center center;

cursor: pointer;
}

tr.shown td.details-control {
background: url('https://cdn.rawgit.com/DataTables/DataTables/6c7ada53ebc228ea9bc28b1b216e793b1825d188/examples/resources/details_close.png') no-repeat center center;


}
    </style>
@endpush
@section('content')

<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Subjects</h4>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">Subjects </h4>
        {{-- <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Subject</button></span></i> --}}
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="groupTable" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                 
                      <th >Name</th>
                      <th >Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
  


  <form id="get_class_student_attendance" method="post" action="{{route('admin-get-student-subject-attendance')}}">
    @csrf
    <input id="class_id" class="class_id" name ="class_id" type="hidden" value="">
    <input class="subject_id" name ="subject_id" type="hidden" value="">
  </form >

  <input type="hidden" id="id" value="{{$id}}">
@push('javascript')
<script>
var x= $("#id").val();

  $("select option:selected").css('backgroundColor', '#FFFFFF');
        var datatable = $('#groupTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-subject-for-managment')}}", type: 'post',
        data: {
            id: x,
            "_token": "{{ csrf_token() }}",
        }
        },
        columns: [
      
        {
            data: 'name',
            name: 'name',
          
        },
       
        {
            data: 'action',
            name: 'action',
          
        }
        ]
});

$(document).on('click', '.get_class_student_attendance', function() {
  var subject_id = $(this).data('subject');
  var class_id = $(this).data('class');
 
  $('.class_id').val(class_id);
  $('.subject_id').val(subject_id);
  
  $('#get_class_student_attendance').submit();
});





</script>
@endpush
@endsection