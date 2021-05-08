<div class="card ">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mg-b-0 text-{{$colors[$counter]}}">{{$result_type->name}}</h4><a class="badge badge-secondary" href="#">Marks :  {{$obt_marks}} /{{$total_marks}}</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered mg-b-0 text-md-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Obtained Marks</th>
                        <th>Total Marks</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($student_marks_of_type as $marks )
                    <tr>
                
                        <th scope="row">{{++$number}}</th>
                        <td>{{$marks->description}}</td>
                        <td>{{$marks->test_date}}</td>
                        @if($marks->student_marks[0])
                            <td>{{$marks->student_marks[0]->obtained_marks}}</td>
                        @else
                            <td>0</td>
                        @endif
                        <td>{{$marks->total_marks}}</td>
                  
                    </tr>
                @endforeach 
                </tbody>
            </table>
        </div>
    </div>
</div>