@extends('layouts.master-layouts')
@section('title')
    @if ($receptionist && $receptionist_info)
        {{ __('Update Receptionist Details') }}
    @else
        {{ __('Add New Receptionist') }}
    @endif
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
@endsection
@section('css-bottom')
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}">
@endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        @if ($receptionist && $receptionist_info)
                            {{ __('Update Receptionist Details') }}
                        @else
                            {{ __('Add New Receptionist') }}
                        @endif
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('receptionist') }}">{{ __('Receptionists') }}</a></li>
                            <li class="breadcrumb-item active">
                                @if ($receptionist && $receptionist_info)
                                    {{ __('Update Receptionist Details') }}
                                @else
                                    {{ __('Add New Receptionist') }}
                                @endif
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="{{ url('receptionist') }} ">
                    <button type="button" class="btn btn-secondary waves-effect waves-light mb-4">
                        <i
                            class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Receptionist List') }}
                    </button>
                </a>
            </div>
        </div>
        <form id="addtime" action="@if ($receptionist && $receptionist_info) {{ url('receptionist/' . $receptionist->id) }} @else {{ route('receptionist.store') }} @endif" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <blockquote>{{ __('Basic Information') }}</blockquote>
                            @csrf
                            @if ($receptionist && $receptionist_info)
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('First Name ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" id="firstname" tabindex="1"
                                                value="@if ($receptionist && $receptionist_info){{ $receptionist->first_name }}@elseif(old('first_name')){{ old('first_name') }}@endif"
                                                placeholder="{{ __('Enter First Name') }}">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('KTP ') }}<span
                                                class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('ktp') is-invalid @enderror"
                                                name="ktp" id="lastname" tabindex="2" value="@if ($receptionist && $receptionist_info){{ $receptionist_info->ktp }}@elseif(old('ktp')){{ old('ktp') }}@endif"
                                                placeholder="{{ __('Enter ID Card') }}">
                                            @error('ktp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Gender ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('gender') is-invalid @enderror"
                                                name="gender" id="gender">
                                                <option selected disabled>{{ __('-- Select Gender --') }}</option>
                                                <option value="{{ 'Male' }}" {{ ($receptionist && $receptionist_info->gender == 'Male') || old('gender') == 'Male' ? 'selected' : '' }}>{{ 'Male' }}</option>
                                                <option value="{{ 'Female' }}" {{ ($receptionist && $receptionist_info->gender == 'Female') || old('gender') == 'Female' ? 'selected' : '' }}>{{ 'Female' }}</option>
                                            </select>
                                            @error('gender')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Place Of Birth ') }}</label>
                                            <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror"
                                                name="place_of_birth" id="place_of_birth" tabindex="4" value="@if ($receptionist && $receptionist_info){{ $receptionist_info->place_of_birth }}@elseif(old('place_of_birth')){{ old('place_of_birth') }}@endif"
                                                placeholder="{{ __('Enter Place Of Birth') }}">
                                            @error('place_of_birth')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Birth Date ') }}</label>
                                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                                name="birth_date" id="birth_date" tabindex="10" value="@if ($receptionist && $receptionist_info){{ $receptionist_info->birth_date }}@elseif(old('birth_date')){{ old('birth_date') }}@endif"
                                                placeholder="{{ __('Enter Birth Date') }}">
                                            @error('birth_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Address ') }}</label>
                                            <textarea rows="3"
                                                class="form-control @error('address') is-invalid @enderror"
                                                name="address" tabindex="5" id="address"
                                                placeholder="{{ __('Enter Address') }}">@if ($receptionist && $receptionist_info){{ $receptionist_info->address }}@elseif(old('address')){{ old('address') }}@endif</textarea>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Status ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('status') is-invalid @enderror"
                                                tabindex="13" name="status">
                                                <option selected disabled>{{ __('-- Select Status --') }}</option>
                                                <option value="1" @if (($receptionist && $receptionist_info->status == '1') || old('status') == '1') selected @endif>{{ __('Active') }}</option>
                                                <option value="0" @if (($receptionist && $receptionist_info->status == '0') || old('status') == '0') selected @endif>{{ __('In Active') }}</option>
                                            </select>
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Last Name ') }}</label>
                                            <input type="text"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" id="lastname" tabindex="8" value="@if ($receptionist && $receptionist_info){{ $receptionist->last_name }}@elseif(old('last_name')){{ old('last_name') }}@endif"
                                                placeholder="{{ __('Enter Last Name') }}">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Email ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" id="email" tabindex="3" value="@if ($receptionist && $receptionist_info){{ $receptionist->email }}@elseif(old('email')){{ old('email') }}@endif"
                                                placeholder="{{ __('Enter Email @youliantang.com') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Phone Number ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" id="phone_number" tabindex="9"
                                                value="@if ($receptionist && $receptionist_info){{ $receptionist->phone_number }}@elseif(old('phone_number')){{ old('phone_number') }}@endif"
                                                placeholder="{{ __('Enter Phone Number') }}">
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Rekening Number ') }}</label>
                                            <input type="number" class="form-control @error('rekening_number') is-invalid @enderror"
                                                name="rekening_number" id="rekening_number" tabindex="11" value="@if ($receptionist && $receptionist_info){{ $receptionist_info->rekening_number }}@elseif(old('rekening_number')){{ old('rekening_number') }}@endif"
                                                placeholder="{{ __('Enter Rekening Number') }}">
                                            @error('rekening_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Profile Photo ') }}</label>
                                            <img class="@error('profile_photo') is-invalid @enderror"
                                                src="@if ($receptionist && $receptionist->profile_photo != '') {{ URL::asset('storage/images/users/' . $receptionist->profile_photo) }}  @else {{ URL::asset('assets/images/users/noImage.png') }} @endif" id="profile_display" onclick="triggerClick()"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Click to Upload Profile Photo" />
                                            <input type="file"
                                                class="form-control @error('profile_photo') is-invalid @enderror"
                                                tabindex="12" name="profile_photo" id="profile_photo" style="display:none;"
                                                onchange="displayProfile(this)">
                                            @error('profile_photo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <blockquote>{{ __('Emergency Information') }}</blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Emergency Name ') }}</label>
                                            <input type="text" class="form-control @error('emergency_name') is-invalid @enderror"
                                                name="emergency_name" id="emergency_name" tabindex="7" value="@if ($receptionist && $receptionist_info){{ $receptionist_info->emergency_name }}@elseif(old('emergency_name')){{ old('emergency_name') }}@endif"
                                                placeholder="{{ __('Enter Emergency Name') }}">
                                            @error('emergency_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Emergency Contact ') }}</label>
                                            <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror"
                                                name="emergency_contact" id="emergency_contact" tabindex="6" value="@if ($receptionist && $receptionist_info){{ $receptionist_info->emergency_contact }}@elseif(old('emergency_contact')){{ old('emergency_contact') }}@endif"
                                                placeholder="{{ __('Enter Emergency Contact') }}">
                                            @error('emergency_contact')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <button type="submit" class="btn btn-primary">
                        @if ($receptionist && $receptionist_info)
                            {{ __('Update Details') }}
                        @else
                            {{ __('Add New Receptionist') }}
                        @endif
                    </button>
                </div>
            </div>
        </form>
        <!-- end row -->
    @endsection
    @section('script')
        <script src="{{ URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
        <!-- form init -->
        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <script>
            $('#addtime').submit(function(e) {
                if (error != 0) {
                    e.preventDefault();
                }
            });
            // Profile photo
            function triggerClick() {
                document.querySelector('#profile_photo').click();
            }

            function displayProfile(e) {
                if (e.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector('#profile_display').setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(e.files[0]);
                }
            }
        </script>
    @endsection
