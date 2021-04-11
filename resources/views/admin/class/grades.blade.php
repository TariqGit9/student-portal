@extends('layouts.admin')
@push('styles')
@endpush
@section('content')

<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Grades</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">Add a Grade </h4>
        <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Grade</button></span></i>
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
  <div class="modal fade addStudentModel" id="addGrade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  </div>

  <div class="modal fade addStudentModel" id="editGradeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a Grade </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="editGradeForm">
                <div class="form-group ">

                  <input type="hidden" class="form-control" id="edit_id" name="edit_id" >
               
                  <label for="bmd-label-floating form-required">Grade</label>
                  <input type="text" class="form-control" id="edit_name" name="edit_name" >
                </div>   
               
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary editGrade">Save changes</button>
        </form>
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
            url: "{{route('get-grades')}}",
        },
        columns: [
      
        {
            data: 'name',
            name: 'name',
          
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
});



$(document).on('click', '.addGrade', function() {
   
   if($("#name").val() == ""){
    toastr.warning('Warning!', "Please Fill Grade Name...", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }
    axios.post("{{route('add-grade')}}",
        $('#addGradeForm').serialize()
    ).then(function(response) {
  
    $('#addGrade').modal('hide');
   
        toastr.success('Success!', 'Class added Successfully',{
                "positionClass": "toast-bottom-right"
            })
        
        $("#name").val(""); 
        datatable.draw();
    });


});

$(document).on('click', '.deleteGrade', function() {
    var id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        // text: "Are you sure!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ca0b00',
        // cancelButtonColor: '#d33',
        confirmButtonText: 'Delete!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post("{{route('del-grade')}}", {
                id: id
            }).then(function(response) {
              toastr.success('Success!', 'Grade Deleted Successfully',{
                "positionClass": "toast-bottom-right"
            })
              datatable.draw();
             
                //   
            }).catch(function(error) {})

        }
    });

});
$(document).on('click', '.editGrade', function() {

    var edit_id = $(this).data('id');
    var edit_name = $(this).data('name');

    $("#edit_id").val(edit_id); 
    $("#edit_name").val(edit_name); 
    $('.selectpicker').selectpicker('refresh');

});



</script>
@endpush
@endsection