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

            <span class="float-right ml-3" >
                <select class="form-control selectpicker" data-live-search="true" name="user_roles" id="user_roles" >
                        <option value="1">Admin</option>
                        <option value="2">Teacher</option>
                        <option value="3">Student</option>
                </select>
            </span>
            <span class="float-right " >
                <button type="button" id="add_user_btn" class="btn btn-secondary" data-toggle="modal" data-target=".addAdmin">Add Admin</button>
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
                      <th class="all" width="2"></th>
                      <th >Image</th>
                      <th >Name</th>
                      <th >Phone</th>
                      <th >Email</th>
                      <th >Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade addAdmin" id="addAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Add Admin</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form id="addAdminForm">
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col ">
              <label class="bmd-label-floating form-required">Name </label>
              <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
            </div>
            <div class="form-group col">
              <label class="bmd-label-floating form-required">User Name</label>
              <input type="text" class="form-control" id="user_name" name="user_name" aria-describedby="emailHelp">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col">
              <label class="bmd-label-floating ">Email</label>
              <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            </div>
            <div class="form-group col ">
              <label class="bmd-label-floating form-required">Password </label>
              <div class="input-group mb-3">
               
                <input type="text" class="form-control" id="password" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-secondary genrate_password" type="button">Genrate</button>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">

            <div class="form-group col">
              <label class="bmd-label-floating form-required">Phone</label>
              <input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp">
            </div>
            <div class="form-group col">
              <label class="bmd-label-floating form-required">Emergency Phone </label>
              <input type="text" class="form-control" id="emergency_phone" name="emergency_phone" aria-describedby="emailHelp">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col ">
              <label class="bmd-label-floating form-required">Address Main </label>
              <textarea  class="form-control" id="address_line_main" name="address_line_main" ></textarea>
            </div>
            <div class="form-group col">
              <label class="bmd-label-floating">Address Secondary</label>
              <textarea  class="form-control" id="address_line_secondary" name="address_line_secondary" ></textarea>
            </div>
            
          </div>

         

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary addstudent">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>

@push('javascript')
<script>
var table;

dataTableData(1);
function dataTableData(role){
    $("#table_data").dataTable().fnDestroy();

    table=$('#table_data').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-school-users')}}", type: 'post',
            data: {
            school_id:{{$school_id}},
            role_id: role,
            "_token": "{{ csrf_token() }}",
        }
        },
        columns: [
        {
            'className': 'details-control',
            'orderable': false,
            'data': null,
            'defaultContent': ''
        },
        {
            data: 'image',
            name: 'image',
          
        },
        {
            data: 'name',
            name: 'name',
          
        },
        {
            data: 'phone',
            name: 'phone',
          
        },
        {
            data: 'email',
            name: 'email',
          
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
});
}


function format(d) {
    var table = "";
    return new Promise((resolve, reject) => {
       axios.post("{{route('get-user-details')}}", {
            id: d.id
        }).then(function(response) {
        
            resolve(response.data);
        }).catch(function(error) {

        })
    });

}

$('#table_data tbody').on('click', 'td.details-control', function() {
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var id = $(this).data('id');
    
    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
    } else {
        format(row.data()).then((data) => {
            var html=data.html;
            row.child(html).show();
        });
        tr.addClass('shown');
    }
});

$('#user_roles').on('change', function() {
    var role = $('#user_roles').val();
    var roleNames = {1: 'Admin', 2: 'Teacher', 3: 'Student'};
    var roleName = roleNames[role] || 'User';
    $('#add_user_btn').text('Add ' + roleName);
    $('#modalTitle').text('Add ' + roleName);
    dataTableData(role);
    $('.user-titles').text($("#user_roles option:selected").text());
});

$(document).on('click', '.genrate_password', function() {
  if($("#user_name").val() == ""){
    toastr.warning('Warning!', "Please Fill User Name before genrating password", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }
  var pass= Math.floor(Math.random() * 976) + 111  ;
   $("#password").val($("#user_name").val()+pass);

});


$(document).on('click', '.addstudent', function() {
 
 //please_wait
  var phone_expresion="^((\+92)|(0092))-{0,1}\d{3}-{0,1}\d{7}$|^\d{11}$|^\d{4}-\d{7}$";
  if($("#name").val() == ""){
   toastr.warning('Warning!', "Please Fill  Name...", {
           "positionClass": "toast-bottom-right"
       });
       $("#name").focus();
       return;
  }
  if($("#user_name").val() == ""){
   toastr.warning('Warning!', "Please Fill User Name...", {
           "positionClass": "toast-bottom-right"
       });
       $("#user_name").focus();
       return;
  }
 //  alert($("#class_id").val());

  if($("#password").val() == ""){
   toastr.warning('Warning!', "Please Fill  out Password...", {
           "positionClass": "toast-bottom-right"
       });
       $("#password").focus();
       return;
  }

  if($("#phone").val() == ""){
   toastr.warning('Warning!', "Please Fill Phone...", {
           "positionClass": "toast-bottom-right"
       });
       $("#phone").focus();
       return;
  }

  if(isNaN($("#phone").val())){
   toastr.warning('Warning!', "Not a Valid Phone number...", {
           "positionClass": "toast-bottom-right"
       });
       $("#phone").focus();
       return;

  }
  if($("#emergency_phone").val() == ""){
   toastr.warning('Warning!', "Please Fill Emergency Phone Number...", {
           "positionClass": "toast-bottom-right"
       });
       $("#emergency_phone").focus();
       return;
  }
  if(isNaN($("#emergency_phone").val())){
   toastr.warning('Warning!', "Not a Valid Emergency Phone number...", {
           "positionClass": "toast-bottom-right"
       });
       $("#emergency_phone").focus();
       return;
 }
  if(! $("#address_line_main").val()){
   toastr.warning('Warning!', "Please Fill Address Line...", {
           "positionClass": "toast-bottom-right"
       });
       $("#address_line_main").focus();
       return;
  }
   var form = $("#addAdminForm");
   var formData = new FormData(form[0]);
   formData.append("role_id", $('#user_roles').val());
   formData.append("school_id", {{$school_id}});

   var roleNames = {1: 'Admin', 2: 'Teacher', 3: 'Student'};
   var roleName = roleNames[$('#user_roles').val()] || 'User';

   $('.addstudent').attr("disabled", true);
   axios.post("{{route('add-school-user')}}",
       formData
   ).then(function(response) {
     $('.addstudent').attr("disabled", false);
   if(response.data.success){

     $('.addAdmin').modal('hide');

     toastr.success('Success!', roleName + ' added Successfully',{
             "positionClass": "toast-bottom-right"
         })
         $("#email").val("");
         $("#name").val("");
         $("#user_name").val("");
         $("#phone").val("");
         $("#address_line_main").val("");
         $("#address_line_secondary").val("");
         $("#emergency_phone").val("");
         $("#password").val("");
         dataTableData($('#user_roles').val());

   }
   else{

     toastr.warning('Warning!', response.data.error,{
             "positionClass": "toast-bottom-right"
         })
     if(response.data.error=="User Name already Exists."){
       $("#user_name").focus();
       return;
     }
     if(response.data.error=="Email already Exists."){
       $("#email").focus();
       return;
     }

   }
   });


});
$(document).on('click', '.toggle_block_data', function() {
    var id = $(this).data('id');
    var status = $(this).data('status');
    if(status==1){
      var Text_message = "Are you Sure you want to activate the user";
      var Text_button = "Activate";
      var color='#4BB543';
    }else{
      var Text_message = "Are you Sure you want to de-activate the user";
      var Text_button = "Deactivate";
      var color='#ca0b00';
 
    }

    Swal.fire({
        title: 'Change user Status',
        text: Text_message,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: color,
        cancelButtonText: "Cancel",
        confirmButtonText: Text_button,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post("{{route('block-user-super-admin')}}", {
                 status: status, id:id ,
            }).then(function(response) {
              toastr.success('Success!', 'user Status Changed Successfully',{
                "positionClass": "toast-bottom-right"
            })
            dataTableData($('#user_roles').val());
        
        })
        }
        else{

        }
    });

});
</script>
@endpush
@endsection