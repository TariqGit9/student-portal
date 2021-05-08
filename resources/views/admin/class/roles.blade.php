
@extends('layouts.admin')
@push('styles')
@endpush
@section('content')

<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Result Types</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">Add a Result Type </h4>
        <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Result Type</button></span></i>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="table-view" width="100%" cellspacing="0">
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
  <div class="modal fade addStudentModel" id="addData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a Result Type </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="addDataForm">
                <div class="form-group ">
                  <label for="bmd-label-floating form-required">Result Type</label>
                  <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                </div>   
               
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary addData">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade addStudentModel" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Result type </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="editDataForm">
                <div class="form-group ">

                  <input type="hidden" class="form-control" id="edit_id" name="edit_id" >
               
                  <label for="bmd-label-floating form-required">Result type</label>
                  <input type="text" class="form-control" id="edit_name" name="edit_name" >
                </div>   
               
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary editDatachanges">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>


@push('javascript')
<script>
        var datatable = $('#table-view').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-result-types')}}",
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



$(document).on('click', '.addData', function() {
   
   if($("#name").val() == ""){
    toastr.warning('Warning!', "Please Fill Result Type Name...", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }
    axios.post("{{route('add-result-type')}}",
        $('#addDataForm').serialize()
    ).then(function(response) {
  
    $('#addData').modal('hide');
   
        toastr.success('Success!', 'Result Type added Successfully',{
                "positionClass": "toast-bottom-right"
            })
        
        $("#name").val(""); 
        datatable.draw();
    });


});


$(document).on('click', '.editData', function() {

    var edit_id = $(this).data('id');
    var edit_name = $(this).data('name');

    $("#edit_id").val(edit_id); 
    $("#edit_name").val(edit_name); 
    $('.selectpicker').selectpicker('refresh');

});

$(document).on('click', '.editDatachanges', function() {
   
   if($("#edit_name").val() == ""){
    toastr.warning('Warning!', "Please Fill Result Type Name...", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }
    axios.post("{{route('edit-result-type')}}",
        $('#editDataForm').serialize()
    ).then(function(response) {
  
    $('#editDataModal').modal('hide');
   
        toastr.success('Success!', 'Result Type Updated Successfully',{
                "positionClass": "toast-bottom-right"
            })
        
        $("#edit_name").val(""); 
        datatable.draw();
    });


});

$(document).on('click', '.change_status', function() {
  var status = $(this).data('status');
  var id = $(this).data('id');
  if(status==0){
      var message="Hide Result Type from Teachers! ";
      var button='Hide';
      var color='#ca0b00';
  }else{
      var message="Show Result Type to Teachers! ";
      var button='Publish';
      var color='#4BB543';
  }
  Swal.fire({
        title: 'Are you Sure ?',
        text: message,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: color,
        confirmButtonText: button,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post("{{route('change-result-type-status')}}", {
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
</script>
@endpush
@endsection