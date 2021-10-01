{{-- layout --}}
@extends('layouts.fullLayoutMaster')

{{-- page title --}}
@section('title','User Forgot Password')

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/forgot.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div id="forgot-password" class="row">
  <div class="col s12 m6 l4 z-depth-4 offset-m4 card-panel border-radius-6 forgot-card bg-opacity-8">
    <form class="login-form" action="{{ route('admin.forget.password.post') }}" method="POST">
      @csrf
      <div class="row">

        <div class="input-field col s12">
          <h5 class="ml-4">Forgot Password</h5>
          @if (Session::has('message'))
          <p class="ml-4">{{ Session::get('message') }}</p>
          @else
          <p class="ml-4">You can reset your password</p>
          @endif
        </div>
      </div>
      <div class="row margin">
        <div class="input-field col s12">
          <i class="material-icons prefix pt-2">person_outline</i>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="username"
            value="{{ $username ?? old('username') }}" autocomplete="email" autofocus>
          <label for="email" class="center-align">Email</label>
          @error('username')
          <small class="red-text ml-7" role="alert">
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <button type="submit"
            class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">{{ __('Send
            Password Reset Link') }}
          </button>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 m6 l6">
          <p class="margin medium-small"><a href="{{ route('admin.login_form') }}">Login</a></p>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection