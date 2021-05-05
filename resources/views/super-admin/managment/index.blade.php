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
      <h4 class="content-title mb-0 my-auto">Schools</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">Add a School </h4>
        <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addSchoolModel">Add a school</button></span></i>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="table_data" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                    <th class="all" width="2"></th>
                      <th >Avatar</th>
                      <th >Name</th>
                      <th >Unique ID</th>
                      <th >Email</th>
                      <th >Phone</th>
                      <!-- <th >Address</th> -->
                      <th >Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
  <div class="modal fade addSchoolModel" id="addschoolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a School </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form id="addSchoolForm">
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col ">
              <label class="bmd-label-floating form-required">Name </label>
              <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
            </div>
            <div class="form-group col">
              <label class="bmd-label-floating form-required">Email</label>
              <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            </div>
       
            
            {{-- --}}
          </div>
          <div class="form-row">
            <div class="form-group col">
              <label class="bmd-label-floating form-required">Phone </label>
              <input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp">
            </div>
            <div class="form-group col">
              <label for="exampleInputEmail1">Secondary Phone  </label>
              <input type="text" class="form-control" id="phone2" name="phone2" aria-describedby="emailHelp">
            </div>
          </div>
          

          <div class="form-row">
            <div class="form-group col">
              <label for="exampleInputEmail1">Abbreviation  </label>
              <input type="text" class="form-control" id="abbreviation" name="abbreviation" aria-describedby="emailHelp">
            </div>
            <div class="form-group col">
                <label class="bmd-label-floating form-required">Address Main </label>
                <textarea  class="form-control" id="address" name="address" ></textarea>
            </div> 
          </div>
          <div class="form-row">
            <div class="input-group file-browser">
                <input type="text" class="custom-file-label form-control browse-file" placeholder="Choose School Avatar" readonly>
                <label class="input-group-btn">
                  <span class="btn btn-default">
                    Browse <input type="file" name="image" id="image"  accept="image/*" style="display: none;" multiple>
                  </span>
                </label>
              </div>
          </div>
          <div class="form-row">
            <div class="form-group col">
              <label class="bmd-label-floating">Specialities</label>
              <textarea  class=" summernote" name="school_details"
              id="school_details"  ></textarea>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary addschool">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>

{{-- //Edit  --}}
<div class="modal fade addSchoolModel" id="editSchoolModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add a student </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form id="editFormData">
      <div class="modal-body">
      <div class="form-row">
            <div class="form-group col ">
              <label class="bmd-label-floating form-required">Name </label>
              <input type="text" class="form-control" id="edit_name" name="edit_name" aria-describedby="emailHelp">
            </div>
            <input type="hidden" class="form-control" id="edit_id" name="edit_id" aria-describedby="emailHelp">
            <div class="form-group col">
              <label class="bmd-label-floating form-required">Email</label>
              <input type="text" class="form-control" id="edit_email" name="edit_email" aria-describedby="emailHelp">
            </div>
       
            
            {{-- --}}
          </div>
          <div class="form-row">
            <div class="form-group col">
              <label class="bmd-label-floating form-required">Phone </label>
              <input type="text" class="form-control" id="edit_phone" name="edit_phone" aria-describedby="emailHelp">
            </div>
            <div class="form-group col">
              <label for="exampleInputEmail1">Secondary Phone  </label>
              <input type="text" class="form-control" id="edit_phone2" name="edit_phone2" aria-describedby="emailHelp">
            </div>
          </div>
          

          <div class="form-row">
            <div class="form-group col">
              <label for="exampleInputEmail1">Abbreviation  </label>
              <input type="text" class="form-control" id="edit_abbreviation" name="edit_abbreviation" aria-describedby="emailHelp">
            </div>
            <div class="form-group col">
                <label class="bmd-label-floating form-required">Address Main </label>
                <textarea  class="form-control" id="edit_address" name="edit_address" ></textarea>
            </div> 
          </div>

        <div class="form-row">
          <div class="form-group col-1">
            <img src="" id="edit_image_display" aly="broken" width="50" height="50">

          </div>

          <div class="form-group col-11">
            <div class="input-group file-browser ">
              <input type="text" class="custom-file-label form-control browse-file" placeholder="Choose  Avatar" readonly>
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
            <textarea  class="editsummer summernote" name="edit_details"
            id="edit_details"  ></textarea>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary editSchoolInfo">Save changes</button>
      </form>
      </div>
    </div>
  </div>
</div>

<form id="all_school_users" method="post" action="view-all-school-users">
  @csrf
  <input id="school_id" class="school_id" name ="school_id" type="hidden" value="">
</form >
<form id="all_school_sessions" method="post" action="view-all-school-sessions">
  @csrf
  <input id="school_id" class="school_id" name ="school_id" type="hidden" value="">
</form >

@push('javascript')
<script>
var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+.[a-z](?:\.[a-zA-Z0-9-]+)*$/;

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        var datatable = $('#table_data').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-schools')}}",
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
            data: 'unique_id',
            name: 'unique_id',
          
        },
        {
            data: 'email',
            name: 'email',
          
        },
        {
            data: 'phone',
            name: 'phone',
          
        },
        // {
        //     data: 'address',
        //     name: 'address',
          
        // },
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
       axios.post("{{route('get-school-detail-super-admin')}}", {
            id: d.id
        }).then(function(response) {
        
            resolve(response.data);
        }).catch(function(error) {

        })
    });

}

$('#table_data tbody').on('click', 'td.details-control', function() {
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
      
            html ="Address : "+ data.address+"<br>";
            html +="Details : "+ data.details+"<br>";
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

$(document).on('click', '.addschool', function() {
 
  //please_wait
   var phone_expresion="^((\+92)|(0092))-{0,1}\d{3}-{0,1}\d{7}$|^\d{11}$|^\d{4}-\d{7}$";
   if($("#name").val() == ""){
    toastr.warning('Warning!', "Please Fill  Name...", {
            "positionClass": "toast-bottom-right"
        });
        $("#name").focus();
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
   if($("#phone2").val() == ""){
    toastr.warning('Warning!', "Please Fill  Phone Number...", {
            "positionClass": "toast-bottom-right"
        });
        $("#phone2").focus();
        return;
   }
   if(isNaN($("#phone2").val())){
    toastr.warning('Warning!', "Not a Valid  Phone number...", {
            "positionClass": "toast-bottom-right"
        });
        $("#phone2").focus();
        return;
  }
   if(! $("#address").val()){
    toastr.warning('Warning!', "Please Fill Address ...", {
            "positionClass": "toast-bottom-right"
        });
        $("#address").focus();
        return;
   }
   if(! $("#abbreviation").val()){
    toastr.warning('Warning!', "Please Fill abbreviation ...", {
            "positionClass": "toast-bottom-right"
        });
        $("#abbreviation").focus();
        return;
   }
   if ($('#school_details').summernote('isEmpty')) {//using id
    toastr.warning('Warning!', "Please Fill School Details ...", {
            "positionClass": "toast-bottom-right"
        });
        $("#school_details").focus();
        return;
  }



    var form = $("#addSchoolForm");
    var formData = new FormData(form[0]);
   // var formData = new FormData();
    var imagefile = document.querySelector('#image');
    formData.append("image", imagefile.files[0]);

    $('#please_wait').modal('show');
    $('.addSchool').attr("disabled", true);
    axios.post("{{route('add-school-superadmin')}}",
        formData
    ).then(function(response) {
      $('.addschool').attr("disabled", false);
      $('#please_wait').modal('hide');
    if(response.data.success){

      $('#addschoolModal').modal('hide');
     
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
$(document).on('click', '.edit_data', function() {

  var edit_id = $(this).data('id');
  var edit_name = $(this).data('name');
  var edit_phone = $(this).data('phone');
  var edit_phone2 = $(this).data('phone2');
  var avatar = $(this).data('avatar');
  var email = $(this).data('email');
  var edit_abbreviation = $(this).data('abbreviation');
 

  $("#edit_id").val(edit_id); 
  $("#edit_name").val(edit_name); 

  $("#edit_phone").val(edit_phone); 
  $("#edit_phone2").val(edit_phone2); 
  $("#edit_email").val(email);
  $("#edit_abbreviation").val(edit_abbreviation);
  axios.post("{{route('get-school-detail-super-admin')}}", {
      id: edit_id
    }).then(function(response) {

      $("#edit_address").val(response.data.address); 
      $("#edit_details").summernote("code", response.data.details);
      
      var path="{{asset('uploads/school_avatars/')}}";
      $("#edit_image_display").attr("src",path+"/"+avatar);
    
      $('#editSchoolModel').modal('show');
    }).catch(function(error) {

  })
  
  

 
});

$(document).on('click', '.editSchoolInfo', function() {
  var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+.[a-z](?:\.[a-zA-Z0-9-]+)*$/;

  if($("#edit_name").val() == ""){
    toastr.warning('Warning!', "Please Fill  Name...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_name").focus();
        return;
   }

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
   if($("#edit_phone2").val() == ""){
    toastr.warning('Warning!', "Please Fill Phone Number 2 ...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_phone2").focus();
        return;
   }
   if(isNaN($("#edit_phone2").val())){
    toastr.warning('Warning!', "Not a Valid Phone number 2...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_phone2").focus();
        return;
  }
   if(! $("#edit_address").val()){
    toastr.warning('Warning!', "Please Fill Address Line...", {
            "positionClass": "toast-bottom-right"
        });
        $("#edit_address").focus();
        return;
   }
    var form = $("#editFormData");
    var formData = new FormData(form[0]);
   // var formData = new FormData();
    var imagefile = document.querySelector('#edit_image');
    formData.append("image", imagefile.files[0]);



    axios.post("{{route('edit-school-superadmin')}}",
        formData
    ).then(function(response) {
  
    if(response.data.success){

      $('#editSchoolModel').modal('hide');
   
      toastr.success('Success!', 'School Updated Successfully',{
              "positionClass": "toast-bottom-right"
          })      
      
      datatable.draw();
      $(".summernote").summernote("code", "");
    }
    else{

      toastr.warning('Warning!', response.data.error,{
              "positionClass": "toast-bottom-right"
          })  
  

    }
    });

});
$(document).on('click', '.toggle_block_data', function() {
    var id = $(this).data('id');
    var status = $(this).data('status');
    if(status==1){
      var Text_message = "Are you Sure you want to activate the School";
      var Text_button = "Activate";
      var color='#4BB543';
    }else{
      var Text_message = "Are you Sure you want to de-activate the School";
      var Text_button = "Deactivate";
      var color='#ca0b00';
 
    }

    Swal.fire({
        title: 'Change School Status',
        text: Text_message,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: color,
        cancelButtonText: "Cancel",
        confirmButtonText: Text_button,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post("{{route('block-school-super-admin')}}", {
                 status: status, id:id ,
            }).then(function(response) {
              toastr.success('Success!', 'School Status Changed Successfully',{
                "positionClass": "toast-bottom-right"
            })
              datatable.draw();
        
        })
        }
        else{

        }
    });

});



$(document).on('click', '.view_all_school_users', function() {
  var id = $(this).data('id');
  $('.school_id').val(id);
  $('#all_school_users').submit();
});
// 

$(document).on('click', '.view_all_school_sessions', function() {
  var id = $(this).data('id');
  $('.school_id').val(id);
  $('#all_school_sessions').submit();
});
</script>
@endpush
@endsection