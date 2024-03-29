@extends('layouts.master-without-nav')

@section('title') {{ __("Reset Password") }} @endsection

@section('body')
<body>
@endsection

@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="{{ url('login') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
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
                                        <h5 class="text-primary">{{ __("Reset Password") }}</h5>
                                        <p>Re-Password with {{ AppSetting('title'); }}.</p>
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
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="{{ URL::asset('assets/images/logo.png') }}" alt=""
                                            class="rounded-circle" height="34">
                                    </span>
                                </div>
                                </a>
                            </div> --}}
                            <div class="p-2">
                                <form class="form-horizontal mt-4" method="POST" action="{{ url('reset-password') }}">
                                    @csrf
                                    @if ($msg = Session::get('error'))
                                        <div class="alert alert-danger">
                                            <span>{{ $msg }}</span>
                                        </div>
                                    @endif
                                    @if ($msg = Session::get('success'))
                                        <div class="alert alert-success">
                                            <span>{{ $msg }}</span>
                                        </div>
                                    @endif
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group">
                                        <label for="userpassword">{{ __("New Password") }}</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="userpassword" placeholder="{{ __("Enter password") }}">
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
                                    <div class="form-group">
                                        <label for="userpassword">{{ __("Confirm Password") }}</label>
                                        <div class="input-group">
                                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __("Enter confirm password") }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text" onclick="password_confirm_show_hide();">
                                                    <i class="fas fa-eye" id="show_eye_confirm"></i>
                                                    <i class="fas fa-eye-slash d-none" id="hide_eye_confirm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{ __("Reset Password") }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>{{ __("Remember It ?") }} <a href="{{ url('login') }}" class="font-weight-medium text-primary"> {{ __("Sign In here") }}</a></p>
                        <p>© {{ date('Y') }} {{ AppSetting('title'); }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function password_show_hide() {
            var x = document.getElementById("userpassword");
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
        function password_confirm_show_hide() {
            var x = document.getElementById("password-confirm");
            var show_eye = document.getElementById("show_eye_confirm");
            var hide_eye = document.getElementById("hide_eye_confirm");
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
