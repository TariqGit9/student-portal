@extends('layouts.'.$user)
@push('styles')
@endpush
@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">{{$class->name}} subjects </h4>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-5 text-center">
                  <span class="mr-3">  Subjects / Teacher : </span>
                    <select class="form-control selectpicker  col-6" data-live-search="true" name="subject" id="subject" required>
                      @if($subjects)
                        @foreach($subjects as $subject )
                        <option value="{{$subject->id}}">{{$subject->name}} &nbsp;&nbsp;&nbsp;&nbsp;  / &nbsp;&nbsp;&nbsp;&nbsp; @if(@$subject->teacher_subject) {{@$subject->teacher_subject->teacher_details->name}} @else No teacher assigned @endif</span></option>
                        @endforeach
                      @endif
                    </select>
                </div>

                <div class=" mt-5 mg-b-5 ">
					<div class="col-xl-12 "id="table_data">
				
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('javascript')
<!-- <script src="{{asset('assets/project-js/student/student-marks.js')}}"></script> -->

<script>
$( document ).ready(function() {
	var id = $('#subject').val();
	getData(id);
});

$(document).on('change', '#subject', function() {
	var	id = $(this).val();
	getData(id);
});

function getData(id){
	// $('#please_wait').modal('show');
  @if(Auth::user()->role_id==3)
	var url = "{{route('get-student-marks')}}";
 
  var student_id = null;
	@elseif(Auth::user()->role_id==2)
	var url = "{{route('display-student-marks')}}";
  var student_id = "{{$student->id}}";
  @elseif(Auth::user()->role_id==1)
	var url = "{{route('display-student-marks-admin')}}";
  var student_id = "{{$student->id}}";
	@endif
	axios.post(url, {
			id: id ,student_id: student_id 
		}).then(function(response) {
			// $('#please_wait').modal('hide');
			$('#table_data').html(response.data.success);
    });
}
</script>
@endpush
@endsection