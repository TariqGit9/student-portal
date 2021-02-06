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
        <h4 class="card-title ">Class </h4>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="studentTable" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                    <th class="all" width="2"></th>
                      <th >Avatar</th>
                      <th >Name</th>
                      <th >User Name</th>
                      <th >Class</th>
                      <th >Reg Number</th>
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
  <div class="modal fade addStudentModel" id="addstudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a student </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form id="addStudentForm">
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
            {{-- <div class="form-group col">
              <label for="exampleInputEmail1">Select Class </label>
                <select class="form-control selectpicker" data-live-search="true" name="class_id" id="class_id" required>
                    <option disabled selected>Please Select a Class</option>  
                    @if($classes)
                        @foreach($classes as $class )
                        <option value="{{$class->id}}">{{$class->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div> --}}
            
            {{-- <div class="form-group col">
              <label class="bmd-label-floating form-required">Email</label>
              <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            </div> --}}
          </div>
          <div class="form-row">
            <div class="form-group col">
              <label class="bmd-label-floating ">Email</label>
              <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            </div>
            <input type="hidden" class="form-control" value="{{$id}}" id="class_id" name="class_id" aria-describedby="emailHelp">
         
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
            <input type="text" class="custom-file-label form-control browse-file" placeholder="Choose student Avatar" readonly>
            <label class="input-group-btn">
              <span class="btn btn-default">
                Browse <input type="file" name="image" id="image"  accept="image/*" style="display: none;" multiple>
              </span>
            </label>
          </div>
          {{-- <div class="form-row">
            <div class="form-group col">
              <label class="bmd-label-floating">Specialities</label>
              <textarea  class=" summernote" name="subject_specialities"
              id="subject_specialities"  ></textarea>
            </div>
          </div> --}}

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary addstudent">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>

{{-- //Edit  --}}
<div class="modal fade addStudentModel" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add a student </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form id="editStudentForm">
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col ">
            <label class="bmd-label-floating form-required">Name </label>
            <input type="text" class="form-control" id="edit_name" name="edit_name" aria-describedby="emailHelp">
          </div>
          <input type="hidden" class="form-control" id="edit_id" name="edit_id" aria-describedby="emailHelp">
          <input type="hidden" class="form-control" value="{{$id}}" id="edit_class_id" name="edit_class_id" aria-describedby="emailHelp">
         
          <div class="form-group col">
            <label class="bmd-label-floating form-required">User Name</label>
            <input type="text" class="form-control" id="edit_user_name" name="edit_user_name" aria-describedby="emailHelp" disabled>
          </div>
        
         
        </div>
     
        <div class="form-row">
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
              <input type="text" class="custom-file-label form-control browse-file" placeholder="Choose student Avatar" readonly>
              <label class="input-group-btn">
                <span class="btn btn-default">
                  Browse <input type="file" name="edit_image" id="edit_image"  accept="image/*" style="display: none;" multiple>
                </span>
              </label>
            </div>  
          </div>
        </div> 
        {{-- <div class="form-row">
          <div class="form-group col">
            <label class="bmd-label-floating">Specialities</label>
            <textarea  class="editsummer summernote" name="edit_subject_specialities"
            id="edit_subject_specialities"  ></textarea>
          </div>
        </div> --}}

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary editstudentInfo">Save changes</button>
      </form>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="please_wait">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-body tx-center pd-y-20 pd-x-20">
        {{-- <i class="  lh-1 mg-t-20 d-inline-block"></i> --}}
        <h4 class="tx-success tx-semibold mg-b-20">Sending Credentials to the student !</h4>
        <img src="{{asset('assets/gifs/loading.gif')}}"  width="100" height="100" alt="Please wait">
        <p class="mg-b-20 mg-x-20"> Please Wait</p>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="id" value="{{$id}}">
@push('javascript')
<script>
        var x= $("#id").val();
        var datatable = $('#studentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-teacher-class-students')}}", type: 'post',
            data: {
            id: x,
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
            data: 'user_name',
            name: 'user_name',
          
        },
        {
            data: 'class',
            name: 'class',
          
        },
        {
            data: 'reg_no',
            name: 'reg_no',
          
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
       axios.post("{{route('get-student-detail')}}", {
            id: d.id
        }).then(function(response) {
        
            resolve(response.data);
        }).catch(function(error) {

        })
    });

}

$('#studentTable tbody').on('click', 'td.details-control', function() {
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
          if(data.email==null){

            var html="Email : "+ "Not available"+"<br>";
          }
          else{

            var html="Email : "+ data.email+"<br>";
          }
       
            html +="Emergency Contact : "+ data.emergency_phone+"<br>";
            html +="Address Line Main : "+ data.address_line_main+"<br>";
           if(data.address_line_secondary==null){

            html +="Address Line Secondary : "+ "Not available"+"<br>";
          }
          else{

            html +="Address Line Secondary : "+ data.address_line_secondary+"<br>";
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
   if($("#class_id").val() == null){
    toastr.warning('Warning!', "Please Select a Class...", {
            "positionClass": "toast-bottom-right"
        });
        $("#class_id").focus();
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
    var form = $("#addStudentForm");
    var formData = new FormData(form[0]);
   // var formData = new FormData();
    var imagefile = document.querySelector('#image');
    formData.append("image", imagefile.files[0]);

    $('#please_wait').modal('show');
    $('.addStudent').attr("disabled", true);
    axios.post("{{route('add-student')}}",
        formData
    ).then(function(response) {
      $('.addstudent').attr("disabled", false);
      $('#please_wait').modal('hide');
    if(response.data.success){

      $('#addstudentModal').modal('hide');
     
      toastr.success('Success!', 'Student added Successfully',{
              "positionClass": "toast-bottom-right"
          })      
      
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

$(document).on('click', '.deleteStudent', function() {
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
            axios.post("{{route('del-student')}}", {
                id: id
            }).then(function(response) {
              toastr.success('Success!', 'Student Deleted Successfully',{
                "positionClass": "toast-bottom-right"
            })
              datatable.draw();
             
                //   
            }).catch(function(error) {})

        }
    });

});
$(document).on('click', '.editStudent', function() {

var edit_id = $(this).data('id');
var edit_name = $(this).data('name');
var edit_user_name = $(this).data('user_name');
var edit_phone = $(this).data('phone');
var edit_emergency_phone = $(this).data('ephone');
var avatar = $(this).data('avatar');
var edit_class = $(this).data('class');
var edit_reg_no = $(this).data('reg_no');
var edit_address_main = $(this).data('address_main');
var edit_address_sec = $(this).data('address_sec');
$("#edit_id").val(edit_id); 
$("#edit_name").val(edit_name); 
$("#edit_user_name").val(edit_user_name); 
$("#edit_class_id").val(edit_class); 
$('.selectpicker').selectpicker('refresh');
$("#edit_reg_no").val(edit_reg_no); 
$("#edit_phone").val(edit_phone); 
$("#edit_emergency_phone").val(edit_emergency_phone); 
$("#edit_address_line_main").val(edit_address_main); 
$("#edit_address_line_secondary").val(edit_address_sec); 
 





var path="{{asset('uploads/student_avatars/')}}";

$("#edit_image_display").attr("src",path+"/"+avatar);

//  axios.post("{{route('get-teacher-detail')}}", {
//         id: edit_id
//     }).then(function(response) {
      
//     $(".editsummer").summernote("code", response.data.details);
//     $("#edit_email").val(response.data.email); 
//     $("#edit_emergency_phone").val(response.data.emergency_phone); 
//     $("#edit_address_line_main").val(response.data.address_line_main); 
//     $("#edit_address_line_secondary").val(response.data.address_line_secondary); 

//     }).catch(function(error) {

//     })
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
   if($("#edit_class_id").val() == null){
    toastr.warning('Warning!', "Please Select a class...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_class_id").focus();
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
    var form = $("#editStudentForm");
    var formData = new FormData(form[0]);
   // var formData = new FormData();
    var imagefile = document.querySelector('#edit_image');
    formData.append("image", imagefile.files[0]);



    axios.post("{{route('edit-student')}}",
        formData
    ).then(function(response) {
  
    if(response.data.success){

      $('#editStudentModal').modal('hide');
   
      toastr.success('Success!', 'Student Updated Successfully',{
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
$(document).on('click', '.deletestudent', function() {
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
            axios.post("{{route('del-student')}}", {
                id: id
            }).then(function(response) {
              toastr.success('Success!', 'student Deleted Successfully',{
                "positionClass": "toast-bottom-right"
            })
              datatable.draw();
             
                //   
            }).catch(function(error) {})

        }
    });

});

$(document).on('click', '.viewDeleted', function() {

  location.href = "{{route('deleted-students')}}";
});


</script>
@endpush
@endsection