@extends('layouts.master-layouts')
@section('title')
    {{ __('Update Therapist Details') }}
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
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
                        {{ __('Update Therapist Details') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('therapist') }}">{{ __('Therapists') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Update Therapist Details') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                @if ($therapist && $therapist_info)
                    @if ($role == 'therapist')
                        <a href="{{ url('/') }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Dashboard') }}
                            </button>
                        </a>
                    @else
                        <a href="{{ url('therapist/' . $therapist->id) }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Profile') }}
                            </button>
                        </a>
                    @endif
                @else
                    <a href="{{ url('therapist') }}">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i
                                class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Therapist List') }}
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Basic Information') }}</blockquote>

                        <form action="{{ url('therapist/' . $therapist->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($therapist && $therapist_info)
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
                                                value="{{ old('first_name', $therapist->first_name) }}"
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
                                            <label class="control-label">{{ __('ID Card ') }}<span
                                                class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('ktp') is-invalid @enderror"
                                                name="ktp" id="lastname" tabindex="2"
                                                value="{{ old('ktp', $therapist_info->ktp) }}"
                                                placeholder="{{ __('Enter ID Card') }}">
                                            @error('ktp')
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
                                                name="email" id="email" tabindex="3"
                                                value="{{ old('email', $therapist->email) }}"
                                                placeholder="{{ __('Enter Email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Place Of Birth ') }}</label>
                                            <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror"
                                                name="place_of_birth" id="place_of_birth" tabindex="4"
                                                value="{{ old('place_of_birth', $therapist_info->place_of_birth) }}"
                                                placeholder="{{ __('Enter Place Of Birth') }}">
                                            @error('place_of_birth')
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
                                                placeholder="{{ __('Enter Address') }}">{{ old('address', $therapist_info->address) }}</textarea>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Emergency Contact ') }}</label>
                                            <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror"
                                                name="emergency_contact" id="emergency_contact" tabindex="6"
                                                value="{{ old('emergency_contact', $therapist_info->emergency_contact) }}"
                                                placeholder="{{ __('Enter Emergency Contact') }}">
                                            @error('emergency_contact')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Emergency Name ') }}</label>
                                            <input type="text" class="form-control @error('emergency_name') is-invalid @enderror"
                                                name="emergency_name" id="emergency_name" tabindex="7"
                                                value="{{ old('emergency_name', $therapist_info->emergency_name) }}"
                                                placeholder="{{ __('Enter Emergency Name') }}">
                                            @error('emergency_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if ($availableDay)
                                            <div class="col-md-12 form-group">
                                                <label class="control-label d-block">{{ __("Therapist available days") }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                        value="1" name="sun" {{ $availableDay->sun == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox1">Sun</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                        value="1" name="mon" {{ $availableDay->mon == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox2">Mon</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                        value="1" name="tue" {{ $availableDay->tue == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox3">Tue</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4"
                                                        value="1" name="wen" {{ $availableDay->wen == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox4">Wen</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5"
                                                        value="1" name="thu" {{ $availableDay->thu == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox5">Thu</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox6"
                                                        value="1" name="fri" {{ $availableDay->fri == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox6">Fri</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox7"
                                                        value="1" name="sat" {{ $availableDay->sat == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="inlineCheckbox7">Sat</label>
                                                </div>
                                                @error('mon')
                                                    <span class="error d-block " role="alert">
                                                        <strong>Select any one days</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Last Name ') }}</label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" id="lastname" tabindex="8"
                                                value="{{ old('last_name', $therapist->last_name) }}"
                                                placeholder="{{ __('Enter Last Name') }}">
                                            @error('last_name')
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
                                                <option value="" disabled selected>-</option>
                                                <option value="{{ 'Male' }}" {{ old('gender', $therapist_info->gender) == 'Male' ? 'selected' : '' }}>{{ 'Male' }}</option>
                                                <option value="{{ 'Female' }}" {{ old('gender', $therapist_info->gender) == 'Female' ? 'selected' : '' }}>{{ 'Female' }}</option>
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
                                            <label class="control-label">{{ __('Phone Number ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" id="phone_number" tabindex="9"
                                                value="{{ old('phone_number', $therapist->phone_number) }}"
                                                placeholder="{{ __('Enter Phone Number') }}">
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Birth Date ') }}</label>
                                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                                name="birth_date" id="birth_date" tabindex="10"
                                                value="{{ old('birth_date', $therapist_info->birth_date) }}"
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
                                            <label class="control-label">{{ __('Rekening Number ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('rekening_number') is-invalid @enderror"
                                                name="rekening_number" id="rekening_number" tabindex="11"
                                                value="{{ old('rekening_number', $therapist_info->rekening_number) }}"
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
                                                src=" @if ($therapist && $therapist_info &&
                                                $therapist->profile_photo != null)
                                            {{ URL::asset('storage/images/users/' . $therapist->profile_photo) }}
                                        @else {{ URL::asset('assets/images/users/noImage.png') }} @endif"
                                            id="profile_display" onclick="triggerClick()"
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
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Status ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                tabindex="13" name="status">
                                                <option selected disabled>{{ __('-- Select Status --') }}</option>
                                                <option value="1" @if (($therapist_info->status == '1') || old('status') == '1') selected @endif>{{ __('Active') }}</option>
                                                <option value="0" @if (($therapist_info->status == '0') || old('status') == '0') selected @endif>{{ __('In Active') }}</option>
                                            </select>
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        @if ($therapist && $therapist_info)
                                            {{ __('Update Details') }}
                                        @else
                                            {{ __('Add New Therapist') }}
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <script src="{{ URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
        <!-- form init -->
        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
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
            // Time validation
            var timecount = $('.timecount').length;
            let cf = 0;
            let error = 0;

            function valinput0() {
                var startTime = $('input[name="TimeSlot[0][from]"]').val();
                var endTime = $('input[name="TimeSlot[0][to]"]').val();
                var st = startTime.split(":");
                var et = endTime.split(":");
                var sst = new Date();
                sst.setHours(st[0]);
                sst.setMinutes(st[1]);
                var eet = new Date();
                eet.setHours(et[0]);
                eet.setMinutes(et[1]);
                if (sst > eet) {
                    error = 1;
                    $('.para').html('to value is bigger then from');
                    $('.para').addClass('d-block');
                } else {
                    error = 0;
                    $('.para').removeClass('d-block');
                }
            }

            function change() {
                cf++;
                setTimeout(function() {
                    $(document).on('change', `input[name="TimeSlot[${cf}][to]"]`, function() {
                        validate1();
                    });
                }, 100);
            }

            function validate1() {
                timecount = $('.timecount').length;
                for (let i = 0; i < timecount; i++) {
                    var startTime = $('input[name="TimeSlot[' + i + '][from]"]').val();
                    var endTime = $('input[name="TimeSlot[' + i + '][to]"]').val();
                    currenttime = $(`input[name="TimeSlot[${cf}][from]"]`).val();
                    currentto = $(`input[name="TimeSlot[${cf}][to]"]`).val();
                    var st = startTime.split(":");
                    var et = endTime.split(":");
                    var ct = currenttime.split(":");
                    var cft = currentto.split(":");
                    var sst = new Date();
                    sst.setHours(st[0]);
                    sst.setMinutes(st[1]);
                    var eet = new Date();
                    eet.setHours(et[0]);
                    eet.setMinutes(et[1]);
                    var cct = new Date();
                    cct.setHours(ct[0]);
                    cct.setMinutes(ct[1]);
                    var cff = new Date();
                    cff.setHours(cft[0]);
                    cff.setMinutes(cft[1]);
                    if (cct < cff) {
                        if (sst < cct && eet > cct) {
                            error = 1;
                            $('.para').html('Value not accepted');
                            $('.para').addClass('d-block');
                            break
                        } else {
                            error = 0;
                            $('.para').removeClass('d-block');
                        }
                    } else {
                        $('.para').html('to value is bigger then from');
                        $('.para').addClass('d-block');
                        break
                    }
                }
            }
            // Checkbox value check
            $('#inlineCheckbox1').on('change', function() {
                var inlineCheckbox1 = $('#inlineCheckbox1').is(':checked') ? '1' : '0';
                $('#inlineCheckbox1').val(inlineCheckbox1);
            }).change();
            $('#inlineCheckbox2').on('change', function() {
                var inlineCheckbox2 = $('#inlineCheckbox2').is(':checked') ? '1' : '0';
                $('#inlineCheckbox2').val(inlineCheckbox2);
            }).change();
            $('#inlineCheckbox3').on('change', function() {
                var inlineCheckbox3 = $('#inlineCheckbox3').is(':checked') ? '1' : '0';
                $('#inlineCheckbox3').val(inlineCheckbox3);
            }).change();
            $('#inlineCheckbox4').on('change', function() {
                var inlineCheckbox4 = $('#inlineCheckbox4').is(':checked') ? '1' : '0';
                $('#inlineCheckbox4').val(inlineCheckbox4);
            }).change();
            $('#inlineCheckbox5').on('change', function() {
                var inlineCheckbox5 = $('#inlineCheckbox5').is(':checked') ? '1' : '0';
                $('#inlineCheckbox5').val(inlineCheckbox5);
            }).change();
            $('#inlineCheckbox6').on('change', function() {
                var inlineCheckbox6 = $('#inlineCheckbox6').is(':checked') ? '1' : '0';
                $('#inlineCheckbox6').val(inlineCheckbox6);
            }).change();
            $('#inlineCheckbox7').on('change', function() {
                var inlineCheckbox7 = $('#inlineCheckbox7').is(':checked') ? '1' : '0';
                $('#inlineCheckbox7').val(inlineCheckbox7);
            }).change();
        </script>
    @endsection
