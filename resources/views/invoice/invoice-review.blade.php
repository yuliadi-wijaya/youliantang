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
        <div class="row">
            <div class="col-12">
                <a href="{{ url('invoice') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Invoice List') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('review.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="old_data" value="{{ $invoice->old_data }}" />
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />

                            <div class="row">
                                <div class="col-md-12">
                                    <blockquote>{{ __('Review Header') }}</blockquote>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Customer Name ') }}</label>
                                            @if ($invoice->old_data == 'Y')
                                                <input type="text" class="form-control" name="customer_name" value="{{ $invoice->customer_name }}" readonly>
                                            @elseif ($invoice->old_data == 'N')
                                                <input type="hidden" class="form-control" name="customer_id" value="{{ $invoice->customer_id }}" readonly>
                                                <input type="text" class="form-control" name="customer_name" value="{{ $invoice->customer_name }}" readonly>
                                            @endif
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Phone Number ') }}</label>
                                            @if ($invoice->old_data == 'Y')
                                                <input type="text" class="form-control" name="phone_number" value="" placeholder="Phone Number">
                                            @elseif ($invoice->old_data == 'N')
                                                <input type="text" class="form-control" name="phone_number" value="{{ $invoice->phone_number }}" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <br />
                                    <blockquote>{{ __('Review Details') }}</blockquote>
                                    @php
                                        $record = 0;
                                    @endphp

                                    @foreach($invoice_details as $index => $row)
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">{{ __('Treatment ') }}</label>
                                                <input type="text" class="form-control" value="{{ old('product_name.' . $index, $row->product_name) }}" readonly>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label class="control-label">{{ __('Therapist ') }}</label>
                                                <input type="text" class="form-control" value="{{ old('therapist_name.' . $index, $row->therapist_name) }}" readonly>
                                                <input type="hidden" name="therapist_id[{{ $index }}]" value="{{ old('therapist_id.' . $index, $row->therapist_id) }}">
                                                <input type="hidden" name="invoice_detail_id[{{ $index }}]" value="{{ old('invoice_detail_id.' . $index, $row->id) }}">
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label class="control-label">{{ __('Rating ') }}<span class="text-danger">*</span></label>
                                                <div class="star-rating" id="star-rating">
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
                                            <div class="col-md-3 form-group">
                                                <label for="comment{{ $index }}">{{ __('Comment (optional) ') }}</label>
                                                <textarea class="form-control" name="comment[{{ $index }}]" rows="4">{{ old('comment.' . $index, $row->comment) }}</textarea>
                                            </div>
                                        </div>

                                        @php
                                            $record++;
                                        @endphp
                                    @endforeach

                                    <input type="hidden" id="record_review" value="{{ $record }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
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
