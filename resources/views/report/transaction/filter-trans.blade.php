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
            @slot('title') Report Filter Transaction History @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Transactions @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Filter Details') }}</blockquote>
                        <form action="{{ route('rs-trans') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Peirode Type') }}</label>
                                    <select class="form-control select2" name="report_type" id="report_type">
                                        <option value="detail" @if (old('report_type') == 'detail') selected @endif>{{ __('Detail') }}</option>
                                        <option value="summary" @if (old('report_type') == 'summary') selected @endif>{{ __('Summary') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Filter Display') }}</label>
                                    <select class="form-control select2" name="filter_display" id="filter_display">
                                        <option value="daily" @if (old('filter_display') == 'daily') selected @endif>{{ __('Daily') }}</option>
                                        <option value="monthly" @if (old('filter_display') == 'monthly') selected @endif>{{ __('Monthly') }}</option>
                                        <option value="yearly" @if (old('filter_display') == 'yearly') selected @endif>{{ __('Yearly') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="daily_show">
                                <div class="col-md-2 form-group">
                                    <label class="control-label">{{ __('Invoice Date ') }}<span class="text-danger">*</span></label>
                                    <div class="input-group datepickerdiv">
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
                            <div class="row" id="monthly_show" style="display: none;">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Invoice Date ') }}<span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group datepickerdiv">
                                                        <select class="form-control select2 @error('month') is-invalid @enderror" id="month" name="month">
                                                            <option value="" disabled selected>Select Month</option>
                                                        </select>
                                                        @error('month')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group datepickerdiv">
                                                        <select class="form-control select2 @error('year') is-invalid @enderror" id="year" name="year">
                                                            <option value="" disabled selected>Select Year</option>
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
                                <div class="col-md-3 form-group">
                                    <label class="control-label">{{ __('Invoice Date ') }}<span class="text-danger">*</span></label>
                                    <div class="input-group datepickerdiv">
                                        <select class="form-control select2 @error('yearly_date') is-invalid @enderror" id="yearly_date" name="yearly_date">
                                            <option value="" disabled selected>Select Year</option>
                                        </select>
                                        @error('yearly_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="therapist_show" style="display: none;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Select Therapist') }}</label>
                                    <select class="form-control select2" name="therapist_id" id="therapist_id">
                                        <option value="all" @if (old('therapist_id') == 'therapist ') selected @endif>{{ __('All Therapist') }}</option>
                                        @foreach($therapists as $row)
                                            <option value="{{ $row->id }}" {{ old('therapist_id') == $row->id ? 'selected' : '' }}>{{ $row->therapist_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="order_by_show" style="display: none;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Order By') }}</label>
                                    <select class="form-control select2" name="order_by">
                                        <option value="therapist" @if (old('order_by') == 'therapist ') selected @endif>{{ __('Therapist Name') }}</option>
                                        <option value="lowest_rating" @if (old('order_by') == 'lowest_rating') selected @endif>{{ __('Lowest Rating') }}</option>
                                        <option value="highest_rating" @if (old('order_by') == 'highest_rating') selected @endif>{{ __('Highest Rating') }}</option>
                                    </select>
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

                    if (selec_type == 'summary') {
                        $("#treatment_date_show").css("display", "none");
                        $("#therapist_show").css("display", "block");
                        $("#order_by_show").css("display", "block");
                    } else {
                        $("#treatment_date_show").css("display", "block");
                        $("#therapist_show").css("display", "none");
                        $("#order_by_show").css("display", "none");
                    }
                }

                function toggleFilterDate() {
                    var selec_type = $("#filter_display").val();

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
                toggleFilterDate();

                $("#report_type").on("change", function() {
                    toggleDisplay();
                });

                $("#filter_display").on("change", function() {
                    toggleFilterDate();
                });
            });

            var monthSelect = document.getElementById("month");
            for (var i = 1; i <= 12; i++) {
                var option = document.createElement("option");
                option.value = i < 10 ? "0" + i : "" + i;
                option.text = new Date(2000, i - 1, 1).toLocaleString('default', { month: 'long' });
                monthSelect.appendChild(option);
            }

            var yearSelect = document.getElementById("year");
            var currentYear = new Date().getFullYear();
            for (var year = currentYear; year >= currentYear - 24; year--) {
                var option = document.createElement("option");
                option.value = "" + year;
                option.text = "" + year;
                yearSelect.appendChild(option);
            }

            var yearSelect = document.getElementById("yearly_date");
            var currentYear = new Date().getFullYear();
            for (var year = currentYear; year >= currentYear - 24; year--) {
                var option = document.createElement("option");
                option.value = "" + year;
                option.text = "" + year;
                yearSelect.appendChild(option);
            }
        </script>
    @endsection
