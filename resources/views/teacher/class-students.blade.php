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
        <h4 class="card-title ">{{$class->name}}  </h4>
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
 

{{-- //Edit  --}}
<div class="modal fade " id="student_report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Report a Student </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form id="report_student">
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col ">
            <label class="bmd-label-floating form-required">Name </label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" disabled>
          </div>
          <input type="hidden" class="form-control" id="student_id" name="student_id" aria-describedby="emailHelp">
          <input type="hidden" class="form-control" value="{{$id}}" id="class_id" name="class_id" aria-describedby="emailHelp">
         
          <div class="form-group col">
            <label class="bmd-label-floating form-required">User Name</label>
            <input type="text" class="form-control" id="user_name" name="user_name" aria-describedby="emailHelp" disabled>
          </div>
          <div class="form-group col">
            <label class="bmd-label-floating form-required">Reg number</label>
            <input type="text" class="form-control" id="reg_no" name="reg_no" aria-describedby="emailHelp" disabled>
          </div>
        
         
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label class="bmd-label-floating">Title</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" >
           
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label class="bmd-label-floating">Description</label>
            <textarea  class="editsummer summernote" name="description"
            id="description"  ></textarea>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary sendreport">Save changes</button>
      </form>
      </div>
    </div>
  </div>
</div>

<form id="view_student_marks" method="post" action="student-marks">
  @csrf
  <input  class="student_id" name ="student_id" type="hidden" value="">

</form >
<form id="view_student_attandence" method="post" action="view-student-attendance">
  @csrf
  <input  class="student_id" name ="student_id" type="hidden" value="">

</form >
@push('javascript')
<script>
        var x= $("#id").val();
        var datatable = $('#studentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-teacher-class-students')}}", type: 'post',
            data: {
            id:{{$id}},
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



$(document).on('click', '.getStudentdetailsReport', function() {

var edit_id = $(this).data('id');
var edit_name = $(this).data('name');
var edit_user_name = $(this).data('user_name');
var edit_reg_no = $(this).data('reg-no');

$("#student_id").val(edit_id); 
$("#name").val(edit_name); 
$("#user_name").val(edit_user_name); 
$("#reg_no").val(edit_reg_no); 


});

$(document).on('click', '.sendreport', function() {
  
    var form = $("#report_student");
    var formData = new FormData(form[0]);
    if($("#title").val()=='' ){
      toastr.warning('Warning!', "Please add a title", {
            "positionClass": "toast-bottom-right"
      });
      return;
    }
    if ($('#description').summernote('isEmpty'))
    {
      toastr.warning('Warning!', "Please add some description", {
            "positionClass": "toast-bottom-right"
      });
      return;
    }
    $('#please_wait').modal('show');
    axios.post("{{route('report-student-to-admin')}}",
        formData
    ).then(function(response) {
  
    if(response.data.success){
      $('#please_wait').modal('hide');

      $('#student_report').modal('hide');
      toastr.success('Success!', 'Student Reported Successfully',{
              "positionClass": "toast-bottom-right"
          })      
          $(".summernote").summernote("code", "");

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


$(document).on('click', '.viewMarks', function() {

var id = $(this).data('id');

$(".student_id").val(id); 
$('#view_student_marks').submit();


});

$(document).on('click', '.viewAttendance', function() {

var id = $(this).data('id');

$(".student_id").val(id); 
$('#view_student_attandence').submit();


});


</script>
@endpush
@endsection