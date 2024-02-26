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
                    <button type="button" class="btn btn-secondary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Promo List') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3" style="background-color: #2a3042">
                            <div class="col-md-12 text-center mt-4 mb-4">
                                <span class="font-weight-bold" style="font-size: 15pt; color: #eff2f7 !important">{{ $promo->name }}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12 text-center">
                                @if ($promo->discount_type == 0)
                                    <span class="font-weight-bold" style="font-size: 25pt; color: #2a3042">{{ "Rp " . number_format($promo->discount_value) }}</span>
                                @else 
                                    @if ((float)$promo->discount_max_value > 0)
                                        <span class="font-weight-bold" style="font-size: 25pt; color: #2a3042">{{ $promo->discount_value . "%"}}</span> <span style="font-weight: bold">(Max: {{number_format($promo->discount_max_value)}})</span>
                                    @else
                                        <span class="font-weight-bold" style="font-size: 25pt; color: #2a3042">{{ $promo->discount_value . "%"}}</span>
                                    @endif
                                @endif <br>
                                <span>({{ date('d M Y', strtotime($promo->active_period_start)) . " - " . date('d M Y', strtotime($promo->active_period_end)) }})</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mt-2">
                                <label class="control-label">{{ __('Reusable Voucher ? ') }} </label>
                                @if ($promo->is_reuse_voucher == 1)
                                    {{ "Yes" }}
                                @else
                                    {{ "No" }}
                                @endif
                            </div>
                            <div class="col-md-6 text-right">
                                @if ($promo->status == 1) 
                                    <span class="btn btn-sm btn-success">{{ "Active" }}</span>
                                @else 
                                    <span class="btn btn-sm btn-danger">{{ "In Active" }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row" style="margin-top: -10px">
                            <div class="col-md-12 form-group" style="font-size: 8pt">
                                @if(isset($promo->description))
                                    * {{ $promo->description }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row text-center" style="margin-bottom: 8px">
                            <div class="col-md-12 form-group">
                                <label for="" class="d-block">{{ __("Voucher List") }}</label>
                                <hr>
                                <div class="btn-group voucher_list d-block" style="max-height: 500px; overflow: scroll; border: solid 1px #f8f8fb; padding: 5px;">
                                    @if ($promo->promo_vouchers)
                                        @foreach ($promo->promo_vouchers as $item)
                                        <label class="btn btn-outline-secondary col-sm-2 m-2">{{ $item->voucher_code }}<input type="hidden" name="voucher_list[]" value="{{ $item->voucher_code }}"></label>
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
