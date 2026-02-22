@extends('layouts.'.$user)
@push('styles')
@endpush
@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <h4 class="content-title mb-0 my-auto">Marks</h4>
    <span class="text-muted mt-1 tx-13 mb-0">{{$class->name}}</span>
  </div>
  @if(isset($student))
  <div class="d-flex align-items-center">
    <img src="{{ asset('uploads/student_avatars/' . $student->avatar) }}" alt="" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
    <div class="ml-3">
      <h6 class="mb-0">{{ $student->name }}</h6>
      <small class="text-muted">Reg# {{ $student->student_details->reg_no }}</small>
    </div>
  </div>
  @endif
</div>
@if(isset($sessions) && $sessions->count() > 0)
<div class="mb-3">
  <div class="d-flex align-items-center" style="gap: 10px;">
    <span class="font-weight-bold tx-13">Session:</span>
    <select class="form-control selectpicker" data-live-search="true" id="session_select" data-width="200px" data-style="btn-sm btn-outline-primary">
      @foreach($sessions as $s)
        <option value="{{$s->id}}" @if($s->id == $active_session_id) selected @endif>{{$s->name}} @if($s->status == 1) (Active) @endif</option>
      @endforeach
    </select>
  </div>
</div>
@endif
<div class="row">
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                  <label class="font-weight-bold mb-2">Subjects / Teacher :</label>
                    <select class="form-control selectpicker w-100" data-live-search="true" name="subject" id="subject" required>
                      @if($subjects)
                        @foreach($subjects as $subject )
                        <option value="{{$subject->id}}">{{$subject->name}}  /  @if(@$subject->teacher_subject) {{@$subject->teacher_subject->teacher_details->name}} @else No teacher assigned @endif</option>
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

$(document).on('change', '#session_select', function() {
	var	id = $('#subject').val();
	getData(id);
});

function getData(id){
  @if(Auth::user()->role_id==3)
	var url = "{{route('get-student-marks')}}";
  var student_id = null;
  var session_id = null;
	@elseif(Auth::user()->role_id==2)
	var url = "{{route('display-student-marks')}}";
  var student_id = "{{$student->id}}";
  var session_id = $('#session_select').val();
  @elseif(Auth::user()->role_id==1)
	var url = "{{route('display-student-marks-admin')}}";
  var student_id = "{{$student->id}}";
  var session_id = $('#session_select').val();
	@endif
	axios.post(url, {
			id: id, student_id: student_id, session_id: session_id
		}).then(function(response) {
			$('#table_data').html(response.data.success);
    });
}
</script>
@endpush
@endsection