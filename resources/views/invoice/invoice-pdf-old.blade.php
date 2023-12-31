<!DOCTYPE html>
<html>
<head>
    <title>Invoice PDF</title>
</head>
<style type="text/css">
    html, body {
        width: 5.5in;
        height: 8.5in;
        display: block;
        font-family: 'Courier New', monospace;
        font-size: 10pt;
        color: #000;
        line-height: 1.2;
        margin: 0;
        padding: 0;
        page-break-before: always;
    }
    @page {
        size: 5.5in 8.5in;
    }
    .m-0{
        margin: 0px;
    }
    .m-15{
        margin-top: 15px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .text-right{
        text-align:right !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;
    }
    .w-30{
        width:30%;
    }
    .w-85{
        width:85%;
    }
    .w-15{
        width:15%;
    }
    .w-5{
        width:5px;
    }
    .text-bold{
        font-weight: bold;
        color: #000;
    }
    .border{
        border:1px solid #000;
    }
    table tr,th,td{
        border-collapse:collapse;
        padding:7px 8px;
        color: #000;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
        color: #000;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    hr.dashed {
        border: none;
        border-top: 1px dashed #000;
        height: 2px;
        width: 100%;
    }
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-15 p-0">YOU LIAN tANG</h1>
    <h3 class="text-center m-0 p-0">Family Refleksi & Massage</h3><br>
    <p class="text-center m-0 p-0">RUKO INKOPAL BLOK C6-C7</p>
    <p class="text-center m-0 p-0">KELAPA GADING BARAT JAKARTA UTARA</p>
</div>

{{-- <hr class="dashed"> --}}

<div class="table-section bill-tbl w-100 mt-10">
    <div class="w-100 float-left mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <td class="m-0 pt-5 text-bold w-30">{{ __('Invoice Date') }}</td>
                <td class="m-0 pt-5 text-bold w-5">:</td>
                <td class="m-0 pt-5 text-bold">{{ $invoice->created_at }}</td>
            </tr>
            {{-- <tr>
                <td class="m-0 pt-5 text-bold w-30">{{ __('Treatment date') }}</td>
                <td class="m-0 pt-5 text-bold w-5">:</td>
                <td class="m-0 pt-5 text-bold">{{ $invoice->treatment_date . ' ' . $invoice->treatment_time_from . ' to ' . $invoice->treatment_time_to }}</td>
            </tr> --}}
            <tr>
                <td class="m-0 pt-5 text-bold w-30">{{ __('Customer') }}</td>
                <td class="m-0 pt-5 text-bold w-5">:</td>
                <td class="m-0 pt-5 text-bold">{{ $invoice_detail->customer_name }}</td>
            </tr>
            {{-- <tr>
                <td class="m-0 pt-5 text-bold w-30">{{ __('Therapist') }}</td>
                <td class="m-0 pt-5 text-bold w-5">:</td>
                <td class="m-0 pt-5 text-bold">{{ $invoice_detail->therapist_name }}</td>
            </tr>
            <tr>
                <td class="m-0 pt-5 text-bold w-30">{{ __('Payment Mode') }}</td>
                <td class="m-0 pt-5 text-bold w-5">:</td>
                <td class="m-0 pt-5 text-bold">{{ $invoice_detail->payment_mode }}</td>
            </tr>
            <tr>
                <td class="m-0 pt-5 text-bold w-30">{{ __('Payment Status') }}</td>
                <td class="m-0 pt-5 text-bold w-5">:</td>
                <td class="m-0 pt-5 text-bold">{{ $invoice_detail->payment_status }}</td>
            </tr> --}}
        </table>
    </div>
    <div style="clear: both;"></div>
</div>

{{-- <hr class="dashed"> --}}

<div class="table-section bill-tbl w-100 mt-10">
    {{-- <h4 style="margin-left: 7px"><strong>Invoice summary</strong></h4> --}}

    <table class="table w-100 mt-10">
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td>No</td>
            <td>Product</td>
            <td>Amount</td>
        </tr>

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
            <td></td>
        </tr>
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td colspan="2" class="text-right">{{ __('Sub Total') }}</td>
            <td class="text-right">Rp {{ number_format($sub_total) }}</td>
        </tr>
        <tr>
            <td colspan="2" class="text-right">Discount</td>
            <td class="text-right">0</td>
        </tr>
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td colspan="2" class="text-right"><strong>{{ __('Total') }}</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($sub_total) }}</strong></td>
        </tr>
    </table>
</div>
</html>
