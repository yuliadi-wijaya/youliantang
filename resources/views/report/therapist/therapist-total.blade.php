@extends('layouts.master-layouts')
@section('title') {{ __('Report Total Therapists') }} @endsection
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
            @slot('title') Report Total Therapists @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Therapists @endslot
            @slot('li_4') Report Total Therapists @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="{{ url('/rf-therapist-total') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Filter Total Therapists') }}
                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="{{ route('ex-therapist-total') }}" method="GET" style="display: none;">
                    @csrf

                    <input type="hidden" name="status" value="{{ $status }}">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <div class="mb-4">
                                <h4><strong>
                                    @if($status === 'All')
                                        {{ __('Report Status = Active & Non Active') }}
                                    @else
                                        {{ __('Report Status = ') . ($status == 1 ? 'Active' : 'Non Active') }}
                                    @endif
                                </strong></h4>
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
                                        <th class="no-wrap">{{ __('Therapist Name') }}</th>
                                        <th class="no-wrap">{{ __('Status') }}</th>
                                        <th class="no-wrap">{{ __('Register Date') }}</th>
                                        <th class="no-wrap">{{ __('Phone Number') }}</th>
                                        <th class="no-wrap">{{ __('Email') }}</th>
                                        <th class="no-wrap">{{ __('Ktp') }}</th>
                                        <th class="no-wrap">{{ __('Gender') }}</th>
                                        <th class="no-wrap">{{ __('Place Of Birth') }}</th>
                                        <th class="no-wrap">{{ __('Birth Date') }}</th>
                                        <th class="no-wrap">{{ __('Address') }}</th>
                                        <th class="no-wrap">{{ __('Rekening Number') }}</th>
                                        <th class="no-wrap">{{ __('Emergency Name') }}</th>
                                        <th class="no-wrap">{{ __('Emergency Contact') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_therapist = 0;
                                    @endphp

                                    @foreach ($report as $index => $row)
                                        @php
                                            $total_therapist += 1;
                                        @endphp

                                        <tr>
                                            <td class="no-wrap">{{ $loop->index + 1 }}</td>
                                            <td class="no-wrap">{{ $row->therapist_name }}</td>
                                            <td class="no-wrap">@if ($row->status == 1) Active @else Non Active @endif</td>
                                            <td class="no-wrap">{{ date('d-m-Y', strtotime($row->register_date)) }}</td>
                                            <td class="no-wrap">{{ $row->phone_number }}</td>
                                            <td class="no-wrap">{{ $row->email }}</td>
                                            <td class="no-wrap">{{ $row->ktp }}</td>
                                            <td class="no-wrap">{{ $row->gender }}</td>
                                            <td class="no-wrap">{{ $row->place_of_birth }}</td>
                                            <td class="no-wrap">{{ date('d-m-Y', strtotime($row->birth_date)) }}</td>
                                            <td class="no-wrap">{{ $row->address }}</td>
                                            <td class="no-wrap">{{ $row->rekening_number }}</td>
                                            <td class="no-wrap">{{ $row->emergency_name }}</td>
                                            <td class="no-wrap">{{ $row->emergency_contact }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="2">{{ __('Total Therapist') }}</th>
                                        <th class="no-wrap">{{ $total_therapist }}</th>
                                        <th class="no-wrap" colspan="11">&nbsp;</th>
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
