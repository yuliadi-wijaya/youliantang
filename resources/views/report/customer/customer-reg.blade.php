@extends('layouts.master-layouts')
@section('title') {{ __('Report Customer Registration') }} @endsection
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
            @slot('title') Report Customer Registration @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Customers @endslot
            @slot('li_4') Report Customer Registration @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="{{ url('/rf-customer-reg') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Filter Customer Registration') }}
                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="{{ route('ex-customer-reg') }}" method="GET" style="display: none;">
                    @csrf

                    <input type="hidden" name="dateFrom" value="{{ $dateFrom }}">
                    <input type="hidden" name="dateTo" value="{{ $dateTo }}">
                    <input type="hidden" name="is_member" value="{{ $is_member }}">
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
                                        <th class="no-wrap">{{ __('No') }}</th>
                                        <th class="no-wrap">{{ __('Customer Name') }}</th>
                                        <th class="no-wrap">{{ __('Phone Number') }}</th>
                                        <th class="no-wrap">{{ __('Email') }}</th>
                                        <th class="no-wrap">{{ __('Register Date') }}</th>
                                        <th class="no-wrap">{{ __('Place Of Birth') }}</th>
                                        <th class="no-wrap">{{ __('Birth Date') }}</th>
                                        <th class="no-wrap">{{ __('Gender') }}</th>
                                        <th class="no-wrap">{{ __('Address') }}</th>
                                        <th class="no-wrap">{{ __('Emergency Name') }}</th>
                                        <th class="no-wrap">{{ __('Emergency Contact') }}</th>
                                        <th class="no-wrap">{{ __('Customer Status') }}</th>
                                        <th class="no-wrap">{{ __('Is Member') }}</th>
                                        <th class="no-wrap">{{ __('Member Plan') }}</th>
                                        <th class="no-wrap">{{ __('Member Status') }}</th>
                                        <th class="no-wrap">{{ __('Start Member') }}</th>
                                        <th class="no-wrap">{{ __('Expired Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_customer = 0;
                                        $total_member = 0;
                                    @endphp

                                    @foreach ($report as $index => $row)
                                        @php
                                            $total_customer += 1;
                                            if ($row->is_member == 1) $total_member += 1;
                                        @endphp

                                        <tr>
                                            <td class="no-wrap">{{ $loop->index + 1 }}</td>
                                            <td class="no-wrap">{{ $row->customer_name }}</td>
                                            <td class="no-wrap">{{ $row->phone_number }}</td>
                                            <td class="no-wrap">{{ $row->email }}</td>
                                            <td class="no-wrap">{{ date('d-m-Y', strtotime($row->register_date)) }}</td>
                                            <td class="no-wrap">{{ $row->place_of_birth }}</td>
                                            <td class="no-wrap">{{ date('d-m-Y', strtotime($row->birth_date)) }}</td>
                                            <td class="no-wrap">{{ $row->gender }}</td>
                                            <td class="no-wrap">{{ $row->address }}</td>
                                            <td class="no-wrap">{{ $row->emergency_name }}</td>
                                            <td class="no-wrap">{{ $row->emergency_contact }}</td>
                                            <td class="no-wrap">{{ $row->customer_status }}</td>
                                            <td class="no-wrap">@if ($row->is_member == 1) Yes @else No @endif</td>
                                            <td class="no-wrap">{{ $row->member_plan }}</td>
                                            <td class="no-wrap">{{ $row->member_status }}</td>
                                            <td class="no-wrap">{{ $row->start_member }}</td>
                                            <td class="no-wrap">{{ date('d-m-Y', strtotime($row->expired_date)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="2">{{ __('Total Customer') }}</th>
                                        <th class="no-wrap">{{ $total_customer }}</th>
                                        <th class="no-wrap" colspan="14">&nbsp;</th>
                                    </tr>
                                    <tr>
                                        <th class="no-wrap" colspan="2">{{ __('Total Member') }}</th>
                                        <th class="no-wrap">{{ $total_member }}</th>
                                        <th class="no-wrap" colspan="14">&nbsp;</th>
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
