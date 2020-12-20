@extends('layouts.teacher')
@push('styles')
@endpush
@section('content')
<div class="card-header card-header-primary">
    <h4 class="card-title">Welcome Admin ...</h4>
    {{-- <p class="card-category">Handcrafted by our friends from
      <a target="_blank" href="https://design.google.com/icons/">Google</a>
    </p> --}}
  </div>
  <div class="col-md-12">
    <div class="card card-chart">
      <div class="card-header card-header-warning">
        <div class="ct-chart" id="websiteViewsChart"></div>
      </div>
      <div class="card-body">
        <h4 class="card-title">Email Subscriptions</h4>
        <p class="card-category">Last Campaign Performance</p>
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="material-icons">access_time</i> campaign sent 2 days ago
        </div>
      </div>
    </div>
  </div>
@push('javascript')
@endpush
@endsection