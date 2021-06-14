@extends('layouts.teacher')
@push('styles')
@endpush
@section('content')

<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Classes</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">Classes </h4>
        {{-- <i class="mdi "><span class="float-right" ><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".addStudentModel">Add a Class</button></span></i> --}}
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">

        <table id="table_id" width="100%" cellspacing="0" class="display">
            <thead>
                <tr>
                  <th>Name</th>
                  @foreach($result as $data)
                    <th>{{$data->date}}</th>
                  @endforeach
                </tr>
            </thead>
            
            <tbody>
            @foreach($class_students as $student)
                <tr>
                    <td>{{$student->name}}</td>
                    @foreach($result as $data)
                        @php
                            $check = $all_class_attendance->where('attendance_id', $data->id)->where('student_id', $student->id)->first();
                        @endphp
                     @if($check)
                     <td>{{$check->attendance}}</td>
                     @else
                     <td>--</td>
                     @endif
                       
                    @endforeach
           
                </tr>
            @endforeach
            </tbody>
        </table>



      </div>
    </div>
  </div>
</div>

@push('javascript')
<script>
$(document).ready( function () {
   
    $('.display').DataTable( {
        "scrollX": true
    } );

});
$(".display tbody tr").on('click',function(event) {
 
    $(".display tbody tr").removeClass('bg-light');        
    $(this).addClass('bg-light');
});
</script>
@endpush
@endsection