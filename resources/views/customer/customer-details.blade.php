@extends('layouts.master-layouts')
@section('title')
    @if ($customer )
        {{ __('Update Customer Details') }}
    @else
        {{ __('Add New Customer') }}
    @endif
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
                        @if ($customer && $customer_info)
                            {{ __('Update Customer Details') }}
                        @else
                            {{ __('Add New Customer') }}
                        @endif
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('customer') }}">{{ __('Customers') }}</a></li>
                            <li class="breadcrumb-item active">
                                @if ($customer)
                                    {{ __('Update Customer Details') }}
                                @else
                                    {{ __('Add New Customer') }}
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
                @if ($customer && $customer_info)
                    @if ($role == 'customer')
                        <a href="{{ url('/') }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Dashboard') }}
                            </button>
                        </a>
                    @else
                        <a href="{{ url('customer/' . $customer->id) }}">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Profile') }}
                            </button>
                        </a>
                    @endif
                @else
                    <a href="{{ url('customer') }}">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i
                                class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Customer List') }}
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
                        <form action="@if ($customer ) {{ url('customer/' . $customer->id) }} @else {{ route('customer.store') }} @endif" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($customer )
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <input type="hidden" name="post_from" value="customer" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('First Name ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" id="firstname" tabindex="1"
                                                value="@if ($customer && $customer_info){{ $customer->first_name }}@elseif(old('first_name')){{ old('first_name') }}@endif"
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
                                            <label class="control-label">{{ __('Email ') }}</label>
                                            <input type="email" class="form-control"
                                                name="email" id="email" tabindex="2"
                                                value="@if ($customer && $customer->email){{ $customer->email }}@elseif(old('email')){{ old('email', $cust_mail) }}@else{{ $cust_mail }}@endif"
                                                placeholder="{{ __('Enter Email') }}">
                                            <input type="hidden" name="hidden_mail" value="@if ($customer && $customer->email){{ $customer->email }}@else{{ $cust_mail }}@endif">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Place Of Birth ') }}</label>
                                            <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror"
                                                name="place_of_birth" id="place_of_birth" tabindex="3" value="@if ($customer && $customer_info){{ $customer_info->place_of_birth }}@elseif(old('place_of_birth')){{ old('place_of_birth') }}@endif"
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
                                            <label class="control-label">{{ __('Phone Number ') }}</label>
                                            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" id="phone_number" tabindex="4"
                                                value="@if ($customer && $customer_info){{ $customer->phone_number }}@elseif(old('phone_number')){{ old('phone_number') }}@endif"
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
                                            <label class="control-label">{{ __('Emergency Contact ') }}</label>
                                            <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror"
                                                name="emergency_contact" id="emergency_contact" tabindex="5" value="@if ($customer && $customer_info){{ $customer_info->emergency_contact }}@elseif(old('emergency_contact')){{ old('emergency_contact') }}@endif"
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
                                                name="emergency_name" id="emergency_name" tabindex="6" value="@if ($customer && $customer_info){{ $customer_info->emergency_name }}@elseif(old('emergency_name')){{ old('emergency_name') }}@endif"
                                                placeholder="{{ __('Enter Emergency Name') }}">
                                            @error('emergency_name')
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
                                                tabindex="7" name="status">
                                                <option value="1" @if (($customer && $customer_info->status == '1') || old('status') == '1') selected @endif>{{ __('Active') }}</option>
                                                <option value="0" @if (($customer && $customer_info->status == '0') || old('status') == '0') selected @endif>{{ __('In Active') }}</option>
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
                                                name="last_name" id="lastname" tabindex="8" value="@if ($customer && $customer_info){{ $customer->last_name }}@elseif(old('last_name')){{ old('last_name') }}@endif"
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
                                                name="gender" id="gender" tabindex="9">
                                                <option selected disabled>{{ __('-- Select Gender --') }}</option>
                                                <option value="{{ 'Male' }}" @if (($customer && $customer_info->gender == 'Male') || old('gender') == 'Male') selected @endif>{{ __('Male') }}</option>
                                                <option value="{{ 'Female' }}" @if (($customer && $customer_info->gender == 'Female') || old('gender') == 'Female') selected @endif>{{ __('Female') }}</option>
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
                                            <label class="control-label">{{ __('Birth Date ') }}</label>
                                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                                name="birth_date" id="birth_date" tabindex="10" value="@if ($customer && $customer_info){{ $customer_info->birth_date }}@elseif(old('birth_date')){{ old('birth_date') }}@endif"
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
                                                name="address" tabindex="11" id="address"
                                                placeholder="{{ __('Enter Address') }}">@if ($customer && $customer_info){{ $customer_info->address }}@elseif(old('address')){{ old('address') }}@endif</textarea>
                                            @error('address')
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
                                                src="@if ($customer && $customer->profile_photo != '') {{ URL::asset('storage/images/users/' . $customer->profile_photo) }}  @else {{ URL::asset('assets/images/users/noImage.png') }} @endif" id="profile_display" onclick="triggerClick()"
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
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        @if ($customer && $customer_info)
                                            {{ __('Update Customer Details') }}
                                        @else
                                            {{ __('Add New Customer') }}
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
