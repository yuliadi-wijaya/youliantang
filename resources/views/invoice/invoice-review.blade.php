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
                        <blockquote>{{ __('Review Details') }}</blockquote>
                        <form action="@if ($reviews ) {{ url('review/' . $reviews->id) }} @else {{ route('review.store') }} @endif" method="post">
                            @csrf
                            @if ($reviews )
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif

                            @if ($reviews == NULL)
                                <input type="hidden" name="is_new" value="Y" />
                            @else
                                <input type="hidden" name="is_new" value="N" />
                                <input type="hidden" name="review_id" value="{{ $reviews->id }}" />
                            @endif
                            <input type="hidden" name="old_data" value="{{ $invoice->old_data }}" />
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />

                            <div class="row">
                                <div class="col-md-12">
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Phone Number ') }}</label>
                                            @if ($invoice->old_data == 'Y')
                                                <input type="text" class="form-control" name="phone_number" value="" placeholder="Phone Number">
                                            @elseif ($invoice->old_data == 'N')
                                                <input type="text" class="form-control" name="phone_number" value="{{ $invoice->phone_number }}" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Rating ') }}<span class="text-danger">*</span></label>
                                            <div class="star-rating" id="star-rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="star" data-rating="{{ $i }}"><i class="fas fa-star" style="font-size: 20px;"></i></span>
                                                @endfor
                                            </div>
                                            <input type="hidden" name="rating" id="rating" value="@if ($reviews){{ old('rating', $reviews->rating) }}@elseif(old('rating')){{ old('rating') }}@endif">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="comment">{{ __('Comment (optional) ') }}</label>
                                            <textarea class="form-control" name="comment" id="comment" rows="4">@if ($reviews){{ old('comment', $reviews->comment) }}@elseif(old('comment')){{ old('comment') }}@endif</textarea>
                                        </div>
                                    </div>
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
