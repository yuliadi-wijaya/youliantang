@extends('layouts.master-layouts')
@section('title') {{ __('Invoice Details') }} @endsection
@section('body')

<body data-topbar="dark" data-layout="horizontal">
@endsection

@section('content')
<style>
    .print-invoice {
        display: none;
        /* width: 75mm; */
        width: 139mm;
        color: black !important;
        font-size: 15pt !important;
        padding: -5px;
        font-family: 'courier';
        margin: 0;
    }

    #table-content-invoice td {
        font-size: 15pt;
    }

    @media print {
        .view-invoice {
            display: none;
        }

        @page {
            /* size: 58mm 120mm; */
            size: 100mm 200mm;
            margin: 0;
        }
        body {
            font-family: 'courier';
            margin: 0;
            color: black !important;
        }
        .print-invoice {
            display: block;
            margin: 0;
            page-break-after: auto;
        }

        .print-invoice td {
            font-size: 8pt;
            padding: 8px 2px 8px 2px;
            white-space: pre-line;
            word-wrap: break-word;
            vertical-align: top;
        }

        .padding-custom {
            padding-top: 3px !important;
            padding-bottom: 3px !important;
        }
    }
</style>
<!-- start page title -->
@component('components.breadcrumb')
@slot('title') Invoice Details @endslot
@slot('li_1') Dashboard @endslot
@slot('li_2') Invoice List @endslot
@slot('li_3') Invoice Details @endslot
@endcomponent
<!-- end page title -->
<div class="row d-print-none">
    <div class="col-12">
        @if ($role == 'admin' || $role == 'receptionist') 
            <a href="{{ url('invoice') }}">
                <button type="button" class="btn btn-secondary waves-effect waves-light mb-4">
                    <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Invoice List') }}
                </button>
            </a>
            <a href="{{ url('invoice/'. $invoices->id . '/edit') }}" class="btn btn-warning waves-effect waves-light mb-4">
                <i class="fa fa-pencil-alt"></i>
            </a>
            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4">
                <i class="fa fa-print"></i>
            </a>
        @endif
        {{-- <a href="{{ url('invoice-pdf/' . $invoices->id) }}" class="btn btn-dark waves-effect waves-light mb-4">
            <i class="fa fa-file-pdf"></i>
        </a> --}}
    </div>
</div>
<div class="view-invoice mb-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header" style="background-color: #2a3042 !important">
                    <div class="invoice-title">
                        <div class="col-12 text-center text-white">
                            <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" width="250" style="margin:-31px 0 -51px 0">
                        </div>
                        <div class="col-12 text-center text-white mb-2" style="font-size: 9pt">
                            Ruko Inkopal Blok C6-C7, Kelapa Gading Barat, Jakarta Utara
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12 mb-1"><strong>{{ __('Receptionist : ') }}</strong>{{ $receptionist->first_name . " " . $receptionist->last_name }}</div>
                                <div class="col-12 mb-1"><strong>{{ __('Bill To : ') }}</strong></div>
                                <div class="col-12 mb-1">{{ ucwords($invoices->customer_name) }}</div>
                                <div class="col-12">{{ $invoices->customer_phone_number }}</div>
                            </div>
                        </div>
                        <div class="col-6 pull-right" style="text-align: right">
                            <div class="row">
                                <div class="col-12"><h4>#{{ $invoices->invoice_code }}</h4></div>
                                <div class="col-12 mb-1"><strong>{{ __('Invoice Date : ') }}</strong>{{ date("d-m-Y", strtotime($invoices->treatment_date)); }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2 mt-3">
                        <h3 class="font-size-15 font-weight-bold">{{ __('Invoice Summary') }}</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">{{ __('No.') }}</th>
                                    <th>{{ __('Treatment') }}</th>
                                    <th class="text-right">{{ __('Price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice_detail as $row)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td><span style="font-weight:500">{{ $row->product_name }}</span> / {{ $row->therapist_name . ' / ' . $row->room . ' / ' . substr($row->treatment_time_from,0,5) . '-' . substr($row->treatment_time_to,0,5) }} </td>
                                        <td class="text-right">Rp {{ number_format($row->amount) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-right">{{ __('Sub Total') }}</td>
                                    <td class="text-right">Rp {{ number_format($invoices->total_price) }}</td>
                                </tr>
                                @if($invoices->discount > 0)
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            {{ __('Discount') }} 
                                            @if($invoices->use_member != 1 && $invoices->voucher_code != '')
                                            (<strong>{{ $invoices->voucher_code }}</strong>)
                                            @endif
                                        </td>
                                        <td class="text-right">- Rp {{ number_format($invoices->discount) }}</td>
                                    </tr>
                                @endif
                                @if($invoices->additional_price > 0)
                                    <tr>
                                        <td colspan="2" class="text-right">{{ __('Additional Charge (*excluded discount)') }}</td>
                                        <td class="text-right">Rp {{ number_format($invoices->additional_price) }}</td>
                                    </tr>
                                @endif
                                @if($invoices->tax_amount > 0)
                                    <tr>
                                        <td colspan="2" class="text-right">{{ __('PPN ('.$invoices->tax_rate.'%)') }}</td>
                                        <td class="text-right">Rp {{ number_format($invoices->tax_amount) }}</td>
                                    </tr>
                                @endif
                                <tr style="border-top: 1px solid #2a3042;">
                                    <td colspan="2" class="border-0 text-right">
                                        <h3>{{ __('Total') }}</h3>
                                    </td>
                                    <td class="border-0 text-right">
                                        <h3 class="m-0">Rp {{ number_format($invoices->grand_total) }}</h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="print-invoice">
    <div class="invoice-title">
        <div class="text-center">
            <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" width="295" style="margin:-65px 0 -62px 0">
        </div>
    </div>
    <div class="invoice-address">
        <div class="text-center text-black font-weight-bold" style="color:black; font-size: 13pt;">
            Ruko Inkopal Blok C6-C7, Kelapa Gading Barat, Jakarta Utara
        </div>
    </div>
    <div class="row mt-5 mb-3">
        <div class="col-12 text-center font-weight-bold mb-3" style="font-size: 16pt"><strong>Receipt #{{ $invoices->invoice_code }}</strong></div>
        <div class="col-6">
            <div class="row">
                <div class="col-12 mb-1 font-weight-bold">{{ date("d-m-Y", strtotime($invoices->treatment_date)); }}</div>
                <div class="col-12 font-weight-bold">{{ __('Bill To: ') }}</div>
                <div class="col-12">{{ ucwords($invoices->customer_name) }}</div>
                <div class="col-12">{{ substr_replace($invoices->customer_phone_number, '****', 5, 4) }}</div>
            </div>
        </div>
        <div class="col-6 pull-right" style="text-align: right">
            <div class="row">
                <div class="col-12 mb-1 font-weight-bold">{{ date("H:m", strtotime($invoices->created_at)); }}</div>
                <div class="col-12 font-weight-bold">{{ __('Cashier: ') }}</div>
                <div class="col-12">{{ $receptionist->first_name . " " . $receptionist->last_name }}</div>
            </div>
        </div>
    </div>
    <table id="table-content-invoice" cellpadding="0" cellspacing="0" style="width: 100%;">
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black;">
            <td class="font-weight-bold">Treatment</td>
            <td class="font-weight-bold" style="width: 100px; text-align:right">Price</td>
        </tr>

        @foreach ($invoice_detail as $row)
            <tr>
                <td>{{ $row->product_name }}</td>
                <td class="text-right">{{ number_format($row->amount) }}</td>
            </tr>
        @endforeach

        <tr style="border-top:1px dashed black;">
            <td class="padding-custom" style="padding-top: 8px !important">{{ __('Sub Total') }}</td>
            <td class="text-right padding-custom" style="padding-top: 8px !important">{{ number_format($invoices->total_price) }}</td>
        </tr>

        @if($invoices->discount > 0)
        <tr>
            <td class="padding-custom">{{ __('Discount') }}</td>
            <td class="text-right padding-custom" style="padding-top:0px !important; padding-bottom:0px !important;">- {{ number_format($invoices->discount) }}</td>
        </tr>
        @endif

        @if($invoices->additional_price > 0)
        <tr>
            <td class="padding-custom">{{ __('Additional Charge') }}</td>
            <td class="text-right padding-custom">{{ number_format($invoices->additional_price) }}</td>
        </tr>
        @endif

        @if($invoices->tax_amount > 0)
        <tr>
            <td class="padding-custom">{{ __('PPN ('.$invoices->tax_rate.'%)') }}</td>
            <td class="text-right padding-custom">{{ number_format($invoices->tax_amount) }}</td>
        </tr>
        @endif

        <tr style="border-top:1px dashed black; border-bottom:1px dashed black;">
            <td class="font-weight-bold">{{ __('TOTAL') }}</td>
            <td class="font-weight-bold text-right" style="font-size:15pt !important;">{{ number_format($invoices->grand_total) }}</td>
        </tr>
    </table>
    {{-- <div class="row" style="margin-top: -27px;">
        <div class="col-6 mb-1">{{ __('Sub Total') }}</div>
        <div class="col-6 mb-1 text-right">{{ number_format($invoices->total_price) }}</div>

        @if($invoices->discount > 0)
            <div class="col-6 mb-1">{{ __('Discount') }}</div>
            <div class="col-6 mb-1 text-right">- {{ number_format($invoices->discount) }}</div>
        @endif

        @if($invoices->additional_price > 0)
            <div class="col-6 mb-1">{{ __('Additional Fee') }}</div>
            <div class="col-6 mb-1 text-right">{{ number_format($invoices->additional_price) }}</div>
        @endif

        @if($invoices->tax_amount > 0)
            <div class="col-6 mb-1">{{ __('PPN ('.$invoices->tax_rate.'%)') }}</div>
            <div class="col-6 mb-1 text-right">{{ number_format($invoices->tax_amount) }}</div>
        @endif
        <div class="col-6 mb-1"><strong>{{ __('Total') }}</strong></div>
                <div class="col-6 mb-1 text-right"><strong>{{ number_format($invoices->grand_total) }}</strong></div>
    </div> --}}
    <div class="row mt-5">
        <div class="col-12 text-center font-weight-bold">Thank you for your visit</div>
    </div>
</div>
@endsection
