@extends('layouts.master-layouts')
@section('title'){{ __('Report Transactions') }}@endsection
@section('css')
    <style type="text/css">
        .h-formfield-uppercase {
            text-transform: uppercase;
            &::placeholder {
                text-transform: none;
            }
        }

    </style>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
    <!-- Datatables -->
    <link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" src="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
@endsection
@section('body')
{{-- @php
    echo '<pre>';
    print_r($request->daily_start_date);
    echo '</pre>';die();
@endphp --}}
<body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Promo Usage Report @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Transactions @endslot
            @slot('li_4') Revenue @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <form>
                @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 form-group">
                                    <label class="control-label">{{ __('Period Type') }}<span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="report_type" id="report_type">
                                        @foreach ($reportType as $key => $val) 
                                        <option value="{{ $key }}" @if (old('report_type') == '{{ $key }}') selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 form-group" id="daily_show">
                                    <label class="control-label">{{ __('Invoice Date ') }}<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-6 input-group datepickerdiv">
                                            <input type="date" class="form-control @error('daily_date') is-invalid @enderror"
                                                name="daily_start_date" id="daily_start_date" value="{{ old('daily_start_date', date('Y-m-d', strtotime($request->daily_start_date))) }}"
                                                placeholder="{{ __('Select Date') }}">
                                            @error('daily_start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 input-group datepickerdiv">
                                            <input type="date" class="form-control @error('daily_date') is-invalid @enderror"
                                                name="daily_end_date" id="daily_end_date" value="{{ old('daily_end_date', $request->daily_end_date) }}"
                                                placeholder="{{ __('Select Date') }}">
                                            @error('daily_end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group" id="monthly_show" style="display: none;">
                                    <label class="control-label">{{ __('Invoice Date ') }}<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group datepickerdiv">
                                                <select class="form-control @error('month') is-invalid @enderror" id="month" name="month">
                                                    <option val="" selected>All Months</option>
                                                    @foreach ($months as $key => $val)
                                                        <option value="{{ $key }}" @if (old('months') == '{{ $key }}') selected @endif>{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                                @error('month')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group datepickerdiv">
                                                <select class="form-control @error('year') is-invalid @enderror" id="year" name="year">
                                                    <option val="" selected>All Years</option>
                                                    @foreach ($years as $key => $val)
                                                    <option value="{{ $key }}" @if (old('year') == '{{ $key }}') selected @endif>{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                                @error('year')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group" id="yearly_show" style="display: none;">
                                    <label class="control-label">{{ __('Invoice Date ') }}<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group datepickerdiv">
                                                <select class="form-control @error('yearly_year') is-invalid @enderror" id="yearly_year" name="yearly_year">
                                                    <option val="" selected>All Years</option>
                                                    @foreach ($years as $key => $val)
                                                    <option value="{{ $key }}" @if (old('yearly_year') == '{{ $key }}') selected @endif>{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                                @error('yearly_year')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 form-group">
                                    <label class="control-label">{{ __('Limit Data') }}<span class="text-danger">*</span></label>
                                    <select class="form-control" name="limit" id="limit">
                                        <option value="10" @if (old('limit') == '10') selected @endif>10</option>
                                        <option value="25" @if (old('limit') == '25') selected @endif>25</option>
                                        <option value="50" @if (old('limit') == '50') selected @endif>50</option>
                                        <option value="100" @if (old('limit') == '100') selected @endif>100</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 28px">
                                        {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="border-bottom: solid #495057; background-color: #fff">
                        <div class="invoice-title text-center">
                            <div class="col-12 text-center text-white">
                                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" width="235" style="margin:-31px 0 -45px 0">
                            </div>
                        </div>
                        @if ($request) 
                            <div class="row">
                                <div class="col-md-6 text-left">
                                    @if (isset($request->report_type))
                                        <h4>{{ ucwords($request->report_type) }} Period</h4>
                                    @endif
                                </div>
                                <div class="col-md-6 text-right">
                                    @if ($request->report_type == 'daily')
                                        <h4>{{ date('j F Y', strtotime($request->daily_start_date)) }} - {{ date('j F Y', strtotime($request->daily_end_date)) }}</h4>
                                    @elseif ($request->report_type == 'monthly')
                                        <h4>
                                        @if ($request->month != 'All Months')
                                            {{ date("F", mktime(0, 0, 0, $request->month, 10)) }}
                                        @endif
                                        @if ($request->year != 'All Years')
                                            {{ $request->year }}
                                        @endif
                                        </h4>
                                    @elseif ($request->report_type == 'yearly' && $request->yearly_year != 'All Years')
                                        <h4>{{ $request->yearly_year }}</h4>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <table id="datas" class="table dt-responsive table-bordered table-striped table-color-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-white" style="background-color: #2a3042">
                                <tr>
                                    <th style="width: 75px">{{ __('#') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Active Period') }}</th>
                                    <th>{{ __('Voucher Quota') }}</th>
                                    <th>{{ __('Transaction Total') }}</th>
                                    <th>{{ __('Remining Quota') }}</th>
                                </tr>
                            </thead>
                            @php 
                                $no = 1;
                            @endphp
                            <tbody>
                                @if ($reports && count($reports) > 0)
                                    @foreach ($reports as $item)
                                        <tr>
                                            <td class="text-right">{{ $no }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ date('d-m-Y', strtotime($item->active_period_start)) . ' to ' . date('d-m-Y', strtotime($item->active_period_end)) }}</td>
                                            <td class="text-right">{{ number_format($item->voucher_total) }}</td>
                                            <td class="text-right">{{ number_format($item->invoice_total) }}</td>
                                            <td class="text-right">
                                                @if ($item->is_reuse_voucher == 1)
                                                    <i>{{ "Unlimited" }}</i>
                                                @else 
                                                    {{ number_format($item->voucher_total - $item->invoice_total) }}
                                                @endif
                                            </td>
                                        </tr>
                                        @php 
                                            $no++; 
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <!-- Datatables -->
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>

        <script>
            $(document).ready(function(){
                $('#datas').DataTable({
                    buttons: [
                        'copy',
                        {extend : 'excel', footer: true},
                        'colvis' ],
                    pagingType: 'full_numbers',
                    "drawCallback": function() {
                        $('.dataTables_paginate > .pagination').addClass('justify-content-end');
                        $('.dataTables_filter').addClass('d-flex justify-content-end');
                    }
                });

                showFormDaily();

                function toggleDisplay() {
                    var selec_type = $("#report_type").val();

                    if (selec_type == 'daily') {
                        showFormDaily();

                        $('daily_start_date').val({{date('d/m/Y', strtotime($request->daily_start_date))}});

                        resetFormDaily();
                        resetFormMonthly();
                        resetFormYearly()
                    } else if (selec_type == 'monthly') {
                        showFormMonthly();

                        resetFormDaily();
                        resetFormMonthly();
                        resetFormYearly()
                    } else if (selec_type == 'yearly') {
                        showFormYearly()

                        resetFormDaily();
                        resetFormMonthly();
                    }
                }

                toggleDisplay();

                $("#report_type").on("change", function() {
                    toggleDisplay();
                });
            });

            function showFormDaily() {
                $("#daily_show").css("display", "block");
                $("#monthly_show").css("display", "none");
                $("#yearly_show").css("display", "none");

                $("#daily_start_date").prop('required',true);
                $("#daily_end_date").prop('required',true);
            }

            function showFormMonthly() {
                $("#daily_show").css("display", "none");
                $("#monthly_show").css("display", "block");
                $("#yearly_show").css("display", "none");
                
                $("#daily_start_date").prop('required',false);
                $("#daily_end_date").prop('required',false);
            }

            function showFormYearly() {
                $("#daily_show").css("display", "none");
                $("#monthly_show").css("display", "none");
                $("#yearly_show").css("display", "block");

                $("#daily_start_date").prop('required',false);
                $("#daily_end_date").prop('required',false);
            }

            function resetFormDaily() {
                if ($('#daily_start_date').val()) {
                    $('#daily_start_date').val("");
                }

                if ($('#daily_end_date').val()) {
                    $('#daily_end_date').val("");
                }
            }

            function resetFormMonthly() {
                if ($("#month").val()) {
                    $("#month").val($("#month option:first").val());
                }

                if ($('#year').val()) {
                    $("#year").val($("#year option:first").val());
                }
            }

            function resetFormYearly() {
                if ($('#yearly_year').val()) {
                    $('#yearly_year').val($('#yearly_year option:first').val());
                }
            }
        </script>
    @endsection

