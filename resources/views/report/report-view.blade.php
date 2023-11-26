@extends('layouts.master-layouts')
@section('title') {{ __('Report View') }} @endsection
@section('body')

    <style>
        .no-wrap {
            white-space: nowrap;
        }
    </style>

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Report View @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Invoice @endslot
            @slot('li_3') Report View @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="{{ url('/report-filter') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Report Filter') }}
                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="{{ route('report-export') }}" method="GET" style="display: none;">
                    @csrf

                    <input type="hidden" name="dateFrom" value="{{ $dateFrom }}">
                    <input type="hidden" name="dateTo" value="{{ $dateTo }}">
                    <input type="hidden" name="payment_status" value="{{ $pay_status }}">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <div class="mb-4">
                                <h4><strong>{{ __('Report') . ' ' . date('d M Y', strtotime($dateFrom)) . ' - ' . date('d M Y', strtotime($dateTo)) }}</strong></h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                        </div>
                        <div class="table-responsive">
                            <table class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th class="no-wrap">{{ __('Invoice No') }}</th>
                                        <th class="no-wrap">{{ __('Invoice Date') }}</th>
                                        <th class="no-wrap">{{ __('Customer Name') }}</th>
                                        <th class="no-wrap">{{ __('Customer Phone') }}</th>
                                        <th class="no-wrap">{{ __('Payment Mode') }}</th>
                                        <th class="no-wrap">{{ __('Payment Status') }}</th>
                                        <th class="no-wrap">{{ __('Note') }}</th>
                                        <th class="no-wrap">{{ __('Total_price') }}</th>
                                        <th class="no-wrap">{{ __('Discount') }}</th>
                                        <th class="no-wrap">{{ __('Grand Total') }}</th>
                                        <th class="no-wrap">{{ __('Product Name') }}</th>
                                        <th class="no-wrap">{{ __('Amount') }}</th>
                                        <th class="no-wrap">{{ __('Duration') }}</th>
                                        <th class="no-wrap">{{ __('Treatment Date') }}</th>
                                        <th class="no-wrap">{{ __('Treatment Time From') }}</th>
                                        <th class="no-wrap">{{ __('Treatment Time To') }}</th>
                                        <th class="no-wrap">{{ __('Room') }}</th>
                                        <th class="no-wrap">{{ __('Therapist Name') }}</th>
                                        <th class="no-wrap">{{ __('Therapist Phone') }}</th>
                                        <th class="no-wrap">{{ __('Commission Fee') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sub_price = 0;
                                        $sub_discount = 0;
                                        $sub_grand_total = 0;
                                    @endphp
                                    @foreach ($report as $index => $row)

                                        @if ($index > 0 && $row->invoice_code == $report[$index - 1]->invoice_code)
                                            @php
                                                $invoice_code = '';
                                                $invoice_date = '';
                                                $customer_name = '';
                                                $customer_phone_number = '';
                                                $payment_mode = '';
                                                $payment_status = '';
                                                $note = '';
                                                $total_price = '';
                                                $discount = '';
                                                $grand_total = '';
                                            @endphp
                                        @else
                                            @php
                                                $invoice_code = $row->invoice_code;
                                                $invoice_date = $row->invoice_date;
                                                $customer_name = $row->customer_name;
                                                $customer_phone_number = $row->customer_phone_number;
                                                $payment_mode = $row->payment_mode;
                                                $payment_status = $row->payment_status;
                                                $note = $row->note;
                                                $total_price = $row->total_price;
                                                $discount = $row->discount;
                                                $grand_total = $row->grand_total;

                                                $sub_price = $sub_price + $total_price;
                                                $sub_discount = $sub_discount + $discount;
                                                $sub_grand_total = $sub_grand_total + $grand_total;
                                            @endphp
                                        @endif

                                        <tr>
                                            <td class="no-wrap">{{ $invoice_code }}</td>
                                            <td class="no-wrap">{{ ($total_price !== '') ? date('d-m-Y', strtotime($invoice_date)) : '' }}</td>
                                            <td class="no-wrap">{{ $customer_name }}</td>
                                            <td class="no-wrap">{{ $customer_phone_number }}</td>
                                            <td class="no-wrap">{{ $payment_mode }}</td>
                                            <td class="no-wrap">{{ $payment_status }}</td>
                                            <td class="no-wrap">{{ $note }}</td>
                                            <td class="no-wrap">{{ ($total_price !== '') ? 'Rp. '.number_format($total_price, 2) : '' }}</td>
                                            <td class="no-wrap">{{ ($discount !== '') ? 'Rp. '.number_format($discount, 2) : '' }}</td>
                                            <td class="no-wrap">{{ ($grand_total !== '') ? 'Rp. '.number_format($grand_total, 2) : '' }}</td>
                                            <td class="no-wrap">{{ $row->product_name }}</td>
                                            <td class="no-wrap">Rp. {{ number_format($row->amount, 0, ',', '.') }}</td>
                                            <td class="no-wrap">{{ $row->duration }}</td>
                                            <td class="no-wrap">{{ date('d-m-Y', strtotime($row->treatment_date)) }}</td>
                                            <td class="no-wrap">{{ $row->treatment_time_from }}</td>
                                            <td class="no-wrap">{{ $row->treatment_time_to }}</td>
                                            <td class="no-wrap">{{ $row->room }}</td>
                                            <td class="no-wrap">{{ $row->therapist_name }}</td>
                                            <td class="no-wrap">{{ $row->therapist_phone_number }}</td>
                                            <td class="no-wrap">Rp. {{ number_format($row->commission_fee, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
