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
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Filter Therapist Transaction') }}
                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="{{ route('ex-therapist-trans') }}" method="GET" style="display: none;">
                    @csrf

                    <input type="hidden" name="report_type" value="{{ $report_type }}">
                    <input type="hidden" name="filter_display" value="{{ $filter_display }}">
                    <input type="hidden" name="daily" value="{{ $daily }}">
                    <input type="hidden" name="monthly" value="{{ $monthly }}">
                    <input type="hidden" name="yearly" value="{{ $yearly }}">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <div class="mb-4" style="text-align: center;">
                                <strong>
                                    <h4>{{ ucfirst($report_type) . ' ' .ucfirst($filter_display) . ' Report' }}</h4>
                                    <h5>
                                        @if ($filter_display === 'daily')
                                            {{ \Carbon\Carbon::parse($daily)->format('d F Y') }}
                                        @elseif ($filter_display === 'monthly')
                                            {{ \Carbon\Carbon::parse($monthly)->format('F Y') }}
                                        @elseif ($filter_display === 'yearly')
                                            {{ $yearly }}
                                        @endif
                                    </h5>
                                </strong>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                        </div>
                        <div class="table-responsive">
                            <table class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th class="no-wrap">{{ __('Invoice Code') }}</th>
                                        <th class="no-wrap">{{ __('Customer Name') }}</th>
                                        <th class="no-wrap">{{ __('Treatment Date') }}</th>
                                        <th class="no-wrap">{{ __('Payment Mode') }}</th>
                                        <th class="no-wrap">{{ __('Payment Status') }}</th>
                                        <th class="no-wrap">{{ __('Note') }}</th>
                                        <th class="no-wrap">{{ __('Voucher Code') }}</th>
                                        <th class="no-wrap">{{ __('Total Price') }}</th>
                                        <th class="no-wrap">{{ __('Discount') }}</th>
                                        <th class="no-wrap">{{ __('PPN (%)') }}</th>
                                        <th class="no-wrap">{{ __('PPN Amount') }}</th>
                                        <th class="no-wrap">{{ __('Grand Total') }}</th>
                                        <th class="no-wrap">{{ __('Therapist Name') }}</th>
                                        <th class="no-wrap">{{ __('Room') }}</th>
                                        <th class="no-wrap">{{ __('Time From') }}</th>
                                        <th class="no-wrap">{{ __('Time To') }}</th>
                                        <th class="no-wrap">{{ __('Product Name') }}</th>
                                        <th class="no-wrap">{{ __('Amount') }}</th>
                                        <th class="no-wrap">{{ __('Duration') }}</th>
                                        <th class="no-wrap">{{ __('Commission Fee') }}</th>
                                        <th class="no-wrap">{{ __('Rating') }}</th>
                                        <th class="no-wrap">{{ __('Comment') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $t_price = 0;
                                        $t_discount = 0;
                                        $t_tax_amount = 0;
                                        $t_grand_total = 0;
                                        $t_fee = 0;
                                    @endphp

                                    @foreach ($report as $row)
                                        @php
                                            $t_price += $row->total_price;
                                            $t_discount += $row->discount;
                                            $t_tax_amount += $row->tax_amount;
                                            $t_grand_total += $row->grand_total;
                                        @endphp

                                        <tr>
                                            <td class="no-wrap">{{ $row->invoice_code }}</td>
                                            <td class="no-wrap">{{ $row->customer_name }}</td>
                                            <td class="no-wrap">{{ $row->treatment_date }}</td>
                                            <td class="no-wrap">{{ $row->payment_mode }}</td>
                                            <td class="no-wrap">{{ $row->payment_status }}</td>
                                            <td class="no-wrap">{{ $row->note }}</td>
                                            <td class="no-wrap">{{ $row->voucher_code }}</td>
                                            <td class="no-wrap">Rp {{ number_format($row->total_price, 0, ',', '.') }}</td>
                                            <td class="no-wrap">Rp {{ number_format($row->discount, 0, ',', '.') }}</td>
                                            <td class="no-wrap">{{ $row->tax_rate }}</td>
                                            <td class="no-wrap">Rp {{ number_format($row->tax_amount, 0, ',', '.') }}</td>
                                            <td class="no-wrap">Rp {{ number_format($row->grand_total, 0, ',', '.') }}</td>
                                            <td class="no-wrap">{{ $row->old_data == 'Y' ? $row->therapist_name : '' }}</td>
                                            <td class="no-wrap">{{ $row->old_data == 'Y' ? $row->room : '' }}</td>
                                            <td class="no-wrap">{{ $row->old_data == 'Y' ? $row->time_from : '' }}</td>
                                            <td class="no-wrap">{{ $row->old_data == 'Y' ? $row->time_to : '' }}</td>
                                            <td class="no-wrap">&nbsp;</td>
                                            <td class="no-wrap">&nbsp;</td>
                                            <td class="no-wrap">&nbsp;</td>
                                            <td class="no-wrap">&nbsp;</td>
                                            <td class="no-wrap">&nbsp;</td>
                                            <td class="no-wrap">&nbsp;</td>
                                        </tr>

                                        @foreach ($report_detail[$row->invoice_id] as $rd)
                                            @php
                                                $t_fee += $rd->commission_fee;
                                            @endphp

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
                                                <td class="no-wrap">{{ $row->old_data == 'N' ? $rd->therapist_name : '' }}</td>
                                                <td class="no-wrap">{{ $row->old_data == 'N' ? $rd->room : '' }}</td>
                                                <td class="no-wrap">{{ $row->old_data == 'N' ? $rd->treatment_time_from : '' }}</td>
                                                <td class="no-wrap">{{ $row->old_data == 'N' ? $rd->treatment_time_to : '' }}</td>
                                                <td class="no-wrap">{{ $rd->product_name }}</td>
                                                <td class="no-wrap">Rp {{ number_format($rd->amount, 0, ',', '.') }}</td>
                                                <td class="no-wrap">{{ $rd->duration }}</td>
                                                <td class="no-wrap">Rp {{ number_format($rd->commission_fee, 0, ',', '.') }}</td>
                                                <td class="no-wrap">{{ $rd->rating }}</td>
                                                <td class="no-wrap">{{ $rd->comment }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="6">&nbsp;</th>
                                        <th class="no-wrap">{{ __('Total') }}</th>
                                        <th class="no-wrap">Rp {{ number_format($t_price, 0, ',', '.') }}</th>
                                        <th class="no-wrap">Rp {{ number_format($t_discount, 0, ',', '.') }}</th>
                                        <th class="no-wrap">&nbsp;</th>
                                        <th class="no-wrap">Rp {{ number_format($t_tax_amount, 0, ',', '.') }}</th>
                                        <th class="no-wrap">Rp {{ number_format($t_grand_total, 0, ',', '.') }}</th>
                                        <th class="no-wrap" colspan="7">&nbsp;</th>
                                        <th class="no-wrap">Rp {{ number_format($t_fee, 0, ',', '.') }}</th>
                                        <th class="no-wrap" colspan="2">&nbsp;</th>
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
