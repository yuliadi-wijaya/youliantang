@extends('layouts.master-layouts')
@section('title') {{ __('Invoice Details') }} @endsection
@section('body')

<body data-topbar="dark" data-layout="horizontal">
@endsection

@section('content')
<style>
    .print-invoice {
        display: none;
    }

    @media print {
        .view-invoice {
            display: none;
        }

        @page {
            size: 58mm 110mm;
            margin: 0;
        }
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
        }
        .print-invoice {
            display: block;
            margin: 0;
            padding: 0;
            page-break-after: auto;
        }

        .print-invoice td {
            font-size: 9pt;
            padding: 2px;
            white-space: pre-line;
            word-wrap: break-word;
            vertical-align: top;
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
        <a href="{{ url('invoice') }}">
            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Invoice List') }}
            </button>
        </a>
        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4">
            <i class="fa fa-print"></i>
        </a>
        <a href="{{ url('invoice-pdf/' . $invoice->id) }}" class="btn btn-success waves-effect waves-light mb-4">
            <i class="fa fa-file-pdf"></i>
        </a>
    </div>
</div>
<div class="view-invoice">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-right font-size-16">{{ __('INVOICE') }}</h4>
                        <div class="mb-4">
                            <h3>YOU LIAN tANG</h3>
                            <h6>Family Refleksi & Massage</h6>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-3">
                            <address>
                                <strong>{{ __('Treatment Date : ') }}</strong>{{ $invoice->treatment_date . ' ' . $invoice->treatment_time_from . ' to ' . $invoice->treatment_time_to }}<br>
                                <strong>{{ __('Customer : ') }}</strong>{{ $invoice_detail->customer_name }}<br>
                                {{-- <strong>{{ __('Therapist : ') }}</strong>{{ $invoice_detail->therapist_name }}<br> --}}
                            </address>
                        </div>
                        <div class="col-3">
                            <address>

                            </address>
                        </div>
                        <div class="col-3">
                            <address>

                            </address>
                        </div>
                        <div class="col-3 pull-right" style="text-align: right">
                            <address>
                                <strong>{{ __('Invoice Date : ') }}</strong>{{ $invoice->created_at }}<br>
                                {{-- <strong>{{ __('Payment Mode : ') }}</strong>{{ $invoice_detail->payment_mode }}<br>
                                <strong>{{ __('Payment Status : ') }}</strong>{{ $invoice_detail->payment_status }}<br> --}}
                            </address>
                        </div>
                    </div>

                    <div class="py-2 mt-3">
                        <h3 class="font-size-15 font-weight-bold">{{ __('Invoice summary') }}</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">{{ __('No.') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th class="text-right">{{ __('Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $sub_total = 0;
                                @endphp
                                @foreach ($invoice_detail->invoice_detail as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td class="text-right">Rp {{ number_format($item->amount) }}</td>
                                </tr>
                                @php
                                $sub_total += $item->amount;
                                @endphp
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-right">{{ __('Sub Total') }}</td>
                                    <td class="text-right">Rp {{ number_format($sub_total) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border-0 text-right">
                                        <strong>{{ __('Total') }}</strong>
                                    </td>
                                    <td class="border-0 text-right">
                                        <h4 class="m-0">Rp {{ number_format($sub_total) }}</h4>
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
    <table cellpadding="0" cellspacing="0" style="margin-left: 20px">
        <tr>
            <td style="text-align:center"><span style="font-weight: bold; font-size:13pt">YOU LIAN tANG<span>
                <span style="font-weight: bold; font-size:10pt;">FAMILY REFLEXOLOGY AND MASSAGE</span></td>
        </tr>
        <tr>
            <td style="text-align:center"><span>RUKO INKOPAL BLOK C6-C7</span>
                <span>KELAPA GADING BARAT JAKARTA UTARA</span>
            </td>
        </tr>
    </table>

    {{-- {{ str_repeat("-", 37) }} --}}
    <br>
    <table cellpadding="0" cellspacing="0" style="font-weight: bold">
        <tr>
            <td>Treatment Date</td>
            <td>:</td>
            <td>{{ $invoice->treatment_date }}</td>
        </tr>
        <tr>
            <td>Treatment Time</td>
            <td>:</td>
            <td>{{ $invoice->treatment_time_from . ' to ' . $invoice->treatment_time_to }}</td>
        </tr>
        <tr>
            <td>Customer</td>
            <td>:</td>
            <td>{{ $invoice_detail->customer_name }}</td>
        </tr>
        {{-- <tr>
            <td>Therapist</td>
            <td>:</td>
            <td>{{ $invoice_detail->therapist_name }}</td>
        </tr>
        <tr>
            <td>Payment Mode</td>
            <td>:</td>
            <td>{{ $invoice_detail->payment_mode }}</td>
        </tr>
        <tr>
            <td>Payment Status</td>
            <td>:</td>
            <td>{{ $invoice_detail->payment_status }}</td>
        </tr> --}}
    </table>

    {{-- {{ str_repeat("-", 37) }} --}}

    {{-- <h6><strong>Invoice summary</strong></h6> --}}
    <br>
    <table cellpadding="0" cellspacing="0">
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td>No</td>
            <td width="200px">Product</td>
            <td>Amount</td>
        </tr>

        @php
            $sub_total = 0;
        @endphp

        @foreach ($invoice_detail->invoice_detail as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item->title }}</td>
                <td align="right">Rp {{ number_format($item->amount) }}</td>
            </tr>
            @php
                $sub_total += $item->amount;
            @endphp
        @endforeach
        <tr>
            <td></td>
        </tr>
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td colspan="2" align="right">{{ __('Sub Total') }}</td>
            <td class="text-right">Rp {{ number_format($sub_total) }}</td>
        </tr>
        <tr>
            <td colspan="2" align="right">Discount</td>
            <td class="text-right">0</td>
        </tr>
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td colspan="2" align="right"><strong>{{ __('Total') }}</strong></td>
            <td align="right"><strong>Rp {{ number_format($sub_total) }}</strong></td>
        </tr>
    </table>
</div>
@endsection
