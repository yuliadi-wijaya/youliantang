@extends('layouts.master-without-nav')

@section('title') {{ __("Forgot Password") }} @endsection

@section('body')
<body>
@endsection

@section('content')
    <div class="account-pages my-5 pt-5">
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
                                        <p>Reset your password with {{ AppSetting('title'); }}.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ URL::asset('images/profile-img.png') }}" alt="You Lian tAng"
                                        class="img-fluid">
                                </div>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            {{-- <div>
                                <a href="{{ url('/') }}">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ URL::asset('images/logo.png') }}" alt="You Lian tAng"
                                                class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div> --}}
                            <div class="p-2">
                                <h4>{{ __("Hello,") }} {{ $user->first_name }} {{ $user->last_name }} </h4>
                                <p>
                                    <a href="{{ url('reset-password/' . $user->id . '/' . $token) }}">{{ __("Click here") }}</a> to reset your {{ AppSetting('title'); }} account password.</p>
                                <p> {{ __("If password reset request is not raised by you then immediately change your password to secure your account.") }}</p>
                                <p>{{ __("Thank you,") }}</p>
                                <p>{{ AppSetting('title'); }}.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>© {{ date('Y') }} {{ AppSetting('title'); }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
