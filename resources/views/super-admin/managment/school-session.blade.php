@extends('layouts.super-admin')
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
      <h4 class="content-title mb-0 my-auto">{{$school->name}} </h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title user-titles">{{$school->name}} </h4>
        <i class="mdi ">

            <span class="float-right " >
                <button type="button" id="add_session" class="btn btn-secondary" data-toggle="modal" data-target=".add-data">Add Session</button>
            </span>
        </i>

      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="table_data" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                 
                      <th >Session</th>
                      <th >Status</th>
                      <th >Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade add-data" id="add-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a session </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form id="add-dataForm">
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col ">
              <label class="bmd-label-floating form-required">Name </label>
              <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
              <input type="hidden" class="form-control" id="school_id" name="school_id" value="{{$school_id}}" aria-describedby="emailHelp">
            </div>
    
          </div>
          <div class="form-row">
            <div class="form-group col">
              <label class="bmd-label-floating">Status</label>
              <select class="form-control selectpicker" data-live-search="true" name="status" id="status" >
                <option value="0">Deactivate</option>
                <option value="1">Activate</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary addsession">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>

@push('javascript')
<script>


var datatable=$('#table_data').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-school-session')}}", type: 'post',
            data: {
            school_id:{{$school_id}},
            "_token": "{{ csrf_token() }}",
        }
        },
        columns: [
        {
            data: 'name',
            name: 'name',
            orderable: false
        },
        {
            data: 'status',
            name: 'status',
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
});



$(document).on('click', '.addsession', function() {
 
 //please_wait
  if($("#name").val() == ""){
   toastr.warning('Warning!', "Please Fill  Name...", {
           "positionClass": "toast-bottom-right"
       });
       $("#name").focus();
       return;
  }
  if($("#status").val() == 1){
    $('#add-data').modal('hide');
    Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to Activate the session If you activate this session this will close your last session.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#4BB543',
        cancelButtonText: "Cancel",
        confirmButtonText: "Ok",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
          addSessions();
        }
        else{
          $('#add-data').modal('show'); 
        }
    });
  }else{
    addSessions();
  }


});

function addSessions(){
   $('#please_wait').modal('show');
   $('.addsession').attr("disabled", true);
   axios.post("{{route('add-session')}}",
   $('#add-dataForm').serialize()
   ).then(function(response) {
     $('.addsession').attr("disabled", false);
     $('#please_wait').modal('hide');
   if(response.data.success){

     $('#add-data').modal('hide');
    
     toastr.success('Success!', 'Session added Successfully',{
             "positionClass": "toast-bottom-right"
         })      

         $("#name").val(""); 
       
         $(".selectpicker").selectpicker("refresh");
        
         datatable.draw();  

   }

   });

}

$(document).on('click', '.toggle_block_data', function() {
    var id = $(this).data('id');
    var school_id= {{$school_id}};
    var status = $(this).data('status');
    if(status==1){
      var Text_message = "Are you Sure you want to activate the Session if you do so all other sessions will be closed";
      var Text_button = "Activate";
      var color='#4BB543';
    }else{
      var Text_message = "Are you Sure you want to de-activate the Session";
      var Text_button = "Deactivate";
      var color='#ca0b00';
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
            axios.post("{{route('change-school-session')}}", {
                 status: status, id:id ,school_id : school_id,
            }).then(function(response) {
              toastr.success('Success!', 'user Status Changed Successfully',{
                "positionClass": "toast-bottom-right"
            })
            datatable.draw();  
        })
        }
        else{

        }
    });

});
</script>
@endpush
@endsection