@extends('layouts.master-without-nav')

@section('title') {{ __("Reset Password") }} @endsection

@section('body')
<body>
@endsection

@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="{{ url('/') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
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
                                        <h5 class="text-primary">{{ __("Reset Password") }}</h5>
                                        <p>Re-Password with {{ AppSetting('title'); }}.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            {{-- <div>
                                <a href="{{ url('/') }}">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ URL::asset('assets/images/logo.png') }}" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div> --}}
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">{{ __("Username") }}</label>
                                        <input name="email" type="email"  class="form-control @error('email') is-invalid @enderror"
                                            @if (old('email')) value="{{ old('email') }}" @endif id="username" placeholder="{{ __("Enter username") }}"
                                            autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-primary w-md waves-effect waves-light"
                                                type="submit">{{ __("Reset") }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>{{ __("Remember It?") }} <a href="{{ url('login') }}" class="font-weight-medium text-primary"> {{ __("Sign In here") }}</a></p>
                        <p>© {{ date('Y') }} {{ AppSetting('title'); }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
