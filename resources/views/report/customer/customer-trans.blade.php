@extends('layouts.master-layouts')
@section('title') {{ __('Report Customers') }} @endsection
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
            @slot('title') Report Customer Transaction History @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_2') Customers @endslot
            @slot('li_3') Report Customer Transaction History @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="{{ url('/rf-customer-trans') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Filter Customer Transaction History') }}
                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="{{ route('ex-customer-trans') }}" method="GET" style="display: none;">
                    @csrf

                    <input type="hidden" name="dateFrom" value="{{ $dateFrom }}">
                    <input type="hidden" name="dateTo" value="{{ $dateTo }}">
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
                                        <th class="no-wrap">{{ __('Customer Name') }}</th>
                                        <th class="no-wrap">{{ __('Phone Number') }}</th>
                                        <th class="no-wrap">{{ __('Email') }}</th>
                                        <th class="no-wrap">{{ __('Invoice Code') }}</th>
                                        <th class="no-wrap">{{ __('Treatment Date') }}</th>
                                        <th class="no-wrap">{{ __('Payment Mode') }}</th>
                                        <th class="no-wrap">{{ __('Payment Status') }}</th>
                                        <th class="no-wrap">{{ __('Note') }}</th>
                                        <th class="no-wrap">{{ __('Is Member') }}</th>
                                        <th class="no-wrap">{{ __('Use Member') }}</th>
                                        <th class="no-wrap">{{ __('Member Plan') }}</th>
                                        <th class="no-wrap">{{ __('Voucher Code') }}</th>
                                        <th class="no-wrap">{{ __('Total Price') }}</th>
                                        <th class="no-wrap">{{ __('Discount') }}</th>
                                        <th class="no-wrap">{{ __('Grand Total') }}</th>
                                        <th class="no-wrap">{{ __('Product Name') }}</th>
                                        <th class="no-wrap">{{ __('Amount') }}</th>
                                        <th class="no-wrap">{{ __('Therapist Name') }}</th>
                                        <th class="no-wrap">{{ __('Room') }}</th>
                                        <th class="no-wrap">{{ __('Time From') }}</th>
                                        <th class="no-wrap">{{ __('Time To') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sub_price = 0;
                                        $sub_discount = 0;
                                        $sub_grand_total = 0;
                                    @endphp
                                    @foreach ($report as $index => $row)
                                        @if ($index > 0 && $row->customer_id == $report[$index - 1]->customer_id)
                                            @php
                                                $customer_name = '';
                                                $phone_number = '';
                                                $email = '';
                                            @endphp
                                        @else
                                            @php
                                                $customer_name = $row->customer_name;
                                                $phone_number = $row->phone_number;
                                                $email = $row->email;
                                            @endphp
                                        @endif

                                        @php
                                            $treatment_date = date('d-m-Y', strtotime($row->treatment_date));
                                            $total_price = 'Rp. '. number_format($row->total_price, 0, ',', '.');
                                            $discount = 'Rp. '. number_format($row->discount, 0, ',', '.');
                                            $grand_total = 'Rp. '. number_format($row->grand_total, 0, ',', '.');

                                            $sub_price = $sub_price + $row->total_price;
                                            $sub_discount = $sub_discount + $row->discount;
                                            $sub_grand_total = $sub_grand_total + $row->grand_total;
                                        @endphp

                                        <tr>
                                            <td class="no-wrap">{{ $customer_name }}</td>
                                            <td class="no-wrap">{{ $phone_number }}</td>
                                            <td class="no-wrap">{{ $email }}</td>
                                            <td class="no-wrap">{{ $row->invoice_code }}</td>
                                            <td class="no-wrap">{{ $treatment_date }}</td>
                                            <td class="no-wrap">{{ $row->payment_mode }}</td>
                                            <td class="no-wrap">{{ $row->payment_status }}</td>
                                            <td class="no-wrap">{{ $row->note }}</td>
                                            <td class="no-wrap">{{ $row->is_member }}</td>
                                            <td class="no-wrap">{{ $row->use_member }}</td>
                                            <td class="no-wrap">{{ $row->member_plan }}</td>
                                            <td class="no-wrap">{{ $row->voucher_code }}</td>
                                            <td class="no-wrap">{{ $total_price}}</td>
                                            <td class="no-wrap">{{ $discount }}</td>
                                            <td class="no-wrap">{{ $grand_total }}</td>
                                            <td class="no-wrap">&nbsp;</td>
                                            <td class="no-wrap">&nbsp;</td>
                                            @if ($row->old_data == 'Y')
                                                <td class="no-wrap">{{ $row->therapist_name }}</td>
                                                <td class="no-wrap">{{ $row->room }}</td>
                                                <td class="no-wrap">{{ $row->time_from }}</td>
                                                <td class="no-wrap">{{ $row->time_to }}</td>
                                            @else
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                            @endif
                                        </tr>

                                        @foreach ($report_detail[$row->invoice_id] as $rd)
                                            <tr>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                @if ($row->old_data == 'Y')
                                                    <td class="no-wrap">{{ $rd->product_name }}</td>
                                                    <td class="no-wrap">Rp. {{ number_format($rd->amount, 0, ',', '.') }}</td>
                                                    <td class="no-wrap">&nbsp;</td>
                                                    <td class="no-wrap">&nbsp;</td>
                                                    <td class="no-wrap">&nbsp;</td>
                                                    <td class="no-wrap">&nbsp;</td>
                                                @else
                                                    <td class="no-wrap">{{ $rd->product_name }}</td>
                                                    <td class="no-wrap">Rp. {{ number_format($rd->amount, 0, ',', '.') }}</td>
                                                    <td class="no-wrap">{{ $rd->therapist_name }}</td>
                                                    <td class="no-wrap">{{ $rd->room }}</td>
                                                    <td class="no-wrap">{{ $rd->treatment_time_from }}</td>
                                                    <td class="no-wrap">{{ $rd->treatment_time_to }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="11">&nbsp;</th>
                                        <th class="no-wrap">{{ __('Total') }}</th>
                                        <th class="no-wrap">Rp. {{ number_format($sub_price, 0, ',', '.') }}</th>
                                        <th class="no-wrap">Rp. {{ number_format($sub_discount, 0, ',', '.') }}</th>
                                        <th class="no-wrap">Rp. {{ number_format($sub_grand_total, 0, ',', '.') }}</th>
                                        <th class="no-wrap" colspan="6">&nbsp;</th>
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
