<div class="col-xl-3 col-lg-6 col-md-6">
    <div class="card  bg-{{$colors[$counter]}}-gradient">
        <div class="card-body">
            <div class="counter-status d-flex md-mb-0">
                <div class="counter-icon">
                    <i class="fas fa-poll"></i>
                </div>
                <div class="ml-auto">
                    <h5 class="tx-13 tx-white-8 mb-3">{{$result_type->name}} ({{$percentage}}%)</h5>
                    <h2 class="counter mb-0 text-white"> {{$obt_marks}} /{{$total_marks}}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

      