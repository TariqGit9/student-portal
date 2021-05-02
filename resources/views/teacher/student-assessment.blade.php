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
      <h4 class="content-title mb-0 my-auto">Results </h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
      <div class="card-body">
          <div class="main-content-label mg-b-5">
              Details
          </div>
          <p class="mg-b-20"> </p>
          <div class="row row-sm">
              <div class="col-lg">
                  <label class="bmd-label-floating">Class</label>
                  <input class="form-control" name="class" value="{{$data->class_details->name}}"  type="text" readonly>
                  <input class="form-control" name="class_id" value="{{$data->class_id}}"  type="hidden">
              </div>
              <div class="col-lg mg-t-10 mg-lg-t-0">
                  <label class="bmd-label-floating">Grade</label>
                  <input class="form-control"  name="grade" value="{{$data->grade->name}}" type="text" readonly>
                  <input class="form-control"  name="grade_id" value="{{$data->grade_id}}"  type="hidden">
              </div>
              <div class="col-lg mg-t-10 mg-lg-t-0">
                  <label class="bmd-label-floating">Subject</label>
                  <input class="form-control" name="subject" value="{{$data->subject_details->name}}" type="text" readonly>
                  <input class="form-control" name="subject_id" value="{{$data->subject_id}}"  type="hidden" readonly>
              </div>
          </div>
          <div class="row row-sm">
              <div class="col-lg">
                  <label class="bmd-label-floating"> Description</label>
                  <input class="form-control" id="description" name= "description" value="{{$data->description}}" type="text"readonly>
              </div>
              <div class="col-lg mg-t-10 mg-lg-t-0">
                  <label class="bmd-label-floating"> Type</label>
                  <input class="form-control" value="{{$data->type->name}}" name= "type" id="type" type="type"readonly>
              </div>
              <div class="col-lg mg-t-10 mg-lg-t-0">
                  <label class="bmd-label-floating">Date</label>
                  <input class="form-control" value="{{$data->test_date}}" name= "date" id="date" type="date"readonly>
              </div>
          </div>
          <div class="row row-sm">
              <div class="col-lg">
                  <label class="bmd-label-floating">Total Marks</label>
                  <input class="form-control" name= "total_marks" id="total_marks" value="{{$data->total_marks}}" type="number"readonly>
              </div>
              <div class="col-lg mg-t-10 mg-lg-t-0">
                  <label class="bmd-label-floating">Passing Marks</label>
                  <input class="form-control" name= "passing_marks" id="passing_marks" value="{{$data->passing_marks}}" type="number"readonly>
              </div>
              
          </div>
      </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">  </h4>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="table_data" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                      <th >Result</th>
                      <th >Student Name ( Registration Number )</th>
                      <th >Marks Obtained</th>
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
<div class="modal fade " id="edit_marks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Marks  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form id="student_marks">
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col ">
            <label class="bmd-label-floating form-required">Name </label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="" disabled>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col ">
            <label class="bmd-label-floating form-required">Total Obtained </label>
            <input type="number" class="form-control" value="{{$data->total_marks}}" id="Totalmarks" name="Totalmarks" aria-describedby="" disabled>
          </div>
          <div class="form-group col ">
            <label class="bmd-label-floating form-required">Marks Obtained </label>
            <input type="number" class="form-control" id="marks" name="marks" aria-describedby="" >
          </div>
          <input type="hidden" class="form-control" value="" id="edit_id" name="edit_id" aria-describedby="emailHelp">
        </div>
    

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary editchanges">Save changes</button>
      </form>
      </div>
    </div>
  </div>
</div>

@push('javascript')
<script>

        var datatable = $('#table_data').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-class-assesments-result')}}", type: 'post',
            data: {
            id:{{$id}},
            "_token": "{{ csrf_token() }}",
        }
        },
        columns: [
      
       
        {
            data: 'result',
            name: 'result',
          
        },
        {
            data: 'student_name',
            name: 'student_name',
          
        },
        {
            data: 'obtained_marks',
            name: 'obtained_marks',
          
        },
     
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
});

$(document).on('click', '.studentMarks', function() {

var edit_id = $(this).data('id');
var marks = $(this).data('marks');
var name = $(this).data('name');

$("#edit_id").val(edit_id); 
$("#marks").val(marks); 
$("#name").val(name); 

$('#edit_marks').modal('show');
});
$(document).on('click', '.editchanges', function() {

  if($("#marks").val() > {{$data->total_marks}}){
    toastr.warning('Warning!', "Obtained Marks can not be greater than Total marks...", {
            "positionClass": "toast-bottom-right"
        });
        return;
   }
    axios.post("{{route('edit-marks')}}",
        $('#student_marks').serialize()
    ).then(function(response) {
  
    $('#edit_marks').modal('hide');
   
        toastr.success('Success!', ' Updated Successfully',{
                "positionClass": "toast-bottom-right"
            })
        
        $("#marks").val(""); 
        datatable.draw();
    });


});




</script>
@endpush
@endsection