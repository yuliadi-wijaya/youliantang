@extends('layouts.master-layouts')
@section('title')
    @if ($customermember)
        {{ __('Update Member Details') }}
    @else
        {{ __('Add New Member') }}
    @endif
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
    <style>
        input[readonly]{
            background-color:#e9ecef !important;
            opacity: 1;
        }
    </style>
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
                        @if ($customermember)
                            {{ __('Update Member Details') }}
                        @else
                            {{ __('Add New Member') }}
                        @endif
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('customermember') }}">{{ __('Membership') }}</a></li>
                            <li class="breadcrumb-item active">
                                @if ($customermember)
                                    {{ __('Update Member Details') }}
                                @else
                                    {{ __('Add New Member') }}
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
                <a href="{{ url('customermember') }}">
                    <button type="button" class="btn btn-secondary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Member List') }}
                    </button>
                </a>
            </div>
        </div>
        <form action="@if ($customermember ) {{ url('customermember/' . $customermember->id) }} @else {{ route('customermember.store') }} @endif" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @csrf
                            @if ($customermember )
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Customer ') }}<span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('customer_id') is-invalid @enderror"
                                                name="customer_id" tabindex="1">
                                                <option selected disabled>{{ __('-- Select Customer --') }}</option>
                                                @foreach($customers as $row)
                                                    <option value="{{ $row->id }}" {{ $customermember && $customermember->customer_id == $row->id || old('customer_id') == $row->id ? 'selected' : '' }}>{{ ucwords($row->first_name).' '.ucwords($row->last_name.' - '.$row->phone_number) }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Membership Plan ') }}<span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('membership_id') is-invalid @enderror"
                                                name="membership_id" tabindex="3" onchange="getPlan(this)">
                                                <option selected disabled>{{ __('-- Select Membership Plan --') }}</option>
                                                @foreach($memberships as $row)
                                                    <option value="{{ $row->id }}"
                                                        data-period="{{$row->total_active_period}}"
                                                        {{ ($customermember && $customermember->membership_id == $row->id) || old('membership_id') == $row->id ? 'selected' : '' }}>
                                                        {{ $row->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('membership_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Expired Date ') }}<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="date" class="form-control @error('expired_date') is-invalid @enderror"
                                                    name="expired_date" id="expired_date" tabindex="2"
                                                    value="{{ $customermember && $customermember->expired_date ? $customermember->expired_date : old('expired_date', now()->format('Y-m-d')) }}"
                                                    placeholder="{{ __('Enter Expired Date') }}" readonly>
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                            @error('expired_date')
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
                                                tabindex="4" name="status">
                                                <option selected disabled>{{ __('-- Select Status --') }}</option>
                                                <option value="1" {{ ($customermember && $customermember->status == '1') || old('status') == '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                <option value="0" {{ ($customermember && $customermember->status == '0') || old('status') == '0' ? 'selected' : '' }}>{{ __('In Active') }}</option>
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
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                @if ($customermember)
                                    {{ __('Update Member Details') }}
                                @else
                                    {{ __('Add New Member') }}
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- end row -->
    @endsection
    @section('script')
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <!-- form mask -->
        <script src="{{ URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js') }}"></script>
        <!-- form init -->
        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <script>
            function getPlan(obj) {
                var selectedOption = obj.options[obj.selectedIndex];
                var period = parseFloat(selectedOption.dataset.period);

                const currentDate = new Date();

                currentDate.setDate(currentDate.getDate() + period);
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                const day = String(currentDate.getDate()).padStart(2, '0');
                const formattedDate = `${year}-${month}-${day}`;

                document.getElementById('expired_date').value = formattedDate;
            }
        </script>
    @endsection
