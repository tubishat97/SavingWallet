{{-- layout --}}
@extends('layouts.fullLayoutMaster')

{{-- page title --}}
@section('title','Register')

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/login.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
@endsection

{{-- page content --}}
@section('content')
<div id="login-page" class="row">
  <div class="col s12  z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
    <form class="login-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.register') }}">
      @csrf
      <div class="row">
        <div class="input-field col s6">
          <h5 class="ml-4">Register</h5>
        </div>
      </div>
      <div class="row margin">
        <div class="input-field col s6">
          <i class="material-icons prefix pt-2">person_outline</i>
          <input id="fullname" name="fullname" type="text">
          <label for="fullname" class="center-align">Full Name</label>
          @error('fullname')
          <small class="red-text ml-7">
            {{ $message }}
          </small>
          @enderror
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix pt-2">mail_outline</i>
          <input id="email" name="username" type="email">
          <label for="email">Email</label>
          @error('username')
          <small class="red-text ml-7">
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>

      <div class="row margin">
        <div class="input-field col s6">
          <i class="material-icons prefix pt-2">call</i>
          <input id="phone" name="phone" type="text">
          <label for="phone">Phone</label>
          @error('phone')
          <small class="red-text ml-7">
            {{ $message }}
          </small>
          @enderror
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix pt-2">event</i>
          <input id="dob" type="text" name="dob" class="datepicker">
          <label for="dob">DOB</label>
          @error('dob')
          <small class="red-text ml-7">
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>

      <div class="row margin">
        <div class="input-field col s6">
          <i class="material-icons prefix pt-2">lock_outline</i>
          <input id="password" name="password" type="password">
          <label for="password">Password</label>
          @error('password')
          <small class="red-text ml-7" style="display: inline;">
            {{ $message }}
          </small>
          @enderror
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix pt-2">lock_outline</i>
          <input id="password-again" name="rpassword" type="password">
          <label for="password-again">Password again</label>
          @error('rpassword')
          <small class="red-text ml-7">
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>

      <div class="row margin">
        <div class="input-field col s3">
          <i class="material-icons prefix pt-2">image</i>
          <label for="image">image</label>
        </div>
        <div class="input-field col s3">
          <input name="image" id="image" type="file" style="margin-top: 13px;">
          @error('image')
          <div>
            <small class="red-text ml-7">
              {{ $message }}
            </small>
          </div>
          @enderror
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <button type="submit"
            class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">
            Register
          </button>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <p class="margin medium-small"><a href="{{ route('admin.login_form') }}">Already have an account? Login</a>
          </p>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{ asset('js/scripts/form-file-uploads.js') }}"></script>
<script src="{{ asset('js/scripts/form-validation.js') }}"></script>
@endsection