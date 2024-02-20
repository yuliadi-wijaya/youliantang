@extends('layouts.master-layouts')
@section('title') {{ __('Review') }} @endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
@endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Review @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Invoice @endslot
            @slot('li_3') Review @endslot
        @endcomponent
        <!-- end page title -->
        <form action="{{ route('review.store') }}" method="post">
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="font-weight-bold">#{{ $invoice->invoice_code }}</h3>
                            <label style="font-size: 10pt">{{ date("d M Y", strtotime($invoice->treatment_date)) }}</label>
                            <hr>
                            <div class="row mb-1">
                                <div class="col-sm-12 font-weight-bold" style="font-size: 14pt">{{ ucwords($invoice->customer_name) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="font-size: 11pt">{{ $invoice->phone_number }} </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ url('invoice') }}">
                                        <button type="button" class="btn btn-secondary waves-effect waves-light col-sm-12">
                                            <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to List') }}
                                        </button>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light col-sm-12">
                                        {{ __('Submit Review') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        @php
                        $record = 0;
                        @endphp

                        @foreach($invoice_details as $index => $row)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    @csrf
                                    <input type="hidden" name="old_data" value="{{ $invoice->old_data }}" />
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />
                                    <input type="hidden" name="customer_id" value="{{ $invoice->customer_id }}">
                                    <input type="hidden" name="customer_name" value="{{ $invoice->customer_name }}">
                                    <input type="hidden" name="phone_number" value="{{ $invoice->phone_number }}">
            
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <div class="col-md-12 form-group">
                                                        <div class="col-sm-12 d-flex justify-content-center">
                                                            <div class="avatar-md profile-user-wid mt-2 mb-3">
                                                                <img src="@if ($row->therapist_profile_photo != ''){{ URL::asset('storage/images/users/' . $row->therapist_profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }}@endif" alt="" class="img-thumbnail rounded-circle">
                                                            </div>
                                                        </div>
                                                        <label class="control-label col-sm-12"><h4>{{ old('therapist_name.' . $index, $row->therapist_name) }}</h4></label>
                                                        <label class="control-label col-sm-12 font-weight-bold">{{ old('product_name.' . $index, $row->product_name) }}</label>
                                                        <label class="control-label font-weight-normal col-sm-12">{{ old('room.' . $index, $row->room) }}</label>
                                                        <label class="control-label font-weight-normal col-sm-12">{{ old('treatment_time.' . $index, $row->treatment_time_from . " - " . $row->treatment_time_to) }}</label>
        
                                                        
                                                        <input type="hidden" class="form-control" value="{{ old('product_name.' . $index, $row->product_name) }}">
                                                        <input type="hidden" class="form-control" value="{{ old('therapist_name.' . $index, $row->therapist_name) }}">
                                                        <input type="hidden" name="therapist_id[{{ $index }}]" value="{{ old('therapist_id.' . $index, $row->therapist_id) }}">
                                                        <input type="hidden" name="invoice_detail_id[{{ $index }}]" value="{{ old('invoice_detail_id.' . $index, $row->id) }}">
                                                        <hr>
                                                        {{-- <label class="control-label">{{ __('Rating ') }}<span class="text-danger">*</span></label> --}}
                                                        <div class="star-rating mt-4" id="star-rating">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <span class="star-{{ $index }}" data-rating="{{ $i }}"><i class="fas fa-star" style="font-size: 20px;"></i></span>
                                                            @endfor
                                                        </div>
                                                        <input type="hidden" class="@error('rating.' . $index) is-invalid @enderror" name="rating[{{ $index }}]" id="rating-{{ $index }}" value="{{ old('rating.' . $index, $row->rating) }}">
                                                        @error('rating.' . $index )
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12 form-group mt-4">
                                                        <textarea class="form-control" placeholder="Enter Comment" name="comment[{{ $index }}]" rows="3">{{ old('comment.' . $index, $row->comment) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php 
                            $record++;
                        @endphp
                        @endforeach
                        <input type="hidden" id="record_review" value="{{ $record }}">
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
        <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/star-rating.js') }}"></script>
    @endsection
