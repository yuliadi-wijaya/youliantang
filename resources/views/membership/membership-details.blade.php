@extends('layouts.master-layouts')
@section('title')
    @if ($membership)
        {{ __('Update Membership Details') }}
    @else
        {{ __('Add New Membership') }}
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
                        @if ($membership)
                            {{ __('Update Membership Details') }}
                        @else
                            {{ __('Add New Membership') }}
                        @endif
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('membership') }}">{{ __('Memberships') }}</a></li>
                            <li class="breadcrumb-item active">
                                @if ($membership)
                                    {{ __('Update Membership Details') }}
                                @else
                                    {{ __('Add New Membership') }}
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
                <a href="{{ url('membership') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Membership List') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Basic Information') }}</blockquote>
                        <form action="@if ($membership ) {{ url('membership/' . $membership->id) }} @else {{ route('membership.store') }} @endif" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($membership )
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Membership Name ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="name" id="Name" tabindex="1"
                                                value="@if ($membership){{ old('name', $membership->name) }}@elseif(old('name')){{ old('name') }}@endif"
                                                placeholder="{{ __('Enter Membership Name') }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Total Active Period (days)') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('total_active_period') is-invalid @enderror"
                                                name="total_active_period" id="TotalActivePeriod" tabindex="1"
                                                value="@if ($membership){{ old('total_active_period', $membership->total_active_period) }}@elseif(old('total_active_period')){{ old('total_active_period') }}@endif"
                                                placeholder="{{ __('Enter Total Active Period of Membership In Days') }}">
                                            @error('total_active_period')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Status ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                tabindex="11" name="status">
                                                <option selected disabled>{{ __('-- Select Status --') }}</option>
                                                <option value="1" @if (($membership && $membership->status == '1') || old('status') == '1') selected @endif>{{ __('Active') }}</option>
                                                <option value="0" @if (($membership && $membership->status == '0') || old('status') == '0') selected @endif>{{ __('In Active') }}</option>
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
                                            <label class="control-label">{{ __('Discount Type ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('discount_type') is-invalid @enderror"
                                                tabindex="11" name="discount_type">
                                                <option selected disabled>{{ __('-- Select Discount Type --') }}</option>
                                                <option value="0" @if (($membership && $membership->discount_type == '0') || old('discount_type') == '0') selected @endif>{{ __('Fix Rate (Rp)') }}</option>
                                                <option value="1" @if (($membership && $membership->discount_type == '1') || old('discount_type') == '1') selected @endif>{{ __('Percentage (%)') }}</option>
                                            </select>
                                            @error('discount_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Total Discount ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('discount_value') is-invalid @enderror"
                                                tabindex="4" name="discount_value" id="DiscountValue" value="@if ($membership ){{ old('discount_value', $membership->discount_value) }}@elseif(old('discount_value')){{ old('discount_value') }}@endif"
                                                placeholder="{{ __('Enter Total Discount Based On Discount Type') }}">
                                            @error('discount_value')
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
                                        @if ($membership)
                                            {{ __('Update Membership Details') }}
                                        @else
                                            {{ __('Add New Membership') }}
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
            // Script
        </script>
    @endsection
