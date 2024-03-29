{{-- extend layout --}}
@extends('layouts.fullLayoutMaster')

{{-- page title --}}
@section('title','500 Page')
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-500.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section p-0 m-0 height-100vh section-500">
  <div class="row">
    <!-- 404 -->
    <div class="col s12 center-align white">
      <img src="{{asset('images/gallery/error-2.png')}}" alt="" class="bg-image-500">
      <h1 class="error-code m-0">500</h1>
      <h6 class="mb-2">BAD REQUEST</h6>
      <a class="btn waves-effect waves-light gradient-45deg-deep-purple-blue gradient-shadow mb-4"
        href="{{asset('/')}}">Back
        TO Home</a>
    </div>
  </div>
</div>
@endsection
