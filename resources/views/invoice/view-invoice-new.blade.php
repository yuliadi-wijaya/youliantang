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
            size: 58mm 120mm;
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
        <a href="{{ url('invoice-pdf/' . $invoices->id) }}" class="btn btn-success waves-effect waves-light mb-4">
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
                        <div class="col-9">
                            <address>
                                <strong>{{ __('Treatment Date : ') }}</strong>{{ $invoices->treatment_date }}<br />
                                <strong>{{ __('Customer : ') }}</strong>{{ $invoices->customer_name }}<br />
                                {{-- <strong>{{ __('Is Member : ') }}</strong>@if ($invoices->is_member == 1) {{ __('Yes (').$invoices->member_plan.')' }} @else {{ __('No') }} @endif<br />
                                @foreach ($invoice_detail as $row)
                                    <strong>{{ __('Therapist : ') }}</strong> {{ $row->therapist_name }}&nbsp;
                                    <strong>{{ __('Room : ') }}</strong> {{ $row->room }}&nbsp;
                                    <strong>{{ __('Treatment Time : ') }}</strong> {{ $row->treatment_time_from }} - {{ $row->treatment_time_to }}<br />
                                @endforeach --}}
                            </address>
                        </div>
                        <div class="col-3 pull-right" style="text-align: right">
                            <address>
                                <strong>{{ __('Invoice No : ') }}</strong>{{ $invoices->invoice_code }}<br />
                                <strong>{{ __('Invoice Date : ') }}</strong>{{ $invoices->created_at }}<br />
                                {{-- <strong>{{ __('Payment Mode : ') }}</strong>{{ $invoices->payment_mode }}<br />
                                <strong>{{ __('Payment Status : ') }}</strong>{{ $invoices->payment_status }}<br /> --}}
                            </address>
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
                                    <th>{{ __('Product Name') }}</th>
                                    <th class="text-right">{{ __('Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice_detail as $row)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td class="text-right">Rp {{ number_format($row->amount) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-right">{{ __('Sub Total') }}</td>
                                    <td class="text-right">Rp {{ number_format($invoices->total_price) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right">{{ __('Discount') }}</td>
                                    <td class="text-right">Rp {{ number_format($invoices->discount) }}</td>
                                </tr>
                                @if($invoices->use_member !== 1 && $invoices->voucher_code !== '')
                                    <tr>
                                        <td colspan="2" class="text-right">{{ __('Voucer Code') }}</td>
                                        <td class="text-right">{{ $invoices->voucher_code }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="2" class="border-0 text-right">
                                        <strong>{{ __('Grand Total') }}</strong>
                                    </td>
                                    <td class="border-0 text-right">
                                        <h4 class="m-0">Rp {{ number_format($invoices->grand_total) }}</h4>
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
    <table cellpadding="0" cellspacing="0" style="margin-left: 20px;">
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
            <td>Invoice No</td>
            <td>:</td>
            <td>{{ $invoices->invoice_code }}</td>
        </tr>
        <tr>
            <td>Treatment Date</td>
            <td>:</td>
            <td>{{ $invoices->treatment_date }}</td>
        </tr>
        <tr>
            <td>Customer</td>
            <td>:</td>
            <td>{{ $invoices->customer_name }}</td>
        </tr>
        {{-- <tr>
            <td>Is Member</td>
            <td>:</td>
            <td>@if ($invoices->is_member == 1) {{ __('Yes (').$invoices->member_plan.')' }} @else {{ __('No') }} @endif</td>
        </tr>
        @foreach ($invoice_detail as $row)
            <tr>
                <td>Therapist</td>
                <td>:</td>
                <td>{{ $row->therapist_name }}</td>
            </tr>
            <tr>
                <td>Treatment Time</td>
                <td>:</td>
                <td>{{ $row->treatment_time_from }} - {{ $row->treatment_time_to }}</td>
            </tr>
        @endforeach --}}
        {{-- <tr>
            <td>Payment Mode</td>
            <td>:</td>
            <td>{{ $invoices->payment_mode }}</td>
        </tr>
        <tr>
            <td>Payment Status</td>
            <td>:</td>
            <td>{{ $invoices->payment_status }}</td>
        </tr> --}}
    </table>

    {{-- {{ str_repeat("-", 37) }} --}}

    {{-- <h6><strong>Invoice summary</strong></h6> --}}
    <br>
    <table cellpadding="0" cellspacing="0">
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td>No</td>
            <td width="200px">Product Name</td>
            <td>Amount</td>
        </tr>

        @foreach ($invoice_detail as $row)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $row->product_name }}</td>
                <td align="right">Rp {{ number_format($row->amount) }}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
        </tr>
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td colspan="2" align="right">{{ __('Sub Total') }}</td>
            <td class="text-right">Rp {{ number_format($invoices->total_price) }}</td>
        </tr>
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td colspan="2" align="right">{{ __('Discount') }}</td>
            <td class="text-right">Rp {{ number_format($invoices->discount) }}</td>
        </tr>
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td colspan="2" align="right"><strong>{{ __('Total') }}</strong></td>
            <td align="right"><strong>Rp {{ number_format($invoices->grand_total) }}</strong></td>
        </tr>
    </table>
</div>
@endsection
