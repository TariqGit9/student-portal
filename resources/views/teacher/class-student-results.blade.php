@extends('layouts.teacher')
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
      <h4 class="content-title mb-0 my-auto">Students </h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">{{$class->name}}  </h4>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="studentTable" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                 
                      <th >Description</th>
                      <th >Type</th>
                      <th >Total Marks</th>
                      <th >Passing Marks</th>
                      <th >Date</th>
                      <th >Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
 

{{-- //Edit  --}}
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
          <input type="hidden" class="form-control" id="student_id" name="student_id" aria-describedby="emailHelp">
          <input type="hidden" class="form-control" value="{{$id}}" id="class_id" name="class_id" aria-describedby="emailHelp">
         
          <div class="form-group col">
            <label class="bmd-label-floating form-required">User Name</label>
            <input type="text" class="form-control" id="user_name" name="user_name" aria-describedby="emailHelp" disabled>
          </div>
          <div class="form-group col">
            <label class="bmd-label-floating form-required">Reg number</label>
            <input type="text" class="form-control" id="reg_no" name="reg_no" aria-describedby="emailHelp" disabled>
          </div>
        
         
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
<form id="assessment_student" method="post" action="assesment-class-student">
  @csrf
  <input class="assessment" name ="assessment" type="hidden" value="">
</form >
@push('javascript')
<script>
        var x= $("#id").val();
        var datatable = $('#studentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-class-assesments')}}", type: 'post',
            data: {
            class_id:{{$id}},
            subject_id:{{$subject_id}},
            "_token": "{{ csrf_token() }}",
        }
        },
        columns: [
      
       
        {
            data: 'description',
            name: 'description',
          
        },
        {
            data: 'type',
            name: 'type',
          
        },
        {
            data: 'total_marks',
            name: 'total_marks',
          
        },
        {
            data: 'passing_marks',
            name: 'passing_marks',
          
        },
        {
            data: 'date',
            name: 'date',
          
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
});

$(document).on('click', '.assessments_status', function() {
  var status = $(this).data('status');
  var id = $(this).data('id');
  if(status==0){
      var message='Are you sure you want to hide result from students';
      var button='Hide';
      var color='#ca0b00';
  }else{
      var message='Are you sure you want to Publish result for students';
      var button='Publish';
      var color='#4BB543';
  }
  Swal.fire({
        title: message,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: color,
        confirmButtonText: button,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post("{{route('toggle-assessments-status')}}", {
              id: id , status: status
            }).then(function(response) {
              toastr.success('Success!', 'Status updated Successfully',{
                "positionClass": "toast-bottom-right"
            })
              datatable.draw();
             
                //   
            }).catch(function(error) {})

        }
    });
  
});

$(document).on('click', '.assesmentClassStudent', function() {
  var id = $(this).data('id');
  
 
  $('.assessment').val(id);
  
  $('#assessment_student').submit();
});

</script>
@endpush
@endsection