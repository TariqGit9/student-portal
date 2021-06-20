@extends('layouts.student')
@push('styles')
@endpush
@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Subjects </h4>
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
                      @if (in_array($subject->id, $student_subjects))
                        <option value="{{$subject->id}}">{{$subject->name}} &nbsp;&nbsp;&nbsp;&nbsp;  / &nbsp;&nbsp;&nbsp;&nbsp;  {{$subject->teacher_subject->teacher_details->name}}</span></option>
                      @endif
                      @endforeach
                    @endif
                  </select>
              </div>
        
              <div class=" mt-5 mg-b-5 ">
                <div class="col-xl-12 ">
                  <div class="col-xl-12">
                    <div class="card">

                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="table datatable" id="table_data" width="100%" cellspacing="0">
                            <tbody>  
                                <thead class=" text-primary" >
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Time</th>
                                        <th class="text-center">Attendance</th>
                                    </tr>
                                </thead>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row row-sm justify-content-center">
                <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                  <div class="card bg-success-gradient text-white ">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-6">
                          <div class="icon1 mt-2 text-center">
                            <i class="fe fe-clipboard tx-40"></i>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="mt-0 text-center">
                            <span class="text-white"> Presents</span>
                            <h2 class="text-white mb-0 all-presents">--</h2>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                  <div class="card bg-warning-gradient text-white">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-6">
                          <div class="icon1 mt-2 text-center">
                            <i class="fe fe-clipboard tx-40"></i>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="mt-0 text-center">
                            <span class="text-white"> Absents</span>
                            <h2 class="text-white mb-0 all-absents">--</h2>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                  <div class="card bg-secondary-gradient text-white">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-6">
                          <div class="icon1 mt-2 text-center">
                            <i class="fe fe-clipboard tx-40"></i>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="mt-0 text-center">
                            <span class="text-white"> Leaves</span>
                            <h2 class="text-white mb-0 all-leaves">--</h2>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
</div>


@push('javascript')
<script>

dataTableData( $("#subject").val());
getStats($("#subject").val());



function dataTableData(subject){
    $("#table_data").dataTable().fnDestroy();

    table=$('#table_data').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{route('get-my-subject-attendance')}}", type: 'post',
            data: {
            subject_id: subject,
            "_token": "{{ csrf_token() }}",
        }
        },
        columns: [
        {
            data: 'date',
            name: 'date',
        },
        {
            data: 'time',
            name: 'time',
        },
        {
            data: 'attendance',
            name: 'attendance',
        },
        ]
});
}

function getStats(subject){
var url = "{{route('get-my-subject-attendance-stats')}}";


	axios.post(url, {
		subject_id: subject 
		}).then(function(response) {
			$('.all-presents').text(response.data.result_present);
      $('.all-absents').text(response.data.result_absents);
      $('.all-leaves').text(response.data.result_leaves);
    });
}





$('#subject').on('change', function() {
   dataTableData($("#subject").val());
   getStats($("#subject").val());

});


</script>


@endpush
@endsection