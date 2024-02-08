@extends('layouts.master-layouts')
@section('title') {{ __('Create New Invoice') }} @endsection
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
                        {{ __('Create Invoice') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('transaction') }}">{{ __('Invoice') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Create Invoice') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="{{ url('transaction') }}">
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
                        <blockquote>{{ __('Invoice Details') }}</blockquote>
                        <form action="@if ($transaction ) {{ url('transaction/' . $transaction->id) }} @else {{ route('transaction.store') }} @endif" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($transaction )
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Customer ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('customer_name') is-invalid @enderror"
                                                name="customer_name" id="customer_name" tabindex="1"
                                                value="@if ($transaction){{ old('customer_name', $transaction->customer_name) }}@elseif(old('customer_name')){{ old('customer_name') }}@endif"
                                                placeholder="{{ __('Enter Customer Name') }}">
                                            @error('customer_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Therapist ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('therapist_name') is-invalid @enderror"
                                                name="therapist_name" id="therapist_name" tabindex="1"
                                                value="@if ($transaction){{ old('therapist_name', $transaction->therapist_name) }}@elseif(old('therapist_name')){{ old('therapist_name') }}@endif"
                                                placeholder="{{ __('Enter Therapist Name') }}">
                                            @error('therapist_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Room ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('room') is-invalid @enderror"
                                                name="room" id="room" tabindex="1"
                                                value="@if ($transaction){{ old('room', $transaction->room) }}@elseif(old('room')){{ old('room') }}@endif"
                                                placeholder="{{ __('Enter Room') }}">
                                            @error('room')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Payment Method ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('payment_method') is-invalid @enderror"
                                                tabindex="11" name="payment_method">
                                                <option selected disabled>{{ __('-- Select Payment Method --') }}</option>
                                                <option value="Cash" @if (($transaction && $transaction->payment_method == 'Cash') || old('payment_method') == 'Cash') selected @endif>{{ __('Cash')}}</option>
                                                <option value="Debit" @if (($transaction && $transaction->payment_method == 'Debit') || old('payment_method') == 'Debit') selected @endif>{{ __('Debit')}}</option>
                                                <option value="GoPay" @if (($transaction && $transaction->payment_method == 'GoPay') || old('payment_method') == 'GoPay') selected @endif>{{ __('GoPay')}}</option>
                                                <option value="QRIS" @if (($transaction && $transaction->payment_method == 'QRIS') || old('payment_method') == 'QRIS') selected @endif>{{ __('QRIS')}}</option>
                                                <option value="Credit Card" @if (($transaction && $transaction->payment_method == 'Credit Card') || old('payment_method') == 'Credit Card') selected @endif>{{ __('Credit Card')}}</option>
                                            </select>
                                            @error('payment_method')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Payment Status ') }}<span
                                                class="text-danger">*</span></label>
                                            <select class="form-control @error('payment_status') is-invalid @enderror"
                                                name="payment_status">
                                                <option selected disabled>{{ __('-- Select Payment Status --') }}</option>
                                                <option value="Paid" @if (old('payment_status') == 'Paid') selected @endif>{{ __('Paid') }}</option>
                                                <option value="Unpaid" @if (old('payment_status') == 'Unpaid') selected @endif>{{ __('Unpaid') }}</option>
                                            </select>
                                            @error('payment_status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Note') }}</label>
                                                    <textarea id="Note" name="note" tabindex="7"
                                                    class="form-control @error('note') is-invalid @enderror" rows="5"
                                                    placeholder="{{ __('Enter Note') }}">@if ($transaction){{ $transaction->note }}@elseif(old('note')){{ old('note') }}@endif</textarea>
                                            @error('note')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <blockquote>{{ __('Invoice Summary') }}</blockquote>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class='repeater mb-4'>
                                        <div data-repeater-list="invoices" class="form-group">
                                            <label>{{ __('Invoice Items ') }}<span
                                                    class="text-danger">*</span></label>
                                            <div data-repeater-item class="mb-3 row">
                                                <div class="col-md-5 col-6">
                                                    <input type="text" name="title" class="form-control"
                                                        placeholder="{{ __('Enter Product') }}" />
                                                </div>
                                                <div class="col-md-5 col-6">
                                                    <input type="text" name="amount" class="form-control"
                                                        placeholder="{{ __('Enter Amount') }}" />
                                                </div>
                                                <div class="col-md-2 col-4">
                                                    <input data-repeater-delete type="button"
                                                        class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                        value="X" />
                                                </div>
                                            </div>
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-primary"
                                            value="Add Item" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create New Invoice') }}
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
    @endsection
