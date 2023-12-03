@extends('layouts.master-layouts')
@section('title') {{ __('Report Therapist Transaction History Detail') }} @endsection
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
            @slot('title') Report Therapist Transaction History Detail @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Therapists @endslot
            @slot('li_4') Report Therapist Transaction History Detail @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="{{ url('/rf-therapist-trans') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Filter Therapist Transaction History Detail') }}
                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="{{ route('ex-therapist-trans') }}" method="GET" style="display: none;">
                    @csrf

                    <input type="hidden" name="dateFrom" value="{{ $dateFrom }}">
                    <input type="hidden" name="dateTo" value="{{ $dateTo }}">
                    <input type="hidden" name="report_type" value="{{ $report_type }}">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <div class="mb-4">
                                <h4><strong>{{ __('Report Status = ') . ($report_type == 'detail' ? 'Detail' : 'Summary') }}</strong></h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                        </div>
                        <div class="table-responsive">
                            <table class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th class="no-wrap">{{ __('Therapist Name') }}</th>
                                        <th class="no-wrap">{{ __('Phone Number') }}</th>
                                        <th class="no-wrap">{{ __('Email') }}</th>
                                        <th class="no-wrap">{{ __('Invoice Code') }}</th>
                                        <th class="no-wrap">{{ __('Treatment Date') }}</th>
                                        <th class="no-wrap">{{ __('Payment Mode') }}</th>
                                        <th class="no-wrap">{{ __('Payment Status') }}</th>
                                        <th class="no-wrap">{{ __('Note') }}</th>
                                        <th class="no-wrap">{{ __('Voucher Code') }}</th>
                                        <th class="no-wrap">{{ __('Total Price') }}</th>
                                        <th class="no-wrap">{{ __('Discount') }}</th>
                                        <th class="no-wrap">{{ __('Grand Total') }}</th>
                                        <th class="no-wrap">{{ __('Amount') }}</th>
                                        <th class="no-wrap">{{ __('Product Name') }}</th>
                                        <th class="no-wrap">{{ __('Duration') }}</th>
                                        <th class="no-wrap">{{ __('Commission Fee') }}</th>
                                        <th class="no-wrap">{{ __('Customer Name') }}</th>
                                        <th class="no-wrap">{{ __('Room') }}</th>
                                        <th class="no-wrap">{{ __('Time From') }}</th>
                                        <th class="no-wrap">{{ __('Time To') }}</th>
                                        <th class="no-wrap">{{ __('Invoice Type') }}</th>
                                        <th class="no-wrap">{{ __('Rating') }}</th>
                                        <th class="no-wrap">{{ __('Comment') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sub_price = 0;
                                        $sub_discount = 0;
                                        $sub_grand_total = 0;
                                        $sub_fee = 0;
                                    @endphp

                                    @foreach ($report as $index => $row)
                                        @if ($index > 0 && $row->therapist_id == $report[$index - 1]->therapist_id)
                                            @php
                                                $therapist_name = '';
                                                $phone_number = '';
                                                $email = '';
                                            @endphp
                                        @else
                                            @php
                                                $therapist_name = $row->therapist_name;
                                                $phone_number = $row->phone_number;
                                                $email = $row->email;
                                            @endphp
                                        @endif

                                        @if ($index > 0 && $row->therapist_id == $report[$index - 1]->therapist_id && $row->invoice_code == $report[$index - 1]->invoice_code)
                                            @php
                                                $invoice_code = '';
                                                $treatment_date = '';
                                                $payment_mode = '';
                                                $payment_status = '';
                                                $note = '';
                                                $voucher_code = '';
                                                $total_price = '';
                                                $discount = '';
                                                $grand_total = '';
                                            @endphp
                                        @else
                                            @php
                                                $invoice_code = $row->invoice_code;
                                                $treatment_date = $row->treatment_date;
                                                $payment_mode = $row->payment_mode;
                                                $payment_status = $row->payment_status;
                                                $note = $row->note;
                                                $voucher_code = $row->voucher_code;
                                                $total_price = 'Rp. '. number_format($row->total_price, 0, ',', '.');
                                                $discount = 'Rp. '. number_format($row->discount, 0, ',', '.');
                                                $grand_total = 'Rp. '. number_format($row->grand_total, 0, ',', '.');

                                                $sub_price = $sub_price + $row->total_price;
                                                $sub_discount = $sub_discount + $row->discount;
                                                $sub_grand_total = $sub_grand_total + $row->grand_total;
                                            @endphp
                                        @endif

                                        @php
                                            $sub_fee = $sub_fee + $row->commission_fee;
                                        @endphp

                                        <tr>
                                            <td class="no-wrap">{{ $therapist_name }}</td>
                                            <td class="no-wrap">{{ $phone_number }}</td>
                                            <td class="no-wrap">{{ $email }}</td>
                                            <td class="no-wrap">{{ $invoice_code }}</td>
                                            <td class="no-wrap">{{ $treatment_date }}</td>
                                            <td class="no-wrap">{{ $payment_mode }}</td>
                                            <td class="no-wrap">{{ $payment_status }}</td>
                                            <td class="no-wrap">{{ $note }}</td>
                                            <td class="no-wrap">{{ $voucher_code }}</td>
                                            <td class="no-wrap">{{ $total_price }}</td>
                                            <td class="no-wrap">{{ $discount }}</td>
                                            <td class="no-wrap">{{ $grand_total }}</td>
                                            <td class="no-wrap">Rp. {{ number_format($row->amount, 0, ',', '.') }}</td>
                                            <td class="no-wrap">{{ $row->product_name }}</td>
                                            <td class="no-wrap">{{ $row->duration }} Minutes</td>
                                            <td class="no-wrap">Rp. {{ number_format($row->commission_fee, 0, ',', '.') }}</td>
                                            <td class="no-wrap">{{ $row->customer_name }}</td>
                                            <td class="no-wrap">{{ $row->room }}</td>
                                            <td class="no-wrap">{{ $row->time_from }}</td>
                                            <td class="no-wrap">{{ $row->time_to }}</td>
                                            <td class="no-wrap">{{ $row->invoice_type }}</td>
                                            <td class="no-wrap">{{ $row->rating }}</td>
                                            <td class="no-wrap">{{ $row->comment }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="8">&nbsp;</th>
                                        <th class="no-wrap">{{ __('Total') }}</th>
                                        <th class="no-wrap">Rp. {{ number_format($sub_price, 0, ',', '.') }}</th>
                                        <th class="no-wrap">Rp. {{ number_format($sub_discount, 0, ',', '.') }}</th>
                                        <th class="no-wrap">Rp. {{ number_format($sub_grand_total, 0, ',', '.') }}</th>
                                        <th class="no-wrap" colspan="3">&nbsp;</th>
                                        <th class="no-wrap">Rp. {{ number_format($sub_fee, 0, ',', '.') }}</th>
                                        <th class="no-wrap" colspan="7">&nbsp;</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
