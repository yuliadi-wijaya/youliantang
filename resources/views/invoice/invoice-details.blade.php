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
                                <div class="col-md-6 form-group">
                                    <label class="control-label">{{ __('Customer') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="form-control select2 sel_Customer @error('Customer_id') is-invalid @enderror"
                                        name="Customer_id" id="Customer">
                                        <option disabled selected>{{ __('Select Customer') }}</option>
                                        @foreach ($Customers as $Customer)
                                            <option value="{{ $Customer->id }}" @if (old('Customer_id') == $Customer->id) selected @endif>
                                                {{ $Customer->first_name }} {{ $Customer->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('Customer_id')
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
                                    <input type="text" class="form-control sel_therapist" readonly>
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
                                        <option value="Cash Payement" @if (old('payment_mode') == 'Cash Payement') selected @endif>{{ __('Cash Payment') }}
                                        </option>
                                        <option value="Cheque" @if (old('payment_mode') == 'Cheque') selected @endif>{{ __('Cheque') }}</option>
                                        <option value="Debit/Credit Card" @if (old('payment_mode') == 'Debit/Credit Card') selected @endif>
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
                                                        placeholder="{{ __('Item title') }}" />
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
        <script>
            // Customer by appointment select
            $('.sel_Customer').on('change', function(e) {
                e.preventDefault();
                var CustomerId = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('Customer_by_appointment') }}",
                    data: {
                        Customer_id: CustomerId,
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
