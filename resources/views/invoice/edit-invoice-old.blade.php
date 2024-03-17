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
                        <form class="outer-repeater" action="{{ url('invoice/' . $invoice_detail->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH" />
                            <input type="hidden" name="old_data" value="{{ $invoice_detail->old_data }}" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Customer ') }}<span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('customer_name') is-invalid @enderror"
                                                name="customer_name" id="customer_name" tabindex="1"
                                                value="{{ $invoice_detail->customer_name }}"
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
                                            <label class="control-label">{{ __('Therapist ') }}<span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('therapist_name') is-invalid @enderror"
                                                name="therapist_name" id="therapist_name" tabindex="1"
                                                value="{{ $invoice_detail->therapist_name }}"
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
                                            <label class="control-label">{{ __('Room ') }}<span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('room') is-invalid @enderror" name="room">
                                                <option selected disabled>{{ __('-- Select Room --') }}</option>
                                                @foreach($rooms as $item)
                                                    <option value="{{ $item->name }}" @if ($invoice_detail->room == $item->name) selected @endif>{{ $item->name }}</option>
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
                                                    value="{{ date('d/m/Y', strtotime($invoice_detail->treatment_date)) }}">
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
                                                value="{{ $invoice_detail->treatment_time_from }}">
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
                                                value="{{ $invoice_detail->treatment_time_to }}">
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
                                                <option value="Cash Payment" @if ($invoice_detail->payment_mode == 'Cash Payement') selected @endif>{{ __('Cash Payment') }} </option>
                                                <option value="Debit/Credit Card" @if ($invoice_detail->payment_mode == 'Debit/Credit Card') selected @endif>{{ __('Debit/Credit Card') }}</option>
                                                <option value="QRIS" @if ($invoice_detail->payment_mode == 'QRIS') selected @endif>{{ __('QRIS') }} </option>
                                                <option value="GoPay" @if ($invoice_detail->payment_mode == 'GoPay') selected @endif>{{ __('GoPay') }} </option>
                                                <option value="OVO" @if ($invoice_detail->payment_mode == 'OVO') selected @endif>{{ __('OVO') }} </option>
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
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Note') }}</label>
                                                    <textarea id="Note" name="note" tabindex="7"
                                                    class="form-control @error('note') is-invalid @enderror" rows="1"
                                                    placeholder="{{ __('Enter Note') }}">{{ $invoice_detail->note }}</textarea>
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
                                            @foreach ($invoice_detail->invoice_detail as $item)
                                                <div data-repeater-item class="mb-3 row">
                                                    <div class="col-md-5 col-6">
                                                        <input type="text" name="title" class="form-control"
                                                            placeholder="{{ __('Enter Product') }}" value="{{ $item->title }}" />
                                                    </div>
                                                    <div class="col-md-5 col-6">
                                                        <input type="number" name="amount" class="form-control"
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
                                        {{ __('Update Invoice') }}
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

            $(document).ready(function() {
                $(this).find('select').each(function() {
                    if (typeof $(this).attr('id') === "undefined") {
                        // ...
                    } else {
                        $('.select2').removeAttr("id").removeAttr("data-select2-id");
                        $('.select2').select2();
                        $('.select2-container').css('width','100%');
                        $('.select2').next().next().remove();
                    }
                });
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
