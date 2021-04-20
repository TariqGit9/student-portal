@extends('layouts.admin')
@push('styles')
@endpush
@section('content')

<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Complaints</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <!-- <div class="d-flex justify-content-between">
        <h4 class="card-title ">Add a Class </h4>
        <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Class</button></span></i>
      </div> -->
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="groupTable" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                      <th >Student</th>
                      <th >Teacher</th>
                      <th >Class</th>
                      <th >Title</th>
                      <th style="width: 35%">Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="complain_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Complain</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-row">
          <div class="form-group col">
            <span class='d-flex'><h5>Teacher : </h5><span class='teacher_data  ml-3'></span></span>
          </div>
          <div class="form-group col">
            <span class='d-flex'>  <h5>Student : </h5><span class='student_data  ml-3'></span></span>
          </div>
      </div>
      <div class="form-row">
          <div class="form-group col">
            <span class='d-flex'><h5>Title :</h5><span class='title_data  ml-3'></span></span> 
          </div>
          <div class="form-group col">
            <span class='d-flex'><h5>Status :</h5><span class='status_data  ml-3'></span></span> 
          </div>
      </div>
        
      <h5>Description :  </h5>  
      <div class='bg-light'>
        <span class='complain_data '></span>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn " id='change-status'>Save changes</button>
      </div>
    </div>
  </div>
</div>
@push('javascript')
<script>
        var datatable = $('#groupTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-teacher-complaints')}}",
        },
        columns: [
      
        {
            data: 'student',
            name: 'student',
          
        },
        {
            data: 'teacher',
            name: 'teacher',
          
        },
     
        {
            data: 'class',
            name: 'class',
          
        },
        {
            data: 'title',
            name: 'title',
          
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
});

$(document).on('click', '.openComplaint', function() {
    var id = $(this).data('id');
    $('#please_wait').modal('show');
    axios.post("{{route('view-complain')}}", {
        id: id
    }).then(function(response) {
        $('#please_wait').modal('hide');
        $('#complain_modal').modal('show');
        $('.student_data').text(' '+response.data.student);
        $('.teacher_data').text(' '+response.data.teacher);
        $('.complain_data').html(' '+response.data.description);
        $('.title_data').text(' '+response.data.title);
        $('.status_data').text(' '+response.data.status);
        if(response.data.status== 'Not Viewed yet'){
            $("#change-status").addClass("btn-success");
        }else{
            $("#change-status").addClass("btn-warning");
        }
        
    })
    

});


</script>
@endpush
@endsection