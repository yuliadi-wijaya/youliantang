@extends('layouts.master-without-nav')
@section('title') {{ __('Complete Profile') }} @endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="card overflow-hidden">
                            <div class="bg-soft-primary">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">{{ __('Registration') }}</h5>
                                            <p>Complete your {{ AppSetting('title') }} account first.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form method="POST" class="form-horizontal mt-4" action="{{ url('user') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <blockquote>{{ __('Basic Information') }}</blockquote>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label class="control-label">{{ __('Gender ') }}<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control select2 @error('gender') is-invalid @enderror"
                                                        name="gender" id="gender" tabindex="9">
                                                        <option selected disabled>{{ __('-- Select Gender --') }}</option>
                                                        <option value="{{ 'Male' }}" @if (old('gender') == 'Male') selected @endif>{{ __('Male') }}</option>
                                                        <option value="{{ 'Female' }}" @if (old('gender') == 'Female') selected @endif>{{ __('Female') }}</option>
                                                    </select>
                                                    @error('gender')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Place Of Birth ') }}</label>
                                                    <input type="text" class="form-control"
                                                        name="place_of_birth" id="place_of_birth" tabindex="3" value="{{ old('place_of_birth') }}"
                                                        placeholder="{{ __('Enter Place Of Birth') }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Birth Date ') }}</label>
                                                    <input type="date" class="form-control"
                                                        name="birth_date" id="birth_date" tabindex="10" value="{{ old('birth_date') }}"
                                                        placeholder="{{ __('Enter Birth Date') }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Emergency Name ') }}</label>
                                                    <input type="text" class="form-control"
                                                        name="emergency_name" id="emergency_name" tabindex="6" value="{{ old('emergency_name') }}"
                                                        placeholder="{{ __('Enter Emergency Name') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Address ') }}</label>
                                                    <textarea id="formmessage" name="address"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        value="{{ old('address') }}" rows="3"
                                                        placeholder="{{ __('Enter Address') }}"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Profile Photo ') }}</label>
                                                    <img class="@error('profile_photo') is-invalid @enderror"
                                                        src="{{ URL::asset('assets/images/users/noImage.png') }}"
                                                        id="profile_display" onclick="triggerClick()" data-toggle="tooltip"
                                                        data-placement="top" title="Click to Upload Profile Photo" />
                                                    <input type="file"
                                                        class="form-control @error('profile_photo') is-invalid @enderror"
                                                        name="profile_photo" id="profile_photo" style="display:none;"
                                                        onchange="displayProfile(this)">
                                                    @error('profile_photo')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label class="control-label">{{ __('Emergency Contact ') }}</label>
                                                    <input type="text" class="form-control"
                                                        name="emergency_contact" id="emergency_contact" tabindex="5" value="{{ old('emergency_contact') }}"
                                                        placeholder="{{ __('Enter Emergency Contact') }}">
                                                    <input type="hidden" name="status" value="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit"
                                                class="btn btn-primary form-control">{{ __('Save Profile') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script>
            // Profile Photo
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
