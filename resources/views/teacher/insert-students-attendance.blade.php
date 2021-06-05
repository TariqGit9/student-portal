@extends('layouts.teacher')
@push('styles')
@endpush
@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Class  </h4>
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
            <form id="submit_attendance">
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
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class="bmd-label-floating"> Type</label>
                        <select class="form-control selectpicker " data-live-search="true" name="type" id="type_id" required>
                            <option value="scheduled">Scheduled</option>
                            <option value="extra">Extra</option>
                        </select>
                    </div>
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class="bmd-label-floating ">Date</label>
                        <input class="form-control formclean" name= "date" id="date" type="text" readonly>
                    </div>
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <label class="bmd-label-floating ">Time</label>
                        <input class="form-control formclean" name="time" id="time" type="text" readonly>
                    </div>
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
                                <th>#</th>
                                <th>Registration Number</th>
                                <th>Name</th>
                                <th >Status</th>
                           
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($students as $index =>$student)
                                <tr>
                                    <th scope="row"> {{$index+1}}</th>
                                    <td>{{$student->student_details->reg_no}}</td>
                                    <td>{{$student->name}}</td>
                                    <td  scope="row"><input class="form-control numbers"  value="{{$student->id}}" name= "attendance[attendance-{{$index+1}}][id]"  type="hidden">
                                       
                                        <select class="form-control attendance  " id="attendance-{{$index+1}}"  name= "attendance[attendance-{{$index+1}}][attendance]"  required>
                                      
                                            <option value="Present">Present</option>
                                            <option value="Absent">Absent</option>
                                            <option value="Leave">Leave</option>
                                        </select>
                                    </td> 
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- bd -->
              <button type="button" class="btn btn-primary add-marks">Save changes</button>

            </div><!-- bd -->
        </div><!-- bd -->
    </div>
    </form>

<form id="class_student_attendance" method="post" action="class-student-results">
  @csrf
  <input id="class_id" class="class_id" name ="class_id" type="hidden" value="{{$class->id}}">
  <input class="subject_id" name ="subject_id" type="hidden" value="{{ $subject->id}}">
</form >

@push('javascript')
<script>
$(document).on('click', '.add-marks', function() {

   
    if($("#type_id").val() == null){
    toastr.warning('Warning!', "Please select type...", {
            "positionClass": "toast-bottom-right"
        });
        scrollTop("#type_id");
        return;
   }
        Swal.fire({
                title: 'Are you sure you want to submit this attendance?',
                // text: "Are you sure!",
                icon: 'info',
                showCancelButton: true,
                cancelButtonText: "Cancel",
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post("{{route('add-student-attendance')}}",
                        $('#submit_attendance').serialize()
                    ).then(function(response) {
                        toastr.success('Success!', "Attendance Saved Successfully...", {
                            "positionClass": "toast-bottom-right"
                        });
                    });
                }else{
                    return;
                }
            });



});
function scrollTop(id){

    $(id).focus();
    $(window).scrollTop($(id).position().top);
}

getDateAndTime();
function getDateAndTime(){
  var today = new Date();
  var time = today.getHours() + ":" + today.getMinutes();
  var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
 
  $("#date").val(date);
  var hours = today.getHours();
  var minutes = today.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  $("#time").val(strTime);
}
</script>
@endpush
@endsection