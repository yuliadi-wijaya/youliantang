@extends('layouts.master-layouts')
@section('title') {{ __('Report Transaction History Summary') }} @endsection
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
            @slot('title') Report Transaction History Summary @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Therapists @endslot
            @slot('li_4') Report Transaction History Summary @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="{{ url('/rf-therapist-trans') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Filter Transaction') }}
                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="{{ route('ex-therapist-trans') }}" method="GET" style="display: none;">
                    @csrf

                    <input type="hidden" name="report_type" value="{{ $report_type }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="therapist_id" value="{{ $therapist_id }}">
                    <input type="hidden" name="order_by" value="{{ $order_by }}">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <div class="mb-4">
                                <h4>
                                    @php
                                        $monthTexts = [
                                            "01" => "January",
                                            "02" => "February",
                                            "03" => "March",
                                            "04" => "April",
                                            "05" => "May",
                                            "06" => "June",
                                            "07" => "July",
                                            "08" => "August",
                                            "09" => "September",
                                            "10" => "October",
                                            "11" => "November",
                                            "12" => "December",
                                        ];
                                    @endphp
                                    <strong>
                                        {{ __('Report Type = ') . ucfirst($report_type) . ' (' . $monthTexts[$month] . ' - ' . $year . ')' }}
                                    </strong>
                                </h4>
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
                                        <th class="no-wrap">{{ __('Treatment Date') }}</th>
                                        <th class="no-wrap">{{ __('Duration') }}</th>
                                        <th class="no-wrap">{{ __('Commission Fee') }}</th>
                                        <th class="no-wrap">{{ __('Rating') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $gt_duration = 0;
                                        $gt_fee = 0;
                                    @endphp

                                    @foreach ($report as $row)
                                        @php
                                            $gt_duration += $row->total_duration;
                                            $gt_fee += $row->total_commission_fee;
                                        @endphp

                                        <tr>
                                            <td class="no-wrap">{{ $row->therapist_name }}</td>
                                            <td class="no-wrap">{{ $row->phone_number }}</td>
                                            <td class="no-wrap">{{ $row->treatment_month_year }}</td>
                                            <td class="no-wrap">{{ $row->total_duration }} Minutes</td>
                                            <td class="no-wrap">Rp {{ number_format($row->total_commission_fee, 0, ',', '.') }}</td>
                                            <td class="no-wrap">{{ $row->avg_rating }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="2">&nbsp;</th>
                                        <th class="no-wrap">{{ __('Total') }}</th>
                                        <th class="no-wrap">{{ $gt_duration }} Minutes</th>
                                        <th class="no-wrap">Rp {{ number_format($gt_fee, 0, ',', '.') }}</td>
                                        <th class="no-wrap">&nbsp;</th>
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
