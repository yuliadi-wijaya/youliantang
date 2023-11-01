@extends('layouts.master-layouts')
@section('title') {{ __('Invoice Details') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
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
                <a href="{{ url('transaction') }}">
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
                        <div class="transaction-title">
                            <h4 class="float-right font-size-16">{{ __('Invoice #') }} {{ $transaction_detail->id }}</h4>
                            <div class="mb-4">
                                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="logo" height="20" />
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">
                                <address>
                                    <strong>{{ __('Customer Details') }}</strong><br>
                                    {{ $transaction_detail->customer_name }}<br>
                                </address>
                            </div>
                            <div class="col-3">
                                <address>
                                    <strong>{{ __('Therapist Details') }}</strong><br>
                                    {{ $transaction_detail->therapist_name }}<br>
                                </address>
                            </div>
                            <div class="col-3">
                                <address>
                                    <strong>{{ __('Payment Details') }}</strong><br>
                                    {{ __('Payment Mode :') }} {{ $transaction_detail->payment_method }}<br>
                                </address>
                            </div>
                            <div class="col-3 pull-right">
                                <address>
                                    <strong>{{ __('Invoice date: ') }}</strong>{{ $transaction_detail->created_at }}<br>
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
                                        <th>{{ __('Product') }}</th>
                                        <th class="text-right">{{ __('Amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $transaction_detail->product }}</td>
                                        <td class="text-right">Rp. {{ number_format($transaction_detail->total_cost, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">{{ __('Sub Total') }}</td>
                                        <td class="text-right">Rp. {{ number_format($transaction_detail->total_cost, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 text-right">
                                            <strong>{{ __('Tax (10%)') }}</strong>
                                        </td>
                                        <td class="border-0 text-right">Rp. {{ number_format(($transaction_detail->total_cost * 5) / 100, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 text-right">
                                            <strong>{{ __('Total') }}</strong>
                                        </td>
                                        <td class="border-0 text-right">
                                            <h4 class="m-0">Rp. {{ number_format($transaction_detail->total_cost + ($transaction_detail->total_cost * 5) / 100, 2, '.', ',') }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
