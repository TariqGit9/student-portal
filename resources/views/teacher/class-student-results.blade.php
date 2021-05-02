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
        <h4 class="card-title ">{{$class->name}}  </h4>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable" id="studentTable" width="100%" cellspacing="0">
          <tbody>  
              <thead class=" text-primary" >
                  <tr>
                 
                      <th >Description</th>
                      <th >Type</th>
                      <th >Total Marks</th>
                      <th >Passing Marks</th>
                      <th >Date</th>
                      <th >Action</th>
                  </tr>
              </thead>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
 

<form id="assessment_student" method="post" action="assesment-class-student">
  @csrf
  <input class="assessment" name ="assessment" type="hidden" value="">
</form >
@push('javascript')
<script>
        var x= $("#id").val();
        var datatable = $('#studentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('get-class-assesments')}}", type: 'post',
            data: {
            class_id:{{$id}},
            subject_id:{{$subject_id}},
            "_token": "{{ csrf_token() }}",
        }
        },
        columns: [
      
       
        {
            data: 'description',
            name: 'description',
          
        },
        {
            data: 'type',
            name: 'type',
          
        },
        {
            data: 'total_marks',
            name: 'total_marks',
          
        },
        {
            data: 'passing_marks',
            name: 'passing_marks',
          
        },
        {
            data: 'date',
            name: 'date',
          
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
});

$(document).on('click', '.assessments_status', function() {
  var status = $(this).data('status');
  var id = $(this).data('id');
  if(status==0){
      var message='Are you sure you want to hide result from students';
      var button='Hide';
      var color='#ca0b00';
  }else{
      var message='Are you sure you want to Publish result for students';
      var button='Publish';
      var color='#4BB543';
  }
  Swal.fire({
        title: message,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: color,
        confirmButtonText: button,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post("{{route('toggle-assessments-status')}}", {
              id: id , status: status
            }).then(function(response) {
              toastr.success('Success!', 'Status updated Successfully',{
                "positionClass": "toast-bottom-right"
            })
              datatable.draw();
             
                //   
            }).catch(function(error) {})

        }
    });
  
});

$(document).on('click', '.assesmentClassStudent', function() {
  var id = $(this).data('id');
  
 
  $('.assessment').val(id);
  
  $('#assessment_student').submit();
});

</script>
@endpush
@endsection