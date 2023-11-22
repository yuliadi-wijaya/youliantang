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
                        <blockquote>{{ __('Invoice Header') }}</blockquote>
                        <form class="outer-repeater" action="{{ route('invoice.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="old_data" value="N">
                            <input type="hidden" name="is_member" id="is_member">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Invoice Code ') }}</label>
                                            <input type="text" class="form-control" placeholder="{{ __('Auto generated') }}" readonly>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">{{ __('Invoice Type ') }}</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="invoice_type" value="CK" checked>
                                                <label class="form-check-label mr-5">Checklist</label>

                                                <input class="form-check-input" type="radio" name="invoice_type" value="NC">
                                                <label class="form-check-label">Non Checklist</label>
                                            </div>
                                        </div>
                                    </div>
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
                                                        {{ old('customer_id') == $row->id ? 'selected' : '' }}>{{ $row->phone_number.' - '.$row->first_name.' '.$row->last_name }}</option>
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
                                                <button type="button" class="form-control btn-primary" title="Add Customers">
                                                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Treatment Date ') }}<span class="text-danger">*</span></label>
                                            <div class="input-group datepickerdiv">
                                                <input type="text"
                                                    class="form-control @error('treatment_date') is-invalid @enderror"
                                                    name="treatment_date" placeholder="{{ __('Enter Date') }}"
                                                    value="{{ now()->format('Y-m-d') }}" readonly>
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
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Note') }}</label>
                                            <textarea id="Note" name="note" class="form-control @error('note') is-invalid @enderror" rows="4" placeholder="{{ __('Enter Note') }}">{{ old('note') }}</textarea>
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
                            <blockquote>{{ __('Invoice Detail') }}</blockquote>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="repeater-product mb-4">
                                        <div data-repeater-list="invoices" class="form-group">
                                            @foreach(old('invoices', [0 => []]) as $index => $item)
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
                                                                        <option value="{{ $row->id }}" data-price="{{ $row->price }}" data-duration="{{ $row->duration }}" {{ old('invoices.' . $index . '.product_id') == $row->id ? 'selected' : '' }}>
                                                                            {{ $row->name }} - Rp. {{ number_format($row->price) }}
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
                                                                <select class="form-control select2 @error('invoices.' . $index . '.therapist_id') is-invalid @enderror" name="invoices[{{ $index }}][therapist_id]">
                                                                    <option selected disabled>{{ __('-- Select Therapist --') }}</option>
                                                                    @foreach($therapists as $row)
                                                                        <option value="{{ $row->id }}" {{ old('invoices.' . $index . '.therapist_id') == $row->id ? 'selected' : '' }}>{{ $row->first_name.' '.$row->last_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('invoices.' . $index . '.therapist_id')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4 form-group">
                                                                <label class="control-label">{{ __('Price ') }}<span class="text-info">{{ __('(Auto-Fill)') }}</span></label>
                                                                <input type="text" name="invoices[{{ $index }}][amount]" class="form-control" value="{{ old('invoices.' . $index . '.amount') }}" placeholder="{{ __('Enter Price') }}" readonly />
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                <label class="control-label">{{ __('Time From ') }}<span class="text-danger">*</span></label>
                                                                <input type="time" name="invoices[{{ $index }}][time_from]"
                                                                    class="form-control @error('invoices.' . $index . '.time_from') is-invalid @enderror"
                                                                    value="{{ old('invoices.' . $index . '.time_from') }}"
                                                                    onchange="getTimeTo(this,'')" />
                                                                @error('invoices.' . $index . '.time_from')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                <label class="control-label">{{ __('Time To ') }}<span class="text-info">{{ __('(Auto-Fill)') }}</span></label>
                                                                <input type="time" name="invoices[{{ $index }}][time_to]" class="form-control" value="{{ old('invoices.' . $index . '.time_to') }}" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-10 form-group">
                                                                <label class="control-label">{{ __('Room ') }}<span class="text-danger">*</span></label>
                                                                <select class="form-control select2 @error('invoices.' . $index . '.room') is-invalid @enderror" name="invoices[{{ $index }}][room]">
                                                                    <option selected disabled>{{ __('-- Select Room --') }}</option>
                                                                    @foreach($rooms as $row)
                                                                        <option value="{{ $row->name }}" {{ old('invoices.' . $index . '.room') == $row->name ? 'selected' : '' }}>{{ $row->name }}</option>
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
                                        <input data-repeater-create type="button" class="btn btn-primary" value="Add Item" />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <blockquote>{{ __('Invoice Summary') }}</blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row" id="row_member" style="display: none">
                                        <div class="col-md-12 form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" value="1" name="use_member" id="use_member" onchange="useMember(this)">
                                                <label class="form-check-label" for="use_member">
                                                    Use Membership
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="row_member_plan" style="display: none">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Member Plan ') }}</label>
                                            <input type="text"
                                                class="form-control" name="member_plan" id="member_plan"
                                                value="@if(old('member_plan')){{ old('member_plan') }}@endif" readonly>
                                        </div>
                                    </div>
                                    <div class="row" id="row_voucher_code" style="display: block">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Voucher Code ') }}</label>
                                            <select class="form-control select2"
                                                name="voucher_code"
                                                id="voucher_code"
                                                onchange="calDiscount()">
                                                <option value="" selected>{{ __('-- Select Voucher Code --') }}</option>
                                                @foreach($promos as $row)
                                                    <option value="{{ $row->voucher_code }}"
                                                        data-type = "{{ $row->discount_type }}"
                                                        data-value = "{{ $row->discount_value }}"
                                                        data-maxvalue = "{{ $row->discount_max_value }}"
                                                        data-reuse = "{{ $row->is_reuse_voucher }}"
                                                        {{ old('voucher_code') == $row->voucher_code ? 'selected' : '' }}>
                                                        {{ $row->voucher_code }} - {{ $row->name }} - @if ($row->discount_type == 0) {{ '(Discount : Rp. '. number_format($row->discount_value) .')' }} @else {{ '(Discount Max : Rp. '. number_format($row->discount_max_value) .')' }} @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row" id="row_member" style="display: none">
                                        <div class="col-md-12 form-group">
                                            <div class="form-check">
                                                &nbsp;
                                                <label class="form-check-label">&nbsp;</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Total Price') }}</label>
                                            <input type="text"
                                                class="form-control"
                                                name="total_price" id="total_price"
                                                value="{{ old('total_price', 0) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Discount') }}</label>
                                            <input type="text"
                                                class="form-control"
                                                name="discount" id="discount"
                                                value="{{ old('discount', 0) }}" readonly>
                                            <input type="hidden"
                                                name="reuse_voucher" id="reuse_voucher"
                                                value="{{ old('reuse_voucher', 0) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Grand Total') }}</label>
                                            <input type="text"
                                                class="form-control"
                                                name="grand_total" id="grand_total"
                                                value="{{ old('grand_total', 0) }}" readonly>
                                        </div>
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
                }

                grandTotal();
            }

            function getAmount(obj) {
                var productName = obj.getAttribute('name');
                var selectedOption = obj.options[obj.selectedIndex];
                var price = parseFloat(selectedOption.dataset.price);

                var amountName = productName.replace('product_id', 'amount');
                var amountInput = document.querySelector('[name="' + amountName + '"]');

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

                var timeFrom = productName.replace('product_id', 'time_from');
                getTimeTo('change', timeFrom);

                calTotal();
            }

            function getTimeTo(obj, name) {
                if(obj == 'change') {
                    var objName = name;
                    var inputName = document.querySelector('input[name="' + objName + '"]');
                    var timeFromValue = inputName.value;
                } else {
                    var objName = obj.getAttribute('name');
                    var timeFromValue = obj.value;
                }

                //get data duration from product
                var productName = objName.replace('time_from', 'product_id');
                var select = document.querySelector('select[name="' + productName + '"]');
                var selectedOption = select.options[select.selectedIndex];
                var duration = parseFloat(selectedOption.getAttribute('data-duration'));

                //get form name time_to
                var timeTo = objName.replace('time_from', 'time_to');
                var timeToInput = document.querySelector('[name="' + timeTo + '"]');

                //Calculate time_to = time_from + duration
                if (!isNaN(duration) && timeFromValue && timeToInput) {
                    var timeFrom = new Date('1970-01-01T' + timeFromValue);
                    timeFrom.setMinutes(timeFrom.getMinutes() + duration);

                    // Format the calculated time as 'HH:mm'
                    var hours = timeFrom.getHours().toString().padStart(2, '0');
                    var minutes = timeFrom.getMinutes().toString().padStart(2, '0');
                    var calculatedTime = hours + ':' + minutes;

                    //Set the calculated time_to value
                    timeToInput.value = calculatedTime;
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

                        grandTotal();
                    }else{
                        document.getElementById('discount').value = 0;
                        grandTotal();
                    }
                }
            }

            function grandTotal() {
                var total_price = document.getElementById('total_price').value.replace(/,/g, '');
                var discount = document.getElementById('discount').value.replace(/,/g, '');

                var grandTotal = total_price - discount;

                var formatGrandTotal = new Intl.NumberFormat('en-US', {
                    currency: 'USD'
                }).format(grandTotal);

                document.getElementById('grand_total').value = formatGrandTotal;
            }
        </script>
    @endsection
