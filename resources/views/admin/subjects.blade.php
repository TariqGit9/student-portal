@extends('layouts.admin')
@push('styles')
<style>

    </style>
@endpush
@section('content')

<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Tables</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Data Tables</span>
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
                        <option value="Nursery">Nursery</option>
                        <option value="Grade 1">Grade 1</option>
                        <option value="Grade 2">Grade 2</option>
                        <option value="Grade 3">Grade 3</option>
                        <option value="Grade 4">Grade 4</option>
                        <option value="Grade 5">Grade 5</option>
                        <option value="Grade 6">Grade 6</option>
                        <option value="Grade 7">Grade 7</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
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
                        <option value="Nursery">Nursery</option>
                        <option value="Grade 1">Grade 1</option>
                        <option value="Grade 2">Grade 2</option>
                        <option value="Grade 3">Grade 3</option>
                        <option value="Grade 4">Grade 4</option>
                        <option value="Grade 5">Grade 5</option>
                        <option value="Grade 6">Grade 6</option>
                        <option value="Grade 7">Grade 7</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
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

     $(".editone").summernote("code", edit_details);

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