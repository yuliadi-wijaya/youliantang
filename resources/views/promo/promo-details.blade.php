@extends('layouts.master-layouts')
@section('css')
<style type="text/css">
    .h-formfield-uppercase {
        text-transform: uppercase;
        &::placeholder {
            text-transform: none;
        }
    }

</style>
@endsection
@section('title')
    @if ($promo)
        {{ __('Update Promo Details') }}
    @else
        {{ __('Add New Promo') }}
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
                        @if ($promo)
                            {{ __('Update Promo Details') }}
                        @else
                            {{ __('Add New Promo') }}
                        @endif
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('promo') }}">{{ __('Promos') }}</a></li>
                            <li class="breadcrumb-item active">
                                @if ($promo)
                                    {{ __('Update Promo Details') }}
                                @else
                                    {{ __('Add New Promo') }}
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
                <a href="{{ url('promo') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Promo List') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Basic Information') }}</blockquote>
                        <form action="@if ($promo ) {{ url('promo/' . $promo->id) }} @else {{ route('promo.store') }} @endif" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($promo )
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Promo Name ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="name" id="Name" tabindex="1"
                                                value="@if ($promo){{ old('name', $promo->name) }}@elseif(old('name')){{ old('name') }}@endif"
                                                placeholder="{{ __('Enter Promo Name') }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Status ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                tabindex="11" name="status">
                                                <option selected disabled>{{ __('-- Select Status --') }}</option>
                                                <option value="1" @if (($promo && $promo->status == '1') || old('status') == '1') selected @endif>{{ __('Active') }}</option>
                                                <option value="0" @if (($promo && $promo->status == '0') || old('status') == '0') selected @endif>{{ __('In Active') }}</option>
                                            </select>
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Reusable Voucher ? ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('is_reuse_voucher') is-invalid @enderror"
                                                tabindex="11" name="is_reuse_voucher" id="is_reuse_voucher">
                                                <option value="0" @if (($promo && $promo->is_reuse_voucher == '0') || old('is_reuse_voucher') == '0') selected @endif>{{ __('No') }}</option>
                                                <option value="1" @if (($promo && $promo->is_reuse_voucher == '1') || old('is_reuse_voucher') == '1') selected @endif>{{ __('Yes') }}</option>

                                            </select>
                                            @error('is_reuse_voucher')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Note') }}</label>
                                                    <textarea id="Description" name="description" tabindex="7"
                                                    class="form-control @error('description') is-invalid @enderror" rows="4"
                                                    placeholder="{{ __('Enter Note') }}">@if ($promo){{ $promo->description }}@elseif(old('description')){{ old('description') }}@endif</textarea>
                                            @error('duration')
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
                                            <label class="control-label">{{ __('Discount Type ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('discount_type') is-invalid @enderror"
                                                tabindex="11" name="discount_type" id="DiscountType">
                                                <option selected disabled>{{ __('-- Select Discount Type --') }}</option>
                                                <option value="0" @if (($promo && $promo->discount_type == '0') || old('discount_type') == '0') selected @endif>{{ __('Fix Rate (Rp)') }}</option>
                                                <option value="1" @if (($promo && $promo->discount_type == '1') || old('discount_type') == '1') selected @endif>{{ __('Percentage (%)') }}</option>
                                            </select>
                                            @error('discount_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="control-label">{{ __('Total Discount ') }}<span
                                                        class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label discount-max-value">{{ __('Max Discount ') }}<span
                                                        class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="number" class="form-control @error('discount_value') is-invalid @enderror"
                                                        tabindex="4" name="discount_value" id="DiscountValue" value="@if ($promo ){{ old('discount_value', $promo->discount_value) }}@elseif(old('discount_value')){{ old('discount_value') }}@endif"
                                                        placeholder="{{ __('Enter Total Discount Based On Type') }}">
                                                    @error('discount_value')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="number" class="form-control discount-max-value @error('discount_max_value') is-invalid @enderror"
                                                        tabindex="4" name="discount_max_value" id="DiscountMaxValue" value="@if ($promo ){{ old('discount_max_value', $promo->discount_max_value) }}@elseif(old('discount_max_value')){{ old('discount_max_value') }}@endif"
                                                        placeholder="{{ __('Enter Max Discount (Fix Rate)') }}">
                                                    @error('discount_max_value')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Active Period ') }}<span
                                                    class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group datepickerdiv">
                                                        <input type="text"
                                                            class="form-control active_period @error('active_period_start') is-invalid @enderror"
                                                            name="active_period_start" id="ActivePeriodStart" data-provide="datepicker"
                                                            data-date-autoclose="true" autocomplete="off"
                                                            {{ old('active_period_start', date('Y-m-d')) }} placeholder="{{ __('Enter Start Date') }}"
                                                            value="@if ($promo ){{ old('active_period_start', date('Y-m-d', strtotime($promo->active_period_start))) }}@elseif(old('active_period_start')){{ old('active_period_start') }}@endif">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        </div>
                                                        @error('active_period_start')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group datepickerdiv">
                                                        <input type="text"
                                                            class="form-control active_period @error('active_period_end') is-invalid @enderror"
                                                            name="active_period_end" id="ActivePeriodEnd" data-provide="datepicker"
                                                            data-date-autoclose="true" autocomplete="off"
                                                            {{ old('active_period_end', date('Y-m-d')) }} placeholder="{{ __('Enter End Date') }}"
                                                            value="@if ($promo ){{ old('active_period_end', date('Y-m-d', strtotime($promo->active_period_end))) }}@elseif(old('active_period_end')){{ old('active_period_end') }}@endif">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        </div>
                                                        @error('active_period_end')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <blockquote>{{ __('Voucher Information') }}</blockquote>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">{{ __('Filter ') }}<span
                                        class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-2 form-group">
                                            <input type="number"
                                                class="form-control"
                                                name="start_number" id="StartNumber" tabindex="1"
                                                value="{{ old('start_number') }}"
                                                placeholder="{{ __('Enter Start Number') }}">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <input type="number"
                                                class="form-control"
                                                name="voucher_total" id="VoucherTotal" tabindex="1"
                                                value="{{ old('voucher_total') }}"
                                                placeholder="{{ __('Enter Total Voucher Will Be Generated') }}">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <input type="text"
                                                class="form-control text-uppercase h-formfield-uppercase"
                                                name="voucher_prefix" id="VoucherPrefix" tabindex="1"
                                                value="{{ old('voucher_prefix') }}"
                                                placeholder="{{ __('Enter Prefix Voucher') }}">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <input type="hidden" id="IsGenerated" name="is_generated" value="0">
                                            <button type="button" id="GenerateVoucher" class="btn btn-primary">{{ __('Generate Voucher') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 8px">
                                <div class="col-md-12 form-group">
                                    <label for="" class="d-block" style="margin-bottom: 15px">{{ __("Voucher List") }}<span
                                            class="text-danger">*</span> <span style="font-size: 8pt; font-style: italic;">{{ __("(will be generated automatically after click the generate voucher button)") }}</span></label>
                                    <div class="btn-group voucher_list d-block">
                                        @if ($promo != null && $promo->promo_vouchers)
                                            @foreach ($promo->promo_vouchers as $item)
                                            <label class="btn btn-outline-secondary m-1">{{ $item->voucher_code }}<input type="hidden" name="voucher_list[]" value="{{ $item->voucher_code }}"></label>
                                            @endforeach
                                        @endif
                                        @error('voucher_list')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        @if ($promo)
                                            {{ __('Update Promo Details') }}
                                        @else
                                            {{ __('Add New Promo') }}
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
        <!-- Calender Js-->
        <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.js') }}"></script>
        <script>
            $(document).ready(function() {
                if ($("#DiscountType").val() == 0) {
                    $("#DiscountMaxValue").val('');
                    $(".discount-max-value").fadeOut();
                } else {
                    $(".discount-max-value").fadeIn();
                }
            });

            $(document).on('change', '#DiscountType', function() {
                if ($(this).val() != undefined) {
                    if ($(this).val() == 0) {
                        $("#DiscountMaxValue").val('');
                        $(".discount-max-value").fadeOut();
                    } else {
                        $(".discount-max-value").fadeIn();
                    }
                }
            });
            // Script
            $('.active_period').datepicker({
                startDate: new Date(),
                format: 'yyyy-mm-dd'
            });

            $(document).on('click', '#GenerateVoucher', function() {
                var startNumber = $('#StartNumber').val();
                var voucherTotal = $('#VoucherTotal').val();
                var voucherPrefix = $('#VoucherPrefix').val();

                if (!startNumber || !voucherTotal || !voucherPrefix) {
                    alert('Input filters are required.');
                    return;
                }

                today = new Date();

                $('.voucher_list').html('');
                for(var i = parseInt(startNumber); i < parseInt(startNumber) + parseInt(voucherTotal); i++) {
                    voucherGeneratedText = voucherPrefix.toUpperCase() + i.toString().padStart(6, '0')
                    //$('.voucher_list').append('<div class="d-inline p-2 bg-success text-white font-weight-bold">' + voucherGeneratedText + '</div>');
                    $('.voucher_list').append('<label class="btn btn-outline-secondary m-1">' + voucherGeneratedText + '<input type="hidden" name="voucher_list[]" value="' + voucherGeneratedText + '"></label>');
                }

                $('#IsGenerated').val(1);
            });

            $(document).on('change', '#is_reuse_voucher', function() {
                if ($(this).val() == 1) {
                    $('#VoucherTotal').val('1');
                    $('#VoucherTotal').prop('readonly', true);
                } else {
                    $('#VoucherTotal').val('');
                    $('#VoucherTotal').prop('readonly', false);
                }
            });
        </script>
    @endsection
