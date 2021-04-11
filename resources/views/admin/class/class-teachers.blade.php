@extends('layouts.admin')
@push('styles')
@endpush
@section('content')

<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Subject Teachers</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      {{-- <div class="d-flex justify-content-between">
        <h4 class="card-title ">Add a Grade </h4>
        <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Grade</button></span></i>
      </div> --}}
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="groupTable" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                      <th >Subject</th>       
                      <th >Teacher</th>  
                      <th >Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
  {{-- <div class="modal fade addStudentModel" id="addGrade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a Grade </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="addGradeForm">
                <div class="form-group ">
                  <label for="bmd-label-floating form-required">Grade</label>
                  <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                </div>   
               
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary addGrade">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div> --}}

  <div class="modal fade addStudentModel" id="editTeacherSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Assign Subject to Teacher </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="assignForm">
                <div class="form-group ">
                    <input type="hidden" class="form-control" id="grade" name="grade" >
                  <input type="hidden" class="form-control" id="subject_id" name="subject_id" >
                  <input type="hidden" class="form-control" value="{{$id}}" id="class_id" name="class_id" >
               
                  <label for="bmd-label-floating form-required">Subject</label>
                  <input type="text" class="form-control" id="edit_name" name="edit_name" disabled>
                </div>   
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Teacher </label>
                    <select class="form-control selectpicker" data-live-search="true" name="teacher" id="teacher" required>
                        <option disabled selected>Please Select a Teacher</option>  
                        @if($teachers)
                        @foreach($teachers as $teacher ){{$teacher->id}}
                        <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary assigningTeacher">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>


  <input type="hidden" id="id" value="{{$id}}">
@push('javascript')
<script>
var x= $("#id").val();

        var datatable = $('#groupTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-subject-teacher')}}",
           
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



$(document).on('click', '.assigningTeacher', function() {
   
   if($("#teacher").val() ==null){
    toastr.warning('Warning!', "Please Select Teacher...", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }
    axios.post("{{route('assign-teacher-to-subject')}}",
        $('#assignForm').serialize()
    ).then(function(response) {
  
    $('#editTeacherSubjectModal').modal('hide');
   
        toastr.success('Success!', 'Teacher added Successfully',{
                "positionClass": "toast-bottom-right"
            })
        
        $("#name").val(""); 
        datatable.draw();
    });


});

$(document).on('click', '.assignteacher', function() {

    var edit_id = $(this).data('id');
    var edit_name = $(this).data('name');
    var edit_grade = $(this).data('grade');
    $("#subject_id").val(edit_id); 
    $("#edit_name").val(edit_name); 
    $("#grade").val(edit_grade); 
    $('.selectpicker').selectpicker('refresh');

});



</script>
@endpush
@endsection