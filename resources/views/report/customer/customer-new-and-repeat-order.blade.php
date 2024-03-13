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
            @slot('title') Customer New And Repeat Order Report @endslot
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
                                    <label class="control-label">{{ __('Report Type') }}</label>
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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <table id="tbl-new-orders" class="table dt-responsive table-bordered table-striped table-color-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-white" style="background-color: #2a3042">
                                <tr>
                                    <th style="width: 75px">{{ __('#') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('New Order Total') }}</th>
                                </tr>
                            </thead>
                            @php 
                                $no = 1;
                                $sum_customer_regist = 0;
                            @endphp
                            <tbody>
                                @if ($new_orders && count($new_orders) > 0)
                                    @foreach ($new_orders as $item)
                                        <tr>
                                            <td class="text-right">{{ $no }}</td>
                                            <td>{{ $item->regist_date }}</td>
                                            <td class="text-right">{{ number_format($item->customer_regist_total) }}</td>
                                        </tr>
                                        @php 
                                            $no++; 
                                            $sum_customer_regist += $item->customer_regist_total;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            @if ($new_orders && count($new_orders) > 0)
                                <tfoot class="text-white" style="background-color: #2a3042">
                                    <tr>
                                        <th class="text-right" colspan="2">TOTAL</th>
                                        <th class="text-right">{{ number_format($sum_customer_regist) }}</th>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <table id="tbl-repeat-orders" class="table dt-responsive table-bordered table-striped table-color-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-white" style="background-color: #2a3042">
                                <tr>
                                    <th style="width: 75px">{{ __('#') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Repeat Order Total') }}</th>
                                </tr>
                            </thead>
                            @php 
                                $no1 = 1;
                                $sum_repeat_order = 0;
                            @endphp
                            <tbody>
                                @if ($repeat_orders && count($repeat_orders) > 0)
                                    @foreach ($repeat_orders as $item)
                                        <tr>
                                            <td class="text-right">{{ $no1 }}</td>
                                            <td>{{ $item->treatment_date }}</td>
                                            <td class="text-right">{{ number_format($item->repeat_order_total) }}</td>
                                        </tr>
                                        @php 
                                            $no1++; 
                                            $sum_repeat_order += $item->repeat_order_total;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            @if ($repeat_orders && count($repeat_orders) > 0)
                                <tfoot class="text-white" style="background-color: #2a3042">
                                    <tr>
                                        <th class="text-right" colspan="2">TOTAL</th>
                                        <th class="text-right">{{ number_format($sum_repeat_order) }}</th>
                                    </tr>
                                </tfoot>
                            @endif
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
                showFormDaily();

                $('#tbl-new-orders').DataTable({
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

                $('#tbl-repeat-orders').DataTable({
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

                function toggleDisplay() {
                    var selec_type = $("#report_type").val();

                    if (selec_type == 'daily') {
                        showFormDaily();

                        $('daily_start_date').val({{date('d/m/Y', strtotime($request->daily_start_date))}});

                        resetFormDaily();
                        resetFormMonthly();
                    } else if (selec_type == 'monthly') {
                        showFormMonthly();

                        resetFormDaily();
                        resetFormMonthly();
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

                $("#daily_start_date").prop('required',true);
                $("#daily_end_date").prop('required',true);
            }

            function showFormMonthly() {
                $("#daily_show").css("display", "none");
                $("#monthly_show").css("display", "block");
                
                $("#daily_start_date").prop('required',false);
                $("#daily_end_date").prop('required',false);
            }

            function showFormYearly() {
                $("#daily_show").css("display", "none");
                $("#monthly_show").css("display", "none");

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
        </script>
    @endsection
