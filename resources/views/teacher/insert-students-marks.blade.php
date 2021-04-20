@extends('layouts.teacher')
@push('styles')
@endpush
@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Class Subject </h4>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    Details
                </div>
            <form id="submit_marks">
                <p class="mg-b-20"> </p>
                <div class="row row-sm">
                    <div class="col-lg">
                        <label class="bmd-label-floating">Class</label>
                        <input class="form-control" name="class" value="{{$class->name}}"  type="text" readonly>
                        <input class="form-control" name="class_id" value="{{$class->id}}"  type="hidden">
                    </div>
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class="bmd-label-floating">Grade</label>
                        <input class="form-control"  name="grade" value="{{$class->grade->name}}" type="text" readonly>
                        <input class="form-control"  name="grade_id" value="{{$class->grade->id}}"  type="hidden">
                    </div>
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class="bmd-label-floating">Subject</label>
                        <input class="form-control" name="subject" value="{{$subject->name}}" type="text" readonly>
                        <input class="form-control" name="subject_id" value="{{$subject->id}}"  type="hidden" readonly>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-lg">
                        <label class="bmd-label-floating"> Description</label>
                        <input class="form-control" id="description" name= "description" type="text">
                    </div>
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class="bmd-label-floating"> Type</label>
                        <select class="form-control selectpicker" data-live-search="true" name="type_id" id="type_id" required>
                            <option disabled selected>Please Select an Option</option>  
                            @if($types)
                            @foreach($types as $type ){{$type->id}}
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                          @endif
                        </select>
                    </div>
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class="bmd-label-floating">Date</label>
                        <input class="form-control" name= "date" id="date" type="date">
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-lg">
                        <label class="bmd-label-floating">Total Marks</label>
                        <input class="form-control" name= "total_marks" id="total_marks" type="number">
                    </div>
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class="bmd-label-floating">Passing Marks</label>
                        <input class="form-control" name= "passing_marks" id="passing_marks"  type="number">
                    </div>
                    {{-- <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class="bmd-label-floating">Date</label>
                        <input class="form-control" name= "date"  type="date">
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
	<div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">Students</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <p class="tx-12 tx-gray-500 mb-2"></p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Registration Number</th>
                                <th>Name</th>
                                <th >Marks Obtained</th>
                           
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($students as $index =>$student)
                                <tr>
                                    <th scope="row"> {{$index+1}}</th>
                                    <td>{{$student->student_details->reg_no}}</td>
                                    <td>{{$student->name}}</td>
                                    <td  scope="row"><input class="form-control numbers"  value="{{$student->id}}" name= "marks[marks-{{$index+1}}][id]"  type="hidden">
                                    <input class="form-control obt_marks" min="0" value="0" id="obt_marks-{{$index+1}}"  name= "marks[marks-{{$index+1}}][obt_marks]"  type="number"></td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- bd -->
              <button type="button" class="btn btn-primary add-result">Save changes</button>

            </div><!-- bd -->
        </div><!-- bd -->
    </div>
    </form>



@push('javascript')
<script>
$(document).on('click', '.add-result', function() {

    if($("#description").val() == ""){
    toastr.warning('Warning!', "Please Fill description ...", {
            "positionClass": "toast-bottom-right"
        });
        scrollTop("#description");
        return;
   }   
    if($("#type_id").val() == null){
    toastr.warning('Warning!', "Please select type...", {
            "positionClass": "toast-bottom-right"
        });
        scrollTop("#type_id");
        return;
   }

   if($("#date").val() == ""){
    toastr.warning('Warning!', "Date can not be Empty...", {
            "positionClass": "toast-bottom-right"
        });
        scrollTop("#date");
        return;
   }
   if($("#total_marks").val() == ""){
    toastr.warning('Warning!', "Please Fill Total Marks...", {
            "positionClass": "toast-bottom-right"
        });
        scrollTop("#total_marks");
        return;
   }
  
   if($("#passing_marks").val() == ""){
    toastr.warning('Warning!', "Please Fill Passing Marks...", {
            "positionClass": "toast-bottom-right"
        });
        scrollTop("#passing_marks");
        return;
   }
   if(Number($("#passing_marks").val()) > Number($("#total_marks").val())){
    toastr.warning('Warning!', "Passing Marks can not be greater than Total marks...", {
            "positionClass": "toast-bottom-right"
        });
        scrollTop("#passing_marks");
        return;
   }
   var check= validate_numbers();
  
    if(check=="success"){
        axios.post("{{route('add-student-result')}}",
            $('#submit_marks').serialize()
        ).then(function(response) {
            toastr.success('Success!', "Marks are Uploaded Successfully...", {
                "positionClass": "toast-bottom-right"
            });
        });
    }


});
function scrollTop(id){

    $(id).focus();
    $(window).scrollTop($(id).position().top);
}
function validate_numbers(){
var inputs = document.getElementsByClassName( 'obt_marks' );
var msg="success";
for (i=0; i<inputs.length; i++){
    if(inputs[i].value==""){
        inputs[i].focus();
        var count= i+1; 
        toastr.warning('Warning!', "Obtained Marks can not Empty...", {
            "positionClass": "toast-bottom-right"
        });
        var elmnt = document.getElementById("obt_marks-"+count);
       // $(window).scrollTop($("#obt_marks-"+count).position().top);
        elmnt.scrollIntoView();
        
        return ;
    }
    if(Number($("#total_marks").val())<inputs[i].value){
        inputs[i].focus();
        var count= i+1; 
        toastr.warning('Warning!', "Obtained Marks can not be greater than Total marks...", {
            "positionClass": "toast-bottom-right"
        });
        var elmnt = document.getElementById("obt_marks-"+count);
       // $(window).scrollTop($("#obt_marks-"+count).position().top);
        elmnt.scrollIntoView();
        msg="error";
        
    }
}
        return msg;
}

</script>
@endpush
@endsection