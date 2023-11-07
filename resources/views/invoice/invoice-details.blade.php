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
        @component('components.breadcrumb')
            @slot('title') Create Invoice @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Invoice @endslot
            @slot('li_3') Create Invoice @endslot
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
                        <blockquote>{{ __('Invoice Details') }}</blockquote>
                        <form class="outer-repeater" action="{{ route('invoice.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Customer ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('customer_id') is-invalid @enderror"
                                                name="customer_id">
                                                <option selected disabled>{{ __('-- Select Customer --') }}</option>
                                                @foreach($customers as $row)
                                                    <option value="{{ $row->id }}" @if (old('customer_id') == {{ $row->id }}) selected @endif>{{ $row->first_name.' '.$row->last_name }}</option>
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
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Therapist ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('therapist_id') is-invalid @enderror"
                                                name="therapist_id">
                                                <option selected disabled>{{ __('-- Select Therapist --') }}</option>
                                                @foreach($therapists as $row)
                                                    <option value="{{ $row->id }}" @if (old('therapist_id') == {{ $row->id }}) selected @endif>{{ $row->first_name.' '.$row->last_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('therapist_id')
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
                                            <select class="form-control select2 @error('room') is-invalid @enderror"
                                                name="room">
                                                <option selected disabled>{{ __('-- Select Room --') }}</option>
                                                @foreach($rooms as $item)
                                                    <option value="{{ $item->name }}" @if (old('room') == '{{ $item->name }}') selected @endif>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
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
                                        <div class="col-md-6">
                                            <label class="control-label">{{ __('Treatment Date ') }}<span
                                                class="text-danger">*</span></label>
                                            <div class="input-group datepickerdiv">
                                                <input type="text"
                                                    class="form-control @error('treatment_date') is-invalid @enderror"
                                                    name="treatment_date" id="TreatmentDate" data-provide="datepicker"
                                                    data-date-autoclose="true" autocomplete="off" placeholder="{{ __('Enter Date') }}"
                                                    value="{{ old('treatment_date') }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                                @error('treatment_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="control-label">{{ __('From ') }}<span
                                                class="text-danger">*</span></label>
                                            <input type="time"
                                                class="form-control @error('treatment_time_from') is-invalid @enderror"
                                                name="treatment_time_from" id="TreatmentTimeFrom" tabindex="1"
                                                value="{{ old('treatment_time_from') }}">
                                            @error('treatment_time_from')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="control-label">{{ __('To ') }}<span
                                                class="text-danger">*</span></label>
                                            <input type="time"
                                                class="form-control @error('treatment_time_to') is-invalid @enderror"
                                                name="treatment_time_to" id="treatment_time_to" tabindex="1"
                                                value="{{ old('treatment_time_to') }}">
                                            @error('treatment_end')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Payment Mode ') }}<span
                                                class="text-danger">*</span></label>
                                            <select class="form-control @error('payment_mode') is-invalid @enderror"
                                                name="payment_mode">
                                                <option selected disabled>{{ __('-- Select Payment Mode --') }}</option>
                                                <option value="Cash Payement" @if (old('payment_mode') == 'Cash Payement') selected @endif>{{ __('Cash Payment') }} </option>
                                                <option value="Debit/Credit Card" @if (old('payment_mode') == 'Debit/Credit Card') selected @endif>{{ __('Debit/Credit Card') }}</option>
                                                <option value="QRIS" @if (old('payment_mode') == 'QRIS') selected @endif>{{ __('QRIS') }} </option>
                                                <option value="GoPay" @if (old('payment_mode') == 'GoPay') selected @endif>{{ __('GoPay') }} </option>
                                                <option value="OVO" @if (old('payment_mode') == 'OVO') selected @endif>{{ __('OVO') }} </option>
                                            </select>
                                            @error('payment_mode')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Payment Status') }}<span
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
                                                    class="form-control @error('note') is-invalid @enderror" rows="1"
                                                    placeholder="{{ __('Enter Note') }}">{{ old('note') }}</textarea>
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
                                    <div class='repeater-product mb-4'>
                                        <div data-repeater-list="invoices" class="form-group">
                                            <label>{{ __('Invoice Items ') }}<span
                                                    class="text-danger">*</span></label>
                                            <div data-repeater-item class="mb-3 row">
                                                <div class="col-md-5 col-6">
                                                    <select class="form-control select2 @error('product_id') is-invalid @enderror" name="product_id" id="product_id" onchange="getAmount(this)">
                                                        <option selected>{{ __('-- Select Product --') }}</option>
                                                        @foreach($products as $row)
                                                            <option value="{{ $row->price }}|{{ $row->id }}" @if (old('product_id') == '{{ $row->price }}|{{ $row->id }}') selected @endif>{{ $row->name }} - Rp. {{ number_format($row->price) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 col-6">
                                                    <input type="text" name="amount" class="form-control"
                                                        placeholder="{{ __('Enter Amount') }}" readonly/>
                                                </div>
                                                <div class="col-md-2 col-4">
                                                    <input data-repeater-delete type="button"
                                                        class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                        value="X" />
                                                </div>
                                            </div>
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-primary" value="Add Item" />
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
        <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>
        <script>
            $('#TreatmentDate').datepicker({
                startDate: new Date(),
                format: 'dd/mm/yyyy'
            });

            function getAmount(obj) {
                var productName = obj.getAttribute('name');
                var productVal = obj.value;

                var amountName = productName.replace('product_id', 'amount');
                var amountInput = document.querySelector('[name="' + amountName + '"]');

                if (amountInput) {
                    var parts = productVal.split('|');
                    var amount = parseFloat(parts[0]);

                    if (!isNaN(amount)) {
                        amountInput.value = amount;

                        var formattedAmount = new Intl.NumberFormat('en-US', {
                            currency: 'USD'
                        }).format(amount);

                        amountInput.value = formattedAmount;
                    } else {
                        amountInput.value = '';
                    }
                }
            }
        </script>
    @endsection
