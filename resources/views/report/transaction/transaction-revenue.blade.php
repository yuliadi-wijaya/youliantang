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
@endsection
@section('body')

<body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Transaction Revenue Report @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Transactions @endslot
            @slot('li_4') Revenue @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Filter Details') }}</blockquote>
                        <form method="POST" action="{{ route('show-transactions-revenue-report') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Report Type') }}</label>
                                    <select class="form-control select2" name="report_type" id="report_type">
                                        @foreach ($reportType as $key => $val) 
                                        <option value="{{ $key }}" @if (old('report_type') == '{{ $key }}') selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="daily_show">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Invoice Date ') }}<span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-6 input-group datepickerdiv">
                                            <input type="date" class="form-control @error('daily_date') is-invalid @enderror"
                                                name="daily_date" id="daily_date" value="{{ old('daily_date') }}"
                                                placeholder="{{ __('Select Date') }}">
                                            @error('daily_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 input-group datepickerdiv">
                                            <input type="date" class="form-control @error('daily_date') is-invalid @enderror"
                                                name="daily_date" id="daily_date" value="{{ old('daily_date') }}"
                                                placeholder="{{ __('Select Date') }}">
                                            @error('daily_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="monthly_show" style="display: none;">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Invoice Date ') }}<span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group datepickerdiv">
                                                        <select class="form-control select2 @error('month') is-invalid @enderror" id="month" name="months[]" multiple="multiple" data-placeholder="Select Month">
                                                            <option value="" disabled>Select Month</option>
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
                                                        <select class="form-control select2 @error('year') is-invalid @enderror" id="year" name="year">
                                                            <option value="" disabled selected>All Years</option>
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
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="yearly_show" style="display: none;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Invoice Date ') }}<span class="text-danger">*</span></label>
                                    <div class="input-group datepickerdiv">
                                        <select class="form-control select2 @error('yearly_date') is-invalid @enderror" id="yearly_date" name="yearly_date" multiple data-placeholder="Select Year">
                                            <option value="" disabled>Select Year</option>
                                        </select>
                                        @error('yearly_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <!-- Calender Js-->
        <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>

        <script>
            $(document).ready(function(){
                function toggleDisplay() {
                    var selec_type = $("#report_type").val();

                    if (selec_type == 'daily') {
                        $("#daily_show").css("display", "block");
                        $("#monthly_show").css("display", "none");
                        $("#yearly_show").css("display", "none");
                    } else if (selec_type == 'monthly') {
                        $("#daily_show").css("display", "none");
                        $("#monthly_show").css("display", "block");
                        $("#yearly_show").css("display", "none");
                    } else if (selec_type == 'yearly') {
                        $("#daily_show").css("display", "none");
                        $("#monthly_show").css("display", "none");
                        $("#yearly_show").css("display", "block");
                    }
                }

                toggleDisplay();

                $("#report_type").on("change", function() {
                    toggleDisplay();
                });
            });

            // var monthSelect = document.getElementById("month");
            // for (var i = 1; i <= 12; i++) {
            //     var option = document.createElement("option");
            //     option.value = i < 10 ? "0" + i : "" + i;
            //     option.text = new Date(2000, i - 1, 1).toLocaleString('default', { month: 'long' });
            //     monthSelect.appendChild(option);
            // }

            // var yearSelect = document.getElementById("year");
            // var currentYear = new Date().getFullYear();
            // for (var year = currentYear; year >= currentYear - 4; year--) {
            //     var option = document.createElement("option");
            //     option.value = "" + year;
            //     option.text = "" + year;
            //     yearSelect.appendChild(option);
            // }

            // var yearSelect = document.getElementById("yearly_date");
            // var currentYear = new Date().getFullYear();
            // for (var year = currentYear; year >= currentYear - 4; year--) {
            //     var option = document.createElement("option");
            //     option.value = "" + year;
            //     option.text = "" + year;
            //     yearSelect.appendChild(option);
            // }
        </script>
    @endsection
