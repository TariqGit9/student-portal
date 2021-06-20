@extends('layouts.'.$layout_user)
@push('styles')
@endpush
@section('content')

<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Class Attendance</h4>
      <span class="text-muted mt-1 tx-13 ml-2 mb-0">
        @if($date) 
        <div class="tags">
          <span class="tag tag-gray">
            {{$date}}
            <a href="javascript:void(0)" class="tag-addon remove-filter-date "><i class="fe fe-x"></i></a>
          </span>
        </div>  
        @endif
        
      </span>
    </div>
  </div>
</div>
<div class="col-xl-12">
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <h4 class="card-title ">Class Attendance </h4>
        
        <div class="float-right row" >
          <div class="col-sm mt-2 ">
            Search by Date: 
          </div> 
          <div class="col-sm">
           <input class="form-control date_search" placeholder="Search by Date" max="" name= "date" id="date" type="date" ></div>
          </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row row-sm">
      </div>


      <div class="table-responsive">
        @php
          $first_row ="";
          $last_row = "";
        @endphp
        <table id="table_id" width="100%" cellspacing="0" class="display">
            <thead>
                <tr>
                  <th>Name</th>
                  @foreach($result as $data)
                    @php
                    if(! $first_row){
                      $first_row = $data->id;
                    }
                     $last_row = $data->id;
                    @endphp
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
      <div class="row row-sm float-right">
        <div class="col-lg-4">
          <div aria-label="Basic example" class="btn-group" role="group">
            <button class="btn btn-secondary pd-x-25 get_class_student_attendance_first mr-2" @if(! $first_check ) disabled @endif  type="button">Previous</button> 
            
            <button class="btn btn-secondary get_class_student_attendance_last pd-x-25" @if(! $last_check ) disabled @endif type="button">Next</button>
          </div>
        </div><!-- col-4 -->
      </div>
      
    </div>
  </div>

</div>



@php 
if($layout_user=='admin'){
  $url= "admin-get-student-subject-attendance";
}else{
  $url= "get-student-subject-attendance";
}


@endphp



<form id="get_class_student_attendance_first" method="post" action="{{route($url)}}">
  @csrf
  <input id="class_id" class="class_id" name ="class_id" type="hidden" value="{{ $class_id }}">
  <input class="subject_id" name ="subject_id" type="hidden" value="{{ $subject_id }}">
  <input class="first_row" name ="first_row" type="hidden" value="{{ $first_row }}">
 
</form>
<form id="get_class_student_attendance_last" method="post" action="{{route($url)}}">
  @csrf
  <input id="class_id" class="class_id" name ="class_id" type="hidden" value="{{ $class_id }}">
  <input class="subject_id" name ="subject_id" type="hidden" value="{{ $subject_id }}">
  <input class="last_row" name ="last_row" type="hidden" value="{{ $last_row }}">
</form>

<form id="get_class_student_attendance_by_date" method="post" action="{{route($url)}}">
  @csrf
  <input id="class_id" class="class_id" name ="class_id" type="hidden" value="{{ $class_id }}">
  <input class="subject_id" name ="subject_id" type="hidden" value="{{ $subject_id }}">
  <input class="search_date" name ="search_date" id="search_date" type="hidden" value="">
</form>
@push('javascript')
<script>
$(document).ready( function () {
   
    $('.display').DataTable( {
        "scrollX": true,
        orderable: true,
        searching: false,
        paging: false,
    } );


});
$(".display tbody tr").on('click',function(event) {
    $(".display tbody tr").removeClass('bg-light');        
    $(this).addClass('bg-light');
});

$(document).on('click', '.get_class_student_attendance_last', function() {
  $('#get_class_student_attendance_last').submit();
});
$(document).on('click', '.get_class_student_attendance_first', function() {
  $('#get_class_student_attendance_first').submit();
});
$(document).on('change', '.date_search', function() {
  var date = $(this).val();
  $('.search_date').val(date);
  $('#get_class_student_attendance_by_date').submit();
});
$(document).on('click', '.remove-filter-date', function() {
  $('#get_class_student_attendance_by_date').submit();
});
$(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();

    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;    
    $('#date').attr('max', maxDate);
});
</script>
@endpush
@endsection