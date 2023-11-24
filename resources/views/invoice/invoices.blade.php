@extends('layouts.master-layouts')
@section('title') {{ __('List of Invoices') }} @endsection
@section('css')
    <style>
        #pageloader {
            background: rgba(255, 255, 255, 0.8);
            display: none;
            height: 100%;
            position: fixed;
            width: 100%;
            z-index: 9999;
            left: 0;
            right: 0;
            margin: auto;
            bottom: 0;
            top: 0;
        }

        #pageloader img {
            left: 50%;
            margin-left: -32px;
            margin-top: -32px;
            position: absolute;
            top: 50%;
        }

    </style>
@endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
        <div id="pageloader">
            <img src="{{ URL::asset('assets/images/loader.gif') }}" alt="processing..." />
        </div>
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Invoice List @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Invoice @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($role != 'customer')
                            <a href=" {{ route('invoice.create') }}">
                                <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i>
                                    {{ __('Create New Invoice') }}
                                </button>
                            </a>
                        @endif
                        <table class="table table-bordered dt-responsive nowrap "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ __('No.') }}</th>
                                    <th>{{ __('Invoice No') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Therapist Name') }}</th>
                                    <th>{{ __('Room') }}</th>
                                    <th>{{ __('Treatment Date') }}</th>
                                    <th>{{ __('Rating') }}</th>
                                    <th>{{ __('Option') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (session()->has('page_limit'))
                                    @php
                                        $per_page = session()->get('page_limit');
                                    @endphp
                                @else
                                    @php
                                        $per_page = Config::get('app.page_limit');
                                    @endphp
                                @endif
                                @php
                                    $currentpage = $invoices->currentPage();
                                @endphp
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                        <td>{{ $invoice->invoice_code }}</td>
                                        <td>{{ $invoice->customer_name }}</td>
                                        @if ($invoice->old_data == 'Y')
                                            <td>{{ $invoice->therapist_name }}</td>
                                            <td>{{ $invoice->room }}</td>
                                        @else
                                            <td>
                                                @foreach ($invoice_detail[$invoice->id] as $detail)
                                                    {{ $detail->therapist_name }}
                                                    @unless ($loop->last)
                                                    ,
                                                    @endunless
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($invoice_detail[$invoice->id] as $detail)
                                                    {{ $detail->room }}
                                                    @unless ($loop->last)
                                                    ,
                                                    @endunless
                                                @endforeach
                                            </td>
                                        @endif
                                        <td>{{ date('Y-m-d', strtotime($invoice->treatment_date)) }} ( {{ $invoice->treatment_time_from }} to {{ $invoice->treatment_time_to }} )</td>
                                        <td>
                                            @if($invoice->id != '')
                                                @for ($i = 1; $i <= $invoice->rating; $i++)
                                                    <span class="star" data-rating="{{ $i }}"><i class="fas fa-star" style="font-size: 15px; color:orange"></i></span>
                                                @endfor
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('invoice/' . $invoice->id) }}">
                                                <button type="button"
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                    title="View Invoice">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ url('invoice/' . $invoice->id . '/edit') }}">
                                                <button type="button"
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                    title="Update invoice">
                                                    <i class="mdi mdi-lead-pencil"></i>
                                                </button>
                                            </a>
                                            <a href="{{ url('review/' . $invoice->id) }}">
                                                <button type="button"
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                    title="Review">
                                                    <i class="fa fa-star"></i>
                                                </button>
                                            </a>
                                            {{-- @if ($role != 'customer')
                                                <a href="javascript:void(0)">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light
                                                                send-mail"
                                                        title="Send Email" data-id="{{ $invoice->id }}">
                                                        <i class="mdi mdi-email"></i>
                                                    </button>
                                                </a>
                                            @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center mt-3">
                            <div class="d-flex justify-content-start">
                                Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of
                                {{ $invoices->total() }} entries
                            </div>
                            <div class="d-flex justify-content-end">
                                {{ $invoices->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    @endsection
    @section('script')
        <!-- Plugins js -->
        <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
        <script>
            $('.send-mail').click(function() {
                var id = $(this).attr('data-id');
                if (confirm('Are you sure you want to send email?')) {
                    $.ajax({
                        type: "get",
                        url: "invoice-email/" + id,
                        beforeSend: function() {
                            $('#pageloader').show();
                        },
                        success: function(response) {
                            toastr.success(response.message);
                        },
                        error: function(response) {
                            toastr.error(response.responseJSON.message);
                        },
                        complete: function() {
                            $('#pageloader').hide();
                        }
                    });
                }
            });
        </script>
    @endsection
