@extends('layouts.master-without-nav')
@section('title') {{ __("Login") }} @endsection
@section('body')
<body>
@endsection
@section('content')
    <div class="account-pages mb-5">
        <div class="container">
            <div class="row justify-content-center">
                {{-- <div class="col-md-8 col-lg-6 col-xl-5">
                    <img src="{{ URL::asset('assets/images/companies/ylt-black.png') }}" alt=""
                                        class="img-fluid">
                </div> --}}
                <div class="col-md-8 col-lg-6 col-xl-5 mt-5">
                    <div class="col-12" style="margin-bottom: -25px">
                        <div class="row justify-content-center">
                            <img src="{{ URL::asset('assets/images/companies/ylt-black.png') }}" width="325" alt=""
                            class="img-fluid">
                        </div>
                    </div>
                    
                    <div class="card overflow-hidden">
                        {{-- <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">{{ __("Welcome Back !") }}</h5>
                                        <p>Sign in to continue to {{ AppSetting('title') }}.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            {{-- <div>
                                <a href="{{ url('/') }}">
                                    <div class="avatar-md profile-user-wid mb-3">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ URL::asset('assets/images/logo.png') }}" alt=""
                                                class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div> --}}
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="{{ url('login') }}">
                                    @csrf
                                    @if ($msg = Session::get('error'))
                                        <div class="alert alert-danger">
                                            <span> {{ $msg }} </span>
                                        </div>
                                    @endif
                                    @if ($msg = Session::get('success'))
                                        <div class="alert alert-success">
                                            <span> {{ $msg }} </span>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="username">{{ __("Username") }}</label>
                                        <input name="email" type="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            @if (old('email')) value="{{ old('email') }}" @else value="" @endif id="username" placeholder="Enter username"
                                            autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="userpassword">{{ __("Password") }}</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="pass"
                                                class="form-control  @error('password') is-invalid @enderror"
                                                id="userpassword" @if (old('password')) value="{{ old('password') }}" @else value="" @endif placeholder="Enter password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="password_show_hide();">
                                                  <i class="fas fa-eye" id="show_eye"></i>
                                                  <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="remember"
                                            id="customControlInline">
                                        <label class="custom-control-label" for="customControlInline">{{ __("Remember me") }}</label>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light"
                                            type="submit">{{ __("Log In") }}</button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <a href="{{ url('forgot-password') }}" class="text-muted"><i
                                                class="mdi mdi-lock mr-1"></i> {{ __("Forgot your password?") }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>{{ __("Don't have an account ?") }} <a href="{{ url('register') }}"
                                class="font-weight-medium text-primary"> {{ __("Sign Up here") }}</a> </p>
                        <p>© {{ date('Y') }} {{ AppSetting('title'); }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function password_show_hide() {
            var x = document.getElementById("pass");
            var show_eye = document.getElementById("show_eye");
            var hide_eye = document.getElementById("hide_eye");
            hide_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                show_eye.style.display = "none";
                hide_eye.style.display = "block";
            } else {
                x.type = "password";
                show_eye.style.display = "block";
                hide_eye.style.display = "none";
            }
        }
    </script>
@endsection
