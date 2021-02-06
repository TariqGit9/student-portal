@extends('layouts.teacher')
@push('styles')
@endpush
@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">Welcome {{Auth::user()->name}} ...</h4>
    </div>
  </div>
</div>





@push('javascript')
@endpush
@endsection