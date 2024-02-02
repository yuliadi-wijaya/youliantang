@extends('layouts.master-layouts')
@section('title') {{ __('Report Therapist Transaction History Summary') }} @endsection
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
            @slot('title') Report Therapist Transaction History Summary @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Therapists @endslot
            @slot('li_4') Report Therapist Transaction History Summary @endslot
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
                                            @if ($filter_display === 'daily')
                                                <td class="no-wrap">{{ $row->treatment_date }}</td>
                                            @elseif ($filter_display === 'monthly')
                                                <td class="no-wrap">{{ $row->treatment_month }}</td>
                                            @elseif ($filter_display === 'yearly')
                                                <td class="no-wrap">{{ $row->treatment_year }}</td>
                                            @endif
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
