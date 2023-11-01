@extends('layouts.master-layouts')
@section('title')
    @if ($transaction)
        {{ __('Update Transaction Details') }}
    @else
        {{ __('Add New Transaction') }}
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
                        @if ($transaction)
                            {{ __('Update Transaction Details') }}
                        @else
                            {{ __('Add New Transaction') }}
                        @endif
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('transaction') }}">{{ __('Transactions') }}</a></li>
                            <li class="breadcrumb-item active">
                                @if ($transaction)
                                    {{ __('Update Transaction Details') }}
                                @else
                                    {{ __('Add New Transaction') }}
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
                <a href="{{ url('transaction') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Transaction List') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Basic Information') }}</blockquote>
                        <form action="@if ($transaction ) {{ url('transaction/' . $transaction->id) }} @else {{ route('transaction.store') }} @endif" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($transaction )
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Customer Name ') }}<span
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
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Therapist Name ') }}<span
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
                                            <label class="control-label">{{ __('Product ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('product') is-invalid @enderror"
                                                name="product" id="product" tabindex="1"
                                                value="@if ($transaction){{ old('product', $transaction->product) }}@elseif(old('product')){{ old('product') }}@endif"
                                                placeholder="{{ __('Enter Product') }}">
                                            @error('product')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Total Cost ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('total_cost') is-invalid @enderror"
                                                name="total_cost" id="total_cost" tabindex="1"
                                                value="@if ($transaction){{ old('total_cost', $transaction->total_cost) }}@elseif(old('total_cost')){{ old('total_cost') }}@endif"
                                                placeholder="{{ __('Enter Total Cost') }}">
                                            @error('total_cost')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
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
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        @if ($transaction)
                                            {{ __('Update Transaction Details') }}
                                        @else
                                            {{ __('Add New Transaction') }}
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
