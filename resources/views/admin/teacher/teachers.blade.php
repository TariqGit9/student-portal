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
        <h4 class="card-title ">Add a Teacher </h4>
        <i class="mdi "><span class="float-right" > 	&nbsp;<button type="button" class="btn btn-danger  viewDeleted" >Deleted Teachers</button></span><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Teacher</button></span></i>
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
  <div class="modal fade addStudentModel" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a Teacher </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form id="addTeacherForm">
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
            <div class="form-group col">
              <label class="bmd-label-floating form-required">Email</label>
              <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            </div>
          </div>
       
       
          <div class="form-row">
            <div class="form-group col ">
              <label class="bmd-label-floating form-required">Password </label>
              <div class="input-group mb-3">
               
                <input type="text" class="form-control" id="password" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-secondary genrate_password" type="button">Genrate</button>
                </div>
              </div>
            </div>
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
          <div class="input-group file-browser">
            <input type="text" class="custom-file-label form-control browse-file" placeholder="Choose Teacher Avatar" readonly>
            <label class="input-group-btn">
              <span class="btn btn-default">
                Browse <input type="file" name="image" id="image"  accept="image/*" style="display: none;" multiple>
              </span>
            </label>
          </div>
          <div class="form-row">
            <div class="form-group col">
              <label class="bmd-label-floating">Specialities</label>
              <textarea  class=" summernote" name="subject_specialities"
              id="subject_specialities"  ></textarea>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary addTeacher">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>

{{-- //Edit  --}}
<div class="modal fade addStudentModel" id="editTeacherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add a Teacher </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form id="editTeacherForm">
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col ">
            <label class="bmd-label-floating form-required">Name </label>
            <input type="text" class="form-control" id="edit_name" name="edit_name" aria-describedby="emailHelp">
          </div>
          <input type="hidden" class="form-control" id="edit_id" name="edit_id" aria-describedby="emailHelp">
        
          <div class="form-group col">
            <label class="bmd-label-floating form-required">User Name</label>
            <input type="text" class="form-control" id="edit_user_name" name="edit_user_name" aria-describedby="emailHelp" disabled>
          </div>
          <div class="form-group col">
            <label class="bmd-label-floating form-required">Email</label>
            <input type="text" class="form-control" id="edit_email" name="edit_email" aria-describedby="emailHelp">
          </div>
        </div>
     
     
        <div class="form-row">
          {{-- <div class="form-group col ">
            <label class="bmd-label-floating form-required">Password </label>
            <div class="input-group mb-3">
             
              <input type="text" class="form-control" id="password" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-secondary genrate_password" type="button">Genrate</button>
              </div>
            </div>
          </div> --}}
          <div class="form-group col">
            <label class="bmd-label-floating form-required">Phone</label>
            <input type="text" class="form-control" id="edit_phone" name="edit_phone" aria-describedby="emailHelp">
          </div>
          <div class="form-group col">
            <label class="bmd-label-floating form-required">Emergency Phone </label>
            <input type="text" class="form-control" id="edit_emergency_phone" name="edit_emergency_phone" aria-describedby="emailHelp">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col ">
            <label class="bmd-label-floating form-required">Address Main </label>
            <textarea  class="form-control" id="edit_address_line_main" name="edit_address_line_main" ></textarea>
          </div>
          <div class="form-group col">
            <label class="bmd-label-floating">Address Secondary</label>
            <textarea  class="form-control" id="edit_address_line_secondary" name="edit_address_line_secondary" ></textarea>
          </div>
          
        </div>

        <div class="form-row">
          <div class="form-group col-1">
            <img src="" id="edit_image_display" aly="broken" width="50" height="50">

          </div>

          <div class="form-group col-11">
            <div class="input-group file-browser ">
              <input type="text" class="custom-file-label form-control browse-file" placeholder="Choose Teacher Avatar" readonly>
              <label class="input-group-btn">
                <span class="btn btn-default">
                  Browse <input type="file" name="edit_image" id="edit_image"  accept="image/*" style="display: none;" multiple>
                </span>
              </label>
            </div>  
          </div>
        </div> 
        <div class="form-row">
          <div class="form-group col">
            <label class="bmd-label-floating">Specialities</label>
            <textarea  class="editsummer summernote" name="edit_subject_specialities"
            id="edit_subject_specialities"  ></textarea>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary editTeacherInfo">Save changes</button>
      </form>
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
            url: "{{route('get-teachers')}}",
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
           if(data.address_line_secondary){
              html +="Address Line Secondary : "+ data.address_line_secondary+"<br>";
            }
            else{

            }
            if(data.details){

              html +="Details : "+ data.details+"<br>";
            }
        
          
          
           
            row.child(html).show();
        });

        tr.addClass('shown');
    }
});





$('#image').on('change',function(){
  var fileName = $(this).val();
  $('.custom-file-label').val("Image Selected");
})


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
var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+.[a-z](?:\.[a-zA-Z0-9-]+)*$/;
$(document).on('click', '.addTeacher', function() {
 
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
   if($("#email").val() == ""){
    toastr.warning('Warning!', "Please Fill Email...", {
            "positionClass": "toast-bottom-right"
        });
        $("#email").focus();
        return;
   }
   if (! $("#email").val().match(mailformat)) {
      toastr.warning('Warning!', "Not a Valid Email...", {
        "positionClass": "toast-bottom-right"
    });
    return;
    }

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
    var form = $("#addTeacherForm");
    var formData = new FormData(form[0]);
   // var formData = new FormData();
    var imagefile = document.querySelector('#image');
    formData.append("image", imagefile.files[0]);

    $('#please_wait').modal('show');
    $('.addTeacher').attr("disabled", true);
    axios.post("{{route('add-teacher')}}",
        formData
    ).then(function(response) {
      $('.addTeacher').attr("disabled", false);
      $('#please_wait').modal('hide');
    if(response.data.success){

      $('#addTeacherModal').modal('hide');
     
      toastr.success('Success!', 'Teacher added Successfully',{
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
          $("#phone").val(""); 
          $(".summernote").summernote("code", "");
      datatable.draw();

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
   if (! $("#edit_email").val().match(mailformat)) {
      toastr.warning('Warning!', "Not a Valid Email...", {
        "positionClass": "toast-bottom-right"
    });
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
$(document).on('click', '.deleteTeacher', function() {
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
            axios.post("{{route('del-teacher')}}", {
                id: id
            }).then(function(response) {
              toastr.success('Success!', 'Teacher Deleted Successfully',{
                "positionClass": "toast-bottom-right"
            })
              datatable.draw();
             
                //   
            }).catch(function(error) {})

        }
    });

});

$(document).on('click', '.viewDeleted', function() {

  location.href = "{{route('deleted-teachers')}}";
});


</script>
@endpush
@endsection