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
      <h4 class="content-title mb-0 my-auto">Students </h4><span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
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


</script>
@endpush
@endsection