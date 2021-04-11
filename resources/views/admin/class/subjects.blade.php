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
      <h4 class="content-title mb-0 my-auto">Subjects</h4>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">Subjects </h4>
        <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Subject</button></span></i>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="groupTable" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                    <th class="all" width="2"></th>
                      <th >Name</th>
                      <th >Grade</th>
                      <th >Type</th>
                      <th >Author</th>
                      <th >Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>





  <div class="modal fade addStudentModel" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a Subject </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="addSubjectForm">
                <div class="form-group">
                 </div>  
                <div class="form-row">
                  <div class="form-group col ">
                    <label class="bmd-label-floating form-required">Subject </label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                  </div>
                  <div class="form-group col">
                    <label class="bmd-label-floating">Book Type</label>
                    <input type="text" class="form-control" id="type" name="type" aria-describedby="emailHelp">
                  </div>
                  <div class="form-group col">
                    <label class="bmd-label-floating">Author</label>
                    <input type="text" class="form-control" id="author" name="author" aria-describedby="emailHelp">
                  </div>
                </div>
              


                <div class="form-group">
                    <label for="exampleInputEmail1">Select Grade </label>
                    <select class="form-control selectpicker" data-live-search="true" name="grade" id="grade" required>
                        <option disabled selected>Please Select a Grade</option>  
                      @if($grades)
                        @foreach($grades as $grade )
                        <option value="{{$grade->id}}">{{$grade->name}}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
                <div class="form-group">
                  
            <label for="exampleInputEmail1">Details </label>
              <br>
              <textarea  class=" summernote" name="info"
                      id="info"  ></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary addSubject">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade addStudentModel" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Subject </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="editSubjectForm">
                <div class="form-group">
                 </div>  
                <div class="form-row">
                  <div class="form-group col ">
                    <label class="bmd-label-floating form-required">Subject </label>
                    <input type="text" class="form-control" id="edit_name" name="edit_name" aria-describedby="emailHelp">
                  </div>
                  <div class="form-group col">
                    <label class="bmd-label-floating">Book Type</label>
                    <input type="text" class="form-control" id="edit_type" name="edit_type" aria-describedby="emailHelp">
                  </div>
                  <div class="form-group col">
                    <label class="bmd-label-floating">Author</label>
                    <input type="text" class="form-control" id="edit_author" name="edit_author" aria-describedby="emailHelp">
                  </div>
                </div>
              
                <input type="hidden" class="form-control" id="edit_id" name="edit_id" aria-describedby="emailHelp">
                 

                <div class="form-group">
                    <label for="exampleInputEmail1">Select Grade </label>
                    <select class="form-control selectpicker" data-live-search="true" name="edit_grade" id="edit_grade" required>
                        <option disabled selected>Please Select a Grade</option>  
                        @if($grades)
                        @foreach($grades as $grade ){{$grade->id}}
                        <option value="{{$grade->id}}">{{$grade->name}}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
                <div class="form-group">
                  
            <label for="exampleInputEmail1">Details </label>
              <br>
              <textarea  class="editone summernote" name="edit_info"
                      id="edit_info"  ></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary editSubject">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>
@push('javascript')
<script>

$("select option:selected").css('backgroundColor', '#FFFFFF');
        var datatable = $('#groupTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-subject')}}",
        },
        columns: [
          {
            'className': 'details-control',
            'orderable': false,
            'data': null,
            'defaultContent': ''
        },
        {
            data: 'name',
            name: 'name',
          
        },
        {
            data: 'grade',
            name: 'grade',
          
        },
        {
            data: 'type',
            name: 'type',
          
        },
        {
            data: 'author',
            name: 'author',
          
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
       axios.post("{{route('get-subject-detail')}}", {
            id: d.id
        }).then(function(response) {
        
            resolve(response.data);
        }).catch(function(error) {

        })
    });

}


$('#groupTable tbody').on('click', 'td.details-control', function() {
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
           
            row.child(data.result).show();
        });

        tr.addClass('shown');
    }
});



$(document).on('click', '.editSubject', function() {
   
   if($("#edit_name").val() == ""){
    toastr.warning('Warning!', "Please Fill Subject Name...", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }

   if($("#edit_grade").val() == null){
    toastr.warning('Warning!', "Please Select grade...", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }
    axios.post("{{route('edit-subject')}}",
        $('#editSubjectForm').serialize()
    ).then(function(response) {
  
    $('#editSubjectModal').modal('hide');
    toastr.success('Success!', "Subject Added Successfully...", {
            "positionClass": "toast-bottom-right"
        });
        $("#name").val(""); 
        $(".selectpicker").val('default');
        $(".selectpicker").selectpicker("refresh");
        $(".summernote").summernote("code", "");

        datatable.draw();
    });


});

$(document).on('click', '.addSubject', function() {
   
   if($("#name").val() == ""){
    toastr.warning('Warning!', "Please Fill Subject Name...", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }

   if($("#grade").val() == null){
    toastr.warning('Warning!', "Please Select grade...", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }
    axios.post("{{route('add-subject')}}",
        $('#addSubjectForm').serialize()
    ).then(function(response) {
  
    $('#addSubjectModal').modal('hide');
    toastr.success('Success!', "Class Added Successfully...", {
            "positionClass": "toast-bottom-right"
        });
        $("#name").val(""); 
        $("#grade").val("");
        $("#author").val("");
        $("#type").val("");
        $(".summernote").summernote("code", "");
        $(".selectpicker").val('default');
        $(".selectpicker").selectpicker("refresh");
        datatable.draw();
    });


});

$(document).on('click', '.editSubjectInfo', function() {

    var edit_id = $(this).data('id');
    var edit_name = $(this).data('name');
    var edit_author = $(this).data('author');
    var edit_grade = $(this).data('grade');
    var edit_type= $(this).data('type');
    var edit_details = $(this).data('details');
    $("#edit_id").val(edit_id); 
    $("#edit_name").val(edit_name); 
    $("#edit_author").val(edit_author); 
    $("#edit_grade").val(edit_grade); 
    $("#edit_type").val(edit_type); 
   // $("#edit_details").val(edit_details); 
    $('.selectpicker').selectpicker('refresh');
     //  $(".summernote").summernote("code", edit_details);

    //  $(".editone").summernote("code", "adasdasdasd");
     axios.post("{{route('get-subject-detail')}}", {
            id: edit_id
        }).then(function(response) {
          
        $(".editone").summernote("code", response.data.result);
        }).catch(function(error) {

        })
});


$(document).on('click', '.deleteSubject', function() {
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
            axios.post("{{route('del-subject')}}", {
                id: id
            }).then(function(response) {
              toastr.success('Success!', 'Subject Deleted Successfully',{
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