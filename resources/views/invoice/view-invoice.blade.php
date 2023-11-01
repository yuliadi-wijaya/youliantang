@extends('layouts.master-layouts')
@section('title') {{ __('Invoice Details') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- Adjust the CSS for the specific paper dimensions and max diameter -->
        <style>
            @page {
                margin: 0
            }
            body {
                margin: 0;
            }
            .sheet {
                margin: 0;
                overflow: hidden;
                position: relative;
                box-sizing: border-box;
                page-break-after: always;
            }

            /** Paper sizes **/
            body.struk .sheet {
                width: 75mm;
            }
            body.struk .sheet {
                padding: 2mm;
            }

            /** For screen preview **/
            @media screen {
                .sheet {
                    background: white;
                    margin: 5mm;
                }
            }

            /** Fix for Chrome issue **/
            @media print {
                body {
                    font-family: monospace;
                }
                body.struk {
                    width: 75mm;
                    text-align: left;
                }
                body.struk .sheet {
                    padding: 2mm;
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
                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4">
                    <i class="fa fa-print"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <section class="sheet">
                            <div class="invoice-title">
                                <h4 class="float-right font-size-16">{{ __('Invoice #') }} {{ $invoice_detail->id }}</h4>
                                <div class="mb-4">
                                    <h3>YOU LIAN tANG</h3>
                                    <h6>Family Refleksi & Massage</h6>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <address>
                                        <strong>{{ __('Treatment date : ') }}</strong>{{ $invoice->treatment_date . ' ' . $invoice->treatment_time_from . ' to ' . $invoice->treatment_time_to }}<br>
                                        <strong>{{ __('Customer : ') }}</strong>{{ $invoice_detail->customer_name }}<br>
                                        <strong>{{ __('Therapist : ') }}</strong>{{ $invoice_detail->therapist_name }}<br>
                                    </address>
                                </div>
                                <div class="col-3">
                                    <address>

                                    </address>
                                </div>
                                <div class="col-3">
                                    <address>

                                    </address>
                                </div>
                                <div class="col-3 pull-right">
                                    <address>
                                        <strong>{{ __('Invoice date : ') }}</strong>{{ $invoice->created_at }}<br>
                                        <strong>{{ __('Payment Mode : ') }}</strong>{{ $invoice_detail->payment_mode }}<br>
                                        <strong>{{ __('Payment Status : ') }}</strong>{{ $invoice_detail->payment_status }}<br>
                                    </address>
                                </div>
                            </div>

                            <div class="py-2 mt-3">
                                <h3 class="font-size-15 font-weight-bold">{{ __('Invoice summary') }}</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">{{ __('No.') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th class="text-right">{{ __('Amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                            <td colspan="2" class="text-right">{{ __('Sub Total') }}</td>
                                            <td class="text-right">Rp {{ number_format($sub_total) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border-0 text-right">
                                                <strong>{{ __('Total') }}</strong>
                                            </td>
                                            <td class="border-0 text-right">
                                                <h4 class="m-0">Rp {{ number_format($sub_total) }}</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
