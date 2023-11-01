@extends('layouts.master-layouts')
@section('title') {{ __('Update Invoice') }} @endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
@endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Update Invoice @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Invoice @endslot
            @slot('li_3') Update Invoice @endslot
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
                        <form class="outer-repeater" action="{{ url('invoice/' . '' . $invoice_detail->id) }}" method="post">
                            @method('PATCH')
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="control-label">{{ __('Customer') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="form-control select2 sel_customer @error('customer_id') is-invalid @enderror"
                                        name="customer_id" id="customer">
                                        <option disabled selected>{{ __('Select Customer') }}</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ $invoice_detail->customer->id == $customer->id?'selected':'' }}>
                                                {{ $customer->first_name }} {{ $customer->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                </div>
                                @if ($role == 'therapist')
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">{{ __('Appointment ') }}<span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="form-control select2 sel_appointment @error('appointment_id') is-invalid @enderror"
                                            name="appointment_id" id="appointment">
                                            <option disabled selected>{{ __('Select Appointment') }}</option>
                                            @foreach ($appointment as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $invoice_detail->appointment->id ? 'selected' : '' }}>
                                                {{ $item->appointment_date }}</option>
                                             @endforeach
                                        </select>
                                        @error('appointment_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                @endif
                                @if ($role == 'receptionist')
                                    <div class="col-md-6 form-group">
                                        <label class="control-label">{{ __('Appointment ') }}<span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="form-control select2 sel_appointment @error('appointment_id') is-invalid @enderror"
                                            name="appointment_id" id="appointment">
                                            <option disabled selected>{{ __('Select Appointment') }}</option>
                                            @foreach ($appointment as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $invoice_detail->appointment->id ? 'selected' : '' }}>
                                                {{ $item->appointment_date }}</option>
                                             @endforeach
                                        </select>
                                        @error('appointment_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                @endif
                                <div class="col-md-6 form-group">
                                    <label class="control-label">{{ __('Therapist ') }}</label>
                                    <input type="text" class="form-control sel_therapist" readonly
                                    value="{{ $invoice_detail->appointment->therapist->first_name .' '.$invoice_detail->appointment->therapist->last_name }}">
                                    <input type="hidden" name="therapist_id" class="form-control sel_therapist_id">
                                    @error('therapist_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <input type="hidden" name="created_by" value="{{ $user->id }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="control-label">{{ __('Payment Mode ') }}<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('payment_mode') is-invalid @enderror"
                                        name="payment_mode">
                                        <option selected disabled>{{ __('Select Payment Mode') }}</option>
                                        <option value="Cash Payement" @if ($invoice_detail->payment_mode == 'Cash Payement') selected @endif>{{ __('Cash Payment') }}
                                        </option>
                                        <option value="Cheque" @if ($invoice_detail->payment_mode == 'Cheque') selected @endif>{{ __('Cheque') }}</option>
                                        <option value="Debit/Credit Card" @if ($invoice_detail->payment_mode == 'Debit/Credit Card') selected @endif>
                                            {{ __('Debit/Credit Card') }}
                                        </option>
                                    </select>
                                    @error('payment_mode')
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
                                        <option selected disabled>{{ __('Select Payment Status') }}</option>
                                        <option value="Paid" @if ($invoice_detail->payment_status == 'Paid') selected @endif>{{ __('Paid') }}</option>
                                        <option value="Unpaid" @if ($invoice_detail->payment_status == 'Unpaid') selected @endif>{{ __('Unpaid') }}</option>
                                    </select>
                                    @error('payment_status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <blockquote>{{ __('Invoice Summary') }}</blockquote>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class='repeater mb-4'>
                                        <div data-repeater-list="invoices" class="form-group">
                                            <label>{{ __('Invoice Items ') }}<span
                                                    class="text-danger">*</span></label>
                                            @foreach ($invoice_detail->invoice_detail as $item)
                                                <div data-repeater-item class="mb-3 row">
                                                    <div class="col-md-5 col-6">
                                                        <input type="text" name="title" class="form-control"
                                                            placeholder="{{ __('Item title') }}" value="{{ $item->title }}"/>
                                                    </div>
                                                    <div class="col-md-5 col-6">
                                                        <input type="text" name="amount" class="form-control"
                                                            placeholder="{{ __('Enter Amount') }}" value="{{ $item->amount }}" />
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <input data-repeater-delete type="button"
                                                            class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                            value="X" />
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-primary"
                                            value="Add Item" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Updated Invoice') }}
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
        <script>
            // Customer by appointment select
            $('.sel_customer').on('change', function(e) {
                e.preventDefault();
                var customerId = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('customer_by_appointment') }}",
                    data: {
                        customer_id: customerId,
                        _token: token,
                    },
                    success: function(res) {
                        $('.sel_appointment').html('');
                        $('.sel_appointment').html(res.options);
                    },
                    error: function(res) {
                        console.log(res);
                    }
                });
            });
            // appointment by therapist select
            $('.sel_appointment').change(function(e) {
                e.preventDefault();
                var appointmentID = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('appointment_by_therapist') }}",
                    data: {
                        appointment_id: appointmentID,
                        _token: token,
                    },
                    success: function(res) {
                        var rd = res.data[0];
                        $('.sel_therapist').val(rd.first_name + ' ' + rd.last_name);
                        $('.sel_therapist_id').val(rd.id);
                    },
                    error: function(res) {
                        console.log(res);
                    }
                });
            });
        </script>
    @endsection
