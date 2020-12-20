@extends('layouts.admin')
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
        <h4 class="card-title ">Add a Class </h4>
        <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Class</button></span></i>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="groupTable" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                      <th style="width:70%">Name</th>
                      <th >Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
  <div class="modal fade addStudentModel" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a Class </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="addClassForm">
                <div class="form-group ">
                  <label for="bmd-label-floating form-required">Class</label>
                  <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                </div>   
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary addClass">Save changes</button>
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
            url: "{{route('get-classes')}}",
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



$(document).on('click', '.addClass', function() {
   
   if($("#name").val() == ""){
    toastr.warning('Warning!', "Please Fill Class Name...", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }
    axios.post("{{route('add-class')}}",
        $('#addClassForm').serialize()
    ).then(function(response) {
  
    $('#addClassModal').modal('hide');
   
        toastr.success('Success!', 'Class added Successfully',{
                "positionClass": "toast-bottom-right"
            })
        
        $("#name").val(""); 
        datatable.draw();
    });


});

$(document).on('click', '.deleteClass', function() {
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
            axios.post("{{route('del-class')}}", {
                id: id
            }).then(function(response) {
              toastr.success('Success!', 'Class Deleted Successfully',{
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