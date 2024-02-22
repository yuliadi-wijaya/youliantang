@extends('layouts.master-layouts')
@section('title') {{ __('Update Invoice') }} @endsection
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
                    <button type="button" class="btn btn-secondary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Invoice List') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form class="outer-repeater" action="{{ url('invoice/' . $invoice->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="old_data" value="{{ $invoice->old_data }}" />
                    <input type="hidden" name="is_member" id="is_member" value="{{ $invoice->is_member }}">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="control-label">{{ __('Invoice Code ') }}</label>
                                    <input type="text" name="invoice_code" value="{{ $invoice->invoice_code }}"
                                        class="form-control" placeholder="{{ __('Auto generated') }}" readonly>
                                    <input type="hidden" name="invoice_type_old" value="{{ $invoice->invoice_type }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label">{{ __('Treatment Date ') }}<span class="text-danger">*</span></label>
                                    <div class="input-group datepickerdiv">
                                        <input type="text"
                                            class="form-control @error('treatment_date') is-invalid @enderror"
                                            name="treatment_date" placeholder="{{ __('Enter Date') }}"
                                            value="{{ $invoice->treatment_date }}" readonly id="treatment_date">
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
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="repeater-product mb-4">
                                                <div data-repeater-list="invoices" class="form-group">
                                                    @foreach(old('invoices', $invoice_detail, [0 => []]) as $index => $item)
                                                        {{-- @php 
                                                            echo '<pre>';
                                                            print_r($item);
                                                            echo '</pre>';die();
                                                        @endphp --}}
                                                        <div data-repeater-item class="mb-12 row" style="border-bottom: 3px solid #f8f8fb; margin-top: 15px;">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12 form-group">
                                                                        <label class="control-label">{{ __('Product ') }}<span class="text-danger">*</span></label>
                                                                        <select class="form-control select2 @error('invoices.' . $index . '.product_id') is-invalid @enderror"
                                                                            name="invoices[{{ $index }}][product_id]"
                                                                            id="product_id"
                                                                            onchange="getAmount(this)">
                                                                            <option selected disabled>{{ __('-- Select Product --') }}</option>
                                                                            @foreach($products as $row)
                                                                                <option value="{{ $row->id }}" data-price="{{ $row->price }}" data-duration="{{ $row->duration }}" data-fee="{{ $row->commission_fee }}" {{ old('invoices.' . $index . '.product_id', $item['product_id']) == $row->id ? 'selected' : '' }}>
                                                                                    {{ $row->name }} - Rp {{ number_format($row->price) }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('invoices.' . $index . '.product_id')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12 form-group">
                                                                        <label class="control-label">{{ __('Therapist ') }}<span class="text-danger">*</span></label>
                                                                        <select class="form-control select2 @error('invoices.' . $index . '.therapist_id') is-invalid @enderror" id="therapist_id_{{ $index }}" name="invoices[{{ $index }}][therapist_id]" onchange="checkTherapistAvailability({{ $index }})">
                                                                            <option selected disabled>{{ __('-- Select Therapist --') }}</option>
                                                                            @foreach($therapists as $row)
                                                                                <option value="{{ $row->id }}" {{ old('invoices.' . $index . '.therapist_id', $item['therapist_id']) == $row->id ? 'selected' : '' }}>{{ $row->first_name.' '.$row->last_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('invoices.' . $index . '.therapist_id')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <input type="hidden" id="old_therapist_id_{{ $index }}" name="old_therapist_id_{{ $index }}" name class="form-control" value="{{ $item['therapist_id'] }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-4 form-group">
                                                                        <label class="control-label">{{ __('Price ') }}<span class="text-info">{{ __('(Auto-Fill)') }}</span></label>
                                                                        <input type="text" name="invoices[{{ $index }}][amount]" class="form-control" value="{{ old('invoices.' . $index . '.amount', number_format((float)$item['amount'])) }}" placeholder="{{ __('Enter Price') }}" readonly />
                                                                        <input type="hidden" name="invoices[{{ $index }}][fee]" class="form-control" value="{{ old('invoices.' . $index . '.fee', $item['fee']) }}" readonly />
                                                                    </div>
                                                                    <div class="col-md-4 form-group">
                                                                        <label class="control-label">{{ __('Time From ') }}<span class="text-danger">*</span></label>
                                                                        <input type="time" name="invoices[{{ $index }}][treatment_time_from]" id="treatment_time_from_{{ $index }}" 
                                                                            class="form-control @error('invoices.' . $index . '.treatment_time_from') is-invalid @enderror"
                                                                            value="{{ old('invoices.' . $index . '.treatment_time_from', $item['treatment_time_from']) }}"
                                                                            onchange="getTimeTo(this,''); checkTherapistAvailability({{ $index }})" />
                                                                        @error('invoices.' . $index . '.treatment_time_from')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                        <input type="hidden" name="old_treatment_time_from_{{ $index }}" id="old_treatment_time_from_{{ $index }}" class="form-control" value="{{ $item['treatment_time_from'] }}" />
                                                                    </div>
                                                                    <div class="col-md-4 form-group">
                                                                        <label class="control-label">{{ __('Time To ') }}<span class="text-info">{{ __('(Auto-Fill)') }}</span></label>
                                                                        <input type="time" name="invoices[{{ $index }}][treatment_time_to]" id="treatment_time_to_{{ $index }}" class="form-control" value="{{ old('invoices.' . $index . '.treatment_time_to', $item['treatment_time_to']) }}" readonly />
                                                                        <input type="hidden" name="old_treatment_time_to_{{ $index }}" id="old_treatment_time_to_{{ $index }}" class="form-control" value="{{ $item['treatment_time_to'] }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-10 form-group">
                                                                        <label class="control-label">{{ __('Room ') }}<span class="text-danger">*</span></label>
                                                                        <select class="form-control select2 @error('invoices.' . $index . '.room') is-invalid @enderror" name="invoices[{{ $index }}][room]">
                                                                            <option selected disabled>{{ __('-- Select Room --') }}</option>
                                                                            @foreach($rooms as $row)
                                                                                <option value="{{ $row->name }}" {{ old('invoices.' . $index . '.room', $item['room']) == $row->name ? 'selected' : '' }}>{{ $row->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('invoices.' . $index . '.room')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-2 form-group">
                                                                        <br />
                                                                        <input data-repeater-delete type="button" class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner" value="X" style="margin-top: 13px" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <input data-repeater-create type="button" class="btn btn-success" value="Add Item" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-10 form-group">
                                            <label class="control-label">{{ __('Customer ') }}<span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('customer_id') is-invalid @enderror"
                                                name="customer_id" id="customer_id" onchange="getMember()">
                                                <option selected disabled>{{ __('-- Select Customer --') }}</option>
                                                @foreach($customers as $row)
                                                    <option value="{{ $row->id }}"
                                                        data-member="{{ $row->is_member }}"
                                                        data-member_plan="{{ $row->member_plan }}"
                                                        data-discount_type="{{ $row->discount_type }}"
                                                        data-discount_value="{{ $row->discount_value }}"
                                                        {{ old('customer_id', $invoice->customer_id) == $row->id ? 'selected' : '' }}>{{ $row->phone_number.' - '.$row->first_name.' '.$row->last_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label class="control-label">&nbsp;</label>
                                            <a href="{{ url('invoice-customer-create') }}">
                                                <button type="button" class="form-control btn-success" title="Add Customers">
                                                    <i class="bx bx-plus font-size-20 align-middle"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="row_member" @if($invoice->is_member != 1) style="display: none" @endif>
                                <div class="col-md-12 form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" value="1"
                                            name="use_member" id="use_member"
                                            @if($invoice->use_member == 1) checked @endif
                                            onchange="useMember(this)">
                                        <label class="form-check-label" for="use_member">
                                            Use Membership
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card" id="row_member_plan" @if($invoice->use_member != 1) style="display: none" @endif>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Member Plan ') }}</label>
                                            <input type="text"
                                                class="form-control" name="member_plan" id="member_plan"
                                                value="{{ old('member_plan', $invoice->member_plan) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" id="row_voucher_code" @if($invoice->use_member != 1) style="display: block" @else style="display: none" @endif>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Voucher Code ') }}</label>
                                            <input type="hidden" name="voucher_code_old" value="{{$invoice->voucher_code}}">
                                            <select class="form-control select2"
                                                name="voucher_code"
                                                id="voucher_code"
                                                onchange="calDiscount()">
                                                <option value="" selected>{{ __('-- Select Voucher Code --') }}</option>
                                                @foreach($promo_used as $row)
                                                    <option value="{{ $row->voucher_code }}"
                                                        data-type = "{{ $row->discount_type }}"
                                                        data-value = "{{ $row->discount_value }}"
                                                        data-maxvalue = "{{ $row->discount_max_value }}"
                                                        data-reuse = "{{ $row->is_reuse_voucher }}"
                                                        {{ old('voucher_code', $invoice->voucher_code) == $row->voucher_code ? 'selected' : '' }}>
                                                        {{ $row->voucher_code }} - {{ $row->name }} - @if ($row->discount_type == 0) {{ '(Discount : Rp '. number_format($row->discount_value) .')' }} @else {{ '(Discount Max : Rp '. number_format($row->discount_max_value) .')' }} @endif
                                                    </option>
                                                @endforeach
                                                @foreach($promos as $row)
                                                    <option value="{{ $row->voucher_code }}"
                                                        data-type = "{{ $row->discount_type }}"
                                                        data-value = "{{ $row->discount_value }}"
                                                        data-maxvalue = "{{ $row->discount_max_value }}"
                                                        data-reuse = "{{ $row->is_reuse_voucher }}"
                                                        {{ old('voucher_code', $invoice->voucher_code) == $row->voucher_code ? 'selected' : '' }}>
                                                        {{ $row->voucher_code }} - {{ $row->name }} - @if ($row->discount_type == 0) {{ '(Discount : Rp '. number_format($row->discount_value) .')' }} @else {{ '(Discount Max : Rp '. number_format($row->discount_max_value) .')' }} @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    {{-- <blockquote>{{ __('Invoice Summary') }}</blockquote> --}}
                                    <div class="row">
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" data-toggle="tooltip" data-placement="top" title="excluded from discount">{{ __('Additional Charge') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input type="number" class="form-control" data-toggle="tooltip" data-placement="top" title="excluded from discount" onchange="calAdditionalPrice()" name="additional_price" id="additional_price" value="{{ old('additional_price', $invoice->additional_price) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">{{ __('PPN') }}</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="tax_rate" id="tax_rate" value="{{ old('tax_rate',  $invoice->tax_rate) }}" onchange="calTax()">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                    <input type="hidden" name="tax_amount" id="tax_amount" value="{{ old('tax_amount', $invoice->tax_amount) }}">
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Payment Mode ') }}<span
                                                class="text-danger">*</span></label>
                                            <select class="form-control @error('payment_mode') is-invalid @enderror"
                                                name="payment_mode">
                                                <option selected disabled>{{ __('-- Select Mode --') }}</option>
                                                <option value="Cash Payement" @if (old('payment_mode', $invoice->payment_mode) == 'Cash Payement') selected @endif>{{ __('Cash Payment') }} </option>
                                                <option value="Debit/Credit Card" @if (old('payment_mode', $invoice->payment_mode) == 'Debit/Credit Card') selected @endif>{{ __('Debit/Credit Card') }}</option>
                                                <option value="QRIS" @if (old('payment_mode', $invoice->payment_mode) == 'QRIS') selected @endif>{{ __('QRIS') }} </option>
                                                <option value="GoPay" @if (old('payment_mode', $invoice->payment_mode) == 'GoPay') selected @endif>{{ __('GoPay') }} </option>
                                                <option value="OVO" @if (old('payment_mode', $invoice->payment_mode) == 'OVO') selected @endif>{{ __('OVO') }} </option>
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
                                                <option selected disabled>{{ __('-- Select Status --') }}</option>
                                                <option value="Paid" @if (old('payment_status', $invoice->payment_status) == 'Paid') selected @endif>{{ __('Paid') }}</option>
                                                <option value="Unpaid" @if (old('payment_status', $invoice->payment_status) == 'Unpaid') selected @endif>{{ __('Unpaid') }}</option>
                                            </select>
                                            @error('payment_status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">{{ __('Invoice Note') }}</label>
                                                <textarea id="Note" name="note" class="form-control @error('note') is-invalid @enderror" rows="1" placeholder="{{ __('Enter Note') }}">{{ old('note', $invoice->note) }}</textarea>
                                                @error('note')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4" style="border-top:1px dashed #e0b402; margin-top:30px">
                                <div class="col-md-12 mt-4">
                                    <div class="row">
                                        <label class="col-sm-6 col-form-label">{{ __('Total Price') }}</label>
                                        <div class="col-sm-6 text-right">
                                            {{-- <label class="col-form-label" id="total_price_txt">{{ __('Rp 1,000,000') }}</label> --}}
                                            <input type="text"
                                                class="form-control text-right"
                                                name="total_price" id="total_price"
                                                value="{{ old('total_price', number_format($invoice->total_price)) }}" readonly style="font-weight: bold">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-6 col-form-label">{{ __('Discount') }}</label>
                                        <div class="col-sm-6 text-right">
                                            {{-- <label class="col-form-label" id="discount_txt">{{ __('Rp 1,000,000') }}</label> --}}
                                            <input type="text"
                                                class="form-control text-right"
                                                name="discount" id="discount"
                                                value="{{ old('discount', number_format($invoice->discount)) }}" readonly style="font-weight: bold">
                                            <input type="hidden"
                                                name="reuse_voucher" id="reuse_voucher"
                                                value="{{ old('reuse_voucher', 0) }}" readonly style="font-weight: bold">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-6 col-form-label" data-toggle="tooltip" data-placement="top" title="excluded from discount">{{ __('Additional Charge') }}</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control text-right" style="font-weight: bold" data-toggle="tooltip" data-placement="top" title="excluded from discount" onchange="calAdditionalPrice()" name="additional_price" id="additional_price" value="{{ old('additional_price', number_format($invoice->additional_price)) }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-6 col-form-label">{{ __('PPN') }}</label>
                                        <div class="input-group col-sm-6">
                                            <input type="number" class="form-control text-right" style="font-weight: bold" name="tax_rate" id="tax_rate" value="{{ old('tax_rate', $invoice->tax_rate) }}" onchange="calTax()">
                                            <div class="input-group-append" style="height: 36.5px">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="hidden" name="tax_amount" id="tax_amount" value="{{ old('tax_amount', $invoice->tax_amount) }}">
                                        </div>
                                    </div>
                                    <div class="row" style="font-size: 11pt">
                                        <label class="col-sm-6 col-form-label" style="font-weight:bold;color:#e0b402;">{{ __('Grand Total') }}</label>
                                        <div class="col-sm-6 text-right">
                                            {{-- <label class="col-form-label" id="grand_total_txt" style="font-weight:bold;font-size:14pt">{{ __('Rp 1,000,000') }}</label> --}}
                                            <input type="text"
                                                class="form-control text-right"
                                                name="grand_total" id="grand_total"
                                                value="{{ old('grand_total', number_format($invoice->grand_total)) }}" readonly style="font-weight: bold">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Invoice') }}
                                    </button>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div class="form-check text-right mt-2">
                                        @php
                                            $parts = explode('/', $invoice->invoice_code);
                                            $invoiceType = $parts[1];
                                        @endphp
                                        <input type="checkbox" class="form-check-input" value="1" name="ck_nc" id="ck_nc" @if ($invoiceType == 'CK') checked @endif onclick="return false">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
            $(document).ready(function () {
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

                // getMember();
            });

            function getMember() {
                var select = document.querySelector('select[name="customer_id"]');
                var selectedOption = select.options[select.selectedIndex];
                var member = parseFloat(selectedOption.dataset.member);
                var member_plan = selectedOption.dataset.member_plan;
                var discount_type = selectedOption.dataset.discount_type;
                var discount_value = parseFloat(selectedOption.dataset.discount_value);

                document.getElementById('is_member').value = member;

                var rowMember = document.getElementById("row_member");
                var rowMemberPlan = document.getElementById("row_member_plan");
                var useMember = document.getElementById("use_member");
                var rowVoucer = document.getElementById("row_voucher_code");

                if(member == 1) {
                    rowMember.style.display = "block";
                    rowMemberPlan.style.display = "block";
                    rowVoucer.style.display = "none";

                    useMember.checked = true;
                    document.getElementById("member_plan").value = member_plan;

                    if(discount_type == 1) {
                        var total_price = document.getElementById('total_price').value.replace(/,/g, '');

                        discount = total_price * discount_value / 100;
                    }else{
                        discount = discount_value;
                    }

                    var formatDiscount = new Intl.NumberFormat('en-US', {
                        currency: 'USD'
                    }).format(discount);

                    document.getElementById('discount').value = formatDiscount;

                    calTax();
                    grandTotal();
                }else{
                    rowMember.style.display = "none";
                    rowMemberPlan.style.display = "none";
                    rowVoucer.style.display = "block";

                    useMember.checked = false;

                    document.getElementById("member_plan").value = '';
                    document.getElementById('discount').value = 0;

                    if(useMember.checked == false) {
                        calDiscount();
                        calTax();
                    }
                    grandTotal();
                }
            }

            function useMember(obj) {
                var rowMemberPlan = document.getElementById("row_member_plan");
                var rowVoucer = document.getElementById("row_voucher_code");

                if(obj.checked == true) {
                    rowMemberPlan.style.display = "block";
                    rowVoucer.style.display = "none";

                    getMember();
                }else{
                    rowMemberPlan.style.display = "none";
                    rowVoucer.style.display = "block";

                    calDiscount();
                    calTax();
                }

                grandTotal();
            }

            function getAmount(obj) {
                var productName = obj.getAttribute('name');
                var selectedOption = obj.options[obj.selectedIndex];
                var price = parseFloat(selectedOption.dataset.price);
                var fee = parseFloat(selectedOption.dataset.fee);

                var amountName = productName.replace('product_id', 'amount');
                var amountInput = document.querySelector('[name="' + amountName + '"]');

                var feeName = productName.replace('product_id', 'fee');
                var feeInput = document.querySelector('[name="' + feeName + '"]');

                if (amountInput) {
                    if (!isNaN(price)) {
                        var formatAmount = new Intl.NumberFormat('en-US', {
                            currency: 'USD'
                        }).format(price);

                        amountInput.value = formatAmount;
                    } else {
                        amountInput.value = '';
                    }
                }

                if (feeInput) {
                    if (!isNaN(fee)) {
                        feeInput.value = fee;
                    } else {
                        feeInput.value = '';
                    }
                }

                var timeFrom = productName.replace('product_id', 'treatment_time_from');
                getTimeTo('change', timeFrom);

                calTotal();
                getMember();
            }

            function getTimeTo(obj, name) {
                if(obj == 'change') {
                    var objName = name;
                    var inputName = document.querySelector('input[name="' + objName + '"]');
                    var timeFromValue = inputName.value;

                    obj = inputName;
                } else {
                    var objName = obj.getAttribute('name');
                    var timeFromValue = obj.value;
                }

                //get data duration from product
                var productName = objName.replace('treatment_time_from', 'product_id');
                var select = document.querySelector('select[name="' + productName + '"]');
                var selectedOption = select.options[select.selectedIndex];
                var duration = parseFloat(selectedOption.getAttribute('data-duration'));

                //get form name treatment_time_to
                var timeTo = objName.replace('treatment_time_from', 'treatment_time_to');
                var timeToInput = document.querySelector('[name="' + timeTo + '"]');

                //Calculate treatment_time_to = treatment_time_from + duration
                if (!isNaN(duration) && timeFromValue && timeToInput) {
                    var timeFrom = new Date('1970-01-01T' + timeFromValue);
                    timeFrom.setMinutes(timeFrom.getMinutes() + duration);

                    // Format the calculated time as 'HH:mm'
                    var hours = timeFrom.getHours().toString().padStart(2, '0');
                    var minutes = timeFrom.getMinutes().toString().padStart(2, '0');
                    var second = timeFrom.getSeconds().toString().padStart(2, '0');
                    var calculatedTime = hours + ':' + minutes + ':' + second;

                    //Set the calculated treatment_time_to value
                    timeToInput.value = calculatedTime;

                    // checkTherapistAvailability(obj, 'treatment_time_from', index);

                    obj.value = timeFromValue + ':' + second;
                }
            }

            function calTotal() {
                document.getElementById('total_price').value = '';
                var total = 0;

                var invoiceInputs = document.querySelectorAll('input[name^="invoices["][name$="][amount]"]');

                invoiceInputs.forEach(function (input) {
                    total += parseFloat(input.value.replace(/,/g, '')) || 0;
                });

                var formatTotalPrice = new Intl.NumberFormat('en-US', {
                    currency: 'USD'
                }).format(total);

                document.getElementById('total_price').value = formatTotalPrice;

                grandTotal();
                calDiscount();
                calTax();
            }

            function calDiscount() {
                var select = document.querySelector('select[name="voucher_code"]');
                var selectedOption = select.options[select.selectedIndex];

                var useMember = document.getElementById("use_member");

                if(useMember.checked == false) {
                    if(select.value != '') {
                        var type = parseFloat(selectedOption.dataset.type);
                        var value = parseFloat(selectedOption.dataset.value);
                        var maxvalue = parseFloat(selectedOption.dataset.maxvalue);
                        var reuse = parseFloat(selectedOption.dataset.reuse);

                        var total_price = document.getElementById('total_price').value.replace(/,/g, '');
                        var discount = 0;

                        if(type == 0) {
                            discount = value;
                        }else{
                            if(total_price != 0) {
                                discountPromo = total_price * value / 100;

                                // if total discount greater than maxvalue get discount form maxvalue
                                if (discountPromo <= maxvalue) {
                                    discount = discountPromo;
                                }else{
                                    discount = maxvalue;
                                }
                            }else{
                                discount = maxvalue;
                            }
                        }

                        var formatDiscount = new Intl.NumberFormat('en-US', {
                            currency: 'USD'
                        }).format(discount);

                        document.getElementById('discount').value = formatDiscount;
                        document.getElementById('reuse_voucher').value = reuse;

                        calTax();
                        grandTotal();
                    }else{
                        document.getElementById('discount').value = 0;

                        calTax();
                        grandTotal();
                    }
                }
            }

            function totalExTax() {
                let total_price = parseFloat(document.getElementById('total_price').value.replace(/,/g, '')) || 0;
                let discount = parseFloat(document.getElementById('discount').value.replace(/,/g, '')) || 0;
                let additional_price = parseFloat(document.getElementById('additional_price').value.replace(/,/g, '')) || 0;

                return ((total_price - discount) + additional_price)
            }

            function grandTotal() {
                let tax_amount = parseFloat(document.getElementById('tax_amount').value.replace(/,/g, '')) || 0;

                let grandTotal = Math.ceil(totalExTax() + tax_amount);

                var formatGrandTotal = new Intl.NumberFormat('en-US', {
                    currency: 'USD'
                }).format(grandTotal);

                document.getElementById('grand_total').value = formatGrandTotal;
            }

            function calAdditionalPrice() {
                let additional_price = parseFloat(document.getElementById('additional_price').value.replace(/,/g, '')) || 0;

                if (!isNaN(additional_price)) {
                    var formatAmount = new Intl.NumberFormat('en-US', {
                        currency: 'USD'
                    }).format(additional_price);

                    document.getElementById('additional_price').value = formatAmount;
                }

                calTax();
                grandTotal();
            }

            function calTax() {
                let tax_rate = parseFloat(document.getElementById('tax_rate').value);

                if (!isNaN(tax_rate) && tax_rate > 0) {
                    let total_price = parseFloat(document.getElementById('total_price').value.replace(/,/g, ''));
                    let discount = parseFloat(document.getElementById('discount').value.replace(/,/g, ''));

                    let tax = (totalExTax() * tax_rate) / 100;

                    console.log(tax);

                    document.getElementById('tax_amount').value = tax.toFixed(2);
                }else{
                    document.getElementById('tax_amount').value = 0;
                }

                grandTotal();
            }

            function checkTherapistAvailability(index) {
                // var objName = obj.getAttribute('name');
                // var therapist_id = document.querySelector('select[name="' + objName.replace(source, 'therapist_id') + '"]');
                // var treatment_start_time = document.querySelector('input[name="' + objName.replace(source, 'treatment_time_from') + '"]');
                // var treatment_end_time = document.querySelector('input[name="' + objName.replace(source, 'treatment_time_to') + '"]');

                var treatment_date = $('#treatment_date').val();
                var therapist_id = "";
                if (document.querySelector('select[name="invoices['+index+'][therapist_id]"]') != undefined) {
                    therapist_id = document.querySelector('select[name="invoices['+index+'][therapist_id]"]').value;
                }
                var treatment_start_time = $('#treatment_time_from_'+index).val();
                var treatment_end_time = $('#treatment_time_to_'+index).val();

                var old_therapist_id = $('#old_therapist_id_'+index).val();
                var old_treatment_start_time = $('#old_treatment_time_from_'+index).val();
                var old_treatment_end_time = $('#old_treatment_time_to_'+index).val();

                console.log(treatment_date);

                var token = $("input[name='_token']").val();
                if (treatment_start_time == "" || treatment_end_time == "" || therapist_id == "") {
                    return;
                }

                if ((therapist_id == old_therapist_id) && (treatment_start_time == old_treatment_start_time) && (treatment_end_time == old_treatment_end_time)) {
                    console.log('in');
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('therapist_availability') }}",
                    data: { 
                        'therapist_id': therapist_id, 
                        'treatment_start_time': treatment_start_time,
                        'treatment_end_time': treatment_end_time,
                        'treatment_date': treatment_date,
                        '_token': token
                    },
                    beforeSend: function() {
                        $('#preloader').show()
                    },
                    success: function(response) {
                        if(response.data.length > 0) {
                            toastr.error('Therapist not available at around ' + response.data[1] + ' - ' + response.data[2]);
                        } else {
                            toastr.success('Threapist is available at around that time');
                        }
                        $(".complete").attr('disabled', false);
                    },
                    error: function(response) {
                        $(".complete").attr('disabled', false);
                        toastr.error(response.responseJSON.Message);
                    },
                    complete: function() {
                        $('#preloader').hide();
                    }
                });
            }
        </script>
    @endsection
