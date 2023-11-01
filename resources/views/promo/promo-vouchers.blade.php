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
    {{ __('Promo Vouchers Detail') }}
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
                        {{ __('Promo Vouchers Detail') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('promo') }}">{{ __('Promos') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Promo Vouchers Detail') }}
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">{{ __('Promo Name: ') }} </label>
                                        {{ $promo->name }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">{{ __('Status: ') }} </label>
                                        @if ($promo->status == 1) 
                                            {{ "Active" }}
                                        @else 
                                            {{ "In Active" }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">{{ __('Reusable Voucher ? ') }} </label>
                                        @if ($promo->is_reuse_voucher == 1)
                                            {{ "Yes" }}
                                        @else
                                            {{ "No" }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">{{ __('Note: ') }} </label>
                                        {{ $promo->description }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">{{ __('Discount: ') }} </label>
                                        @if ($promo->discount_type == 0)
                                            {{ "Rp " . number_format($promo->discount_value) }}
                                        @else 
                                            {{ $promo->discount_value . "% " . "(Max: Rp " . number_format($promo->discount_max_value) . ")"}}
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label">{{ __('Active Period: ') }} </label>
                                        {{ date('d/m/Y', strtotime($promo->active_period_start)) . " - " . date('d/m/Y', strtotime($promo->active_period_end)) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <blockquote>{{ __('Voucher Information') }}</blockquote>
                        <div class="row" style="margin-bottom: 8px">
                            <div class="col-md-12 form-group">
                                <label for="" class="d-block" style="margin-bottom: 15px">{{ __("Voucher List") }}</label>
                                <div class="btn-group voucher_list d-block">
                                    @if ($promo->promo_vouchers)
                                        @foreach ($promo->promo_vouchers as $item)
                                        <label class="btn btn-outline-secondary m-1">{{ $item->voucher_code }}<input type="hidden" name="voucher_list[]" value="{{ $item->voucher_code }}"></label>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
