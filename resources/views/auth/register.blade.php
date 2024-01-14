@extends('layouts.master-without-nav')

@section('title') {{ __("Register") }} @endsection

@section('body')
<body>
@endsection

@section('content')
    <div class="account-pages mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="col-12" style="height: 250px">
                        <img src="{{ URL::asset('assets/images/companies/ylt-black.png') }}" alt=""
                                        class="img-fluid">
                    </div>
                    <div class="card overflow-hidden">
                        {{-- <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">{{ __("Customer Register") }}</h5>
                                        <p>Get your free {{ AppSetting('title'); }} Customer account now.</p>
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
                                <form method="POST" class="form-horizontal mt-4" action="{{ url('register') }}">
                                    @csrf
                                    @if ($msg = Session::get('error'))
                                        <div class="alert alert-danger">
                                            <span> {{ $msg }} </span>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="first_name">{{ __("First Name ") }}<span
                                            class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name') }}" name="first_name" id="userfirstname"
                                            placeholder="{{ __("Enter First Name") }}">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">{{ __("Last Name ") }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('last_name') }}" name="last_name" id="userlastname"
                                            placeholder="{{ __("Enter Last Name") }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="userphone_number">{{ __("Phone Number ") }}</label>
                                        <input type="tel" class="form-control"
                                            value="{{ old('phone_number') }}" name="phone_number" id="userphone_number"
                                            placeholder="{{ __("Enter Phone Number") }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="useremail">{{ __("Email ") }}<span
                                            class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" id="useremail" name="email"
                                            placeholder="{{ __("Enter email") }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="userpassword">{{ __("Password ") }}<span
                                            class="text-danger">*</span></label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            value="{{ old('password') }}" name="password" id="userpassword"
                                            placeholder="{{ __("Enter password") }}">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="userpassword">{{ __("Confirm Password ") }} <span
                                            class="text-danger">*</span></label>
                                        <input id="password-confirm" type="password" name="password_confirmation"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="{{ __("Enter confirm password ") }}">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mt-4">
                                        <button class="btn btn-primary btn-block waves-effect waves-light"
                                            type="submit">{{ __("Register") }}</button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">By registering you agree to the {{ AppSetting('title'); }} <a href="#" class="text-primary">{{ __("Terms of Use") }}</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>{{ __("Already have an account ?") }} <a href="{{ url('login') }}"
                                class="font-weight-medium text-primary">{{ __("Login") }} </a> </p>
                        <p>© {{ date('Y') }} {{ AppSetting('title'); }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
