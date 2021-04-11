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
      <h4 class="content-title mb-0 my-auto">Teachers</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">Deleted Teachers </h4>
        {{-- <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Teacher</button></span></i> --}}
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="teacherTable" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                    <th class="all" width="2"></th>
                      <th >Avatar</th>
                      <th >Name</th>
                      <th >User Name</th>
                     
                      <th >Phone</th>
                      <th >Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
 

@push('javascript')
<script>
        var datatable = $('#teacherTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-deleted-teachers')}}",
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
            data: 'user_name',
            name: 'user_name',
          
        },
     
        {
            data: 'phone',
            name: 'phone',
          
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
});

function format(d) {
    var table = "";
    return new Promise((resolve, reject) => {
       axios.post("{{route('get-teacher-detail')}}", {
            id: d.id
        }).then(function(response) {
        
            resolve(response.data);
        }).catch(function(error) {

        })
    });

}

$('#teacherTable tbody').on('click', 'td.details-control', function() {
    var tr = $(this).closest('tr');
    var row = datatable.row(tr);
    var id = $(this).data('id');
    
    if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    } else {
        // Open this row
        // row.child(  ).show();

        format(row.data()).then((data) => {
           var html="Email : "+ data.email+"<br>";
           html +="Emergency Contact : "+ data.emergency_phone+"<br>";
           html +="Address Line Main : "+ data.address_line_main+"<br>";
           html +="Address Line Secondary : "+ data.address_line_secondary+"<br>";
           html +="Details : "+ data.details+"<br>";
           
            row.child(html).show();
        });

        tr.addClass('shown');
    }
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
$(document).on('click', '.editTeacher', function() {

var edit_id = $(this).data('id');
var edit_name = $(this).data('name');
var edit_user_name = $(this).data('user_name');
var edit_phone = $(this).data('phone');
var avatar = $(this).data('avatar');
$("#edit_id").val(edit_id); 
$("#edit_name").val(edit_name); 
$("#edit_user_name").val(edit_user_name); 
$("#edit_phone").val(edit_phone); 
var path="{{asset('uploads/teacher_avatars/')}}";
$("#edit_image_display").attr("src",path+"/"+avatar);

 axios.post("{{route('get-teacher-detail')}}", {
        id: edit_id
    }).then(function(response) {
      
    $(".editsummer").summernote("code", response.data.details);
    $("#edit_email").val(response.data.email); 
    $("#edit_emergency_phone").val(response.data.emergency_phone); 
    $("#edit_address_line_main").val(response.data.address_line_main); 
    $("#edit_address_line_secondary").val(response.data.address_line_secondary); 

    }).catch(function(error) {

    })
});

$(document).on('click', '.editTeacherInfo', function() {
  if($("#edit_name").val() == ""){
    toastr.warning('Warning!', "Please Fill  Name...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_name").focus();
        return;
   }
  //  if($("#user_name").val() == ""){
  //   toastr.warning('Warning!', "Please Fill User Name...", {
  //           "positionClass": "toast-bottom-right"
  //       });
  //       $("#user_name").focus();
  //       return;
  //  }
   if($("#edit_email").val() == ""){
    toastr.warning('Warning!', "Please Fill Email...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_email").focus();
        return;
   }
   if($("#edit_phone").val() == ""){
    toastr.warning('Warning!', "Please Fill Phone...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_phone").focus();
        return;
   }

   if(isNaN($("#edit_phone").val())){
    toastr.warning('Warning!', "Not a Valid Phone number...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_phone").focus();
        return;

   }
   if($("#edit_emergency_phone").val() == ""){
    toastr.warning('Warning!', "Please Fill Emergency Phone Number...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_emergency_phone").focus();
        return;
   }
   if(isNaN($("#edit_emergency_phone").val())){
    toastr.warning('Warning!', "Not a Valid Emergency Phone number...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_emergency_phone").focus();
        return;
  }
   if(! $("#edit_address_line_main").val()){
    toastr.warning('Warning!', "Please Fill Address Line...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_address_line_main").focus();
        return;
   }
    var form = $("#editTeacherForm");
    var formData = new FormData(form[0]);
   // var formData = new FormData();
    var imagefile = document.querySelector('#edit_image');
    formData.append("image", imagefile.files[0]);



    axios.post("{{route('edit-teacher')}}",
        formData
    ).then(function(response) {
  
    if(response.data.success){

      $('#editTeacherModal').modal('hide');
   
      toastr.success('Success!', 'Teacher added Successfully',{
              "positionClass": "toast-bottom-right"
          })      
      
      datatable.draw();

    }
    else{

      toastr.warning('Warning!', response.data.error,{
              "positionClass": "toast-bottom-right"
          })  
  

    }
    });

});
$(document).on('click', '.activateTeacher', function() {
    var id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        // text: "Are you sure!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4BB543',
        // cancelButtonColor: '#d33',
        confirmButtonText: 'Activate!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post("{{route('activate-teacher')}}", {
                id: id
            }).then(function(response) {
              toastr.success('Success!', 'Teacher Activated Successfully',{
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