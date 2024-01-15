@extends('layouts.master-layouts')
@section('title') {{ __('Invoice Details') }} @endsection
@section('body')

<body data-topbar="dark" data-layout="horizontal">
@endsection

@section('content')
<style>
    .print-invoice {
        display: none;
        width: 75mm;
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
            page-break-after: auto;
        }

        .print-invoice td {
            font-size: 8pt;
            padding: 3px 2px 3px 2px;
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
        <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light mb-4">
            <i class="fa fa-print"></i>
        </a>
        {{-- <a href="{{ url('invoice-pdf/' . $invoices->id) }}" class="btn btn-dark waves-effect waves-light mb-4">
            <i class="fa fa-file-pdf"></i>
        </a> --}}
    </div>
</div>
<div class="view-invoice">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header" style="background-color: #2a3042 !important">
                    <div class="invoice-title">
                        <div class="col-12 text-center text-white">
                            <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" width="300" style="margin:-37px 0 -60px 0">
                        </div>
                        <div class="col-12 text-center text-white mb-2" style="font-size: 10pt">
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
                                <div class="col-12 mb-1">{{ $invoices->customer_name }}</div>
                                <div class="col-12">{{ $invoices->customer_phone_number }}</div>
                            </div>
                        </div>
                        <div class="col-6 pull-right" style="text-align: right">
                            <div class="row">
                                <div class="col-12"><h5>#{{ $invoices->invoice_code }}</h5></div>
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
                                @if($invoices->discount > 0)
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            {{ __('Discount') }} 
                                            @if($invoices->use_member != 1 && $invoices->voucher_code != '')
                                            (<strong>{{ $invoices->voucher_code }}</strong>)
                                            @endif
                                        </td>
                                        <td class="text-right">Rp {{ number_format($invoices->discount) }}</td>
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
    <div class="invoice-title mb-3">
        <div class="col-12 text-center text-white">
            <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" width="225" style="margin:-30px 0 -48px 0">
        </div>
        <div class="col-12 text-center mb-2" style="font-size: 8pt">
            Ruko Inkopal Blok C6-C7
            Kelapa Gading Barat, Jakarta Utara
        </div>
    </div>
    <div class="row mb-3" style="font-size: 8pt">
        <div class="col-12 text-center font-weight-bold mb-1"><h6><strong>Receipt #{{ $invoices->invoice_code }}</strong></h6></div>
        <div class="col-6">
            <div class="row">
                <div class="col-12 mb-1 font-weight-bold">{{ date("d-m-Y", strtotime($invoices->treatment_date)); }}</div>
                <div class="col-12 font-weight-bold">{{ __('Bill To: ') }}</div>
                <div class="col-12">{{ $invoices->customer_name }}</div>
                <div class="col-12">{{ $invoices->customer_phone_number }}</div>
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
    <table cellpadding="0" cellspacing="0" style="width: 100%">
        <tr style="border-top:1px dashed grey; border-bottom:1px dashed grey">
            <td class="font-weight-bold">Product Name</td>
            <td class="font-weight-bold" style="width: 90px; text-align:right">Amount</td>
        </tr>

        @foreach ($invoice_detail as $row)
            <tr>
                <td>{{ $row->product_name }}</td>
                <td class="text-right">Rp {{ number_format($row->amount) }}</td>
            </tr>
        @endforeach
        <tr style="border-top:1px dashed grey;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <div class="row" style="font-size: 8pt; margin-top: -10px">
        <div class="col-6 mb-1">{{ __('Sub Total') }}</div>
        <div class="col-6 mb-1 text-right">Rp {{ number_format($invoices->total_price) }}</div>

        @if($invoices->discount > 0)
            <div class="col-6 mb-1">{{ __('Discount') }}</div>
            <div class="col-6 mb-1 text-right">Rp {{ number_format($invoices->discount) }}</div>
        @endif

        @if($invoices->tax_amount > 0)
            <div class="col-6 mb-1">{{ __('PPN ('.$invoices->tax_rate.'%)') }}</div>
            <div class="col-6 mb-1 text-right">Rp {{ number_format($invoices->tax_amount) }}</div>
        @endif
        <div class="col-6 mb-1"><h6><strong>{{ __('Total') }}</strong></h6></div>
        <div class="col-6 mb-1 text-right"><h6><strong>Rp {{ number_format($invoices->grand_total) }}</strong></h6></div>
    </div>
    <div class="row mt-3" style="font-size: 8pt">
        <div class="col-12 text-center font-weight-bold">Thank you for your visit</div>
    </div>
</div>
@endsection
